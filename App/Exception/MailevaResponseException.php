<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 14:28
 */

namespace MailevaApiAdapter\App\Exception;

/**
 * Class MailevaResponseException
 *
 * @package MailevaApiAdapter\App\Exception
 */
class MailevaResponseException extends MailevaException
{

    /**
     * @return bool
     */
    protected function isLogEnable(): bool
    {
        return true;
    }
}
