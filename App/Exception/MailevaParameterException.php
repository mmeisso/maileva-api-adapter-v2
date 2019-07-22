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
class MailevaParameterException extends MailevaException
{

    /** Postage type does not match */
    CONST ERROR_POSTAGE_TYPE_DOES_NOT_MATCH = -138;
    /** A key in the array is not defined */
    CONST ERROR_MAILEVA_KEY_NOT_SET = -137;
    /** Sender adress line 1 or 2 not set */
    CONST ERROR_MAILEVA_SENDERADDRESS_LINE_1_OR_2_NOT_SET = -136;
    /** Sender adress line 6 not set */
    CONST ERROR_MAILEVA_SENDERADDRESS_LINE_6_NOT_SET = -135;
    /** email notification not set */
    CONST ERROR_MAILEVA_NOTIFICATION_EMAIL_NOT_SET = -134;
    /** Adress line 1 or 2 not set */
    CONST ERROR_MAILEVA_ADDRESS_LINE_1_OR_2_NOT_SET = -133;
    /** Adress line 16 not set */
    CONST ERROR_MAILEVA_ADDRESS_LINE_6_NOT_SET = -132;
    /** Wrong email notification */
    CONST ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION = -131;
    /** This file is too long adresse */
    CONST ERROR_MAILEVA_TOO_LONG_ADRESSE = -130;
    /** This file is not found */
    CONST ERROR_MAILEVA_FILE_NOT_FOUND = -129;
    /** This file is too big. */
    CONST ERROR_MAILEVA_FILE_IS_TOO_BIG = -128;

    /**
     * MailevaParameterException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($code = 0, $message = '', \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
