<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:52
 */

namespace MailevaApiAdapter\App\Core;

use MailevaApiAdapter\App\Core\Http\Client\Request;
use MailevaApiAdapter\App\Core\Http\Request\Method;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use MailevaApiAdapter\App\Exception\RoutingException;
use MailevaApiAdapter\App\MailevaApiAdapter;

class Route
{


    private $mailevaApiAdapter;
    private $url;
    private $method;
    private $params;
    private $headers;
    private $body;
    private $file;
    private $authenticatedRoute;

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

            if ($this->mailevaApiAdapter->isAuthenticated()) {
                $this->headers['Authorization'] = 'Bearer ' . $this->mailevaApiAdapter->getAccessToken();
            }

            #migrate parameter to url if necessary
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

                if ($key === 'file') {
                    $this->file = $value;
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
                        break;
                    case 'params':
                        $this->params = $value;
                        break;
                }
                $this->populate($value);

            } else {
                # a value -> set
                if ($value === Routing::REQUIRED) {
                    throw new RoutingException($key . ' not set');
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
     * getBody()
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @throws MailevaResponseException
     * @return MailevaResponse
     */
    public function call(): MailevaResponse
    {
        if ($this->isAuthenticatedRoute() && $this->mailevaApiAdapter->isAuthenticated() === false) {
            $this->mailevaApiAdapter->postAuthentication();
        }


        $response = null;
        $provider = Request::getProvider();


        $provider->setOption(CURLOPT_HEADER, false);
        $provider->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $provider->setOption(CURLOPT_SSL_VERIFYHOST, false);
        $provider->setOption(CURLOPT_TIMEOUT, 3600);


        foreach ($this->getHeaders() as $key => $value) {
            $provider->header->set($key, $value);
        }

        switch ($this->getMethod()) {
            case Method::GET:
                $response = $provider->get($this->getUrl(), $this->getParams());
                break;
            case Method::POST:
                $response = $provider->post($this->getUrl(), $this->getParams());
                break;
            case Method::DELETE:
                $response = $provider->delete($this->getUrl(), $this->getParams());
                break;
            case Method::PATCH:
                $response = $provider->patch($this->getUrl(), $this->getParams());
                break;

        }


        return new MailevaResponse($this, $response);
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
     * @return String
     */
    public function getUrl(): String
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }


}

