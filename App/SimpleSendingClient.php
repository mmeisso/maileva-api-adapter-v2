<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\DestinatairesApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\DocumentsApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\ApiException;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\RecipientCreation;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingCreation;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingsSendingIdDocumentsGetRequestMetadata;
use MailevaApiAdapter\App\Core\MailevaResponse;

class SimpleSendingClient extends AbstractClient
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
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function prepare(MailevaSending $mailevaSending): string
    {
        $envoiApi = new EnvoiApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());

        $sendingCreation = new SendingCreation();
        $sendingCreation
            ->setName($mailevaSending->getName())
            ->setCustomId($mailevaSending->getCustomId())
            ->setColorPrinting($mailevaSending->isColorPrinting())
            ->setDuplexPrinting($mailevaSending->isDuplexPrinting())
            ->setOptionalAddressSheet($mailevaSending->isOptionalAddressSheet())
            ->setTreatUndeliveredMail($mailevaSending->isTreatUndeliveredMail())
            ->setNotificationTreatUndeliveredMail([$mailevaSending->getNotificationTreatUndeliveredMail()])
            ->setPostageType($mailevaSending->getPostageType())
            ->setTreatUndeliveredMail($mailevaSending->isTreatUndeliveredMail())
            ->setNotificationTreatUndeliveredMail([$mailevaSending->getNotificationTreatUndeliveredMail()]);

        $sendingResponse = $envoiApi->sendingsPost($sendingCreation);
        $sendingId = $sendingResponse->getId();

        # add recipient (contact address)
        $recipientCreation = new RecipientCreation();
        $recipientCreation
            ->setAddressLine1($mailevaSending->getAddressLine1())
            ->setAddressLine2($mailevaSending->getAddressLine2())
            ->setAddressLine3($mailevaSending->getAddressLine3())
            ->setAddressLine4($mailevaSending->getAddressLine4())
            ->setAddressLine5($mailevaSending->getAddressLine5())
            ->setAddressLine6($mailevaSending->getAddressLine6())
            ->setCountryCode($mailevaSending->getCountryCode())
            ->setCustomId($mailevaSending->getCustomId()); // <=why we set the same one?! legacy compat
        $destinatairesApi = new DestinatairesApi(
            $this->client,
            $this->configuration,
            null,
            $this->mailevaConnection->getHostIndex()
        );
        $destinatairesApi->sendingsSendingIdRecipientsPost($sendingId, $recipientCreation);

        # add document
        $sendingsSendingIdDocumentsGetRequestMetadata = new SendingsSendingIdDocumentsGetRequestMetadata();
        $sendingsSendingIdDocumentsGetRequestMetadata
            ->setName($mailevaSending->getFilename())
            ->setPriority($mailevaSending->getFilepriority());

        $documentsApi = new DocumentsApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $documentsApi->sendingsSendingIdDocumentsPost(
            $sendingId,
            $mailevaSending->getFile(),
            $sendingsSendingIdDocumentsGetRequestMetadata
        );

        # store into memcached to avoid duplicate sending
        $this->mailevaConnection->getMemcachedManager()
            ->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);

        return $sendingId;
    }


    /**
     * @param string $sendingId
     *
     * @return void
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function deleteSendingBySendingId(string $sendingId): void
    {
        $envoiApi = new EnvoiApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $envoiApi->sendingsSendingIdDelete($sendingId);
    }


    /**
     * @param string $sendingId
     * @param string $documentId
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function getDocumentBySendingIdAndDocumentId(string $sendingId, string $documentId): MailevaResponse
    {
        $documentsApi = new DocumentsApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $response = $documentsApi->sendingsSendingIdDocumentsDocumentIdGet($sendingId, $documentId);
        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function getDocumentsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $documentsApi = new DocumentsApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $response = $documentsApi->sendingsSendingIdDocumentsGet($sendingId, $startIndex, $count);
        return $this->toMailevaResponse($response);
    }


    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function getRecipientBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        $destinatairesApi = new DestinatairesApi(
            $this->client,
            $this->configuration,
            null,
            $this->mailevaConnection->getHostIndex()
        );
        $response = $destinatairesApi->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);
        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function getRecipientsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $destinatairesApi = new DestinatairesApi(
            $this->client,
            $this->configuration,
            null,
            $this->mailevaConnection->getHostIndex()
        );
        $response = $destinatairesApi->sendingsSendingIdRecipientsGet($sendingId, $startIndex, $count);
        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @return MailevaResponse
     * @throws ApiException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponse
    {
        $envoiApi = new EnvoiApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $response = $envoiApi->sendingsSendingIdGet($sendingId);

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
        $envoiApi = new DestinatairesApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $response = $envoiApi->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws ApiException
     */
    public function postSendingBySendingId(string $sendingId):void
    {
        $envoiApi = new EnvoiApi($this->client, $this->configuration, null, $this->mailevaConnection->getHostIndex());
        $envoiApi->sendingsSendingIdSubmitPost($sendingId);
    }
}