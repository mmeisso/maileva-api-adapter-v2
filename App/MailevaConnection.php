<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 21/02/2018
 * Time: 15:31
 */

namespace MailevaApiAdapter\App;

use GuzzleHttp\Client;
use MailevaApiAdapter\App\Client\AuthClient\Api\AuthApi;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Client\AuthClient\Configuration;
use MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse;
use MailevaApiAdapter\App\Core\MemcachedInterface;
use MailevaApiAdapter\App\Core\MemcachedManager;
use MailevaApiAdapter\App\Core\MemcachedStub;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Helpers\ConfigurationHelper;

/**
 * Class MailevaConnection
 *
 * @package MailevaApiAdapter\App
 */
class MailevaConnection
{

    public const CLASSIC = 'classic';
    public const LRE = 'lre';
    public const LRCOPRO = 'lrcopro';
    public const MAILEVA_COPRO = 'mailevaCopro';
    public const COPRO_LIST = [MailevaConnection::MAILEVA_COPRO, MailevaConnection::LRCOPRO];

    const TYPE_LIST = [
        self::CLASSIC,
        self::LRE,
        self::LRCOPRO,
        self::MAILEVA_COPRO
    ];
    public const HOST_ENV_SANDBOX = 'sandbox';
    public const HOST_ENV_PROD = 'production';
    public const HOST_ENV_LIST = [
        self::HOST_ENV_SANDBOX,
        self::HOST_ENV_PROD
    ];

    public const HOST_PROD_IDX = 0;
    public const HOST_SANDBOX_IDX = 1;
    public const TOKEN_PREFIX_V2 = 'MTV2_';
    private string $clientId;
    private string $clientSecret;
    private string $hostEnv;
    private string $memcacheHost;
    private int $memcachePort;
    private string $password;
    private string $type = self::CLASSIC;
    private string $username;
    private string $ftpClientId;
    private string $ftpClientSecret;
    private string $ftpUserName;
    private string $ftpPassword;
    private string $directoryCallback;
    private string $tmpFileDirectory;
    private string $usernameMailevaCopro;
    private string $passwordMailevaCopro;
    private string $accessToken;

    private MemcachedInterface $memcachedManager;

    /**
     * @return void
     */
    public function initMemcachedManager(): void
    {
        if ($this->useMemcache()) {
            $this->memcachedManager = MemcachedManager::getInstance(
                $this->getMemcacheHost(),
                $this->getMemcachePort()
            );
        } else {
            $this->memcachedManager = new MemcachedStub();
        }
    }

