<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/02/2018
 * Time: 09:42
 */

namespace MailevaApiAdapter\App\Core;

use GuzzleHttp\Psr7\Response;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use MailevaApiAdapter\App\Exception\RoutingException;

/**
 * Class MailevaResponse
 * @package MailevaApiAdapter\App\Core
 */
class MailevaResponse
{

    private $route;
    private $responseAsArray = null;

    /**
     * MailevaResponse constructor.
     * @param Route $route
     * @param Response $response
     * @throws MailevaResponseException
     */
    public function __construct(Route $route, Response $response)
    {
        $this->route = $route;

        $this->checkValidityResponse($response->getStatusCode(), $response->getBody()->getContents(), $response->getHeaders());
        $this->registerAuthentication();
    }

    /**
     * @param int $statusCode
     * @param string $body
     * @param array $headers
     * @throws MailevaResponseException
     */
    private function checkValidityResponse(int $statusCode, string $body, array $headers)
    {

        if ($statusCode > 300) {
            throw new MailevaResponseException('Wrong statusCode ' . $statusCode . ' on ' . $this->route->getUrl() . ' method ' . $this->route->getMethod() . ' body ' . $body);
        }

        #201, 204 no data...
        if ($statusCode !== 201 && $statusCode !== 204) {

            if (strlen(trim($body)) > 0) {
                $json = json_decode($body, true);
                if (is_null($json)) {
                    throw new MailevaResponseException('Response is not Json compliant ' . $statusCode . ' on ' . $this->route->getUrl() . ' method ' . $this->route->getMethod() . ' body ' . $body);
                }

                $this->responseAsArray = json_decode($body, true);
            }
        } else {
            if ($statusCode === 201) {
                if (array_key_exists('Location', $headers) && count($headers['Location']) > 0) {
                    $asArray = explode('/', $headers['Location'][0]);
                    $this->responseAsArray = [
                        'sendingId' => $asArray[count($asArray) - 1]
                    ];
                }
            }
        }


        try {
            $this->responseAsArray['method'] = $this->route->getMethod();
            $this->responseAsArray['url'] = $this->route->getUrl();
            $this->responseAsArray['requestParameters']  = $this->route->getRequestParameters();
        } catch (RoutingException $e) {
        }



    }

    private function registerAuthentication()
    {
        if (isset($this->responseAsArray['access_token']) && isset($this->responseAsArray['expires_in'])) {
            $this->route->getMailevaApiAdapter()->setAccessToken($this->responseAsArray['access_token'], $this->responseAsArray['expires_in']);
        }
    }

    /**
     * @return mixed
     */
    public function getResponseAsArray()
    {
        return $this->responseAsArray;
    }


}