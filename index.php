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
            ->setPostageType(\MailevaApiAdapter\App\MailevaSending::POSTAGE_TYPE_FAST)
            ->setColorPrinting(true)
            ->setDuplexPrinting(true)
            ->setOptionalAddressSheet(false)
            ->setFile('/var/www/maileva/cybble/public/testFiles/document.pdf')
            //->setFilepriority()  #optionnal default 1
            ->setFilename('document.pdf')
            ->setAddressLine1('M. Pettitti Loïc')
            ->setAddressLine2('Eukles Solutions')
            ->setAddressLine3('236 Rue de St Honorat')#optionnal default ''
            //->setAddressLine4() #optionnal default ''
            //->setAddressLine5() #optionnal default ''
            ->setAddressLine6('83510 Lorgues')
            //->setCountryCode() #optionnal default FR
            ->setCustomId('1')
            ->validate($mailevaApiAdapter);

        $sendingId = $mailevaApiAdapter->post($mailevaSending, true);
        echo "sendingId = " . $sendingId . "<br/>";
    } catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
        var_dump($e);
    }
}

/**
 * @param \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter
 * @param                                          $sendingId
 *
 * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
 * @throws \MailevaApiAdapter\App\Exception\RoutingException
 */
function debugSendingId(\MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter, $sendingId)
{
    $result = $mailevaApiAdapter->getSendingBySendingId($sendingId);
    var_dump($result->getResponseAsArray());

    $result = $mailevaApiAdapter->getRecipientBySendingIdAndRecipientId($sendingId,
        $mailevaApiAdapter->getRecipientsBySendingId($sendingId)->getResponseAsArray()['recipients'][0]['id']);
    var_dump($result);

    $result = $mailevaApiAdapter->getDocumentBySendingIdAndDocumentId($sendingId,
        $mailevaApiAdapter->getDocumentsBySendingId($sendingId)->getResponseAsArray()['documents'][0]['id']);
    var_dump($result->getResponseAsArray());
}

$mailevaApiAdapter = $mailevaApiAdapterProdClassic;
$mailevaApiAdapter = $mailevaApiAdapterSandBoxClassic;
try {
//testPost($mailevaApiAdapter);
//die;

$sendingId = '35987f0c-18b7-4524-b163-462416cdfc60';
debugSendingId($mailevaApiAdapter, $sendingId);
die;
} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
    var_dump($e);
}

try {
    $sendings = $mailevaApiAdapter->getSendings();
    echo "lecture des envois" . PHP_EOL;
    var_dump($sendings->getResponseAsArray());
} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
    var_dump($e);
}









