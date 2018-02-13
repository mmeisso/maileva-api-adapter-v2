<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 14:28
 */

namespace MailevaApiAdapter\App\Exception;


class MailevaResponseException extends \Exception
{


    /**
     * MailevaResponseException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        error_log('[' . date('d-M-Y H:m:s') . '] ' . str_replace('\n', ', ', $this->getMessage() . ' ' . $this->getTraceAsString()));
        echo '[' . date('d-M-Y H:m:s') . '] ' . str_replace('\n', ', ', $this->getMessage() . ' ' . $this->getTraceAsString());
    }

}