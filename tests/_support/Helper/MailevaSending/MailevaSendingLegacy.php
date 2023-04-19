<?php

namespace MailevaApiAdapter\tests\_support\Helper\MailevaSending;

use Faker\Factory;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\MailevaSending as MailevaSendingApp;

class MailevaSendingLegacy extends MailevaSendingDocument
{
    /**
     * @throws MailevaCoreException
     */
    protected function getMailevaSendingCommon(): MailevaSendingApp
    {
        $address        = $this->getRandomAddress();
        $senderAddress  = $this->getRandomAddress();
        $mailevaSending = new MailevaSendingApp();

        $sendingName          = (new \DateTime())->format('Y-m-d H:i:s') . ' ' . Factory::create('fr_FR')->name;
        $colorPrinting        = (rand(0, 100) < 50) ? true : false;
        $duplexPrinting       = (rand(0, 100) < 50) ? true : false;
        $optionalAddressSheet = (rand(0, 100) < 50) ? true : false;
        $fileName             = Factory::create('fr_FR')->word . '.pdf';
        $file                 = (rand(0, 100) < 50) ? 'testFiles/1pageWithTextLayer.pdf' : 'testFiles/1pageWithoutTextLayer.pdf';

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
     * @return MailevaSendingAbstract
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    protected function getMailevaSendingLRCOPRO(): MailevaSendingApp
    {
        $mailevaSending = $this->getMailevaSendingCommon();
        $mailevaSending->setFile(codecept_root_dir() . 'testFiles/14pages.pdf');
        $senderAddress = $this->getRandomAddress();
        $mailevaSending
            ->setPostageType(MailevaSendingApp::POSTAGE_TYPE_LRCOPRO)
            ->setTreatUndeliveredMail(false)
            ->setNotificationEmail(self::NOTIFICATION_EMAIL)
            ->setSenderAddressLine1($senderAddress['line1'])
            ->setSenderAddressLine2($senderAddress['line2'])
            ->setSenderAddressLine3($senderAddress['line3'])#optionnal default ''
            ->setSenderAddressLine4($senderAddress['line4'])#optionnal default ''
            ->setSenderAddressLine5($senderAddress['line5'])#optionnal default ''
            ->setSenderAddressLine6($senderAddress['line6']);

        return $mailevaSending;
    }
}