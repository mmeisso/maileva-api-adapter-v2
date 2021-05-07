<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

?>

<form action="index.php">

    <input type="text"  name="start" value ="660"/>
	<input type="text"  name="end" value="50"/>
    <br/>
    <input type="submit" />

</form>


<?php


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
            ->setFile('/var/www/maileva/cybble/public/testFiles/1pageWithTextLayer.pdf')
            //->setFilepriority()  #optionnal default 1
            ->setFilename('1pageWithTextLayer.pdf')
            ->setAddressLine1('M. Pettitti Loïc')
            ->setAddressLine2('Eukles Solutions')
            ->setAddressLine3('236 Rue de St Honorat')#optionnal default ''
            //->setAddressLine4() #optionnal default ''
            //->setAddressLine5() #optionnal default ''
            ->setAddressLine6('83510 Lorgues')
            //->setCountryCode() #optionnal default FR
            ->setCustomId('1')
            ->validate($mailevaApiAdapter);

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, true);
        //$mailevaApiAdapter->submit($sendingId);
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
 * @throws \MailevaApiAdapter\App\Exception\MailevaRoutingException
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
//$mailevaApiAdapter = $mailevaApiAdapterSandBoxClassic;
//try {
////testPost($mailevaApiAdapter);
////die;
//
//$oups = 'e7db7f6e-e8f6-4e9c-97e2-5682479831cf';
//$duxplexOn = '8c526ac2-bcc8-4710-b995-76dd9dc8c4b8';
//$duxplexOff = '0b7b705c-72ee-4a34-9832-7723cc5044b2';

$sendingId =  "c0288884-57bf-4326-8556-11d4240580cd";
//testPost($mailevaApiAdapter);

//die;

//$mailevaApiAdapter->submit($sendingId);
//die;
debugSendingId($mailevaApiAdapter, $sendingId);
die;
//die;
//} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
//    var_dump($e);
//}

try {
    $sendings = $mailevaApiAdapter->getSendings();
    echo "lecture des envois" . PHP_EOL;
    var_dump($sendings->getResponseAsArray());
} catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
    var_dump($e);
}










