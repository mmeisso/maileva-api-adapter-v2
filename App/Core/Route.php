<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:52
 */

namespace MailevaApiAdapter\App\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use MailevaApiAdapter\App\Core\Http\Request\Method;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use MailevaApiAdapter\App\Exception\RoutingException;
use MailevaApiAdapter\App\MailevaApiAdapter;

/**
 * Class Route
 * @package MailevaApiAdapter\App\Core
 */
class Route
{

    const DEBUG = false;

    private $mailevaApiAdapter;
    private $url;
    private $method;
    private $params;
    private $headers;
    private $body;
    private $file;
    private $authenticatedRoute;
    private $multipart;

    /**
     * Route constructor.
     * @param MailevaApiAdapter $mailevaApiAdapter
     * @param array $defaultArgues
     * @param array $argues
     * @throws RoutingException
     */
    public function __construct(MailevaApiAdapter $mailevaApiAdapter, array $defaultArgues, array $argues)
    {
        if (!is_array($defaultArgues)) {
            throw new RoutingException(' not implemented');
        } else {

            $this->mailevaApiAdapter = $mailevaApiAdapter;

            $this->populate($this->array_merge_recursive_distinct($defaultArgues, $argues));

            #migrate parameter to url, body and multipart if necessary
            foreach ($this->params as $key => $value) {

                if (strpos($this->url, '{' . $key . '}')) {
                    $this->url = str_replace('{' . $key . '}', $value, $this->url);
                    unset($this->params[$key]);
                    continue;
                }

                if ($key === 'body') {
                    $this->body = $value;
                    unset($this->params[$key]);
                    continue;
                }

                if ($key === 'multipart') {
                    $this->multipart = $value;
                    unset($this->params[$key]);
                    continue;
                }

            }
        }
    }

    /**
     * Set values and check consistence
     *
     * @param array $array
     * @throws RoutingException
     */
    private function populate(array $array)
    {
        foreach ($array as $key => $value) {

            if (is_array($value)) {
                # an array -> loop
                switch ($key) {
                    case 'headers':
                        $this->headers = $value;
                        continue;
                    case 'params':
                        $this->params = $value;
                        continue;
                    default:
                        $this->populate($value);
                }
            } else {
                # a value -> set
                if ($value === Routing::REQUIRED) {
                    throw new RoutingException($key . ' not set');
                }

                switch ($key) {
                    case 'method':
                        $this->method = $value;
                        continue;
                    case 'url':
                        $this->url = $value;
                        continue;
                    case 'authenticated_route':
                        $this->authenticatedRoute = $value;
                        continue;
                    default:
                        continue;


                }

            }
        }


    }

    /**
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    /**
     * @return MailevaApiAdapter
     */
    public function getMailevaApiAdapter(): MailevaApiAdapter
    {
        return $this->mailevaApiAdapter;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return MailevaResponse
     * @throws MailevaResponseException
     * @throws RoutingException
     */
    public function call(): MailevaResponse
    {
        $response = null;
        $requestParameters = [];

        try {

            if ($this->isAuthenticatedRoute()) {
                if ($this->mailevaApiAdapter->isAuthenticated() === false) {
                    $this->mailevaApiAdapter->postAuthentication();
                }

                if ($this->mailevaApiAdapter->isAuthenticated()) {
                    $this->headers['Authorization'] = 'Bearer ' . $this->mailevaApiAdapter->getAccessToken();
                } else {
                    throw new MailevaResponseException('unable to authenticate');
                }

            }

            $requestParameters[RequestOptions::HEADERS] = $this->getHeaders();


            switch ($this->getMethod()) {
                case Method::DELETE:
                case Method::GET:
                    $requestParameters [RequestOptions::QUERY] = $this->getParams();
                    break;
                case Method::PATCH:
                case Method::POST:

                    if (!is_null($this->getMultipart())) {

                        $requestParameters [RequestOptions::MULTIPART] = $this->getMultipart();

                    } elseif (!is_null($this->getBody())) {

                        $requestParameters[RequestOptions::JSON] = $this->getBody();

                    } elseif (!empty($this->getParams())) {

                        $requestParameters [RequestOptions::FORM_PARAMS] = $this->getParams();

                    }
                    break;

                default:
                    throw new RoutingException(' not implemented ' . $this->getMethod());
                    break;
            }

            $client = new Client(['verify' => false ]);

            $res = $client->request($this->getMethod(), $this->getUrl(), $requestParameters);

            $mailevaResponse = new MailevaResponse($this, $res);

            if (self::DEBUG) {
                echo '-------------' . $this->getMethod() . ' ' . $this->getUrl() . '-------------';
                var_dump($mailevaResponse->getResponseAsArray());
                echo '*****************************************************************************';

                error_log('-------------' . $this->getMethod() . ' ' . $this->getUrl() . '-------------');
                error_log(print_r($mailevaResponse->getResponseAsArray(), true));
                error_log('*****************************************************************************');
            }

            return $mailevaResponse;

        } catch (GuzzleException $guzzleException) {
            throw new MailevaResponseException($guzzleException->getMessage());
        }
    }

    /**
     * @return bool
     */
    public function isAuthenticatedRoute(): bool
    {
        return $this->authenticatedRoute;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return String
     */
    public function getMethod(): String
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getMultipart()
    {
        return $this->multipart;
    }

    /**
     * @param mixed $multipart
     */
    public function setMultipart($multipart)
    {
        $this->multipart = $multipart;
    }

    /**
     * getBody()
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return String
     * @throws RoutingException
     */
    public function getUrl(): String
    {
        if ($this->isAuthenticatedRoute()) {
            if (strpos('sandbox', $this->getMailevaApiAdapter()->getHost()) > 1) {
                return $this->getMailevaApiAdapter()->getHost() . '/mail/v1' . $this->url;
            } else {
                return $this->getMailevaApiAdapter()->getHost() . '/sendings-api/v1/mail' . $this->url;
            }

        } else {
            return $this->getMailevaApiAdapter()->getAuthenticationHost() . '/authentication' . $this->url;
        }
    }

}

