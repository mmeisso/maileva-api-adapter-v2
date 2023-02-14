<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:33
 */

namespace MailevaApiAdapter\App;

use ArrayAccess;
use GuzzleHttp\Psr7\Utils;
use JsonSerializable;
use MailevaApiAdapter\App\Client\AuthClient\Api\AuthApi;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi as EnvoiLrCoproApi;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\RegisteredMailOptions;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingCreation as LrCoproSendingCreation;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\DestinatairesApi as SimpleSendingDestinatairesApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\DocumentsApi as SimpleSendingDocumentsApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi as EnvoiSimpleApi;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\ModelInterface;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\RecipientCreation;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingCreation as SimpleSendingCreation;
use MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingsSendingIdDocumentsGetRequestMetadata;
use MailevaApiAdapter\App\Core\MailevaResponse;
use MailevaApiAdapter\App\Core\MailevaResponseInterface;
use MailevaApiAdapter\App\Core\MailevaResponseLRCOPRO;
use MailevaApiAdapter\App\Core\MemcachedInterface;
use MailevaApiAdapter\App\Core\MemcachedManager;
use MailevaApiAdapter\App\Core\Route;
use MailevaApiAdapter\App\Core\Routing;
use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use MailevaApiAdapter\App\Exception\MailevaRoutingException;

/**
 * Class MailevaApiAdapter
 *
 * @package MailevaApiAdapter\App
 */
class MailevaApiAdapter
{

    public const MEMCACHE_SIMILAR_DURATION = 60 * 60 * 24 * 7;
    public const TOKEN_PREFIX_V1 = 'MT_';
    public const TOKEN_PREFIX_V2 = 'MTV2_';
    public const HOST_PROD_IDX = 0;
    public const HOST_SANDBOX_IDX = 1;

    private ?string $access_token = null;
    /** @var MailevaConnection|null */
    private ?MailevaConnection $mailevaConnection;
    private ?MemcachedInterface $memcachedManager;

    private int $hostIndex = self::HOST_SANDBOX_IDX;

    /**
     * MailevaApiAdapter constructor.
     *
     * @param MailevaConnection $mailevaConnection
     * @param MemcachedInterface|null $memcached
     * @throws ApiException
     */
    public function __construct(MailevaConnection $mailevaConnection, ?MemcachedInterface $memcached = null)
    {
        $this->mailevaConnection = $mailevaConnection;

        # handle memcached injection
        $this->memcachedManager = $memcached;
        if (!$memcached && $mailevaConnection->useMemcache()) {
            $this->initMemcachedManager();
        }

        # authentication V2
        if (!$this->getAccessTokenV2()) {
            $this->authenticateV2($mailevaConnection);
        }
    }


    /**
     * @param string $sendingId
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function deleteSendingBySendingId(string $sendingId): MailevaResponse
    {
        $envoiApi = new EnvoiSimpleApi(null, new Configuration(), null, $this->hostIndex);
        $envoiApi->sendingsSendingIdDelete($sendingId);
        return new MailevaResponse();
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @param string $localFilePath
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function downloadAcknowledgementOfReceiptBySendingIdAndRecipientId(
        string $sendingId,
        string $recipientId,
        string $localFilePath
    ): MailevaResponse {
        if ($this->getType() !== MailevaConnection::LRE) {
            throw new MailevaCoreException('Only available for LRE');
        }
        $route = new Route(
            $this, Routing::DOWNLOAD_ACKNOWLEDGEMENT_OF_RECEIPT_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id'   => $sendingId,
                    'recipient_id' => $recipientId,
                    'sink'         => $localFilePath
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param string $localFilePath
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function downloadDepositProofBySendingId(string $sendingId, string $localFilePath): MailevaResponse
    {
        if ($this->getType() !== MailevaConnection::LRE) {
            throw new MailevaCoreException('Only available for LRE');
        }

        $route = new Route(
            $this, Routing::DOWNLOAD_DEPOSIT_PROOF_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'sink'       => $localFilePath
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $tokenKeyPrefix
     * @return ?string
     */
    public function getAccessToken(string $tokenKeyPrefix = self::TOKEN_PREFIX_V1): ?string
    {
        if ($this->mailevaConnection->useMemcache()) {
            if (is_null($this->access_token)) {
                $key = $tokenKeyPrefix . $this->mailevaConnection->getClientId(
                    ) . '_' . $this->mailevaConnection->getUsername();
                $memcachedToken = $this->getMemcachedManager()->get($key, false);
                if (false !== $memcachedToken) {
                    $this->access_token = $memcachedToken;
                }
            }
        }

        return $this->access_token;
    }

