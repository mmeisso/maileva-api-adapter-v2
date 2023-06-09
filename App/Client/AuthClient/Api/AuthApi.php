<?php
/**
 * AuthApi
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\AuthClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Maileva / Authentification
 *
 * # Description générale     L'authentification aux API Maileva est régie par un serveur d'authentification centrale qui implémente le protocole OAuth2. Le serveur d'authentification délivre des jetons d'accès (*token*). La présente documentation décrit les différentes méthodes pour obetnir un jeton.      Ensuite, lors des appels aux API Maileva, ce jeton d'accès devra être envoyé dans l'entête HTTP Authorization de la requête de la manière suivante :  ```sh Authorization: Bearer <access_token> ```   # Identification des applications clientes    Pour qu'une application cliente (Site web, application mobile, partenaire) puisse interroger et authentifier des utilisateurs, elle doit s'enregistrer auprès de Maileva afin de pouvoir appeler (au nom de l'utilisateur connecté) les API. Maileva fournit alors un jeu d'identifiants *client_id*, *client_secret* qui permettra à l'application d'être identifiée auprès du serveur OAuth2.  # Les modes d'authentification OAuth2 Le protocole OAuth2 prévoit plusieurs modes d'authentification, appelés *grant_type*, suivant les cas d'utilisation.  - Ressource Owner Password Credentials grant_type : ce mode est basé sur un appel serveur à serveur (machine-2-machine ou m2m) sans aucune IHM ni jeu de redirection (l'utilisateur n'étant pas forcément derrière un navigateur). Ce mode est conçu principalement pour des applications riches (dans lesquelles les redirections web ne sont pas évidentes) ou encore pour des applications souhaitant proposer leur propre IHM ou une page d'authentification autre que celle du serveur d'authentification OAuth2 Maileva. Ce mode d'authentification nécessite une qualification de la part de Maileva pour être accessible. Cette authentification s'utilise en appelant la méthode `POST /oauth2/token`  - Client Credentials grant_type : ce mode peut s'assimiler à l'authentification classique par login et mot de passe (Basic Auth par exemple). Ce mode est adapté aux applications accédant à leurs propres ressources. L'utilisateur et l'application cliente se confondent. Ce mode d'authentification nécessite une qualification de la part de Maileva pour être accessible. Cette authentification s'utilise en appelant la méthode `POST /oauth2/token`    # Format du jeton    Le jeton d'accès retourné par l'application d'authentification est au format JWT ([JSON Web Token](https://jwt.io/)).      Le format et la taille de ce jeton est succeptible d'évoluer.    # Références    OAuth2 RFC-6749 : https://tools.ietf.org/html/rfc6749      OAuth2 portal : https://oauth.net/2/      Comprendre OAuth2 : http://www.bubblecode.net/fr/2016/01/22/comprendre-oauth2/      jwt.io : https://jwt.io/
 *
 * The version of the OpenAPI document: 2.0
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.3.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\AuthClient\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Client\AuthClient\Configuration;
use MailevaApiAdapter\App\Client\AuthClient\HeaderSelector;
use MailevaApiAdapter\App\Client\AuthClient\ObjectSerializer;

/**
 * AuthApi Class Doc Comment
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\AuthClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class AuthApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /** @var string[] $contentTypes **/
    public const contentTypes = [
        'tokenPost' => [
            'application/x-www-form-urlencoded',
        ],
    ];

