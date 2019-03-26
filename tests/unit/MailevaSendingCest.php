<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 19/09/2018
 * Time: 10:14
 */

namespace MailevaApiAdapter\tests\unit;

use Faker\Factory;

class MailevaSendingCest
{

    /**
     * @param \UnitTester $I
     */
    public function fileExistingValidation(\UnitTester $I)
    {

        #CLASSIC --------------------------------------------------------------
        #WRONG FILE PATH
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterClassic();

        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setFile('toto');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE --------------------------------------------------------------
        # WRONG FILE PATH
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRE();

        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setFile('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });
    }

    /**
     * @param \UnitTester $I
     */
    public function addressValidation(\UnitTester $I)
    {
        #CLASSIC --------------------------------------------------------------
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterClassic();

        #CLASSIC
        #ADDRESS LINE1 && ADDRESS LINE2 EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine1('');
        $mailevaSending->setAddressLine2('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #CLASSIC
        #ADDRESS LINE6 EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine6('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #CLASSIC
        #TOO LONG ADDRESS LINE
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine1(Factory::create('fr_FR')->password(39, 39));
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE --------------------------------------------------------------
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRE();

        #LRE
        #ADDRESS LINE1 && ADDRESS LINE2 EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine1('');
        $mailevaSending->setAddressLine2('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE
        #SENDER ADDRESSLINE1 && SENDER ADDRESS LINE2 EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setSenderAddressLine1('');
        $mailevaSending->setSenderAddressLine2('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE
        #SENDER ADDRESS LINE6 EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine6('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE
        #TOO LONG ADDRESS LINE
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setAddressLine1(Factory::create('fr_FR')->password(39, 39));
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE
        #TOO LONG SENDER ADDRESS LINE
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setSenderAddressLine1(Factory::create('fr_FR')->password(39, 39));
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });
    }

    /**
     * @param \UnitTester $I
     */
    public function notificationEmailValidation(\UnitTester $I)
    {
        #CLASSIC --------------------------------------------------------------
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterClassic();

        #CLASSIC
        #WRONG NOTIFICATION EMAIL
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setNotificationEmail('zzz@');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE --------------------------------------------------------------
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRE();

        #LRE
        #WRONG NOTIFICATION EMAIL
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setNotificationEmail('zzz@');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });

        #LRE
        #NOTIFICATION EMAIL EMPTY
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);
        $mailevaSending->setNotificationEmail('');
        $I->expectException(\MailevaApiAdapter\App\Exception\MailevaParameterException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
            $mailevaSending->validate($mailevaApiAdapter);
        });
    }
}
