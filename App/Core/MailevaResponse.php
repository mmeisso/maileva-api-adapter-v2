<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/02/2018
 * Time: 09:42
 */

namespace MailevaApiAdapter\App\Core;

/**
 * Class MailevaResponse
 *
 * @package MailevaApiAdapter\App\Core
 */
class MailevaResponse implements MailevaResponseInterface
{

    private array $responseAsArray = [];

    /**
     * MailevaResponse constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getResponseAsArray(): array
    {
        return $this->responseAsArray;
    }

    /**
     * @param array $responseAsArray
     */
    public function setResponseAsArray(array $responseAsArray): void
    {
        $this->responseAsArray = $responseAsArray;
    }

}