    /**
     * @return TokenResponse
     * @throws ApiException
     */
    public function authenticate(): TokenResponse
    {
        $configuration = new Configuration();

        ConfigurationHelper::setHostFromEnvironment($configuration, $this->hostEnv);

        $apiInstance = new AuthApi(new Client(), $configuration);
        $authorization = 'Basic ' . base64_encode(
                "{$this->getClientId()}:{$this->getClientSecret()}"
            );

        # use a special account for MailevaCopro
        if ($this->getType() === self::MAILEVA_COPRO) {
            $username = $this->getUsernameMailevaCopro();
            $password = $this->getUsernameMailevaCopro();
        } else {
            $username = $this->getUsername();
            $password = $this->getPassword();
        }

        return $apiInstance->tokenPost(
            $authorization,
            'password',
            $username,
            $password
        );
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
     *
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
     *
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
    public function getHostEnv(): string
    {
        return $this->hostEnv;
    }

    /**
     * @param string $hostEnv
     *
     * @return MailevaConnection
     * @throws MailevaCoreException
     */
    public function setHostEnv(string $hostEnv): MailevaConnection
    {
        if (!in_array($hostEnv, self::HOST_ENV_LIST)) {
            throw new MailevaCoreException("Host '$hostEnv' is not a valid value");
        }
        $this->hostEnv = $hostEnv;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemcacheHost(): string
    {
        return $this->memcacheHost;
    }

    /**
     * @param $memcacheHost
     *
     * @return MailevaConnection
     */
    public function setMemcacheHost($memcacheHost): MailevaConnection
    {
        $this->memcacheHost = $memcacheHost;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMemcachePort(): ?int
    {
        return $this->memcachePort;
    }

    /**
     * @param $memcachePort
     *
     * @return MailevaConnection
     */
    public function setMemcachePort($memcachePort): MailevaConnection
    {
        $this->memcachePort = $memcachePort;
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
     *
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
    public function getFtpClientId(): string
    {
        return $this->ftpClientId;
    }

    /**
     * @param string $ftpClientId
     * @return MailevaConnection
     */
    public function setFtpClientId(string $ftpClientId): MailevaConnection
    {
        $this->ftpClientId = $ftpClientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFtpClientSecret(): string
    {
        return $this->ftpClientSecret;
    }

    /**
     * @param string $ftpClientSecret
     * @return MailevaConnection
     */
    public function setFtpClientSecret(string $ftpClientSecret): MailevaConnection
    {
        $this->ftpClientSecret = $ftpClientSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getFtpUserName(): string
    {
        return $this->ftpUserName;
    }

    /**
     * @param string $ftpUserName
     * @return MailevaConnection
     */
    public function setFtpUserName(string $ftpUserName): MailevaConnection
    {
        $this->ftpUserName = $ftpUserName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFtpPassword(): string
    {
        return $this->ftpPassword;
    }

    /**
     * @param string $ftpPassword
     * @return MailevaConnection
     */
    public function setFtpPassword(string $ftpPassword): MailevaConnection
    {
        $this->ftpPassword = $ftpPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return MailevaConnection
     * @throws MailevaCoreException
     */
    public function setType(string $type): MailevaConnection
    {
        if (!in_array($type, self::TYPE_LIST)) {
            throw new MailevaCoreException("Type '$type' is not a valid value");
        }
        $this->type = $type;
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
     *
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
    public function getDirectoryCallback(): string
    {
        return $this->directoryCallback;
    }

    /**
     * @param null $directoryRetour
     *
     * @return MailevaConnection
     */
    public function setDirectoryCallback($directoryRetour): MailevaConnection
    {
        $this->directoryCallback = $directoryRetour;
        return $this;
    }

    /**
     * @return null
     */
    public function getTmpFileDirectory(): ?string
    {
        return $this->tmpFileDirectory;
    }

    /**
     * @param null $tmpFileDirectory
     *
     * @return MailevaConnection
     */
    public function setTmpFileDirectory($tmpFileDirectory): MailevaConnection
    {
        $this->tmpFileDirectory = $tmpFileDirectory;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsernameMailevaCopro(): string
    {
        return $this->usernameMailevaCopro;
    }

    /**
     * @param string $usernameMailevaCopro
     * @return MailevaConnection
     */
    public function setUsernameMailevaCopro(string $usernameMailevaCopro): MailevaConnection
    {
        $this->usernameMailevaCopro = $usernameMailevaCopro;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordMailevaCopro(): string
    {
        return $this->passwordMailevaCopro;
    }

    /**
     * @param string $passwordMailevaCopro
     * @return MailevaConnection
     */
    public function setPasswordMailevaCopro(string $passwordMailevaCopro): MailevaConnection
    {
        $this->passwordMailevaCopro = $passwordMailevaCopro;
        return $this;
    }


    /**
     * @return MemcachedInterface
     */
    public function getMemcachedManager(): MemcachedInterface
    {
        return $this->memcachedManager;
    }

    /**
     * @param MemcachedInterface $memcachedManager
     * @return MailevaConnection
     */
    public function setMemcachedManager(MemcachedInterface $memcachedManager): self
    {
        $this->memcachedManager = $memcachedManager;
        return $this;
    }

    /**
     * @return bool
     */
    public function useMemcache(): bool
    {
        return !empty($this->memcacheHost) && !empty($this->memcachePort);
    }

    /**
     * @return bool
     */
    public function isSandboxHost(): bool
    {
        return $this->hostEnv === self::HOST_ENV_SANDBOX;
    }

    /**
     * @return bool
     */
    public function isProdHost(): bool
    {
        return $this->hostEnv === self::HOST_ENV_PROD;
    }

    public function isCopro(): bool
    {
        return in_array($this->getType(), self::COPRO_LIST);
    }

    /**
     * @return bool
     */
    public function requireAuthentication(): bool
    {
        return $this->getType() !== self::LRCOPRO;
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getAccessToken(): string
    {
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }

        $accessToken = $this->memcachedManager->get($this->getMemcachedKeyForAccessToken(), false);
        if (!empty($accessToken)) {
            $this->accessToken = $accessToken;
            return $accessToken;
        }

        $tokenResponse = $this->authenticate();
        $this->setAccessToken($tokenResponse->getAccessToken(), $tokenResponse->getExpiresIn());

        return $tokenResponse->getAccessToken();
    }

    /**
     * @return string
     */
    private function getMemcachedKeyForAccessToken(): string
    {
        return sprintf(
            "%s%s_%s",
            self::TOKEN_PREFIX_V2,
            $this->getClientId(),
            $this->getUsername()
        );
    }

    /**
     * @param string $token
     * @param int $secondsDurationValidity
     */
    private function setAccessToken(string $token, int $secondsDurationValidity): void
    {
        #2592000 max memcache value -> http://php.net/manual/fr/memcache.set.php
        $this->memcachedManager->set(
            $this->getMemcachedKeyForAccessToken(),
            $token,
            min(abs($secondsDurationValidity / 2), 2592000)
        );
        $this->accessToken = $token;
    }

}
