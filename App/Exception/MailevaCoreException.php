<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 14:28
 */

namespace MailevaApiAdapter\App\Exception;

/**
 * Class MailevaCoreException
 *
 * @package MailevaApiAdapter\App\Exception
 */
class MailevaCoreException extends MailevaException
{

    /**
     * @return bool
     */
    protected function isLogEnable(): bool
    {
        return true;
    }
}
