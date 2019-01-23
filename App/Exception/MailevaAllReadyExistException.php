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

    /**
     * @var array
     */
    private $previousMailevaSending;

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