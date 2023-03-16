<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 21/02/2018
 * Time: 11:05
 */

namespace MailevaApiAdapter\App\Exception;

use Exception;
use Throwable;

/**
 * Class MailevaException
 *
 * @package MailevaApiAdapter\App\Exception
 */
abstract class MailevaException extends Exception
{

    /**
     * MailevaException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if ($this->isLogEnable()){
            error_log('[' . date('d-M-Y H:m:s') . '] ' . str_replace('\n', ', ', $this->getMessage() . ' ' . $this->getTraceAsString()));
        }

        //echo '[' . date('d-M-Y H:m:s') . '] ' . str_replace('\n', ', ', $this->getMessage() . ' ' . $this->getTraceAsString());
    }

    /**
     * @return bool
     */
    abstract protected function isLogEnable():bool;
}
