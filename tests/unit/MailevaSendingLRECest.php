<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 18/09/2018
 * Time: 15:19
 */

class MailevaSendingLRECest
{

    public function post(\UnitTester $I)
    {
        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRE();
        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);

        echo PHP_EOL . $mailevaSending->toString() . PHP_EOL;

        $sendingId = $mailevaApiAdapter->post($mailevaSending, $I->getMailevaApiConnection()->useMemcache());
        echo PHP_EOL . 'SENDING_ ID : ' . $sendingId . PHP_EOL;

        $I->assertNotEmpty($sendingId);

        #SENDING PROPERTIES
        for ($i = 1; $i <= 20; $i++) {
            $result = $mailevaApiAdapter->getSendingBySendingId($sendingId)->getResponseAsArray();
            if ($result['status'] !== \MailevaApiAdapter\App\MailevaSendingStatus::PENDING) {
                echo PHP_EOL . 'Waiting  status : ' . \MailevaApiAdapter\App\MailevaSendingStatus::PENDING . ' loop ' . $i . PHP_EOL;
                sleep(1);
            } else {
                break;
            }
        }

        $I->assertEquals($result['id'], $sendingId);
        $I->assertEquals($result['name'], $mailevaSending->getName());
        $I->assertEquals($result['status'], \MailevaApiAdapter\App\MailevaSendingStatus::PENDING);
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
        $I->assertTrue(array_key_exists('status', $result)
            && ($result['status'] === \MailevaApiAdapter\App\MailevaSendingStatus::PENDING || $result['status'] === \MailevaApiAdapter\App\MailevaSendingStatus::DRAFT));
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
        $I->assertEquals($result['type'], pathinfo($mailevaSending->getFile())['extension']);

        #STATUS
        $result = $mailevaApiAdapter->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId)->getResponseAsArray();
        $I->assertNotEmpty($result);


        #ALREADY SEND EXCEPTION
        if ($I->getMailevaApiConnection()->useMemcache()){
            $I->expectException(\MailevaApiAdapter\App\Exception\MailevaException::class, function () use ($mailevaSending, $mailevaApiAdapter) {
                $mailevaApiAdapter->post($mailevaSending);
            });
        }

    }
}