    /**
     * @return string|null
     */
    public function getAccessTokenV2(): ?string
    {
        return $this->getAccessToken(self::TOKEN_PREFIX_V2);
    }

    /**
     * @param string $token
     * @param int $secondsDurationValidity
     * @param string $tokenKeyPrefix
     */
    public function setAccessToken(string $token, int $secondsDurationValidity, string $tokenKeyPrefix = self::TOKEN_PREFIX_V1): void
    {
        if ($this->mailevaConnection->useMemcache()) {
            $key = $tokenKeyPrefix . $this->mailevaConnection->getClientId(
                ) . '_' . $this->mailevaConnection->getUsername();
            #2592000 max memcache value -> http://php.net/manual/fr/memcache.set.php
            $this->getMemcachedManager()->set(
                $key,
                $token,
                min(abs($secondsDurationValidity / 2), 2592000)
            );
        }
        $this->access_token = $token;
    }

    public function setAccessTokenV2(string $token, int $secondsDurationValidity): void
    {
        $this->setAccessToken($token, $secondsDurationValidity, self::TOKEN_PREFIX_V2);
    }

    /**
     * @return string
     */
    public function getAuthenticationHost(): string
    {
        return $this->mailevaConnection->getAuthenticationHost();
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
        $configuration = new Configuration();
        $configuration->setAccessToken($this->getAccessTokenV2());
        $documentsApi = new SimpleSendingDocumentsApi(null,$configuration,null,$this->hostIndex);
        $response = $documentsApi->sendingsSendingIdDocumentsDocumentIdGet($sendingId,$documentId);
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
        $configuration = new Configuration();
        $configuration->setAccessToken($this->getAccessTokenV2());
        $documentsApi = new SimpleSendingDocumentsApi(null,$configuration,null,$this->hostIndex);
        $response = $documentsApi->sendingsSendingIdDocumentsGet($sendingId,$startIndex,$count);
        return $this->toMailevaResponse($response);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->mailevaConnection->getHost();
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
        $configuration = new Configuration();
        $configuration->setAccessToken($this->getAccessTokenV2());
        $destinatairesApi = new SimpleSendingDestinatairesApi(null, $configuration, null, $this->hostIndex);
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
        $configuration = new Configuration();
        $configuration->setAccessToken($this->getAccessTokenV2());
        $destinatairesApi = new SimpleSendingDestinatairesApi(null, $configuration, null, $this->hostIndex);
        $recipientsResponse = $destinatairesApi->sendingsSendingIdRecipientsGet($sendingId, $startIndex, $count);
        return $this->toMailevaResponse($recipientsResponse);
    }

