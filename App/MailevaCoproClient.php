<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Client\MailevaCoproClient\Api\EnvoiApi;
use MailevaApiAdapter\App\Client\MailevaCoproClient\Configuration;
use MailevaApiAdapter\App\Client\MailevaCoproClient\Model\CountryCode;
use MailevaApiAdapter\App\Client\MailevaCoproClient\Model\RegisteredMailOptions;
use MailevaApiAdapter\App\Client\MailevaCoproClient\Model\SendingCreation;
use MailevaApiAdapter\App\Client\MailevaCoproClient\Model\SendingResponse;
use MailevaApiAdapter\App\Core\MailevaResponseLRCOPRO;

class MailevaCoproClient extends AbstractClient
{
    /**
     * @return Configuration
     */
    protected function getNewConfiguration(): Configuration
    {
        return $this->configuration ?? new Configuration();
    }

    /**
     * @param MailevaSending $mailevaSending
     * @return string
     * @throws Client\MailevaCoproClient\ApiException
     */
    public function prepare(MailevaSending $mailevaSending): string
    {
        # prepare payload
        $sendingCreation = new SendingCreation();
        $sendingCreation
            ->setName($mailevaSending->getName())
            ->setCustomId($mailevaSending->getCustomId());

        $registeredMailOptions = new RegisteredMailOptions();
        $registeredMailOptions
            ->setDuplexPrinting($mailevaSending->isDuplexPrinting())
            ->setArchivingDuration(0)
            ->setAcknowledgementOfReceiptScanning(false)
            ->setSenderAddressLine1($mailevaSending->getSenderAddressLine1())
            ->setSenderAddressLine2($mailevaSending->getSenderAddressLine2())
            ->setSenderAddressLine3($mailevaSending->getSenderAddressLine3())
            ->setSenderAddressLine4($mailevaSending->getSenderAddressLine4())
            ->setSenderAddressLine5($mailevaSending->getSenderAddressLine5())
            ->setSenderAddressLine6($mailevaSending->getSenderAddressLine6())
            ->setSenderCountryCode(CountryCode::FR); //todo

        $sendingCreation->setRegisteredMailOptions($registeredMailOptions);

        # send payload
        $envoiApi = new EnvoiApi(null, null, null, $this->mailevaConnection->getHostIndex());
        $sendingResponse = $envoiApi->createSending($sendingCreation);

        # store into memcached to avoid duplicate sending
        $this->mailevaConnection->getMemcachedManager()
            ->set($mailevaSending->getUID()[0], $sendingResponse->getId(), self::MEMCACHE_SIMILAR_DURATION);

        return $sendingResponse->getId();
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws Client\MailevaCoproClient\ApiException
     */
    public function submit(string $sendingId): void
    {
        $envoiApi = new EnvoiApi(null, null, null, $this->mailevaConnection->getHostIndex());
        $envoiApi->submitSending($sendingId);
    }

    /**
     * @param string $sendingId
     * @return MailevaResponseLRCOPRO
     * @throws Client\MailevaCoproClient\ApiException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponseLRCOPRO
    {
        $envoiApi = new EnvoiApi(null, null, null, $this->mailevaConnection->getHostIndex());
        $submitSending = $envoiApi->getSending($sendingId);

        # new status unhandled by resoposte
        if ($submitSending->getStatus() === SendingResponse::STATUS_BLOCKED) {
            $submitSending->setStatus(SendingResponse::STATUS_PENDING);
        } elseif ($submitSending->getStatus() === SendingResponse::STATUS_PREPARING) {
            $submitSending->setStatus(SendingResponse::STATUS_ACCEPTED);
        }

        # Because some peoples love array...
        $mailevaResponseLRCOPRO = new MailevaResponseLRCOPRO();
        $mailevaResponseLRCOPRO->setResponseAsArray(json_decode(json_encode($submitSending->jsonSerialize()), true));

        return $mailevaResponseLRCOPRO;
    }
}