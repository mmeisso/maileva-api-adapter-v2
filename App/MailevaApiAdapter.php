<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:33
 */

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Core\MailevaResponse;
use MailevaApiAdapter\App\Core\MemcachedManager;
use MailevaApiAdapter\App\Core\Route;
use MailevaApiAdapter\App\Core\Routing;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use MailevaApiAdapter\App\Exception\MailevaResponseException;

/**
 * Class MailevaApiAdapter
 * @package MailevaApiAdapter\App
 */
class MailevaApiAdapter
{


    private $access_token = null;
    private $clientId;
    private $clientSecret;
    private $username;
    private $password;
    private $env;
    private $useMemcache = false;
    private $memcacheHost = null;
    private $memcachePort = null;


    /**
     * MailevaApiAdapter constructor.
     * @param MailevaConnection $mailevaConnection
     */
    public function __construct(MailevaConnection $mailevaConnection)
    {
        $this->env = $mailevaConnection->getEnv();
        $this->clientId = $mailevaConnection->getClientId();
        $this->clientSecret = $mailevaConnection->getClientSecret();
        $this->username = $mailevaConnection->getUsername();
        $this->password = $mailevaConnection->getPassword();

        if ($mailevaConnection->useMemcache()) {
            $this->useMemcache = true;
            $this->memcacheHost = $mailevaConnection->getMemcacheHost();
            $this->memcachePort = $mailevaConnection->getMemcachePort();
        }

    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }


    /**
     * @param MailevaSending $mailevaSending
     * @return string
     * @throws MailevaParameterException
     * @throws MailevaResponseException
     */
    public function post(MailevaSending $mailevaSending): string
    {
        $name = $mailevaSending->getName();
        $postageType = $mailevaSending->getPostageType();
        $colorPrinting = $mailevaSending->isColorPrinting();
        $duplexPrinting = $mailevaSending->isDuplexPrinting();
        $optionalAddressSheet = $mailevaSending->isOptionalAddressSheet();
        $notificationEmail = $mailevaSending->getNotificationEmail();
        $file = $mailevaSending->getFile();
        $filePriority = $mailevaSending->getFilepriority();
        $fileName = $mailevaSending->getFilename();
        $addressLine1 = $mailevaSending->getAddressLine1();
        $addressLine2 = $mailevaSending->getAddressLine2();
        $addressLine3 = $mailevaSending->getAddressLine3();
        $addressLine4 = $mailevaSending->getAddressLine4();
        $addressLine5 = $mailevaSending->getAddressLine5();
        $addressLine6 = $mailevaSending->getAddressLine6();
        $countryCode = $mailevaSending->getCountryCode();
        $customId = $mailevaSending->getCustomId();

        $sending = $this->postSending(['name' => $name]);
        $sendingId = $sending->getResponseAsArray()['sendingId'];

        if (empty($sendingId)) {
            throw new MailevaResponseException('Unable to retrieve sendingId');
        }

        $this->patchSendingBySendingId($sendingId,
            ["postage_type" => $postageType,
                "color_printing" => $colorPrinting,
                "duplex_printing" => $duplexPrinting,
                "optional_address_sheet" => $optionalAddressSheet,
                "notification_email" => $notificationEmail
            ]
        );

        $this->postDocumentBySendingId($sendingId,
            [
                ['name' => 'document', 'contents' => \GuzzleHttp\Psr7\stream_for(fopen($file, 'rb'))],
                ['name' => 'metadata', 'contents' => '{"priority": ' . $filePriority . ',"name":"' . $fileName . '"}']
            ]
        );

        $this->postImportRecipientsBySendingId($sendingId,
            ['import_recipients' =>
                [
                    [
                        'address_line_1' => $addressLine1,
                        'address_line_2' => $addressLine2,
                        'address_line_3' => $addressLine3,
                        'address_line_4' => $addressLine4,
                        'address_line_5' => $addressLine5,
                        'address_line_6' => $addressLine6,
                        'country_code' => $countryCode,
                        'custom_id' => $customId
                    ]
                ]
            ]
        );

        $this->postSendingBySendingId($sendingId);

        return $sendingId;

    }

