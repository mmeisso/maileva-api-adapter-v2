<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Faker\Factory;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaConnection;
use MailevaApiAdapter\App\MailevaSending;
use MailevaApiAdapter\tests\_support\Helper\MailevaSending\MailevaSendingAbstract;
use MailevaApiAdapter\tests\_support\Helper\MailevaSending\MailevaSendingDocument;
use MailevaApiAdapter\tests\_support\Helper\MailevaSending\MailevaSendingLegacy;

class Unit extends \Codeception\Module
{

//    const AUTHENTICATION_HOST = 'https://api.sandbox.maileva.net';
//    const HOST = 'https://api.sandbox.maileva.net';
//    const CLIENT_ID = '2382a479-a4a6-4618-9854-0dbd6bcec849';
//    const CLIENT_SECRET = '3151dfc6-fbab-4597-86f9-fa7ecb799137';
//    const USERNAME = 'sandbox.1567';
//    const PASSWORD = 'o93126';

    const HOST_ENV = MailevaConnection::HOST_ENV_SANDBOX;
    const CLIENT_ID = 'sandbox-EUKLES';
    const CLIENT_SECRET = '4131d512-9f5b-43de-83e6-eac84059bc6a';
    const USERNAME = 'sandbox.1567';
    const PASSWORD = 'o93126/A*';
    const FTP_USERNAME = 'sandbox.1662';
    const FTP_PASSWORD = 'lfqcs7';
    const FTP_CLIENT_ID = 'mlv-s-cdbSJ3F';
    const FTP_CLIENT_SECRET = 'UxSqjsB';
    const NOTIFICATION_EMAIL = MailevaSendingAbstract::NOTIFICATION_EMAIL;
    const DIRECTORY_CALLBACK = '/retour_sandbox.1662';
    const TMP_FILE_DIRECTORY = '/tmp/MAILEVA';


    /**
     * @return MailevaApiAdapter
     * @throws ApiException
     * @throws MailevaCoreException
     */
    public function getMailevaApiAdapterClassic(): MailevaApiAdapter
    {
        $mailevaConnection = $this->getMailevaApiConnection();
        $mailevaConnection->setType(MailevaConnection::CLASSIC);
        return new MailevaApiAdapter($mailevaConnection);
    }

    /**
     * @return MailevaApiAdapter
     * @throws ApiException
     */
    public function getMailevaApiAdapterLRCOPRO(): MailevaApiAdapter
    {
        $mailevaConnection = $this->getMailevaApiConnection();
        $mailevaConnection
            ->setType(MailevaConnection::LRCOPRO)
            ->setHostEnv(self::HOST_ENV)
            ->setFtpClientId(self::FTP_CLIENT_ID)
            ->setFtpClientSecret(self::FTP_CLIENT_SECRET)
            ->setFtpUserName(self::FTP_USERNAME)
            ->setFtpPassword(self::FTP_PASSWORD)
            ->setDirectoryCallback(self::DIRECTORY_CALLBACK)
            ->setTmpFileDirectory(self::TMP_FILE_DIRECTORY);
        return new MailevaApiAdapter($mailevaConnection);
    }

    /**
     * @return MailevaApiAdapter
     */
    public function getMailevaApiAdapterLRE(): MailevaApiAdapter
    {
        $mailevaConnection = $this->getMailevaApiConnection();
        $mailevaConnection->setType(MailevaConnection::LRE);
        return new MailevaApiAdapter($mailevaConnection);
    }

    /**
     * @return MailevaConnection
     * @throws MailevaCoreException
     */
    public function getMailevaApiConnection(): MailevaConnection
    {
        $mailevaConnection = new MailevaConnection();
        $mailevaConnection
            ->setHostEnv(self::HOST_ENV)
            ->setClientId(self::CLIENT_ID)
            ->setClientSecret(self::CLIENT_SECRET)
            ->setUsername(self::USERNAME)
            ->setPassword(self::PASSWORD);
        return $mailevaConnection;
    }

    public function getMailevaSending(MailevaApiAdapter $mailevaApiAdapter): MailevaSending
    {
        $sending = new MailevaSendingDocument();

        return $sending->getMailevaSending($mailevaApiAdapter);
    }

    public function getMailevaSendingLegacy(MailevaApiAdapter $mailevaApiAdapter): MailevaSending
    {
        $sending = new MailevaSendingLegacy();

        return $sending->getMailevaSending($mailevaApiAdapter);
    }
}
