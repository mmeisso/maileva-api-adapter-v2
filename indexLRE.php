<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

$mailevaConnectionSandBoxClassic = new \MailevaApiAdapter\App\MailevaConnection();
$mailevaConnectionSandBoxClassic
    ->setAuthenticationHost('https://api.sandbox.aws.maileva.net')
    ->setHost('https://api.sandbox.aws.maileva.net')
    ->setType(\MailevaApiAdapter\App\MailevaConnection::CLASSIC)
    ->setClientId('2382a479-a4a6-4618-9854-0dbd6bcec849')
    ->setClientSecret('3151dfc6-fbab-4597-86f9-fa7ecb799137')
    ->setUsername('sandbox.1567')
    ->setPassword('o93126')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);

$mailevaConnectionSandBoxLRE = new \MailevaApiAdapter\App\MailevaConnection();
$mailevaConnectionSandBoxLRE
    ->setAuthenticationHost('https://api.sandbox.aws.maileva.net')
    ->setHost('https://api.sandbox.aws.maileva.net')
    ->setType(\MailevaApiAdapter\App\MailevaConnection::LRE)
    ->setClientId('2382a479-a4a6-4618-9854-0dbd6bcec849')
    ->setClientSecret('3151dfc6-fbab-4597-86f9-fa7ecb799137')
    ->setUsername('sandbox.1567')
    ->setPassword('o93126')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);

$mailevaConnectionProdClassic = new \MailevaApiAdapter\App\MailevaConnection();
$mailevaConnectionProdClassic
    ->setAuthenticationHost('https://connect.maileva.com')
    ->setHost('https://api.maileva.com')
    ->setType(\MailevaApiAdapter\App\MailevaConnection::CLASSIC)
    ->setClientId('6ebf75c54d60440eaf1b07115bff0bc5')
    ->setClientSecret('3148349a1d19467f8c40f4f7dfa49454')
    ->setUsername('EUKLES.EUKLES')
    ->setPassword('XeL9yAJyvy')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);

$mailevaConnectionProdLRE = new \MailevaApiAdapter\App\MailevaConnection();
$mailevaConnectionProdLRE
    ->setAuthenticationHost('https://connect.maileva.com')
    ->setHost('https://api.maileva.com')
    ->setType(\MailevaApiAdapter\App\MailevaConnection::LRE)
    ->setClientId('6ebf75c54d60440eaf1b07115bff0bc5')
    ->setClientSecret('3148349a1d19467f8c40f4f7dfa49454')
    ->setUsername('EUKLES.EUKLES')
    ->setPassword('XeL9yAJyvy')
    ->setMemcacheHost('localhost')
    ->setMemcachePort(11211);

$mailevaApiAdapterSandBoxClassic = new \MailevaApiAdapter\App\MailevaApiAdapter($mailevaConnectionSandBoxClassic);
$mailevaApiAdapterSandBoxLRE     = new \MailevaApiAdapter\App\MailevaApiAdapter($mailevaConnectionSandBoxLRE);

$mailevaApiAdapterProdClassic = new \MailevaApiAdapter\App\MailevaApiAdapter($mailevaConnectionProdClassic);
$mailevaApiAdapterProdLRE     = new \MailevaApiAdapter\App\MailevaApiAdapter($mailevaConnectionProdLRE);

function testPost(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter)
{

    try {
        $mailevaSending = new \MailevaApiAdapter\App\MailevaSending();
        $mailevaSending
            ->setName((new DateTime())->format('Y-m-d H:i:s'))
            ->setPostageType(\MailevaApiAdapter\App\MailevaSending::POSTAGE_TYPE_LRE)
            ->setColorPrinting(true)
            ->setDuplexPrinting(true)
            ->setOptionalAddressSheet(false)
            ->setFile('/var/www/maileva/cybble/public/testFiles/document.pdf')
            //->setFilepriority()  #optionnal default 1
            ->setFilename('document.pdf')
            ->setAddressLine1('Mr. Rousseaux damien')
            ->setAddressLine2('Eukles Solutions')
            ->setAddressLine3('236 Rue de Saint Honorat')#optionnal default ''
            //->setAddressLine4() #optionnal default ''
            //->setAddressLine5() #optionnal default ''
            ->setAddressLine6('83510 Lorgues')
            //->setCountryCode() #optionnal default FR

            ->setNotificationEmail('lpettiti@eukles.com')
            ->setSenderAddressLine1('M. Pettiti Loïc')
            ->setSenderAddressLine2('Eukles Solutions')
            ->setSenderAddressLine3('236 Rue de Saint Honorat')#optionnal default ''
            #->setSenderAddressLine4('Batiment')#optionnal default ''
            #->setSenderAddressLine5('Etage 1')#optionnal default ''
            ->setSenderAddressLine6('83510 Lorgues')
            ->setSenderCountryCode('FR')#optionnal default FR

            ->setCustomId('1')
            ->validate($mailevaApiAdapter);

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, true);
        $mailevaApiAdapter->submit($sendingId);
        echo "sendingId = " . $sendingId . "<br/>";
        debugSendingId($mailevaApiAdapter, $sendingId);
    } catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
        var_dump($e);
    }
}

