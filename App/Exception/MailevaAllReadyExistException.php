<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 21/02/2018
 * Time: 11:05
 */

namespace MailevaApiAdapter\App\Exception;

/**
 * Class MailevaParameterException
 *
 * @package MailevaApiAdapter\App\Exception
 */
class MailevaAllReadyExistException extends MailevaException
{

    /** @var Integer */
    private $errorCode;

    /**
     * MailevaAllReadyExistException constructor.
     *
     * @param                 $errorCode
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($errorCode, $message = '', $code = 0, \Throwable $previous = null)
    {
        $this->errorCode = $errorCode;
        parent::__construct($message, $code, $previous);

    }

    /** Same mailevaSending has already been sent with sendingId  */
    CONST ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID = -139;
    /** Same mailevaSending has already been sent with sendingId  */
    CONST ERROR_SAME_MAILEVASENDING_THE_LRCOPRO_HAS_ALREADY_BEEN_SENT= -140;

    /**
     * @var array
     */
    private $previousMailevaSending;

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return array
     */
    public function getPreviousMailevaSending(): array
    {
        return $this->previousMailevaSending;
    }

    /**
     * @param array $previousMailevaSendingAsArray
     */
    public function setPreviousMailevaSending(array $previousMailevaSendingAsArray)
    {
        $this->previousMailevaSending = $previousMailevaSendingAsArray;
    }

}