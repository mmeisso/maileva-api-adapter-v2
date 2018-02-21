# Maileva Api Connector

## Prepare adapter
    #Connection settings
    $mailevaConnection = new \MailevaApiAdapter\App\MailevaConnection();

    $mailevaConnection->setEnv('DEV')
        ->setClientId('[CLIENT_ID]')
        ->setClientSecret('[CLIENT_SECRET]')
        ->setUsername('[CLIENT_USERNAME]')
        ->setPassword('[CLIENT_PASSWORD]')
        ->setMemcacheHost('localhost')
        ->setMemcachePort(11211);

## Post sending
    #Sending settings
    $mailevaSending = new \MailevaApiAdapter\App\MailevaSending();
    $mailevaSending
        ->setName((new DateTime())->format('Y-m-d H:i:s'))
        ->setPostageType('FAST')
        ->setColorPrinting(true)
        ->setDuplexPrinting(true)
        ->setOptionalAddressSheet(false)
        ->setNotificationEmail('lpettiti@eukles.com')
        ->setFile('/var/www/maileva/cybble/public/testFiles/document.pdf')
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
        
    #Post sending    
    try {
        $sendingId = $mailevaApiAdapter->post($mailevaSending);
        echo "sendingId = " . $sendingId;
    } catch (\MailevaApiAdapter\App\Exception\MailevaException $e) {
        error_log($e);
    }
    
## Get sending details
    $result = $mailevaApiAdapter->getSendingBySendingId('[SENDING_ID]');
    var_dump($result->getResponseAsArray());

## Get recipients details
    $result = $mailevaApiAdapter->getRecipientsBySendingId('[SENDING_ID]');
    var_dump($result->getResponseAsArray());

## Get documents details
    $result = $mailevaApiAdapter->getDocumentsBySendingId('[SENDING_ID]');
    var_dump($result->getResponseAsArray());