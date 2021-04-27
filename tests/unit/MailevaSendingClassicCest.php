<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaSending;
use MailevaApiAdapter\App\MailevaSendingStatus;

/**
 * Created by PhpStorm.
 * User: loic
 * Date: 18/09/2018
 * Time: 15:19
 */

/**
 * Class MailevaSendingClassicCest
 *
 * @group MailevaSendingClassicCest
 */
class MailevaSendingClassicCest
{

    /**
     * @param UnitTester $I
     *
     * @group classic
     *
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\RoutingException
     * @throws Exception
     */
    public function prepareAndPost(\UnitTester $I)
    {
        /** @var MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterClassic();

        /** @var MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);

        echo PHP_EOL . $mailevaSending->toString() . PHP_EOL;

        $similarPrevisionSendingResult = $mailevaApiAdapter->getSimilarPreviousAlreadyBeenSent($mailevaSending);
        $I->assertFalse($similarPrevisionSendingResult[0]);
        $I->assertNull($similarPrevisionSendingResult[1]);

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, $I->getMailevaApiConnection()->useMemcache());
        echo PHP_EOL . 'SENDING_ ID : ' . $sendingId . PHP_EOL;

        $I->assertNotEmpty($sendingId);

        $mailevaApiAdapter->submit($sendingId);

        $this->testSubmit($I, $mailevaApiAdapter, $mailevaSending, $sendingId);

        #ALREADY SEND EXCEPTION
        if ($I->getMailevaApiConnection()->useMemcache()) {
            $similarPrevisionSendingResult = $mailevaApiAdapter->getSimilarPreviousAlreadyBeenSent($mailevaSending);
            $I->assertEquals($similarPrevisionSendingResult[0], true);
            $similarPrevisionMailevaSending = $similarPrevisionSendingResult[1];
            $I->assertEquals($similarPrevisionMailevaSending['id'], $sendingId);

            $I->expectThrowable(
                new MailevaAllReadyExistException(
                    MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                    "Same mailevaSending has already been sent with sendingId " . $sendingId
                ),
                function () use ($mailevaSending, $mailevaApiAdapter) {
                    $sendingId = $mailevaApiAdapter->prepare($mailevaSending);
                    $mailevaApiAdapter->submit($sendingId);
                }
            );
        }
    }

    /**
     * @param UnitTester $I
     *
     * @group prepareAndPostWithTreatUndeliveredMail
     *
     * @throws MailevaAllReadyExistException
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\RoutingException
     */
    public function prepareAndPostWithTreatUndeliveredMail(\UnitTester $I)
    {
        /** @var MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterClassic();

        /** @var MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);

        $mailevaSending->setTreatUndeliveredMail(true);
        $mailevaSending->setNotificationTreatUndeliveredMail(\Helper\Unit::NOTIFICATION_EMAIL);

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, $I->getMailevaApiConnection()->useMemcache());
        echo PHP_EOL . 'SENDING_ ID : ' . $sendingId . PHP_EOL;

        $I->assertNotEmpty($sendingId);

        $mailevaApiAdapter->submit($sendingId);

        $this->testSubmit($I, $mailevaApiAdapter, $mailevaSending, $sendingId);
    }

    /**
     * @param UnitTester $I
     * @param MailevaApiAdapter $mailevaApiAdapter
     * @param MailevaSending $mailevaSending
     * @param string $sendingId
     *
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\RoutingException
     */
    private function testSubmit(\UnitTester $I, MailevaApiAdapter $mailevaApiAdapter, MailevaSending $mailevaSending, string $sendingId)
    {
        #SENDING PROPERTIES
        for ($i = 1; $i <= 20; $i++) {
            $result = $mailevaApiAdapter->getSendingBySendingId($sendingId)->getResponseAsArray();
            if ($result['status'] !== MailevaSendingStatus::PENDING) {
                echo PHP_EOL . 'Waiting  status : ' . MailevaSendingStatus::PENDING . ' loop ' . $i . PHP_EOL;
                sleep(1);
            } else {
                break;
            }
        }

        $I->assertEquals($result['id'], $sendingId);
        $I->assertEquals($result['name'], $mailevaSending->getName());
        $I->assertEquals($result['status'], MailevaSendingStatus::PENDING);
        $I->assertEquals($result['postage_type'], $mailevaSending->getPostageType());
        $I->assertNotNull($result['creation_date']);
        $I->assertEquals($result['color_printing'], $mailevaSending->isColorPrinting());
        $I->assertEquals($result['duplex_printing'], $mailevaSending->isDuplexPrinting());
        $I->assertEquals($result['optional_address_sheet'], $mailevaSending->isOptionalAddressSheet());
        $I->assertEquals($result['treat_undelivered_mail'], $mailevaSending->isTreatUndeliveredMail());
        if (true === $result['treat_undelivered_mail']) {
            $I->assertEquals($result['notification_treat_undelivered_mail'][0], $mailevaSending->getNotificationTreatUndeliveredMail());
        }

        $I->assertEquals($result['recipients_counts']['total'], 1);

        #RECIPIENT PROPERTIES
        $recipientId = $mailevaApiAdapter->getRecipientsBySendingId($sendingId)->getResponseAsArray()['recipients'][0]['id'];

        $result = $mailevaApiAdapter->getRecipientBySendingIdAndRecipientId($sendingId, $recipientId)->getResponseAsArray();
        $I->assertNotEmpty($result['id']);
        $I->assertEquals($result['id'], $recipientId);
        $I->assertEquals($result['country_code'], $mailevaSending->getCountryCode());
        $I->assertTrue(
            array_key_exists('status', $result)
            && ($result['status'] === MailevaSendingStatus::PENDING || $result['status'] === MailevaSendingStatus::DRAFT)
        );
        $I->assertEquals($result['custom_id'], $mailevaSending->getCustomId());
        $I->assertEquals($result['address_line_1'], $mailevaSending->getAddressLine1());
        $I->assertEquals($result['address_line_2'], $mailevaSending->getAddressLine2());
        $I->assertEquals($result['address_line_3'], $mailevaSending->getAddressLine3());
        $I->assertEquals($result['address_line_4'], $mailevaSending->getAddressLine4());
        $I->assertEquals($result['address_line_5'], $mailevaSending->getAddressLine5());
        $I->assertEquals($result['address_line_6'], $mailevaSending->getAddressLine6());

        #DOCUMENT PROPERTIES
        $documentId = $mailevaApiAdapter->getDocumentsBySendingId($sendingId)->getResponseAsArray()['documents'][0]['id'];
        $result     = $mailevaApiAdapter->getDocumentBySendingIdAndDocumentId($sendingId, $documentId)->getResponseAsArray();

        $I->assertNotEmpty($result['id']);
        $I->assertEquals($result['name'], $mailevaSending->getFilename());


        if (true === $mailevaSending->isTreatUndeliveredMail()) {
            #STATUS
            $result = $mailevaApiAdapter->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId)->getResponseAsArray();
            $I->assertNotEmpty($result);
            var_dump($result);
        }

    }
}
