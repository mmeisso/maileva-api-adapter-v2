<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 21/02/2018
 * Time: 11:05
 */

namespace MailevaApiAdapter\App\Exception;

use Throwable;

/**
 * Class MailevaParameterException
 *
 * @package MailevaApiAdapter\App\Exception
 */
class MailevaAllReadyExistException extends MailevaException
{

    /** Same mailevaSending has already been sent with sendingId  */
    const ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID = -139;
    /** @var array */
    private $previousMailevaSending;

    /**
     * MailevaAllReadyExistException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($code = 0, $message = '', Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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
