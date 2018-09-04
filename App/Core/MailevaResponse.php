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

/**
 * Class MailevaResponse
 *
 * @package MailevaApiAdapter\App\Core
 */
class MailevaResponse
{

    private $route;
    private $responseAsArray = null;

    /**
     * MailevaResponse constructor.
     *
     * @param Route    $route
     * @param Response $response
     *
     * @throws MailevaResponseException
     */
    public function __construct(Route $route, Response $response)
    {
        $this->route = $route;

        $this->checkValidityResponse($route, $response);
        $this->registerAuthentication();
    }

    /**
     * @param Route    $route
     * @param Response $response
     *
     * @throws MailevaResponseException
     * @throws \MailevaApiAdapter\App\Exception\MailevaException
     */
    private function checkValidityResponse(Route $route, Response $response)
    {


        $statusCode = $response->getStatusCode();
        $body       = $response->getBody()->getContents();
        $headers    = $response->getHeaders();

        if ($statusCode > 300) {
            throw new MailevaResponseException('Wrong statusCode ' . $statusCode . ' on ' . $this->route->getUrl() . ' method ' . $this->route->getMethod() . ' body ' . $body);
        }

        #201, 204 no data...
        if ($statusCode !== 201 && $statusCode !== 204) {

            if (strlen(trim($body)) > 0) {
                if (is_null($route->getSink()) === false) {
                    $this->responseAsArray = [
                        'localFilePath' => $route->getSink()
                    ];
                } else {
                    $json = json_decode($body, true);
                    if (is_null($json)) {
                        throw new MailevaResponseException('Response is not Json compliant ' . $statusCode . ' on ' . $this->route->getUrl() . ' method ' . $this->route->getMethod() . ' body ' . $body);
                    }

                    $this->responseAsArray = json_decode($body, true);


                    if (array_key_exists(MailevaLREStatuses::DELIVERY_STATUSES, $this->responseAsArray)) {
                        if (count($this->responseAsArray[MailevaLREStatuses::DELIVERY_STATUSES]) > 0){
                            $mailevaLREStatuses    = new MailevaLREStatuses();
                            $mailevaLREStatuses->setStatuses($this->responseAsArray[MailevaLREStatuses::DELIVERY_STATUSES]);
                            $this->responseAsArray[MailevaLREStatuses::DELIVERY_STATUSES] = $mailevaLREStatuses;
                        } else {
                            unset($this->responseAsArray[MailevaLREStatuses::DELIVERY_STATUSES]);
                        }
                    }
                }
            }
        } else {
            if ($statusCode === 201) {
                if (array_key_exists('Location', $headers) && count($headers['Location']) > 0) {
                    $asArray               = explode('/', $headers['Location'][0]);
                    $this->responseAsArray = [
                        'sendingId' => $asArray[count($asArray) - 1]
                    ];
                }
            }
        }

        try {
            $this->responseAsArray['method']            = $this->route->getMethod();
            $this->responseAsArray['url']               = $this->route->getUrl();
            $this->responseAsArray['requestParameters'] = $this->route->getRequestParameters();
        } catch (\Throwable $e) {
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