    /**
     * @param string $sendingId
     *
     * @return MailevaResponseInterface
     * @throws Client\LrCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponseInterface
    {
        switch ($this->getType()) {
            case MailevaConnection::LRCOPRO:
                return $this->getSendingBySendingIdLRCOPRO($sendingId);
            default:

                $configuration = new Configuration();
                $configuration->setAccessToken($this->getAccessTokenV2());
                $envoiApi = new EnvoiSimpleApi(null, $configuration, null, $this->hostIndex);
                $response = $envoiApi->sendingsSendingIdGet($sendingId);

                return $this->toMailevaResponse($response);
        }
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return MailevaResponse
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getSendingStatusBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        if (false === in_array($this->getType(), [MailevaConnection::LRE, MailevaConnection::CLASSIC], true)) {
            throw new MailevaCoreException('Not available for type ' . $this->getType());
        }

        $configuration = new Configuration();
        $configuration->setAccessToken($this->getAccessTokenV2());
        $envoiApi = new SimpleSendingDestinatairesApi(null, $configuration, null, $this->hostIndex);
        $response = $envoiApi->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);

        return $this->toMailevaResponse($response);
    }

    /**
     * @param MailevaSending $mailevaSending
     *
     * @return array
     * @throws Client\LrCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getSimilarPreviousAlreadyBeenSent(MailevaSending $mailevaSending): array
    {
        if ($this->mailevaConnection->useMemcache() === false) {
            throw new MailevaCoreException("unable to check checkSimilarPreviousHasAlreadyBeenSent without Memcache enable");
        }

        $sendingIdSimilarPrevious = $this->getMemcachedManager()->get(
            $mailevaSending->getUID()[0],
            false
        );

        if (false === $sendingIdSimilarPrevious) {
            return [false, null];
        } else {
            if ($this->getType() !== MailevaConnection::LRCOPRO) {
                $previousSimilarMailevaSimple = $this->getSendingBySendingId($sendingIdSimilarPrevious)->getResponseAsArray();
                return [true, $previousSimilarMailevaSimple];
            } else {
                return [true, null];
            }
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->mailevaConnection->getType();
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return is_null($this->getAccessToken()) === false;
    }

    /**
     * @param string $sendingId
     * @param array  $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function patchLRESendingBySendingId(string $sendingId, array $body): MailevaResponse
    {
        if ($this->getType() !== MailevaConnection::LRE) {
            throw new MailevaCoreException('Only available for LRE');
        }

        $route = new Route(
            $this, Routing::PATCH_LRE_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body'       => $body
                ]
            ]
        );
        return $route->call();
    }


    /**
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postAuthentication(): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_AUTHENTICATION,
            [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(
                            $this->mailevaConnection->getClientId() . ':' . $this->mailevaConnection->getClientSecret()
                        )
                ],
                'params'  => [
                    'username' => $this->mailevaConnection->getUsername(),
                    'password' => $this->mailevaConnection->getPassword()
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param MailevaConnection $mailevaConnection
     * @throws ApiException
     */
    private function authenticateV2(MailevaConnection $mailevaConnection)
    {
        if ($mailevaConnection->isProdHost()) {
            $this->hostIndex = self::HOST_PROD_IDX;
        }

        $apiInstance = new AuthApi(null, null, null, $this->hostIndex);
        $authorization = 'Basic ' . base64_encode(
                "{$mailevaConnection->getClientId()}:{$mailevaConnection->getClientSecret()}"
            );
        $result = $apiInstance->tokenPost(
            $authorization,
            'password',
            $mailevaConnection->getUsername(),
            $mailevaConnection->getPassword()
        );

        $this->setAccessTokenV2($result->getAccessToken(), $result->getExpiresIn());
    }

