<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';


$mailevaConnection = new \MailevaApiAdapter\App\MailevaConnection();
$mailevaConnection->setEnv('DEV')
    ->setClientId('d9ca6d5e349d44acacdce7e3bb0d0c14')
    ->setClientSecret('976b0aa3dbd74ce0a107586ac1d6c528')
    ->setUsername('recette.eukles')
    ->setPassword('3ukl3s!')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);

/*
$mailevaConnection->setEnv('PROD')
    ->setClientId('6ebf75c54d60440eaf1b07115bff0bc5')
    ->setClientSecret('3148349a1d19467f8c40f4f7dfa49454')
    ->setUsername('test.eukless')
    ->setPassword('Aegp1s')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);
*/

$mailevaApiAdapter = new \MailevaApiAdapter\App\MailevaApiAdapter($mailevaConnection);


function testPost(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{


    $mailevaSending = new \MailevaApiAdapter\App\MailevaSending();
    $mailevaSending
        ->setName((new DateTime())->format('Y-m-d H:i:s'))
        ->setPostageType('FAST')
        ->setColorPrinting(true)
        ->setDuplexPrinting(true)
        ->setOptionalAddressSheet(false)
        ->setNotificationEmail('')
        ->setFile('/var/www/maileva/cybble/public/testFiles/pdf_result_23-03-2018_15-34-59.pdf')
        //->setFilepriority()  #optionnal default 1
        ->setFilename('document.pdf')
        ->setAddressLine1('Mr Robert jacques')
        ->setAddressLine2('8 boulevard saint léger')
        //->setAddressLine3()  #optionnal default ''
        //->setAddressLine4() #optionnal default ''
        //->setAddressLine5() #optionnal default ''
        ->setAddressLine6('13001 Marseille')
        //->setCountryCode() #optionnal default FR
        ->setCustomId('My custom ID')
        ->validate();

    try {
        $sendingId = $mailevaApiAdapter->post($mailevaSending);
        echo "sendingId = " . $sendingId;
    } catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
        var_dump($e);
    }

}

#testPost($mailevaApiAdapter);
#deleteAll($mailevaApiAdapter);

$sendingId = "cb97075f-6c8d-44de-8e62-d0284652cf7e";
$result = $mailevaApiAdapter->getSendingBySendingId($sendingId);
var_dump($result->getResponseAsArray());
$result = $mailevaApiAdapter->getRecipientsBySendingId($sendingId);
var_dump($result->getResponseAsArray());
$result = $mailevaApiAdapter->getDocumentsBySendingId($sendingId);
var_dump($result->getResponseAsArray());
//$result = $mailevaApiAdapter->getDocumentBySendingId($sendingId, '76968db3-52c6-4bf6-92ce-9a95def66bef');


