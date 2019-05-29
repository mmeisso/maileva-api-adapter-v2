<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Faker\Factory;
use MailevaApiAdapter\App\Exception\MailevaException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaConnection;
use MailevaApiAdapter\App\MailevaSending;

class Unit extends \Codeception\Module
{

    const AUTHENTICATION_HOST = 'https://api.sandbox.aws.maileva.net';
    const HOST = 'https://api.sandbox.aws.maileva.net';
    const CLIENT_ID = '2382a479-a4a6-4618-9854-0dbd6bcec849';
    const CLIENT_SECRET = '3151dfc6-fbab-4597-86f9-fa7ecb799137';
    const USERNAME = 'sandbox.1567';
    const PASSWORD = 'o93126';
    const FTP_HOST = 'ftp.recette.maileva.com';
    const FTP_USERNAME = 'sandbox.1662';
    const FTP_PASSWORD = 'lfqcs7';
    const FTP_CLIENT_ID = 'mlv-s-cdbSJ3F';
    const FTP_CLIENT_SECRET = 'UxSqjsB';
    const MEMCACHE_HOST = 'localhost';
    const MEMCACHE_PORT = 11211;
    const NOTIFICATION_EMAIL = 'lpettiti@eukles.com';

    /**
     * @return MailevaApiAdapter
     */
    public function getMailevaApiAdapterClassic(): MailevaApiAdapter
    {
        $mailevaConnection = $this->getMailevaApiConnection();
        $mailevaConnection->setType(MailevaConnection::CLASSIC);
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
     * @return MailevaApiAdapter
     */
    public function getMailevaApiAdapterLRCOPRO(): MailevaApiAdapter
    {
        $mailevaConnection = new MailevaConnection();
        $mailevaConnection->setType(MailevaConnection::LRCOPRO);
        $mailevaConnection
            ->setAuthenticationHost("")
            ->setHost(self::FTP_HOST)
            ->setClientId(self::FTP_CLIENT_ID)
            ->setClientSecret(self::FTP_CLIENT_SECRET)
            ->setUsername(self::FTP_USERNAME)
            ->setPassword(self::FTP_PASSWORD)
            ->setMemcacheHost(self::MEMCACHE_HOST)
            ->setMemcachePort(self::MEMCACHE_PORT);
        return new MailevaApiAdapter($mailevaConnection);
    }

    /**
     * @return MailevaConnection
     */
    public function getMailevaApiConnection(): MailevaConnection
    {
        $mailevaConnection = new MailevaConnection();
        $mailevaConnection
            ->setAuthenticationHost(self::AUTHENTICATION_HOST)
            ->setHost(self::HOST)
            ->setClientId(self::CLIENT_ID)
            ->setClientSecret(self::CLIENT_SECRET)
            ->setUsername(self::USERNAME)
            ->setPassword(self::PASSWORD)
            ->setMemcacheHost(self::MEMCACHE_HOST)
            ->setMemcachePort(self::MEMCACHE_PORT);
        return $mailevaConnection;
    }

    /**
     * @param MailevaApiAdapter $mailevaApiAdapter
     *
     * @return MailevaSending
     * @throws MailevaException
     */
    public function getMailevaSending(MailevaApiAdapter $mailevaApiAdapter): MailevaSending
    {
        $mailevaSending = null;
        switch ($mailevaApiAdapter->getType()) {
            case MailevaConnection::CLASSIC:
                $mailevaSending = $this->getMailevaSendingClassic();
                break;
            case MailevaConnection::LRE:
                $mailevaSending = $this->getMailevaSendingLRE();
                break;
            case MailevaConnection::LRCOPRO:
                $mailevaSending = $this->getMailevaSendingLRCOPRO();
                break;
            default:
                throw new MailevaException('Unable to retreive $mailevaApiAdapter->getType() : ' . $mailevaApiAdapter->getType());
        }

        $mailevaSending->validate($mailevaApiAdapter);
        return $mailevaSending;
    }

    /**
     * @return MailevaSending
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    private function getMailevaSendingCommon(): MailevaSending
    {
        $address        = $this->getRandomAddress();
        $mailevaSending = new MailevaSending();

        $sendingName          = (new \DateTime())->format('Y-m-d H:i:s') . ' ' . Factory::create('fr_FR')->name;
        $colorPrinting        = (rand(0, 50) < 50) ? true : false;
        $duplexPrinting       = (rand(0, 50) < 50) ? true : false;
        $optionalAddressSheet = (rand(0, 50) < 50) ? true : false;
        $fileName             = Factory::create('fr_FR')->word . '.pdf';
        $file                 = (rand(0, 50) < 50) ? 'testFiles/1pageWithTextLayer.pdf' : 'testFiles/1pageWithoutTextLayer.pdf';

        $mailevaSending
            ->setName($sendingName)
            ->setColorPrinting($colorPrinting)
            ->setDuplexPrinting($duplexPrinting)
            ->setOptionalAddressSheet($optionalAddressSheet)
            ->setFile(codecept_root_dir() . $file)
            //->setFilepriority()  #optionnal default 1
            ->setFilename($fileName)
            ->setAddressLine1($address['line1'])
            ->setAddressLine2($address['line2'])
            ->setAddressLine3($address['line3'])#optionnal default ''
            ->setAddressLine4($address['line4'])#optionnal default ''
            ->setAddressLine5($address['line5'])#optionnal default ''
            ->setAddressLine6($address['line6'])
            //->setCountryCode() #optionnal default FR
            ->setCustomId('1');

        return $mailevaSending;
    }

    /**
     * @return MailevaSending
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    private function getMailevaSendingClassic(): MailevaSending
    {
        $mailevaSending = $this->getMailevaSendingCommon();
        $postagetType   = (rand(0, 50) < 50) ? MailevaSending::POSTAGE_TYPE_FAST : MailevaSending::POSTAGE_TYPE_ECONOMIC;

        $mailevaSending->setPostageType($postagetType);

        return $mailevaSending;
    }

    /**
     * @return MailevaSending
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    private function getMailevaSendingLRE(): MailevaSending
    {
        $mailevaSending = $this->getMailevaSendingCommon();
        $senderAddress  = $this->getRandomAddress();
        $mailevaSending
            ->setPostageType(MailevaSending::POSTAGE_TYPE_LRE)
            ->setNotificationEmail(self::NOTIFICATION_EMAIL)
            ->setSenderAddressLine1($senderAddress['line1'])
            ->setSenderAddressLine2($senderAddress['line2'])
            ->setSenderAddressLine3($senderAddress['line3'])#optionnal default ''
            ->setSenderAddressLine4($senderAddress['line4'])#optionnal default ''
            ->setSenderAddressLine5($senderAddress['line5'])#optionnal default ''
            ->setSenderAddressLine6($senderAddress['line6']);

        return $mailevaSending;
    }

    /**
     * @return MailevaSending
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    private function getMailevaSendingLRCOPRO(): MailevaSending
    {
        $mailevaSending = $this->getMailevaSendingCommon();
        $mailevaSending ->setFile(codecept_root_dir() . 'testFiles/147pages.pdf');
        $senderAddress  = $this->getRandomAddress();
        $mailevaSending
            ->setPostageType(MailevaSending::POSTAGE_TYPE_LRCOPRO)
            ->setNotificationEmail(self::NOTIFICATION_EMAIL)
            ->setSenderAddressLine1($senderAddress['line1'])
            ->setSenderAddressLine2($senderAddress['line2'])
            ->setSenderAddressLine3($senderAddress['line3'])#optionnal default ''
            ->setSenderAddressLine4($senderAddress['line4'])#optionnal default ''
            ->setSenderAddressLine5($senderAddress['line5'])#optionnal default ''
            ->setSenderAddressLine6($senderAddress['line6']);

        return $mailevaSending;
    }

    private function getRandomAddress()
    {
        $address = [];
        $faker   = Factory::create('fr_FR');
        $rand    = rand(0, 100);

        if ($rand < 33) {
            $address['line1'] = $faker->title() . ' ' . $faker->name;
            $address['line2'] = '';
        } elseif ($rand < 66) {
            $address['line1'] = '';
            $address['line2'] = strtoupper($faker->companySuffix . ' ' . $faker->company);
        } else {
            $address['line1'] = $faker->title() . ' ' . $faker->name;
            $address['line2'] = strtoupper($faker->companySuffix . ' ' . $faker->company);
        }

        $rand = rand(0, 100);

        if ($rand < 33) {
            $address['line3'] = $faker->jobTitle;
            $address['line4'] = '';
        } elseif ($rand < 66) {
            $address['line3'] = '';
            $address['line4'] = strtoupper($faker->word);
        } else {
            $address['line3'] = $faker->jobTitle;
            $address['line4'] = strtoupper($faker->word);
        }

        $address['line5'] = $faker->streetAddress;
        $address['line6'] = preg_replace('/\s+/', '', $faker->postcode) . ' ' . $faker->city;

        return $address;
    }
}