/**
 * @param \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter
 * @param                                          $sendingId
 *
 * @throws \MailevaApiAdapter\App\Exception\MailevaException
 * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
 * @throws \MailevaApiAdapter\App\Exception\RoutingException
 */
function debugSendingId(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter, $sendingId)
{
    echo "getSendingBySendingId<br/>";
    $result = $mailevaApiAdapter->getSendingBySendingId($sendingId);
    var_dump($result->getResponseAsArray());

    $recipientId = $mailevaApiAdapter->getRecipientsBySendingId($sendingId)->getResponseAsArray()['recipients'][0]['id'];

    echo "getRecipientBySendingIdAndRecipientId<br/>";
    $result = $mailevaApiAdapter->getRecipientBySendingIdAndRecipientId($sendingId, $recipientId);
    var_dump($result);

    echo "getSendingStatusBySendingIdAndRecipientId<br/>";
    $result = $mailevaApiAdapter->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId);
    var_dump($result);

    if (array_key_exists(\MailevaApiAdapter\App\Core\MailevaLREStatuses::DELIVERY_STATUSES, $result->getResponseAsArray())){
        /** @var \MailevaApiAdapter\App\Core\MailevaLREStatuses $mailevaLREStatuses */
        $mailevaLREStatuses = $result->getResponseAsArray()[\MailevaApiAdapter\App\Core\MailevaLREStatuses::DELIVERY_STATUSES];
        $lastStatus =$mailevaLREStatuses->getActiveStatus();
        echo "getActiveStatus<br/>";
        var_dump($lastStatus);

    }



//    echo "getDocumentBySendingId<br/>";
//    $result = $mailevaApiAdapter->getDocumentBySendingId($sendingId,
//        $mailevaApiAdapter->getDocumentsBySendingId($sendingId)->getResponseAsArray()['documents'][0]['id']);
//    var_dump($result->getResponseAsArray());
////
//    echo "downloadDepositProofBySendingId";
//    $tmpFile = '/tmp/mailevaDepositProof'.$sendingId.'.zip';
//    $result = $mailevaApiAdapter->downloadDepositProofBySendingId($sendingId, $tmpFile);
//    var_dump($result->getResponseAsArray());

   // echo "downloadAcknowledgementOfReceiptBySendingIdAndRecipientId";
   // $tmpFile = '/tmp/mailevaAcknowledgementOfReceipt' . $sendingId . '.pdf';
   // $result  = $mailevaApiAdapter->downloadAcknowledgementOfReceiptBySendingIdAndRecipientId($sendingId, $recipientId, $tmpFile);
    //var_dump($result->getResponseAsArray());
}

$mailevaApiAdapter = $mailevaApiAdapterProdLRE;
#$mailevaApiAdapter = $mailevaApiAdapterSandBoxLRE;

try {
#testPost($mailevaApiAdapter);
#die;

#PROD !
    $sendingId = '99988654-118e-4143-b549-823b89428a00';

#DEV !
    #$sendingId = '663fb844-1bf9-4f87-a1a1-6b958673736a';
    debugSendingId($mailevaApiAdapter, $sendingId);
#die;

} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
    var_dump($e);
}
die;
try {
    $sendings = $mailevaApiAdapter->getSendings();
    echo "lecture des envois" . PHP_EOL;
    var_dump($sendings->getResponseAsArray());
} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
    var_dump($e);
}




