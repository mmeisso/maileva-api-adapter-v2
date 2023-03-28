<?php

namespace MailevaApiAdapter\App;

use GuzzleHttp\Client;
use JsonSerializable;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Client\AuthClient\Configuration;
use MailevaApiAdapter\App\Core\MailevaResponse;

abstract class AbstractClient
{
    protected const MEMCACHE_SIMILAR_DURATION = 60 * 60 * 24 * 7;
    protected MailevaConnection $mailevaConnection;
    protected Client $client;
    /**
     * cannot add type, it doesn't implement interface or extend abstract class
     * @var mixed
     * @see Configuration
     */
    protected $configuration;


    /**
     * @param MailevaConnection $mailevaConnection
     * @throws ApiException
     */
    public function __construct(MailevaConnection $mailevaConnection)
    {
        $this->mailevaConnection = $mailevaConnection;
        $this->client = new Client();

        $mailevaConnection->initMemcachedManager();

        if(!$mailevaConnection->requireAuthentication()) {
            return;
        }

        $newConfiguration = $this->getNewConfiguration();
        if ($newConfiguration) {
            $this->configuration = $newConfiguration;
            $this->configuration->setAccessToken($mailevaConnection->getAccessToken());
            $host = $this->configuration->getHostFromSettings($mailevaConnection->getHostIndex());
            $this->configuration->setHost($host);
        }
    }

    /**
     * return a Configuration depend on inuse client API
     * @return \MailevaApiAdapter\App\Client\MailevaCoproClient\Configuration|mixed
     */
    abstract protected function getNewConfiguration();

    /**
     * @param JsonSerializable $response
     * @return MailevaResponse
     */
    protected function toMailevaResponse(JsonSerializable $response): MailevaResponse
    {
        $jsonSerialize = $response->jsonSerialize();
        $mailevaResponse = new MailevaResponse();
        $mailevaResponse->setResponseAsArray(json_decode(json_encode($jsonSerialize), true));
        return $mailevaResponse;
    }
}