    /**
     * @param array $body
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postSending(array $body): MailevaResponse
    {
        #$body : {"name": "string"}
        $route = new Route($this, Routing::POST_SENDING,
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
     * @param array $body
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function patchSendingBySendingId(string $sendingId, array $body): MailevaResponse
    {

        #$body : {"postage_type": "FAST","color_printing": true,"duplex_printing": true,"optional_address_sheet": true,"undelivered_mails_management": true, "notification_email": "string"}
        $route = new Route($this, Routing::PATCH_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $body
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param array $multipart
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentBySendingId(string $sendingId, array $multipart): MailevaResponse
    {
        $route = new Route($this, Routing::POST_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'multipart' => $multipart
                ]
            ]
        );
        return $route->call();


    }

    /**
     * @param string $sendingId
     * @param array $body
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postImportRecipientsBySendingId(string $sendingId, array $body): MailevaResponse
    {
        #$body : [{"address_line_1": "string","address_line_2": "string","address_line_3": "string","address_line_4": "string","address_line_5": "string","address_line_6": "string","country_code": "string","custom_id": "string"}]
        $route = new Route($this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $body
                ]
            ]
        );
        return $route->call();


    }

    /**
     * @param string $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postSendingBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route($this, Routing::POST_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param array $body
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getAuthentication(array $body): MailevaResponse
    {
        #$body : {"client_id": "string","redirect_uri": "string","state": "string","response_type": "token"}
        $route = new Route($this, Routing::GET_AUTHENTICATION,
            [
                'params' => [
                    'body' => $body
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postAuthentication(): MailevaResponse
    {
        $route = new Route($this, Routing::POST_AUTHENTICATION,
            [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
                ],
                'params' => [
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param int $startIndex
     * @param int $count
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getSendings(int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route($this, Routing::GET_SENDINGS,
            [
                'params' => [
                    'start_index' => $startIndex,
                    'count' => $count
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route($this, Routing::GET_SENDING_BY_SENDING_ID,
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
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteSendingBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route($this, Routing::DELETE_SENDING_BY_SENDING_ID,
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
     * @param int $startIndex
     * @param int $count
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getDocumentsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route($this, Routing::GET_DOCUMENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'start_index' => $startIndex,
                    'count' => $count
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @param int $position
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentPositionBySendingId(string $sendingId, string $documentId, int $position): MailevaResponse
    {
        $route = new Route($this, Routing::POST_DOCUMENT_POSITION_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'document_id' => $documentId,
                    'position' => $position
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param int $fileId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentFromLibrary(string $sendingId, int $fileId): MailevaResponse
    {
        $route = new Route($this, Routing::POST_DOCUMENT_FROM_LIBRARY,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'file_id' => $fileId
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteDocumentBySendingId(string $sendingId, string $documentId): MailevaResponse
    {
        $route = new Route($this, Routing::DELETE_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'document_id' => $documentId
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getDocumentBySendingId(string $sendingId, string $documentId): MailevaResponse
    {

        $route = new Route($this, Routing::GET_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'document_id' => $documentId
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param int $importId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getImportRecipientsBySendingIdAndImportId(string $sendingId, int $importId): MailevaResponse
    {
        $route = new Route($this, Routing::GET_IMPORT_RECIPIENTS_BY_SENDING_ID_AND_IMPORT_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'import_id' => $importId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getRecipientsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        $route = new Route($this, Routing::GET_RECIPIENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'start_index' => $startIndex,
                    'count' => $count
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteRecipientsBySendingId(string $sendingId): MailevaResponse
    {
        $route = new Route($this, Routing::DELETE_RECIPIENTS_BY_SENDING_ID,
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
     * @param array $body
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postImportRecipientsBySendingIdFromAddressBook(string $sendingId, array $body): MailevaResponse
    {
        #$body : [{"id": "string"}]
        $route = new Route($this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID_FROM_ADDRESS_BOOK,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $body
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $sendingId
     * @param int $recipientId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getRecipientBySendingIdAndRecipientId(string $sendingId, int $recipientId): MailevaResponse
    {
        $route = new Route($this, Routing::GET_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'recipient_id' => $recipientId
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param string $sendingId
     * @param int $recipientId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteRecipientBySendingIdAndRecipientId(string $sendingId, int $recipientId): MailevaResponse
    {
        $route = new Route($this, Routing::DELETE_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'recipient_id' => $recipientId
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return is_null($this->getAccessToken()) === false;
    }


    /**
     * @return string
     */
    public function getAccessToken()
    {
        if ($this->useMemcache) {
            if (is_null($this->access_token)) {
                $key = 'MT_' . $this->clientId . '_' . $this->username;
                $memcachedToken = MemcachedManager::getInstance($this->memcacheHost, $this->memcachePort)->get($key, false);
                if (false !== $memcachedToken) {
                    $this->access_token = $memcachedToken;
                }
            }
        }

        return $this->access_token;
    }

    /**
     * @param string $token
     * @param int $secondsDurationValidity
     */
    public function setAccessToken(string $token, int $secondsDurationValidity)
    {
        if ($this->useMemcache) {
            $key = 'MT_' . $this->clientId . '_' . $this->username;
            #2592000 max memcache value -> http://php.net/manual/fr/memcache.set.php
            MemcachedManager::getInstance($this->memcacheHost, $this->memcachePort)->set($key, $token, min(abs($secondsDurationValidity / 2), 2592000));
        }
        $this->access_token = $token;
    }

}