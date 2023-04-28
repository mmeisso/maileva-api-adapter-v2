<?php

namespace MailevaApiAdapter\tests\_support\Helper\MailevaSending;

use Faker\Factory;
use MailevaApiAdapter\App\Entity\Document;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaConnection;
use MailevaApiAdapter\App\MailevaSending as MailevaSendingApp;

class MailevaSendingDocument extends MailevaSendingAbstract
{

    /**
     * @throws MailevaCoreException
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    public function getMailevaSending(MailevaApiAdapter $mailevaApiAdapter): MailevaSendingApp
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
                throw new MailevaCoreException('Unable to retrieve $mailevaApiAdapter->getType() : ' . $mailevaApiAdapter->getType());
        }

        $mailevaSending->validate($mailevaApiAdapter->getType());
        return $mailevaSending;
    }

    /**
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    protected function getMailevaSendingClassic(): MailevaSendingApp
    {
        $mailevaSending       = $this->getMailevaSendingCommon();
        $postagetType         = (rand(0, 50) < 50) ? MailevaSendingApp::POSTAGE_TYPE_FAST : MailevaSendingApp::POSTAGE_TYPE_ECONOMIC;
        $treatUndeliveredMail = (rand(0, 50) < 50) ? true : false;

        $mailevaSending->setPostageType($postagetType)
            ->setTreatUndeliveredMail($treatUndeliveredMail);

        if (true === $treatUndeliveredMail) {
            $mailevaSending->setNotificationTreatUndeliveredMail(self::NOTIFICATION_EMAIL);
        }

        return $mailevaSending;
    }

    /**
     * @return MailevaSendingAbstract
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
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
        $document = new Document();

        $document->setFile(codecept_root_dir() . $file)
            //->setFilepriority()  #optionnal default 1
            ->setFilename($fileName);

        $mailevaSending
            ->setName($sendingName)
            ->setColorPrinting($colorPrinting)
            ->setDuplexPrinting($duplexPrinting)
            ->setOptionalAddressSheet($optionalAddressSheet)
            ->addDocument($document)
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
        $document = new Document();

        $document->setFile(codecept_root_dir() . 'testFiles/14pages.pdf');
        $mailevaSending->addDocument($document);
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

    /**
     * @return MailevaSendingApp
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     */
    protected function getMailevaSendingLRE(): MailevaSendingApp
    {
        $mailevaSending = $this->getMailevaSendingCommon();
        $senderAddress  = $this->getRandomAddress();
        $mailevaSending
            ->setPostageType(MailevaSendingApp::POSTAGE_TYPE_LRE)
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

    /**
     * @return string[]
     */
    protected function getRandomAddress(): array
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