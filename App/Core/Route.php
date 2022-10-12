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
use MailevaApiAdapter\App\Exception\MailevaRoutingException;
use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaConnection;
use Throwable;

/**
 * Class Route
 *
 * @package MailevaApiAdapter\App\Core
 */
class Route
{

    const DEBUG = false;
    private $authenticatedRoute;
    private $body;
    private $file;
    private $headers;
    private $mailevaApiAdapter;
    private $method;
    private $multipart;
    private $params;
    private $requestParameters;
    private $sink;
    private $url;

    /**
     * Route constructor.
     *
     * @param MailevaApiAdapter $mailevaApiAdapter
     * @param array             $defaultArgues
     * @param array             $argues
     *
     * @throws MailevaRoutingException
     */
    public function __construct(MailevaApiAdapter $mailevaApiAdapter, array $defaultArgues, array $argues)
    {
        if (!is_array($defaultArgues)) {
            throw new MailevaRoutingException(' not implemented');
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

                if ($key === 'sink') {
                    $this->sink = $value;
                    unset($this->params[$key]);
                    continue;
                }
            }
        }
    }

    /**
     * @return MailevaResponse
     * @throws MailevaResponseException
     */
    public function call(): MailevaResponse
    {
        $response                = null;
        $this->requestParameters = [];

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

            $this->requestParameters[RequestOptions::HEADERS] = $this->getHeaders();

            switch ($this->getMethod()) {
                case Method::DELETE:
                case Method::GET:
                    $this->requestParameters[RequestOptions::QUERY] = $this->getParams();
                    if (!is_null($this->getSink())) {
                        $this->requestParameters[RequestOptions::SINK] = $this->getSink();
                    }
                    break;
                case Method::PATCH:
                case Method::POST:
                    if (!is_null($this->getMultipart())) {
                        $this->requestParameters[RequestOptions::MULTIPART] = $this->getMultipart();
                    } elseif (!is_null($this->getBody())) {
                        $this->requestParameters[RequestOptions::JSON] = $this->getBody();
                    } elseif (!empty($this->getParams())) {
                        $this->requestParameters [RequestOptions::FORM_PARAMS] = $this->getParams();
                    }
                    break;
                default:
                    throw new MailevaRoutingException(' not implemented ' . $this->getMethod());
            }

            $client = new Client(['verify' => false]);

            if (self::DEBUG) {
                error_log('*****************************************************************************');
                echo '*****************************************************************************' . '<br/>';
                echo '*****************************************************************************' . '<br/>';
                echo '-------------' . $this->getMethod() . ' ' . $this->getUrl() . ' ' . json_encode(
                        $this->requestParameters
                    ) . '-------------' . '<br/>';
                error_log(
                    '-------------' . $this->getMethod() . ' ' . $this->getUrl() . ' ' . json_encode($this->requestParameters) . '-------------'
                );
                echo '*****************************************************************************' . '<br/>';
            }

            $res = $client->request($this->getMethod(), $this->getUrl(), $this->requestParameters);

            $mailevaResponse = new MailevaResponse($this, $res);

            if (self::DEBUG) {
                var_dump($mailevaResponse->getResponseAsArray());
                echo '*****************************************************************************' . '<br/>';
                error_log(print_r($mailevaResponse->getResponseAsArray(), true));
                error_log('*****************************************************************************');
            }

            return $mailevaResponse;
        } catch (GuzzleException $guzzleException) {
            throw new MailevaResponseException($guzzleException->getMessage());
        } catch (MailevaRoutingException $exception) {
            throw new MailevaResponseException($exception->getMessage());
        } catch (Throwable $throwable) {
            throw new MailevaResponseException($throwable->getMessage());
        }
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
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return MailevaApiAdapter
     */
    public function getMailevaApiAdapter(): MailevaApiAdapter
    {
        return $this->mailevaApiAdapter;
    }

    /**
     * @return String
     */
    public function getMethod(): string
    {
        return $this->method;
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
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRequestParameters()
    {
        return $this->requestParameters;
    }

    /**
     * @return mixed
     */
    public function getSink()
    {
        return $this->sink;
    }

    /**
     * @param mixed $sink
     */
    public function setSink($sink)
    {
        $this->sink = $sink;
    }

    /**
     * @return String
     */
    public function getUrl(): string
    {
        if ($this->isAuthenticatedRoute()) {
            $subDirectory = 'mail';
            if ($this->getMailevaApiAdapter()->getType() === MailevaConnection::LRE) {
                $subDirectory = 'registered_mail';
            }

            return $this->getMailevaApiAdapter()->getHost() . '/' . $subDirectory . '/v2' . $this->url;
        } else {
            $authenticationHost = $this->getMailevaApiAdapter()->getAuthenticationHost();
            if (strpos('sandbox', $authenticationHost) > 1) {
                return $authenticationHost . '/auth/realms/services/protocol/openid-connect' . $this->url;
            } else {
                return $authenticationHost . '/authentication/oauth2' . $this->url;
            }
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
     * @param array $array1
     * @param array $array2
     *
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
     * Set values and check consistence
     *
     * @param array $array
     *
     * @throws MailevaRoutingException
     */
    private function populate(array $array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                # an array -> loop
                switch ($key) {
                    case 'headers':
                        if (!array_search(Routing::REQUIRED, $value)) {
                            $this->headers = $value;
                            break;
                        } else {
                            throw new MailevaRoutingException(array_search(Routing::REQUIRED, $value) . ' not set');
                        }

                    case 'params':
                        if (!array_search(Routing::REQUIRED, $value)) {
                            $this->params = $value;
                            break;
                        } else {
                            throw new MailevaRoutingException(array_search(Routing::REQUIRED, $value) . ' not set');
                        }

                    default:
                        $this->populate($value);
                }
            } else {
                # a value -> set
                if ($value === Routing::REQUIRED) {
                    throw new MailevaRoutingException($key . ' not set');
                }

                switch ($key) {
                    case 'method':
                        $this->method = $value;
                        break;
                    case 'url':
                        $this->url = $value;
                        break;
                    case 'authenticated_route':
                        $this->authenticatedRoute = $value;
                        break;
                    default:
                        break;
                }
            }
        }
    }
}

