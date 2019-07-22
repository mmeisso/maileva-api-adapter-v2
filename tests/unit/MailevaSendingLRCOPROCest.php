<?php

use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\MailevaSendingStatus;

/**
 * Created by PhpStorm.
 * User: loic
 * Date: 18/09/2018
 * Time: 15:19
 */
class MailevaSendingLRCOPROCest
{

    /**
     * @param UnitTester $I
     *
     * @group lrcopro
     *
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     * @throws \MailevaApiAdapter\App\Exception\MailevaParameterException
     * @throws \MailevaApiAdapter\App\Exception\MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\RoutingException
     * @throws Exception
     */
    public function prepareAndPost(\UnitTester $I)
    {
        $arraySendingId = [];

        /** @var \MailevaApiAdapter\App\MailevaApiAdapter $mailevaApiAdapter */
        $mailevaApiAdapter = $I->getMailevaApiAdapterLRCOPRO();

        //for($i = 1; $i <= 5; $i++){

        /** @var \MailevaApiAdapter\App\MailevaSending $mailevaSending */
        $mailevaSending = $I->getMailevaSending($mailevaApiAdapter);

        echo PHP_EOL . $mailevaSending->toString() . PHP_EOL;

        $similarPrevisionSendingResult = $mailevaApiAdapter->getSimilarPreviousAlreadyBeenSent($mailevaSending);
        $I->assertFalse($similarPrevisionSendingResult[0]);
        $I->assertNull($similarPrevisionSendingResult[1]);

        $sendingId = $mailevaApiAdapter->prepare($mailevaSending, $I->getMailevaApiConnection()->useMemcache());
        echo PHP_EOL . 'SENDING_ ID : ' . $sendingId . PHP_EOL;
        $I->assertNotEmpty($sendingId);

        $mailevaApiAdapter->submit($sendingId);
        $arraySendingId[$sendingId] = $mailevaSending;
        //}

        foreach ($arraySendingId as $sendingId => $mailevaSending) {
            $result = [];

            #SENDING PROPERTIES
            for ($i = 1; $i <= 20; $i++) {

                $result = $mailevaApiAdapter->getSendingBySendingId($sendingId)->getResponseAsArray();

                if (null === $result || array_key_exists('status', $result) === false || $result['status'] !== MailevaSendingStatus::ACCEPTED) {
                    echo PHP_EOL . 'Waiting  status : ' . MailevaSendingStatus::ACCEPTED . ' loop ' . $i . PHP_EOL;
                    sleep(1);
                } else {
                    break;
                }
            }



            $I->assertEquals($result['id'], $sendingId);
            $I->assertEquals($result['postage_type'], 'RECOMMANDE_AR');
            $I->assertEquals($result['color_printing'], $mailevaSending->isColorPrinting());
            $I->assertEquals($result['duplex_printing'], $mailevaSending->isDuplexPrinting());
            $I->assertEquals($result['billed_page_count'], '14');
            $I->assertNotNull($result['deposit_id']);
            $I->assertNotNull($result['expected_production_date']);

            #ALREADY SEND EXCEPTION
            if ($I->getMailevaApiConnection()->useMemcache()) {
                $similarPrevisionSendingResult = $mailevaApiAdapter->getSimilarPreviousAlreadyBeenSent($mailevaSending);
                $I->assertEquals($similarPrevisionSendingResult[0], true);
                $I->assertNull($similarPrevisionSendingResult[1]);

                $I->expectThrowable(new MailevaAllReadyExistException(MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                    "Same mailevaSending the LRCOPRO has already been sent"), function () use ($mailevaSending, $mailevaApiAdapter, $I) {
                    $sendingId = $mailevaApiAdapter->prepare($mailevaSending);
                    $mailevaApiAdapter->submit($sendingId);
                });
            }
        }
    }
}
