<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:33
 */

namespace MailevaApiAdapter\App;

use GuzzleHttp\Psr7\Utils;
use MailevaApiAdapter\App\Client\AuthClient\Api\AuthApi;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Client\AuthClient\Model\Errors;
use MailevaApiAdapter\App\Client\AuthClient\Model\ModelInterface;
use MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse;
use MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\RegisteredMailOptions;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingCreation;
use MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse;
use MailevaApiAdapter\App\Core\MailevaResponse;
use MailevaApiAdapter\App\Core\MailevaResponseInterface;
use MailevaApiAdapter\App\Core\MailevaResponseLRCOPRO;
use MailevaApiAdapter\App\Core\MemcachedInterface;
use MailevaApiAdapter\App\Core\MemcachedManager;
use MailevaApiAdapter\App\Core\Route;
use MailevaApiAdapter\App\Core\Routing;
use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use Throwable;
use ZipArchive;

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
    private ?MailevaConnection $mailevaConnection = null;
    private ?MemcachedInterface $memcachedManager = null;

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
     * @param string $documentId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function deleteDocumentBySendingId(string $sendingId, string $documentId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::DELETE_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id'  => $sendingId,
                    'document_id' => $documentId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function deleteRecipientBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::DELETE_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id'   => $sendingId,
                    'recipient_id' => $recipientId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function deleteRecipientsBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::DELETE_RECIPIENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function deleteSendingBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::DELETE_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId
                ]
            ]
        );
        return $route->call();
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
     * @param array $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getAuthentication(array $body): MailevaResponse
    {
        #$body : {"client_id": "string","redirect_uri": "string","state": "string","response_type": "token"}
        $route = new Route(
            $this, Routing::GET_AUTHENTICATION,
            [
                'params' => [
                    'body' => $body
                ]
            ]
        );
        return $route->call();
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
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getDocumentBySendingIdAndDocumentId(string $sendingId, string $documentId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id'  => $sendingId,
                    'document_id' => $documentId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param int    $startIndex
     * @param int    $count
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getDocumentsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_DOCUMENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id'  => $sendingId,
                    'start_index' => $startIndex,
                    'count'       => $count
                ]
            ]
        );
        return $route->call();
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
     * @param string $importId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getImportRecipientsBySendingIdAndImportId(string $sendingId, string $importId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_IMPORT_RECIPIENTS_BY_SENDING_ID_AND_IMPORT_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'import_id'  => $importId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getRecipientBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id'   => $sendingId,
                    'recipient_id' => $recipientId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param int    $startIndex
     * @param int    $count
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getRecipientsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_RECIPIENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id'  => $sendingId,
                    'start_index' => $startIndex,
                    'count'       => $count
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     *
     * @return MailevaResponseInterface
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponseInterface
    {
        switch ($this->getType()) {
            case MailevaConnection::LRCOPRO:
                return $this->getSendingBySendingIdLRCOPRO($sendingId);
            default:
                $route = new Route(
                    $this, Routing::GET_SENDING_BY_SENDING_ID,
                    [
                        'params' => [
                            'sending_id' => $sendingId
                        ]
                    ]
                );
                return $route->call();
        }
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function getSendingStatusBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        if (false === in_array($this->getType(), [MailevaConnection::LRE, MailevaConnection::CLASSIC], true)) {
            throw new MailevaCoreException('Not available for type ' . $this->getType());
        }

        $route = new Route(
            $this, Routing::GET_SENDING_DELIVERY_STATUSES_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id'   => $sendingId,
                    'recipient_id' => $recipientId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param int $startIndex
     * @param int $count
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function getSendings(int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route(
            $this, Routing::GET_SENDINGS,
            [
                'params' => [
                    'start_index' => $startIndex,
                    'count'       => $count
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param MailevaSending $mailevaSending
     *
     * @return array
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
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
     * @param string $sendingId
     * @param array  $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function patchSendingBySendingId(string $sendingId, array $body): MailevaResponse
    {
        if ($this->getType() !== MailevaConnection::CLASSIC) {
            throw new MailevaCoreException('not available for LRE');
        }

        $route = new Route(
            $this, Routing::PATCH_SENDING_BY_SENDING_ID,
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
     * @return Errors|TokenResponse
     * @throws ApiException
     */
    private function authenticateV2(MailevaConnection $mailevaConnection): ModelInterface
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
        return $result;
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
     * @param int    $fileId
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postDocumentFromLibrary(string $sendingId, int $fileId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_DOCUMENT_FROM_LIBRARY,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'file_id'    => $fileId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @param int    $position
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postDocumentPositionBySendingId(string $sendingId, string $documentId, int $position): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_DOCUMENT_POSITION_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id'  => $sendingId,
                    'document_id' => $documentId,
                    'position'    => $position
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
     * @throws MailevaResponseException
     * @deprecated
     *
     */
    public function postImportRecipientsBySendingId(string $sendingId, array $body): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID,
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
     * @param string $sendingId
     * @param array  $body
     *
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postImportRecipientsBySendingIdFromAddressBook(string $sendingId, array $body): MailevaResponse
    {
        #$body : [{"id": "string"}]
        $route = new Route(
            $this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID_FROM_ADDRESS_BOOK,
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
     * @return MailevaResponse
     * @throws Exception\MailevaRoutingException
     * @throws MailevaResponseException
     */
    public function postSendingBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route(
            $this, Routing::POST_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param MailevaSending $mailevaSending
     * @param bool           $checkSimilarPreviousHasAlreadyBeenSent
     *
     * @return string
     * @throws Exception\MailevaParameterException
     * @throws Exception\MailevaRoutingException
     * @throws MailevaAllReadyExistException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
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
     * @param                        $conn
     * @param MailevaResponseLRCOPRO $mailevaResponseLRCOPRO
     *
     * @return bool
     */
    public function renameFileAfterReturnStatus($conn, MailevaResponseLRCOPRO $mailevaResponseLRCOPRO): bool
    {
        try {
            $original_directory = ftp_pwd($conn);
            if (@ftp_chdir($conn, $this->mailevaConnection->getDirectoryCallback() . $mailevaResponseLRCOPRO->getResponseAsArray()['status'])) {
                // If it is a directory, then change the directory back to the original directory
                ftp_chdir($conn, $original_directory);

                $newDirectoryTmp = str_replace(
                    '/',
                    '\/',
                    $this->mailevaConnection->getTmpFileDirectory() . $this->mailevaConnection->getDirectoryCallback()
                );
                $newFileRename   = preg_replace(
                    '/' . $newDirectoryTmp . '/',
                    $mailevaResponseLRCOPRO->getResponseAsArray()['status'] . '/',
                    $mailevaResponseLRCOPRO->getResponseAsArray()['filePathTmp']
                );

                if (!ftp_rename(
                    $conn,
                    $mailevaResponseLRCOPRO->getResponseAsArray()['filePathFtp'],
                    $this->mailevaConnection->getDirectoryCallback() . $newFileRename
                )) {
                    return false;
                }
                unlink($mailevaResponseLRCOPRO->getResponseAsArray()['filePathTmp']);
                return true;
            } else {
                ftp_mkdir($conn, $this->mailevaConnection->getDirectoryCallback() . $mailevaResponseLRCOPRO->getResponseAsArray()['status']);
                $newDirectoryTmp = str_replace(
                    '/',
                    '\/',
                    $this->mailevaConnection->getTmpFileDirectory() . $this->mailevaConnection->getDirectoryCallback()
                );
                $newFileRename   = preg_replace(
                    '/' . $newDirectoryTmp . '/',
                    $mailevaResponseLRCOPRO->getResponseAsArray()['status'] . '/',
                    $mailevaResponseLRCOPRO->getResponseAsArray()['filePathTmp']
                );

                if (!ftp_rename(
                    $conn,
                    $mailevaResponseLRCOPRO->getResponseAsArray()['filePathFtp'],
                    $this->mailevaConnection->getDirectoryCallback() . $newFileRename
                )) {
                    return false;
                }
                unlink($mailevaResponseLRCOPRO->getResponseAsArray()['filePathTmp']);
                return true;
            }
        } catch (Throwable $t) {
            error_log($t);
            return false;
        }
    }

    /**
     * @param string $sendingId
     *
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
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
        $envoiApi = new EnvoiApi(null, null, null, $this->hostIndex);
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
     * @param string $sendingId
     *
     * @return MailevaResponseLRCOPRO
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     *
     * @deprecated
     */
    private function getSendingBySendingIdLRCOPRO_legacy(string $sendingId): MailevaResponseLRCOPRO
    {
        $mailevaResponseLRCOPRO = new MailevaResponseLRCOPRO();
        $responseAsArray = [];

        $conn = null;
        //Get list notification
        try {
            $conn = ftp_connect($this->mailevaConnection->getHost());

            if (false === $conn) {
                throw new MailevaCoreException('Unable to connect ' . $this->mailevaConnection->getHost() . ' fail');
            }

            if (!ftp_login($conn, $this->mailevaConnection->getClientId(), $this->mailevaConnection->getClientSecret())) {
                throw new MailevaCoreException('Unable to login ' . $this->mailevaConnection->getHost() . ' fail');
            }

            if (!ftp_pasv($conn, true)) {
                throw new MailevaCoreException('Unable to set passive mode ' . $this->mailevaConnection->getHost() . ' fail');
            }

            $fileListing = ftp_nlist($conn, $this->mailevaConnection->getDirectoryCallback());
            // Check if directory

            if (!empty($fileListing)) {
                foreach ($fileListing as $filePath) {
                    $pathInfo = pathinfo($filePath);
                    if (false === array_key_exists('extension', $pathInfo)) {
                        continue;
                    }

                    if (!is_dir($this->mailevaConnection->getTmpFileDirectory() . $this->mailevaConnection->getDirectoryCallback())) {
                        if (!mkdir($concurrentDirectory = $this->mailevaConnection->getTmpFileDirectory() . $this->mailevaConnection->getDirectoryCallback()) && !is_dir($concurrentDirectory)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                        }
                    }
                    $tmpLocalFile = $this->mailevaConnection->getTmpFileDirectory() . $filePath;

                    if(false === file_exists($tmpLocalFile)){
                        if (false === ftp_get($conn, $tmpLocalFile, $filePath, FTP_BINARY)) {
                            error_log(__FILE__ . '(' . __LINE__ . '):  Trouble downloading the file : ' . $filePath);
                            continue;
                        }
                    }

                    if (is_file($tmpLocalFile)) {
                        $handle   = fopen($tmpLocalFile, "r");
                        $contents = fread($handle, filesize($tmpLocalFile));

                        $xml = preg_replace('/tnsb:/', '', $contents);
                        $xml = simplexml_load_string($xml);
                        if (!empty($xml->Request->TrackId[0])) {
                            $trackId = (string)$xml->Request->TrackId[0]; #1
                            if ($sendingId . '.Rq' === $trackId) {
                                $responseAsArray['id'] = $sendingId;
                                # Todo pansement pas joli, mieux gérer les différents status LRCOPRO
                                if (in_array((string)$xml->Request->Status[0],['ACCEPT','OK'])) {
                                    $responseAsArray['status'] = MailevaSendingStatus::ACCEPTED;
                                }
                                if ((string)$xml->Request->Status[0] === 'NACCEPT') {
                                    $responseAsArray['status'] = MailevaSendingStatus::SUBMIT_ERROR;
                                }

                                $responseAsArray['creation_date']            = (string)$xml->Request->ReceptionDate[0];
                                $responseAsArray['postage_type']             = (string)$xml->Request->PaperOptions->PostageClass[0];
                                $responseAsArray['pages_count']              = (string)$xml->Request->PaperOptions->PageCount[0];
                                $responseAsArray['documents_count']          = (string)$xml->Request->PaperOptions->DocumentCount[0];
                                $responseAsArray['billed_page_count']        = (string)$xml->Request->PaperOptions->BilledPageCount[0];
                                $responseAsArray['deposit_id']               = (string)$xml->Request->DepositId[0];
                                $responseAsArray['expected_production_date'] = (string)$xml->Request->ExpectedProductionDate[0];

                                if ($xml->Request->PaperOptions->PrintDuplex[0]) {
                                    $responseAsArray['duplex_printing'] = 1;
                                } else {
                                    $responseAsArray['duplex_printing'] = 0;
                                }
                                if ($xml->Request->PaperOptions->HasColorPage[0]) {
                                    $responseAsArray['color_printing'] = 1;
                                } else {
                                    $responseAsArray['color_printing'] = 0;
                                }

                                $responseAsArray['filePathTmp'] = $tmpLocalFile;
                                $responseAsArray['filePathFtp'] = $filePath;
                                $mailevaResponseLRCOPRO->setResponseAsArray($responseAsArray);

                                if ($this->renameFileAfterReturnStatus($conn, $mailevaResponseLRCOPRO) === false) {
                                    error_log(
                                        __FILE__ . '(' . __LINE__ . '): Rename file not worked : ' . $mailevaResponseLRCOPRO->getResponseAsArray(
                                        )['filePathTmp']
                                    );
                                }

                                break;
                            }
                        } else {
                            error_log(__FILE__ . '(' . __LINE__ . '): The generation of the xml file is empty');
                            continue;
                        }
                        fclose($handle);
                    } else {
                        throw new MailevaCoreException('Unable to access file ' . $tmpLocalFile);
                    }
                }
            }
        } catch (Throwable $t) {
            throw new MailevaCoreException(
                'Function : getSendingStatusById : Unable to connect to ' . $this->mailevaConnection->getHost() . ' ' . $t->getMessage(),
                $t->getCode(), $t
            );
        } finally {
            if (null !== $conn) {
                ftp_close($conn);
            }

            if (empty($mailevaResponseLRCOPRO->getResponseAsArray())) {
                throw new MailevaResponseException('Unable to retrieve by sendingId ' . $sendingId);
            }

            return $mailevaResponseLRCOPRO;
        }
    }

    /**
     * @param MailevaSending $mailevaSending
     * @return string
     * @throws Client\LrCoproClient\ApiException
     */
    public function prepareLRCOPRO(MailevaSending $mailevaSending): string
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

        $envoiApi = new EnvoiApi(null, null, null, $this->hostIndex);
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
     * @throws MailevaCoreException
     * @deprecated
     * @see self::prepareLRCOPRO()
     */
    private function prepareLRCOPROLegacy(MailevaSending $mailevaSending): string
    {
        $conn      = null;
        $sendingId = null;
        try {
            $conn = ftp_connect($this->mailevaConnection->getHost());

            if (false === $conn) {
                throw new MailevaCoreException('Unable to connect ' . $this->mailevaConnection->getHost() . ' fail');
            }

            if (!ftp_login($conn, $this->mailevaConnection->getClientId(), $this->mailevaConnection->getClientSecret())) {
                throw new MailevaCoreException('Unable to login ' . $this->mailevaConnection->getHost() . ' fail');
            }

            if (!ftp_pasv($conn, true)) {
                throw new MailevaCoreException('Unable to set passive mode ' . $this->mailevaConnection->getHost() . ' fail');
            }

            $sendingId  = str_replace('.', '', uniqid('', 'true'));
            $tplContent = file_get_contents(__DIR__ . '/templates/lrcopro.xml');

            $file = $mailevaSending->getFile();

            $login    = $this->mailevaConnection->getUsername();
            $password = $this->mailevaConnection->getPassword();

            $customId = $mailevaSending->getCustomId();
            //$name               = $mailevaSending->getName();
            $duplexPrinting     = $mailevaSending->isDuplexPrinting() ? 1 : 0;
            $notification_email = $mailevaSending->getNotificationEmail();

            $tplContent = str_replace(
                array('##login##', '##password##', '##customId##', '##sendingId##', '##name##', '##duplexPrinting##', '##notification_email##'),
                array($login, $password, $customId, $sendingId, 'Envoi LRCOPRO', $duplexPrinting, $notification_email),
                $tplContent
            );

            $addressLine1 = $mailevaSending->getAddressLine1();
            $addressLine2 = $mailevaSending->getAddressLine2();
            $addressLine3 = $mailevaSending->getAddressLine3();
            $addressLine4 = $mailevaSending->getAddressLine4();
            $addressLine5 = $mailevaSending->getAddressLine5();
            $addressLine6 = $mailevaSending->getAddressLine6();

            $tplContent = str_replace(
                array('##addressLine1##', '##addressLine2##', '##addressLine3##', '##addressLine4##', '##addressLine5##', '##addressLine6##'),
                array($addressLine1, $addressLine2, $addressLine3, $addressLine4, $addressLine5, $addressLine6),
                $tplContent
            );

            $senderAddressLine1 = $mailevaSending->getSenderAddressLine1();
            $senderAddressLine2 = $mailevaSending->getSenderAddressLine2();
            $senderAddressLine3 = $mailevaSending->getSenderAddressLine3();
            $senderAddressLine4 = $mailevaSending->getSenderAddressLine4();
            $senderAddressLine5 = $mailevaSending->getSenderAddressLine5();
            $senderAddressLine6 = $mailevaSending->getSenderAddressLine6();

            $tplContent = str_replace(
                array(
                    '##senderAddressLine1##',
                    '##senderAddressLine2##',
                    '##senderAddressLine3##',
                    '##senderAddressLine4##',
                    '##senderAddressLine5##',
                    '##senderAddressLine6##'
                ),
                array($senderAddressLine1, $senderAddressLine2, $senderAddressLine3, $senderAddressLine4, $senderAddressLine5, $senderAddressLine6),
                $tplContent
            );

            $tplFile = tempnam(sys_get_temp_dir(), 'xml');
            file_put_contents($tplFile, $tplContent);

            $zip     = new ZipArchive();
            $tempZip = sys_get_temp_dir() . '/' . $sendingId . '.zip';

            if ($zip->open($tempZip, ZipArchive::CREATE) !== true) {
                throw new MailevaCoreException('Unable to open Zip File ' . $tempZip);
            }

            $zip->addFile($file, $sendingId . '.001');
            $zip->addFile($tplFile, $sendingId . '.002');
            $zip->close();

            if (!ftp_put($conn, $sendingId . '.zip', $tempZip, FTP_BINARY)) {
                throw new MailevaCoreException('Unable to send Zip File ' . $tempZip);
            }

            if ($this->mailevaConnection->useMemcache() === true) {
                MemcachedManager::getInstance(
                    $this->mailevaConnection->getMemcacheHost(),
                    $this->mailevaConnection->getMemcachePort()
                )->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);
            }
        } catch (Throwable $t) {
            throw new MailevaCoreException('Unable to connect to ' . $this->mailevaConnection->getHost() . ' ' . $t->getMessage(), $t->getCode(), $t);
        } finally {
            if (null !== $conn) {
                ftp_close($conn);
            }
        }

        return $sendingId;
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
     * @throws Exception\MailevaRoutingException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    private function prepareSimple(MailevaSending $mailevaSending): string
    {
        $name                             = $mailevaSending->getName();
        $postageType                      = $mailevaSending->getPostageType();
        $colorPrinting                    = $mailevaSending->isColorPrinting();
        $duplexPrinting                   = $mailevaSending->isDuplexPrinting();
        $optionalAddressSheet             = $mailevaSending->isOptionalAddressSheet();
        $treatUndeliveredMail             = $mailevaSending->isTreatUndeliveredMail();
        $notificationTreatUndeliveredMail = $mailevaSending->getNotificationTreatUndeliveredMail();
        $file                             = $mailevaSending->getFile();
        $filePriority                     = $mailevaSending->getFilepriority();
        $fileName                         = $mailevaSending->getFilename();
        $addressLine1                     = $mailevaSending->getAddressLine1();
        $addressLine2                     = $mailevaSending->getAddressLine2();
        $addressLine3                     = $mailevaSending->getAddressLine3();
        $addressLine4                     = $mailevaSending->getAddressLine4();
        $addressLine5                     = $mailevaSending->getAddressLine5();
        $addressLine6                     = $mailevaSending->getAddressLine6();
        $countryCode                      = $mailevaSending->getCountryCode();
        $customId                         = $mailevaSending->getCustomId();

        $sending   = $this->postSending(['name' => $name]);
        $sendingId = $sending->getResponseAsArray()['sendingId'];

        if (empty($sendingId)) {
            throw new MailevaResponseException('Unable to retrieve sendingId');
        }

        $this->patchSendingBySendingId(
            $sendingId,
            [
                "postage_type"                        => $postageType,
                "color_printing"                      => $colorPrinting,
                "duplex_printing"                     => $duplexPrinting,
                "optional_address_sheet"              => $optionalAddressSheet,
                "treat_undelivered_mail"              => $treatUndeliveredMail,
                "notification_treat_undelivered_mail" => $notificationTreatUndeliveredMail
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
     * @param string $sendingId
     * @return void
     * @throws Client\LrCoproClient\ApiException
     */
    private function submitLrCopro(string $sendingId): void
    {
        $envoiApi = new EnvoiApi(null, null, null, $this->hostIndex);
        $envoiApi->submitSending($this->getAccessTokenV2(), $sendingId);
    }

    /**
     * @param string $sendingId
     *
     * @throws MailevaCoreException
     */
    private function submitLrCopro_legacy(string $sendingId)
    {
        $conn = ftp_connect($this->mailevaConnection->getHost());

        if (false === $conn) {
            throw new MailevaCoreException('Unable to connect ' . $this->mailevaConnection->getHost() . ' fail');
        }

        if (!ftp_login($conn, $this->mailevaConnection->getClientId(), $this->mailevaConnection->getClientSecret())) {
            throw new MailevaCoreException('Unable to login ' . $this->mailevaConnection->getHost() . ' fail');
        }

        if (!ftp_pasv($conn, true)) {
            throw new MailevaCoreException(
                'Unable to set passive mode ' . $this->mailevaConnection->getHost() . ' fail'
            );
        }

        if (!ftp_rename($conn, $sendingId . '.zip', $sendingId . '.zcou')) {
            throw new MailevaCoreException('Unable to rename ' . $sendingId . '.zip submit fail');
        }

        ftp_close($conn);
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
}