function deleteAll(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{
    $result = $mailevaApiAdapter->getSendings();
    if (empty($result->getResponseAsArray()['sendings']) === false) {
        for ($i = 0; $i < count($result->getResponseAsArray()['sendings']); $i++) {
            if ($result->getResponseAsArray()['sendings'][$i]['status'] === "DRAFT") {
                $sendingId = $result->getResponseAsArray()['sendings'][$i]['id'];
                $result = $mailevaApiAdapter->deleteSendingBySendingId($sendingId);
                var_dump($result->getResponseAsArray());
            }
        }

    }
    $result = $mailevaApiAdapter->getSendings();
    var_dump($result->getResponseAsArray());

}


function testCall(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{


    $sendings = $mailevaApiAdapter->getSendings();
    echo "lecture des envois" . PHP_EOL;
    var_dump($sendings->getResponseAsArray());


    if (empty($sendings->getResponseAsArray()['sendings'])) {
        $result = $mailevaApiAdapter->postSending(['name' => 'test loic' . rand()]);
        echo "réponse creation de l'envoi" . PHP_EOL;
        var_dump($result->getResponseAsArray());

        echo "lecture des envois" . PHP_EOL;
        $result = $mailevaApiAdapter->getSendings();
        var_dump($result->getResponseAsArray());
    } else {
        for ($i = 0; $i < count($sendings->getResponseAsArray()['sendings']); $i++) {
            if ($sendings->getResponseAsArray()['sendings'][$i]['status'] === "DRAFT") {
                $sendingId = $sendings->getResponseAsArray()['sendings'][$i]['id'];
            }
        }
    }

    if (isset($sendingId)) {

        $result = $mailevaApiAdapter->getSendingBySendingId($sendingId);

        echo "information du premier envoi de la liste" . PHP_EOL;
        var_dump($result->getResponseAsArray());


        $result = $mailevaApiAdapter->patchSendingBySendingId($sendingId,
            ["postage_type" => "FAST",
                "color_printing" => true,
                "duplex_printing" => true,
                "optional_address_sheet" => true,
                "undelivered_mails_management" => true,
                "notification_email" => "loic.pettiti@gmail.com",
                //"return_envelope_reference" => "envelope_reference"
            ]
        );
        echo "réponse du patch de l'envoi" . PHP_EOL;
        var_dump($result);

        $result = $mailevaApiAdapter->postDocumentBySendingId($sendingId,

            [
                [
                    'name' => 'document',
                    'contents' => \GuzzleHttp\Psr7\stream_for(fopen('/var/www/maileva/cybble/public/testFiles/pdf_result_23-03-2018_15-34-59.pdf', 'rb'))
                ],
                [
                    'name' => 'metadata',
                    'contents' => '{"priority": 4,"name":"document.pdf"}'
                ]

            ]

        );
        echo "réponse de l'ajout du fichier" . PHP_EOL;
        var_dump($result->getResponseAsArray());

        $result = $mailevaApiAdapter->getDocumentsBySendingId($sendingId);
        echo "lecture des informations du fichier ajouté" . PHP_EOL;
        var_dump($result->getResponseAsArray());


        $result = $mailevaApiAdapter->postImportRecipientsBySendingId($sendingId,
            ['import_recipients' =>
                [
                    [
                        'address_line_1' => 'Mr Nom8 Prénom8',
                        'address_line_2' => '8 boulevard de la tapenade',
                        'address_line_3' => 'Quartier clemenceau',
                        'address_line_4' => '',
                        'address_line_5' => '',
                        'address_line_6' => '13001 Marseille',
                        'country_code' => 'FR',
                        'custom_id' => 'My custom ID'
                    ]
                ]
            ]
        );
        echo "réponse de l'ajout d'un destinataire" . PHP_EOL;
        var_dump($result->getResponseAsArray());

        $result = $mailevaApiAdapter->getRecipientsBySendingId($sendingId, 1, 100);
        echo "lecture des informations du destinataire" . PHP_EOL;
        var_dump($result->getResponseAsArray());


        $result = $mailevaApiAdapter->postSendingBySendingId($sendingId);
        echo "réponse de la soumission du formulaire" . PHP_EOL;
        var_dump($result->getResponseAsArray());


        $result = $mailevaApiAdapter->getSendingBySendingId($sendingId);

        echo "relecture des informations du premier envoi de la liste" . PHP_EOL;
        var_dump($result->getResponseAsArray());

        echo "relecture des envois" . PHP_EOL;
        $result = $mailevaApiAdapter->getSendings();
        var_dump($result->getResponseAsArray());

    } else {
        $result = $mailevaApiAdapter->postSending(['name' => 'test loic' . rand()]);
        echo "réponse creation de l'envoi" . PHP_EOL;
        var_dump($result->getResponseAsArray());

        echo "lecture des envois" . PHP_EOL;
        $result = $mailevaApiAdapter->getSendings();
        var_dump($result->getResponseAsArray());
    }


    //


}

#testCall($mailevaApiAdapter);
#deleteAll($mailevaApiAdapter);


/*
function testRoute(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_AUTHENTICATION,
        [
            'params' => [
                'client_id' => 'd9ca6d5e349d44acacdce7e3bb0d0c14',
                'client_secret' => '976b0aa3dbd74ce0a107586ac1d6c528',
                'username' => 'recette.eukles',
                'password' => '3ukl3s!'
            ],
        ]
    );
    $result = $route->call();
    var_dump($result->getResponseAsJson());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_AUTHENTICATION,
        [
            'params' => [
                'body' => ' {"client_id": "string","redirect_uri": "string","state": "string","response_type": "token"}'
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_SENDING,
        [
            'params' => [
                'body' => '{"name": "string"}'
            ],
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_SENDINGS,
        []
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_SENDING_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1
            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::DELETE_SENDING_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_DOCUMENT_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1,
                'file' => 'file_field'
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_DOCUMENTS_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1

            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_DOCUMENT_POSITION_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1,
                'document_id' => 2,
                'position' => 3
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_DOCUMENT_FROM_LIBRARY,
        [
            'params' => [
                'sending_id' => 1,
                'file_id' => 2
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::DELETE_DOCUMENT_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1,
                'document_id' => 2
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1,
                'body' => '{"address_line_1": "string","address_line_2": "string","address_line_3": "string","address_line_4": "string","address_line_5": "string","address_line_6": "string","country_code": "string","custom_id": "string"}'
            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_IMPORT_RECIPIENTS_BY_SENDING_ID_AND_IMPORT_ID,
        [
            'params' => [
                'sending_id' => 1,
                'import_id' => 2
            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_RECIPIENTS_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1
            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::DELETE_RECIPIENTS_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1
            ]
        ]
    );
    var_dump($route->call());

    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID_FROM_ADDRESS_BOOK,
        [
            'params' => [
                'sending_id' => 1,
                'body' => '{"id": "string"}'
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::GET_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
        [
            'params' => [
                'sending_id' => 1,
                'recipient_id' => 2
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::DELETE_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
        [
            'params' => [
                'sending_id' => 1,
                'recipient_id' => 2
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::PATCH_SENDING_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1,
                'body' => '{"postage_type": "FAST","color_printing": true,"duplex_printing": true,"optional_address_sheet": true,"undelivered_mails_management": true,"notification_email": "string"}'
            ]
        ]
    );
    var_dump($route->call());


    $route = new \MailevaApiAdapter\App\Core\Route(\MailevaApiAdapter\App\Core\Routing::POST_SENDING_BY_SENDING_ID,
        [
            'params' => [
                'sending_id' => 1
            ]
        ]
    );
    var_dump($route->call());


}
*/






