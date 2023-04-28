<?php

namespace MailevaApiAdapter\App\Helpers;

use MailevaApiAdapter\App\Exception\MailevaCoreException;

class ConfigurationHelper
{
    /**
     * @throws MailevaCoreException
     */
    static public function getHostFromEnvironment($configuration, string $env): string
    {
        /** @var [['url' => string, 'description' => 'Sandbox'|'Production']] $hosts */
        $hosts = $configuration->getHostSettings();

        foreach ($hosts as $host) {
            if (strtolower($host['description']) === strtolower($env)) {
                return $host['url'];
            }
        }
        throw new MailevaCoreException('Unknown environment ' . $env);
    }

    /**
     * @throws MailevaCoreException
     */
    static public function setHostFromEnvironment($configuration, string $env): void
    {
        $host = self::getHostFromEnvironment($configuration, $env);
        $configuration->setHost($host);
    }
}