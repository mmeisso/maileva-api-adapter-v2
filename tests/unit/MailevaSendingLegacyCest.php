<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 19/09/2018
 * Time: 10:14
 */

namespace MailevaApiAdapter\tests\unit;

use Faker\Factory;
use MailevaApiAdapter\App\Entity\Document;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaConnection;
use MailevaApiAdapter\App\MailevaSending;

/**
 * Class MailevaSendingCest
 *
 * @package MailevaApiAdapter\tests\unit
 * @group   MailevaSendingCest
 */
class MailevaSendingLegacyCest
{

    /**
     * @param \UnitTester $I
     *
     * @group fileMoreTenMb
     * @throws MailevaParameterException
     */
    public function FileMoreThanTenMB(\UnitTester $I)
    {
        foreach ([$I->getMailevaApiAdapterClassic(), $I->getMailevaApiAdapterLRE()] as $mailevaApiAdapter) {
            #File More 10 MB
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setFile(codecept_root_dir() . 'testFiles/filesizelargeplus10mo.pdf');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_FILE_IS_TOO_BIG,
                    'The file is too big :' . codecept_root_dir(
                    ) . 'testFiles/filesizelargeplus10mo.pdf the maximum is ' . Document::MAX_MB_FILE_MAILEVA . ' MB'
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );
        }

        $mailevaApiAdapter = $I->getMailevaApiAdapterLRCOPRO();
        /** @var MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
        $mailevaSending->setFile(codecept_root_dir() . 'testFiles/filesizelargeplus10mo.pdf');
        $mailevaSending->validate($mailevaApiAdapter->getType());
    }

    /**
     * @param \UnitTester $I
     *
     * @group adresse
     * @throws MailevaParameterException
     */
    public function addressValidation(\UnitTester $I)
    {
        foreach ([$I->getMailevaApiAdapterClassic(), $I->getMailevaApiAdapterLRE(), $I->getMailevaApiAdapterLRCOPRO()] as $mailevaApiAdapter) {
            #ADDRESS LINE1 && ADDRESS LINE2 EMPTY
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setAddressLine1('');
            $mailevaSending->setAddressLine2('');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_1_OR_2_NOT_SET,
                    "addressLine1 || addressLine2 not set"
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );

            #ADDRESS LINE6 EMPTY
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setAddressLine6('');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_6_NOT_SET,
                    "addressLine6 not set"
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );

