<?php

use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\MailevaSendingStatus;

/**
 * Class MailevaSendingLRECest
 *
 * @group MailevaSendingLRECest
 */
class MailevaSendingLRECest
{

    /**
     * @param UnitTester $I
     *
     * @group lre
     *
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\RoutingException
     */
    public function prepareAndPost(\UnitTester $I)
    {
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRE();
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);

        $similarPrevisionSendingResult = $mailevaApiAdapter->getSimilarPreviousAlreadyBeenSent($mailevaSending);
        $I->assertFalse($similarPrevisionSendingResult[0]);
        $I->assertNull($similarPrevisionSendingResult[1]);

        echo PHP_EOL . $mailevaSending->toString() . PHP_EOL;

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, $I->getMailevaApiConnection()->useMemcache());
        echo PHP_EOL . 'SENDING_ ID : ' . $sendingId . PHP_EOL;

        $I->assertNotEmpty($sendingId);

        $mailevaApiAdapter->submit($sendingId);

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
        $I->assertTrue(array_key_exists('postage_type', $result) === false);
        $I->assertNotNull($result['creation_date']);
        $I->assertEquals($result['color_printing'], $mailevaSending->isColorPrinting());
        $I->assertEquals($result['duplex_printing'], $mailevaSending->isDuplexPrinting());
        $I->assertEquals($result['optional_address_sheet'], $mailevaSending->isOptionalAddressSheet());
        $I->assertEquals($result['notification_email'], $mailevaSending->getNotificationEmail());
        $I->assertEquals($result['recipients_counts']['total'], 1);
        $I->assertEquals($result['sender_address_line_1'], $mailevaSending->getSenderAddressLine1());
        $I->assertEquals($result['sender_address_line_2'], $mailevaSending->getSenderAddressLine2());
        $I->assertEquals($result['sender_address_line_3'], $mailevaSending->getSenderAddressLine3());
        $I->assertEquals($result['sender_address_line_4'], $mailevaSending->getSenderAddressLine4());
        $I->assertEquals($result['sender_address_line_5'], $mailevaSending->getSenderAddressLine5());
        $I->assertEquals($result['sender_address_line_6'], $mailevaSending->getSenderAddressLine6());

        #RECIPIENT PROPERTIES
        $recipientId = $mailevaApiAdapter->getRecipientsBySendingId($sendingId)->getResponseAsArray()['recipients'][0]['id'];
        $result      = $mailevaApiAdapter->getRecipientBySendingIdAndRecipientId($sendingId, $recipientId)->getResponseAsArray();
        $I->assertNotEmpty($result['id']);
        $I->assertEquals($result['id'], $recipientId);
        $I->assertEquals($result['country_code'], $mailevaSending->getCountryCode());
        $I->assertTrue(
            array_key_exists('status', $result)
            && ($result['status'] === MailevaSendingStatus::PENDING || $result['status'] === MailevaSendingStatus::DRAFT)
        );
        #No work fine on LRE
        #$I->assertEquals($result['contact_id'], $mailevaSending->getCustomId());
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
        //$I->assertEquals($result['type'], mime_content_type($mailevaSending->getFile()));

        #STATUS
        $result = $mailevaApiAdapter->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId)->getResponseAsArray();
        $I->assertNotEmpty($result);

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
}
