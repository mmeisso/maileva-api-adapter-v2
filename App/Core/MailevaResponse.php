<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/02/2018
 * Time: 09:42
 */

namespace MailevaApiAdapter\App\Core;


use MailevaApiAdapter\App\Core\Http\Client\Header;
use MailevaApiAdapter\App\Core\Http\Client\Response;
use MailevaApiAdapter\App\Exception\MailevaResponseException;

class MailevaResponse
{

    private $route;
    private $responseAsJson = null;

    /**
     * MailevaResponse constructor.
     * @param Route $route
     * @param Response $response
     * @throws MailevaResponseException
     */
    public function __construct(Route $route, Response $response)
    {
        $this->route = $route;
        $this->checkValidityResponse($response->header, $response->body);
        $this->registerAuthentication();
    }

    /**
     * checkValidityResponse
     * @param Header $header
     * @param string $body
     * @throws MailevaResponseException
     */
    private function checkValidityResponse(Header $header, string $body)
    {

        if ($header->statusCode !== 200) {
            throw new MailevaResponseException('Wrong statusCode ' . $header->statusCode);
        }


        if ($header->statusMessage !== 'OK') {
            throw new MailevaResponseException('Wrong statusMessage ' . $header->statusMessage);
        }

        $json = json_decode($body, true);

        if (is_null($json)) {
            throw new MailevaResponseException('Response is not Json compliant ' . $header->statusMessage);
        }

        $this->responseAsJson = json_decode($body, true);

    }

    private function registerAuthentication()
    {
        if (isset($this->responseAsJson['access_token']) && isset($this->responseAsJson['expires_in'])) {
            $this->route->getMailevaApiAdapter()->setAccessToken($this->responseAsJson['access_token'], $this->responseAsJson['expires_in']);
        }
    }

    /**
     * @return mixed
     */
    public function getResponseAsJson()
    {
        return $this->responseAsJson;
    }


}