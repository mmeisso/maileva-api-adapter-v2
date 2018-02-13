<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

$clientId = 'd9ca6d5e349d44acacdce7e3bb0d0c14';
$clientSecret = '976b0aa3dbd74ce0a107586ac1d6c528';
$username = 'recette.eukles';
$password = '3ukl3s!';

$mailevaApiAdapter = new \MailevaApiAdapter\App\MailevaApiAdapter($clientId, $clientSecret, $username, $password);


function testCall(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{
    $result = $mailevaApiAdapter->getSendings();
    var_dump($result);

}

testCall($mailevaApiAdapter);

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






