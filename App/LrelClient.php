<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi;
use MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi;
use MailevaApiAdapter\App\Client\LrelClient\Api\EnvoiApi;
use MailevaApiAdapter\App\Client\LrelClient\ApiException;
use MailevaApiAdapter\App\Client\LrelClient\Configuration;
use MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation;
use MailevaApiAdapter\App\Client\LrelClient\Model\SendingCreation;
use MailevaApiAdapter\App\Client\LrelClient\Model\SendingsSendingIdDocumentsGetRequestMetadata;
use MailevaApiAdapter\App\Core\MailevaResponse;
use SplFileObject;

class LrelClient extends AbstractClient
{
    /**
     * @return Configuration
     */
    protected function getNewConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @param MailevaSending $mailevaSending
     *
     * @return string
     * @throws Client\LrelClient\ApiException
     */
    public function prepare(MailevaSending $mailevaSending): string
    {
        # create Lrel sending
        $envoiApi = new EnvoiApi($this->client, $this->configuration);
        $sendingCreation = new SendingCreation();
        $sendingCreation
            ->setName($mailevaSending->getName())
            ->setCustomId($mailevaSending->getCustomId())
            ->setAcknowledgementOfReceipt(true)
            ->setAcknowledgementOfReceiptScanning(false)
            ->setColorPrinting($mailevaSending->isColorPrinting())
            ->setDuplexPrinting($mailevaSending->isDuplexPrinting())
            ->setOptionalAddressSheet($mailevaSending->isOptionalAddressSheet())
            ->setNotificationEmail($mailevaSending->getNotificationEmail())
            ->setSenderAddressLine1($mailevaSending->getSenderAddressLine1())
            ->setSenderAddressLine2($mailevaSending->getSenderAddressLine2())
            ->setSenderAddressLine3($mailevaSending->getSenderAddressLine3())
            ->setSenderAddressLine4($mailevaSending->getSenderAddressLine4())
            ->setSenderAddressLine5($mailevaSending->getSenderAddressLine5())
            ->setSenderAddressLine6($mailevaSending->getSenderAddressLine6())
            ->setSenderCountryCode($mailevaSending->getSenderCountryCode());

        $response = $envoiApi->sendingsPost($sendingCreation);
        $sendingId = $response->getId();

        # Add document to send
        $documentsApi = new DocumentsApi(null, $this->configuration);
        $sendingsSendingIdDocumentsGetRequestMetadata = new SendingsSendingIdDocumentsGetRequestMetadata();
        $sendingsSendingIdDocumentsGetRequestMetadata
            ->setName($mailevaSending->getFilename())
            ->setPriority($mailevaSending->getFilepriority());

        $documentsApi->sendingsSendingIdDocumentsPost(
            $sendingId,
            $mailevaSending->getFile(),
            $sendingsSendingIdDocumentsGetRequestMetadata
        );

        # add recipient
        $destinatairesApi = new DestinatairesApi(
            null,
            $this->configuration,
        );
        $recipientCreation = new RecipientCreation();
        $recipientCreation
            ->setAddressLine1($mailevaSending->getAddressLine1())
            ->setAddressLine2($mailevaSending->getAddressLine2())
            ->setAddressLine3($mailevaSending->getAddressLine3())
            ->setAddressLine4($mailevaSending->getAddressLine4())
            ->setAddressLine5($mailevaSending->getAddressLine5())
            ->setAddressLine6($mailevaSending->getAddressLine6())
            ->setCountryCode($mailevaSending->getCountryCode())
            ->setCustomId($mailevaSending->getCustomId());
        $destinatairesApi->sendingsSendingIdRecipientsPost($sendingId, $recipientCreation);

        # store into memcached to avoid duplicate sending
        $this->mailevaConnection->getMemcachedManager()
            ->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);

        return $sendingId;
    }

    /**
     * @param string $sendingId
     *
     * @return SplFileObject
     * @throws ApiException
     */
    public function downloadDepositProofBySendingId(string $sendingId): SplFileObject
    {
        $envoiApi = new EnvoiApi(null, $this->configuration);
        return $envoiApi->sendingsSendingIdDownloadDepositProofGet($sendingId);
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws ApiException
     */
    public function postSendingBySendingId(string $sendingId): void
    {
        $envoiApi = new EnvoiApi(null, $this->configuration);
        $envoiApi->sendingsSendingIdSubmitPost($sendingId);
    }

    /**
     * @param string $sendingId
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponse
    {
        $envoiApi = new EnvoiApi(null, $this->configuration);
        $response = $envoiApi->sendingsSendingIdGet($sendingId);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws ApiException
     */
    public function deleteSendingBySendingId(string $sendingId): void
    {
        $envoiApi = new EnvoiApi(null, $this->configuration);
        $envoiApi->sendingsSendingIdDelete($sendingId);
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getRecipientsBySendingId(string $sendingId, int $startIndex, int $count): MailevaResponse
    {
        $envoiApi = new DestinatairesApi(null, $this->configuration);
        $response = $envoiApi->sendingsSendingIdRecipientsGet($sendingId, $startIndex, $count);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getSendingStatusBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        $envoiApi = new DestinatairesApi(null, $this->configuration, null);
        $response = $envoiApi->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return SplFileObject
     * @throws ApiException
     */
    public function downloadAcknowledgementOfReceiptBySendingIdAndRecipientId(
        string $sendingId,
        string $recipientId
    ): SplFileObject {
        $destinatairesApi = new DestinatairesApi(
            null,
            $this->configuration,
        );
        return $destinatairesApi->sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet(
            $sendingId,
            $recipientId
        );
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getRecipientBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        $envoiApi = new DestinatairesApi(null, $this->configuration);
        $response = $envoiApi->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getDocumentsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $envoiApi = new DocumentsApi(null, $this->configuration);
        $response = $envoiApi->sendingsSendingIdDocumentsGet($sendingId, $startIndex, $count);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getDocumentBySendingIdAndDocumentId(string $sendingId, string $documentId): MailevaResponse
    {
        $envoiApi = new DocumentsApi(null, $this->configuration);
        $response = $envoiApi->sendingsSendingIdDocumentsDocumentIdGet($sendingId, $documentId);

        return $this->toMailevaResponse($response);
    }
}