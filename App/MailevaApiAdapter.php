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
use MailevaApiAdapter\App\Exception\MailevaResponseException;

class MailevaApiAdapter
{


    private $access_token = null;
    private $clientId;
    private $clientSecret;
    private $username;
    private $password;

    /**
     * MailevaApiAdapter constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $username
     * @param string $password
     */
    public function __construct(string $clientId, string $clientSecret, string $username, string $password)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @param string $JsonAsString
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getAuthentication(string $JsonAsString): MailevaResponse
    {
        #$JsonAsString : {"client_id": "string","redirect_uri": "string","state": "string","response_type": "token"}
        $route = new Route($this, Routing::GET_AUTHENTICATION,
            [
                'params' => [
                    'body' => $JsonAsString
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
                'params' => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param string $JsonAsString
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postSending(string $JsonAsString): MailevaResponse
    {
        #$JsonAsString : {"name": "string"}
        $route = new Route($this, Routing::POST_SENDING,
            [
                'params' => [
                    'body' => $JsonAsString
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
    public function getSendings(int $startIndex = 1, int $count = 1): MailevaResponse
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
     * @param int $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getSendingBySendingId(int $sendingId): MailevaResponse
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
     * @param int $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteSendingBySendingId(int $sendingId): MailevaResponse
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
     * @param int $sendingId
     * @param string $filePath
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentBySendingId(int $sendingId, string $filePath): MailevaResponse
    {
        $route = new Route($this, Routing::POST_DOCUMENT_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'file' => $filePath
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param int $sendingId
     * @param int $startIndex
     * @param int $count
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getDocumentsBySendingId(int $sendingId, int $startIndex = 1, int $count = 1): MailevaResponse
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
     * @param int $sendingId
     * @param int $documentId
     * @param int $position
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentPositionBySendingId(int $sendingId, int $documentId, int $position): MailevaResponse
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
     * @param int $sendingId
     * @param int $fileId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postDocumentFromLibrary(int $sendingId, int $fileId): MailevaResponse
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
     * @param int $sendingId
     * @param int $documentId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteDocumentBySendingId(int $sendingId, int $documentId): MailevaResponse
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
     * @param int $sendingId
     * @param int $documentId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getDocumentBySendingId(int $sendingId, int $documentId): MailevaResponse
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
     * @param int $sendingId
     * @param string $JsonAsString
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postImportRecipientsBySendingId(int $sendingId, string $JsonAsString): MailevaResponse
    {
        #$JsonAsString : [{"address_line_1": "string","address_line_2": "string","address_line_3": "string","address_line_4": "string","address_line_5": "string","address_line_6": "string","country_code": "string","custom_id": "string"}]
        $route = new Route($this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $JsonAsString
                ]
            ]
        );
        return $route->call();


    }

    /**
     * @param int $sendingId
     * @param int $importId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getImportRecipientsBySendingIdAndImportId(int $sendingId, int $importId): MailevaResponse
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
     * @param int $sendingId
     * @param int $startIndex
     * @param int $count
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getRecipientsBySendingId(int $sendingId, int $startIndex = 1, int $count = 1): MailevaResponse
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
     * @param int $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteRecipientsBySendingId(int $sendingId): MailevaResponse
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
     * @param int $sendingId
     * @param string $JsonAsString
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postImportRecipientsBySendingIdFromAddressBook(int $sendingId, string $JsonAsString): MailevaResponse
    {
        #$JsonAsString : [{"id": "string"}]
        $route = new Route($this, Routing::POST_IMPORT_RECIPIENTS_BY_SENDING_ID_FROM_ADDRESS_BOOK,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $JsonAsString
                ]
            ]
        );
        return $route->call();
    }

    /**
     * @param int $sendingId
     * @param int $recipientId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function getRecipientBySendingIdAndRecipientId(int $sendingId, int $recipientId): MailevaResponse
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
     * @param int $sendingId
     * @param int $recipientId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function deleteRecipientBySendingIdAndRecipientId(int $sendingId, int $recipientId): MailevaResponse
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
     * @param int $sendingId
     * @param string $JsonAsString
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function patchSendingBySendingId(int $sendingId, string $JsonAsString): MailevaResponse
    {

        #$JsonAsString : {"postage_type": "FAST","color_printing": true,"duplex_printing": true,"optional_address_sheet": true,"undelivered_mails_management": true, "notification_email": "string"}
        $route = new Route($this, Routing::PATCH_SENDING_BY_SENDING_ID,
            [
                'params' => [
                    'sending_id' => $sendingId,
                    'body' => $JsonAsString
                ]
            ]
        );
        return $route->call();

    }

    /**
     * @param int $sendingId
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function postSendingBySendingId(int $sendingId): MailevaResponse
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
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return is_null($this->access_token) === false;
    }


    /**
     * @return string
     */
    public function getAccessToken()
    {
        if (is_null($this->access_token)) {
            $key = 'maileva_token_' . $this->clientId . '_' . $this->clientSecret . '_' . $this->username;
            $memcachedToken = MemcachedManager::getInstance()->get($key, false);
            if (false !== ($memcachedToken)) {
                $this->access_token = $memcachedToken;
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
        $key = 'maileva_token_' . $this->clientId . '_' . $this->clientSecret . '_' . $this->username;
        MemcachedManager::getInstance()->set($key, $token, abs($secondsDurationValidity / 2));
        $this->access_token = $token;
    }

}