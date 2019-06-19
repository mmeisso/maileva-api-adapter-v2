<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/02/2018
 * Time: 09:42
 */

namespace MailevaApiAdapter\App\Core;

/**
 * Class MailevaResponseLRCOPRO
 *
 * @package MailevaApiAdapter\App\Core
 */
class MailevaResponseLRCOPRO implements MailevaResponseInterface
{

    private $responseAsArray =  [];

    /**
     * @return array
     */
    public function getResponseAsArray(): array
    {
        return $this->responseAsArray;
    }

    /**
     * @param array $responseAsArray
     */
    public function setResponseAsArray(array $responseAsArray)
    {
        $this->responseAsArray = $responseAsArray;
    }
}