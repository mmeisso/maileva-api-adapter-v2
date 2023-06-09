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
class MailevaParameterException extends MailevaException
{

    /** Status NPD detected */
    const ERROR_MAILEVA_NPD_DETECTED = -147;
    /** email notification not set */
    const ERROR_MAILEVA_NOTIFICATION_TREAT_UNDELIVERED_MAIL_NOT_SET = -146;
    /** too much documents */
    CONST ERROR_MAILEVA_ECONOMIC_MAX_DOCUMENT_EXCEEDED = -141;
    /** max page exceeded */
    CONST ERROR_MAILEVA_ECONOMIC_MAX_PAGE_EXCEEDED = -140;
    /** Field not set */
    CONST ERROR_FIELD_NOT_SET = -139;
    /** Postage type does not match */
    const ERROR_POSTAGE_TYPE_DOES_NOT_MATCH = -138;
    /** A key in the array is not defined */
    const ERROR_MAILEVA_KEY_NOT_SET = -137;
    /** Sender adress line 1 or 2 not set */
    const ERROR_MAILEVA_SENDERADDRESS_LINE_1_OR_2_NOT_SET = -136;
    /** Sender adress line 6 not set */
    const ERROR_MAILEVA_SENDERADDRESS_LINE_6_NOT_SET = -135;
    /** email notification not set */
    const ERROR_MAILEVA_NOTIFICATION_EMAIL_NOT_SET = -134;
    /** Adress line 1 or 2 not set */
    const ERROR_MAILEVA_ADDRESS_LINE_1_OR_2_NOT_SET = -133;
    /** Adress line 16 not set */
    const ERROR_MAILEVA_ADDRESS_LINE_6_NOT_SET = -132;
    /** Wrong email notification */
    const ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION = -131;
    /** This file is too long adresse */
    const ERROR_MAILEVA_TOO_LONG_ADRESSE = -130;
    /** This file is not found */
    const ERROR_MAILEVA_FILE_NOT_FOUND = -129;
    /** This file is too big. */
    const ERROR_MAILEVA_FILE_IS_TOO_BIG = -128;

    /**
     * MailevaParameterException constructor.
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
     * @return bool
     */
    protected function isLogEnable(): bool
    {
        return true;
    }
}
