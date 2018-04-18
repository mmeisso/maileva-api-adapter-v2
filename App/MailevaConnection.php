<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 21/02/2018
 * Time: 15:31
 */

namespace MailevaApiAdapter\App;

/**
 * Class MailevaConnection
 * @package MailevaApiAdapter\App
 */
class MailevaConnection
{
    private $authenticationHost;
    private $host;
    private $clientId = null;
    private $clientSecret = null;
    private $username = null;
    private $password = null;
    private $memcacheHost = null;
    private $memcachePort = null;

    public function __construct()
    {
    }

    /**
     * @param string $host
     * @return MailevaConnection
     */
    public function setHost(string $host): MailevaConnection
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $authenticationHost
     * @return MailevaConnection
     */
    public function setAuthenticationHost(string $authenticationHost): MailevaConnection
    {
        $this->authenticationHost = $authenticationHost;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthenticationHost(): string
    {
        return $this->authenticationHost;
    }


    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return MailevaConnection
     */
    public function setClientId(string $clientId): MailevaConnection
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return MailevaConnection
     */
    public function setClientSecret(string $clientSecret): MailevaConnection
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return MailevaConnection
     */
    public function setUsername(string $username): MailevaConnection
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return MailevaConnection
     */
    public function setPassword(string $password): MailevaConnection
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemcacheHost()
    {
        return $this->memcacheHost;
    }

    /**
     * @param string $memcacheHost
     * @return MailevaConnection
     */
    public function setMemcacheHost(string $memcacheHost): MailevaConnection
    {
        $this->memcacheHost = $memcacheHost;
        return $this;
    }

    /**
     * @return bool
     */
    public function useMemcache(): bool
    {
        return empty($this->getMemcacheHost()) === false && empty($this->getMemcachePort()) === false;
    }

    /**
     * @return int
     */
    public function getMemcachePort()
    {
        return $this->memcachePort;
    }

    /**
     * @param int $memcachePort
     * @return MailevaConnection
     */
    public function setMemcachePort(int $memcachePort): MailevaConnection
    {
        $this->memcachePort = $memcachePort;
        return $this;
    }


}