    /**
     * @param string $sendingId
     * @param array  $multipart
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postDocumentBySendingId(string $sendingId, array $multipart): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'multipart'  => $multipart
                ]
            ]
        );
        return $route->call();
    }




    /**
     * @param string $sendingId
     * @param array  $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException*
     */
    public function postRecipientBySendingId(string $sendingId, array $body): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_RECIPIENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body'       => $body
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param array $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postSending(array $body): MailevaResponse
    {
        #$body : {"name": "string"}
        $route = new Route(
            $this, Routing::POST_SENDING,
            [
                'params' => [
                    'body' => $body
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     *
     * @return void
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function postSendingBySendingId(string $sendingId): void
    {
        $config = new Configuration();
        $config->setAccessToken($this->getAccessTokenV2());
        $envoiApi = new EnvoiSimpleApi(null, $config, null, $this->hostIndex);
        $envoiApi->sendingsSendingIdSubmitPost($sendingId);
    }

    /**
     * @param MailevaSending $mailevaSending
     * @param bool $checkSimilarPreviousHasAlreadyBeenSent
     *
     * @return string
     * @throws Client\LrCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaParameterException
     * @throws MailevaAllReadyExistException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     * @throws MailevaRoutingException
     */
    public function prepare(MailevaSending $mailevaSending, bool $checkSimilarPreviousHasAlreadyBeenSent = true): string
    {
        $mailevaSending->validate($this);

        if ($checkSimilarPreviousHasAlreadyBeenSent === true) {
            if ($this->mailevaConnection->useMemcache() === false) {
                throw new MailevaCoreException("unable to check checkSimilarPreviousHasAlreadyBeenSent without Memcache enable");
            }
            $sendingIdSimilarPrevious = $this->getSimilarPreviousAlreadyBeenSent($mailevaSending);

            if ($sendingIdSimilarPrevious[0] !== false) {
                if ($this->getType() !== MailevaConnection::LRCOPRO) {
                    $allReadyExistException = new MailevaAllReadyExistException(
                        MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                        "Same mailevaSending has already been sent with sendingId " . $sendingIdSimilarPrevious[1]['id']
                    );
                    $allReadyExistException->setPreviousMailevaSending($sendingIdSimilarPrevious[1]);
                } else {
                    $allReadyExistException = new MailevaAllReadyExistException(
                        MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                        "Same mailevaSending the LRCOPRO has already been sent"
                    );
                }

                throw $allReadyExistException;
            }
        }

        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                return $this->prepareSimple($mailevaSending);
            case MailevaConnection::LRE:
                return $this->prepareLRE($mailevaSending);
            case MailevaConnection::LRCOPRO:
                return $this->prepareLRCOPRO($mailevaSending);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     *
     * @throws Client\LrCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     */
    public function submit(string $sendingId)
    {
        switch ($this->getType()) {
            case MailevaConnection::LRCOPRO:
                $this->submitLrCopro($sendingId);
                break;
            default:
                $this->postSendingBySendingId($sendingId);
        }
    }

    /**
     * @param string $sendingId
     * @return MailevaResponseLRCOPRO
     * @throws Client\LrCoproClient\ApiException
     */
    private function getSendingBySendingIdLRCOPRO(string $sendingId): MailevaResponseLRCOPRO
    {
        $envoiApi = new EnvoiLrCoproApi(null, null, null, $this->hostIndex);
        $submitSending = $envoiApi->getSending($this->getAccessTokenV2(), $sendingId);

        # new status unhandled by resoposte
        if ($submitSending->getStatus() === SendingResponse::STATUS_BLOCKED) {
            $submitSending->setStatus(SendingResponse::STATUS_PENDING);
        } elseif ($submitSending->getStatus() === SendingResponse::STATUS_PREPARING) {
            $submitSending->setStatus(SendingResponse::STATUS_ACCEPTED);
        }

        # Because some peoples love array...
        $mailevaResponseLRCOPRO = new MailevaResponseLRCOPRO();
        $mailevaResponseLRCOPRO->setResponseAsArray(json_decode($submitSending->jsonSerialize(), true));

        return $mailevaResponseLRCOPRO;
    }

    /**
     * @param MailevaSending $mailevaSending
     * @return string
     * @throws Client\LrCoproClient\ApiException
     */
    public function prepareLRCOPRO(MailevaSending $mailevaSending): string
    {
        # prepare payload
        $sendingCreation = new LrCoproSendingCreation();
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

        $envoiApi = new EnvoiLrCoproApi(null, null, null, $this->hostIndex);
        $sendingResponse = $envoiApi->createSending($this->getAccessTokenV2(), $sendingCreation);

        # store into memcached to avoid duplicate sending
        if ($this->mailevaConnection->useMemcache() === true) {
            MemcachedManager::getInstance(
                $this->mailevaConnection->getMemcacheHost(),
                $this->mailevaConnection->getMemcachePort()
            )->set($mailevaSending->getUID()[0], $sendingResponse->getId(), self::MEMCACHE_SIMILAR_DURATION);
        }

        return $sendingResponse->getId();
    }


    /**
     * @param MailevaSending $mailevaSending
     *
     * @return string
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    private function prepareLRE(MailevaSending $mailevaSending): string
    {
        $name                 = $mailevaSending->getName();
        $colorPrinting        = $mailevaSending->isColorPrinting();
        $duplexPrinting       = $mailevaSending->isDuplexPrinting();
        $optionalAddressSheet = $mailevaSending->isOptionalAddressSheet();
        $file                 = $mailevaSending->getFile();
        $filePriority         = $mailevaSending->getFilepriority();
        $fileName             = $mailevaSending->getFilename();
        $addressLine1         = $mailevaSending->getAddressLine1();
        $addressLine2         = $mailevaSending->getAddressLine2();
        $addressLine3         = $mailevaSending->getAddressLine3();
        $addressLine4         = $mailevaSending->getAddressLine4();
        $addressLine5         = $mailevaSending->getAddressLine5();
        $addressLine6         = $mailevaSending->getAddressLine6();
        $countryCode          = $mailevaSending->getCountryCode();
        $customId             = $mailevaSending->getCustomId();

        $sending   = $this->postSending(['name' => $name]);
        $sendingId = $sending->getResponseAsArray()['sendingId'];

        if (empty($sendingId)) {
            throw new MailevaResponseException('Unable to retrieve sendingId');
        }

        $notification_email = $mailevaSending->getNotificationEmail();
        $senderAddressLine1 = $mailevaSending->getSenderAddressLine1();
        $senderAddressLine2 = $mailevaSending->getSenderAddressLine2();
        $senderAddressLine3 = $mailevaSending->getSenderAddressLine3();
        $senderAddressLine4 = $mailevaSending->getSenderAddressLine4();
        $senderAddressLine5 = $mailevaSending->getSenderAddressLine5();
        $senderAddressLine6 = $mailevaSending->getSenderAddressLine6();
        $senderCountryCode  = $mailevaSending->getSenderCountryCode();

        $this->patchLRESendingBySendingId(
            $sendingId,
            [
                "acknowledgement_of_receipt"          => true,
                "acknowledgement_of_receipt_scanning" => false,
                "color_printing"                      => $colorPrinting,
                "duplex_printing"                     => $duplexPrinting,
                "optional_address_sheet"              => $optionalAddressSheet,
                "notification_email"                  => $notification_email,
                "sender_address_line_1"               => $senderAddressLine1,
                "sender_address_line_2"               => $senderAddressLine2,
                "sender_address_line_3"               => $senderAddressLine3,
                "sender_address_line_4"               => $senderAddressLine4,
                "sender_address_line_5"               => $senderAddressLine5,
                "sender_address_line_6"               => $senderAddressLine6,
                "sender_country_code"                 => $senderCountryCode,
            ]
        );

        $this->postDocumentBySendingId(
            $sendingId,
            [
                ['name' => 'document', 'contents' => Utils::streamFor(fopen($file, 'rb'))],
                ['name' => 'metadata', 'contents' => '{"priority": ' . $filePriority . ',"name":"' . $fileName . '"}']
            ]
        );

        $this->postRecipientBySendingId(
            $sendingId,
            [
                'address_line_1' => $addressLine1,
                'address_line_2' => $addressLine2,
                'address_line_3' => $addressLine3,
                'address_line_4' => $addressLine4,
                'address_line_5' => $addressLine5,
                'address_line_6' => $addressLine6,
                'country_code'   => $countryCode,
                'custom_id'      => $customId
            ]
        );

        if ($this->mailevaConnection->useMemcache() === true) {
            $this->getMemcachedManager()
                ->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);
        }

        return $sendingId;
    }

    /**
     * @param MailevaSending $mailevaSending
     *
     * @return string
     * @throws Client\SimpleSendingClient\ApiException
     */
    private function prepareSimple(MailevaSending $mailevaSending): string
    {
        $config = new Configuration();
        $config->setAccessToken($this->getAccessTokenV2());
        $envoiApi = new EnvoiSimpleApi(null, $config, null, $this->hostIndex);

        $sendingCreation = new SimpleSendingCreation();
        $sendingCreation
            ->setName($mailevaSending->getName())
            ->setCustomId($mailevaSending->getCustomId())
            ->setColorPrinting($mailevaSending->isColorPrinting())
            ->setDuplexPrinting($mailevaSending->isDuplexPrinting())
            ->setOptionalAddressSheet($mailevaSending->isOptionalAddressSheet())
//            ->setNotificationEmail($mailevaSending->getNotificationEmail())
//            ->setSenderAddressLine1($mailevaSending->getSenderAddressLine1())
//            ->setSenderAddressLine2($mailevaSending->getSenderAddressLine2())
//            ->setSenderAddressLine3($mailevaSending->getSenderAddressLine3())
//            ->setSenderAddressLine4($mailevaSending->getSenderAddressLine4())
//            ->setSenderAddressLine5($mailevaSending->getSenderAddressLine5())
//            ->setSenderAddressLine6($mailevaSending->getSenderAddressLine6())
//            ->setSenderCountryCode($mailevaSending->getSenderCountryCode()) //todo
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
        $destinatairesApi = new SimpleSendingDestinatairesApi(null, $config, null, $this->hostIndex);
        $destinatairesApi->sendingsSendingIdRecipientsPost($sendingId, $recipientCreation);

        # add document
        $sendingsSendingIdDocumentsGetRequestMetadata = new SendingsSendingIdDocumentsGetRequestMetadata();
        $sendingsSendingIdDocumentsGetRequestMetadata
            ->setName($mailevaSending->getFilename())
            ->setPriority($mailevaSending->getFilepriority());

        $documentsApi = new SimpleSendingDocumentsApi(null, $config, null, $this->hostIndex);
        $documentsApi->sendingsSendingIdDocumentsPost(
            $sendingId,
            $mailevaSending->getFile(),
            $sendingsSendingIdDocumentsGetRequestMetadata
        );

        if ($this->mailevaConnection->useMemcache() === true) {
            $this->getMemcachedManager()
                ->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);
        }

        return $sendingId;
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws Client\LrCoproClient\ApiException
     */
    private function submitLrCopro(string $sendingId): void
    {
        $envoiApi = new EnvoiLrCoproApi(null, null, null, $this->hostIndex);
        $envoiApi->submitSending($this->getAccessTokenV2(), $sendingId);
    }

    private function getMemcachedManager(): MemcachedInterface
    {
        return $this->memcachedManager;
    }

    /**
     * @param MemcachedInterface|null $memcachedManager
     */
    public function setMemcachedManager(?MemcachedInterface $memcachedManager): void
    {
        $this->memcachedManager = $memcachedManager;
    }

    /**
     * @return void
     */
    private function initMemcachedManager(): void
    {
        $this->memcachedManager = MemcachedManager::getInstance(
            $this->mailevaConnection->getMemcacheHost(),
            $this->mailevaConnection->getMemcachePort()
        );
    }

    /**
     * @param ModelInterface|ArrayAccess|JsonSerializable $response
     * @return MailevaResponse
     */
    private function toMailevaResponse(JsonSerializable $response): MailevaResponse
    {
        $jsonSerialize = $response->jsonSerialize();
        $mailevaResponse = new MailevaResponse();
        $mailevaResponse->setResponseAsArray(json_decode(json_encode($jsonSerialize),true));
        return $mailevaResponse;
    }
}