            #TOO LONG ADDRESS LINE
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $addressLine1   = Factory::create('fr_FR')->password(39, 39);
            $mailevaSending->setAddressLine1($addressLine1);
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_TOO_LONG_ADRESSE,
                    "too long address on addressLine1 : " . $addressLine1
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );
        }

        foreach ([$I->getMailevaApiAdapterLRE(), $I->getMailevaApiAdapterLRCOPRO()] as $mailevaApiAdapter) {
            #SENDER ADDRESSLINE1 && SENDER ADDRESS LINE2 EMPTY
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setSenderAddressLine1('');
            $mailevaSending->setSenderAddressLine2('');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_1_OR_2_NOT_SET,
                    "senderAddressLine1 || senderAddressLine2 not set"
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );

            #SENDER ADDRESS LINE6 EMPTY
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setSenderAddressLine6('');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_6_NOT_SET,
                    "senderAddressLine6 not set"
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );

            #TOO LONG SENDER ADDRESS LINE
            /** @var MailevaSending $mailevaSending */
            $mailevaSending     = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $senderAddressLine1 = Factory::create('fr_FR')->password(39, 39);
            $mailevaSending->setSenderAddressLine1($senderAddressLine1);
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_TOO_LONG_ADRESSE,
                    "too long address on senderAddressLine1 : " . $senderAddressLine1
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );
        }
    }

    /**
     * @param \UnitTester $I
     *
     * @group file
     */
    public function fileExistingValidation(\UnitTester $I)
    {
        foreach ([$I->getMailevaApiAdapterClassic(), $I->getMailevaApiAdapterLRE(), $I->getMailevaApiAdapterLRCOPRO()] as $mailevaApiAdapter) {
            #WRONG FILE PATH
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setFile('toto');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_FILE_NOT_FOUND,
                    'file toto not found'
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );
        }
    }

    /**
     * @param \UnitTester $I
     *
     * @group notif
     */
    public function notificationEmailValidation(\UnitTester $I)
    {
        foreach ([$I->getMailevaApiAdapterClassic(), $I->getMailevaApiAdapterLRE(), $I->getMailevaApiAdapterLRCOPRO()] as $mailevaApiAdapter) {
            #WRONG NOTIFICATION EMAIL
            /** @var MailevaSending $mailevaSending */
            $mailevaSending = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $mailevaSending->setNotificationEmail('zzz@');
            $I->expectThrowable(
                new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION,
                    "Wrong email syntax on notificationEmail parameter"
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $mailevaSending->validate($mailevaApiAdapter->getType());
                }
            );
        }
    }

    /**
     * @param \UnitTester $I
     *
     * @group similar
     */
    public function similarValidation(\UnitTester $I)
    {
        foreach ([$I->getMailevaApiAdapterClassic(), $I->getMailevaApiAdapterLRE(), $I->getMailevaApiAdapterLRCOPRO()] as $mailevaApiAdapter) {
            /** @var MailevaSending $mailevaSending1 */
            $mailevaSending1 = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $file            = 'testFiles/1pageWithTextLayer.pdf';
            $mailevaSending1->setFile(codecept_root_dir() . $file);
            $mailevaSending1->setNbPage(1);
            $I->assertEquals(
                MailevaSending::UID_METHOD_PDFTEXT,
                $mailevaSending1->getUid()[1],
                'Method UID Check ' . MailevaSending::UID_METHOD_PDFTEXT
            );

            /** @var MailevaSending $mailevaSendingCopy1 */
            $mailevaSendingCopy1 = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $this->copyMailevaSending($mailevaSending1, $mailevaSendingCopy1, $mailevaApiAdapter);
            $file = 'testFiles/1pageWithTextLayer.pdf';
            $mailevaSendingCopy1->setFile(codecept_root_dir() . $file);
            $mailevaSendingCopy1->setNbPage(1);
            $I->assertEquals($mailevaSending1->getUid(), $mailevaSendingCopy1->getUID(), 'Check similar detected');

            /** @var MailevaSending $mailevaSending2 */
            $mailevaSending2 = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $file            = 'testFiles/1pageWithoutTextLayer.pdf';
            $mailevaSending2->setFile(codecept_root_dir() . $file);
            $mailevaSending2->setNbPage(1);
            $I->assertEquals(
                $mailevaSending2->getUid()[1],
                MailevaSending::UID_METHOD_MD5_FILE,
                'Method UID Check ' . MailevaSending::UID_METHOD_MD5_FILE
            );

            /** @var MailevaSending $mailevaSendingCopy2 */
            $mailevaSendingCopy2 = $I->getMailevaSendingLegacy($mailevaApiAdapter);
            $this->copyMailevaSending($mailevaSending2, $mailevaSendingCopy2, $mailevaApiAdapter);
            $file = 'testFiles/1pageWithoutTextLayer.pdf';
            $mailevaSendingCopy2->setFile(codecept_root_dir() . $file);
            $mailevaSendingCopy2->setNbPage(1);
            $I->assertEquals($mailevaSending2->getUid(), $mailevaSendingCopy2->getUID(), 'Check similar detected');

            $I->assertNotEquals($mailevaSending1->getUid(), $mailevaSending2->getUID(), 'Check different detected');
            $I->assertNotEquals($mailevaSending1->getUid(), $mailevaSendingCopy2->getUID(), 'Check different detected');
            $I->assertNotEquals($mailevaSending2->getUid(), $mailevaSendingCopy1->getUID(), 'Check different detected');
            $I->assertNotEquals($mailevaSendingCopy1->getUid(), $mailevaSendingCopy2->getUID(), 'Check different detected');
        }
    }

    private function copyMailevaSending(MailevaSending $mailevaSendingSrc, MailevaSending $mailevaSendingDest, MailevaApiAdapter $mailevaApiAdapter)
    {
        /** @var MailevaSending $mailevaSendingDest */
        $mailevaSendingDest->setPostageType($mailevaSendingSrc->getPostageType());
        $mailevaSendingDest->setColorPrinting($mailevaSendingSrc->isColorPrinting());
        $mailevaSendingDest->setDuplexPrinting($mailevaSendingSrc->isDuplexPrinting());
        $mailevaSendingDest->setOptionalAddressSheet($mailevaSendingSrc->isOptionalAddressSheet());
        $mailevaSendingDest->setTreatUndeliveredMail($mailevaSendingSrc->isTreatUndeliveredMail());
        if ($mailevaSendingSrc->isTreatUndeliveredMail()){
            $mailevaSendingDest->setNotificationTreatUndeliveredMail($mailevaSendingSrc->getNotificationTreatUndeliveredMail());
        }
        $mailevaSendingDest->setAddressLine1($mailevaSendingSrc->getAddressLine1());
        $mailevaSendingDest->setAddressLine2($mailevaSendingSrc->getAddressLine2());
        $mailevaSendingDest->setAddressLine3($mailevaSendingSrc->getAddressLine3());
        $mailevaSendingDest->setAddressLine4($mailevaSendingSrc->getAddressLine4());
        $mailevaSendingDest->setAddressLine5($mailevaSendingSrc->getAddressLine5());
        $mailevaSendingDest->setAddressLine6($mailevaSendingSrc->getAddressLine6());

        if (in_array(
            $mailevaApiAdapter->getType(),
            [MailevaConnection::LRE, MailevaConnection::LRCOPRO, MailevaConnection::MAILEVA_COPRO]
        )) {
            $mailevaSendingDest->setSenderAddressLine1($mailevaSendingSrc->getSenderAddressLine1());
            $mailevaSendingDest->setSenderAddressLine2($mailevaSendingSrc->getSenderAddressLine2());
            $mailevaSendingDest->setSenderAddressLine3($mailevaSendingSrc->getSenderAddressLine3());
            $mailevaSendingDest->setSenderAddressLine4($mailevaSendingSrc->getSenderAddressLine4());
            $mailevaSendingDest->setSenderAddressLine5($mailevaSendingSrc->getSenderAddressLine5());
            $mailevaSendingDest->setSenderAddressLine6($mailevaSendingSrc->getSenderAddressLine6());
        }
    }
}