/**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation tokenPost
     *
     * @param  string $authorization Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) (required)
     * @param  string $grantType Mode d’authentification (required)
     * @param  string $username Identifiant de l’utilisateur Maileva (optional)
     * @param  string $password Mot de passe de l’utilisateur (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['tokenPost'] to see the possible values for this operation
     *
     * @throws \MailevaApiAdapter\App\Client\AuthClient\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse|\MailevaApiAdapter\App\Client\AuthClient\Model\Errors|\MailevaApiAdapter\App\Client\AuthClient\Model\Errors
     */
    public function tokenPost($authorization, $grantType, $username = null, $password = null, string $contentType = self::contentTypes['tokenPost'][0])
    {
        list($response) = $this->tokenPostWithHttpInfo($authorization, $grantType, $username, $password, $contentType);
        return $response;
    }

    /**
     * Operation tokenPostWithHttpInfo
     *
     * @param  string $authorization Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) (required)
     * @param  string $grantType Mode d’authentification (required)
     * @param  string $username Identifiant de l’utilisateur Maileva (optional)
     * @param  string $password Mot de passe de l’utilisateur (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['tokenPost'] to see the possible values for this operation
     *
     * @throws \MailevaApiAdapter\App\Client\AuthClient\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse|\MailevaApiAdapter\App\Client\AuthClient\Model\Errors|\MailevaApiAdapter\App\Client\AuthClient\Model\Errors, HTTP status code, HTTP response headers (array of strings)
     */
    public function tokenPostWithHttpInfo($authorization, $grantType, $username = null, $password = null, string $contentType = self::contentTypes['tokenPost'][0])
    {
        $request = $this->tokenPostRequest($authorization, $grantType, $username, $password, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null,
                    $e
                );
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null,
                    $e
                );
            }


            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\MailevaApiAdapter\App\Client\AuthClient\Model\Errors' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\MailevaApiAdapter\App\Client\AuthClient\Model\Errors' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MailevaApiAdapter\App\Client\AuthClient\Model\Errors', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 401:
                    if ('\MailevaApiAdapter\App\Client\AuthClient\Model\Errors' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\MailevaApiAdapter\App\Client\AuthClient\Model\Errors' !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\MailevaApiAdapter\App\Client\AuthClient\Model\Errors', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MailevaApiAdapter\App\Client\AuthClient\Model\Errors',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\MailevaApiAdapter\App\Client\AuthClient\Model\Errors',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation tokenPostAsync
     *
     * @param  string $authorization Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) (required)
     * @param  string $grantType Mode d’authentification (required)
     * @param  string $username Identifiant de l’utilisateur Maileva (optional)
     * @param  string $password Mot de passe de l’utilisateur (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['tokenPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function tokenPostAsync($authorization, $grantType, $username = null, $password = null, string $contentType = self::contentTypes['tokenPost'][0])
    {
        return $this->tokenPostAsyncWithHttpInfo($authorization, $grantType, $username, $password, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation tokenPostAsyncWithHttpInfo
     *
     * @param  string $authorization Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) (required)
     * @param  string $grantType Mode d’authentification (required)
     * @param  string $username Identifiant de l’utilisateur Maileva (optional)
     * @param  string $password Mot de passe de l’utilisateur (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['tokenPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function tokenPostAsyncWithHttpInfo($authorization, $grantType, $username = null, $password = null, string $contentType = self::contentTypes['tokenPost'][0])
    {
        $returnType = '\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse';
        $request = $this->tokenPostRequest($authorization, $grantType, $username, $password, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'tokenPost'
     *
     * @param  string $authorization Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) (required)
     * @param  string $grantType Mode d’authentification (required)
     * @param  string $username Identifiant de l’utilisateur Maileva (optional)
     * @param  string $password Mot de passe de l’utilisateur (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['tokenPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function tokenPostRequest($authorization, $grantType, $username = null, $password = null, string $contentType = self::contentTypes['tokenPost'][0])
    {

        // verify the required parameter 'authorization' is set
        if ($authorization === null || (is_array($authorization) && count($authorization) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $authorization when calling tokenPost'
            );
        }

        // verify the required parameter 'grantType' is set
        if ($grantType === null || (is_array($grantType) && count($grantType) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $grantType when calling tokenPost'
            );
        }




        $resourcePath = '/token';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($authorization !== null) {
            $headerParams['Authorization'] = ObjectSerializer::toHeaderValue($authorization);
        }


        // form params
        if ($grantType !== null) {
            $formParams['grant_type'] = ObjectSerializer::toFormValue($grantType);
        }
        // form params
        if ($username !== null) {
            $formParams['username'] = ObjectSerializer::toFormValue($username);
        }
        // form params
        if ($password !== null) {
            $formParams['password'] = ObjectSerializer::toFormValue($password);
        }

        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
