<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Exception\MailevaParameterException;

/**
 * Class MailevaSending
 *
 * @package MailevaApiAdapter\App
 */
class MailevaSending
{

    const LINE_ADDRESS_MAX_LENGTH = 38;
    const EMAIL_REGEX = '/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
    const POSTAGE_TYPE_ECONOMIC = 'ECONOMIC';
    const POSTAGE_TYPE_FAST = 'FAST';
    const POSTAGE_TYPE_LRE = 'LRE';
    const POSTAGE_TYPE_LRCOPRO = 'LRCOPRO';
    const UID_METHOD_PDFTEXT = 'UID_METHOD_PDFTEXT';
    const UID_METHOD_MD5_FILE = 'UID_METHOD_MD5_FILE';
    const MAX_MB_FILE_MAILEVA = 10000000; #10MO
    /**@var String */
    Private $addressLine1 = null;
    /**@var String */
    Private $addressLine2 = null;
    /**@var String */
    Private $addressLine3 = '';
    /**@var String */
    Private $addressLine4 = '';
    /**@var String */
    Private $addressLine5 = '';
    /**@var String */
    Private $addressLine6 = null;
    /**@var Bool */
    Private $colorPrinting = null;
    /**@var String */
    Private $countryCode = 'FR';
    /**@var String */
    Private $customId = null;
    /**@var Bool */
    Private $duplexPrinting = null;
    /**@var String */
    Private $file = null;
    /**@var String */
    Private $filename = null;
    /**@var Int */
    Private $filepriority = 1;
    /**@var String */
    Private $name = null;
    /**@var String */
    Private $notificationEmail = null;
    /**@var Bool */
    Private $optionalAddressSheet = null;
    /**@var String */
    Private $postageType = null;
    #LRE
    /**@var String */
    Private $senderAddressLine1 = null;
    /**@var String */
    Private $senderAddressLine2 = null;
    /**@var String */
    Private $senderAddressLine3 = '';
    /**@var String */
    Private $senderAddressLine4 = '';
    /**@var String */
    Private $senderAddressLine5 = '';
    /**@var String */
    Private $senderAddressLine6 = null;
    /**@var String */
    Private $senderCountryCode = 'FR';

    /**
     * @return String
     */
    public function getAddressLine1(): String
    {
        return $this->addressLine1;
    }

    /**
     * @param String $addressLine1
     *
     * @return MailevaSending
     */
    public function setAddressLine1(String $addressLine1): MailevaSending
    {
        $this->addressLine1 = $addressLine1;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine2(): String
    {
        return $this->addressLine2;
    }

    /**
     * @param String $addressLine2
     *
     * @return MailevaSending
     */
    public function setAddressLine2(String $addressLine2): MailevaSending
    {
        $this->addressLine2 = $addressLine2;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine3(): String
    {
        return $this->addressLine3;
    }

    /**
     * @param String $addressLine3
     *
     * @return MailevaSending
     */
    public function setAddressLine3(String $addressLine3): MailevaSending
    {
        $this->addressLine3 = $addressLine3;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine4(): String
    {
        return $this->addressLine4;
    }

    /**
     * @param String $addressLine4
     *
     * @return MailevaSending
     */
    public function setAddressLine4(String $addressLine4): MailevaSending
    {
        $this->addressLine4 = $addressLine4;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine5(): String
    {
        return $this->addressLine5;
    }

    /**
     * @param String $addressLine5
     *
     * @return MailevaSending
     */
    public function setAddressLine5(String $addressLine5): MailevaSending
    {
        $this->addressLine5 = $addressLine5;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine6(): String
    {
        return $this->addressLine6;
    }

    /**
     * @param String $addressLine6
     *
     * @return MailevaSending
     */
    public function setAddressLine6(String $addressLine6): MailevaSending
    {
        $this->addressLine6 = $addressLine6;
        return $this;
    }

    /**
     * @return String
     */
    public function getCountryCode(): String
    {
        return $this->countryCode;
    }

    /**
     * @param String $countryCode
     *
     * @return MailevaSending
     */
    public function setCountryCode(String $countryCode): MailevaSending
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return String
     */
    public function getCustomId(): String
    {
        return $this->customId;
    }

    /**
     * @param String $customId
     *
     * @return MailevaSending
     */
    public function setCustomId(String $customId): MailevaSending
    {
        $this->customId = $customId;
        return $this;
    }

    /**
     * @return String
     */
    public function getFile(): String
    {
        return $this->file;
    }

    /**
     * @param String $file
     *
     * @return MailevaSending
     */
    public function setFile(String $file): MailevaSending
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return String
     */
    public function getFilename(): String
    {
        return $this->filename;
    }

    /**
     * @param String $filename
     *
     * @return MailevaSending
     */
    public function setFilename(String $filename): MailevaSending
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return Int
     */
    public function getFilepriority(): Int
    {
        return $this->filepriority;
    }

    /**
     * @param Int $filepriority
     *
     * @return MailevaSending
     */
    public function setFilepriority(Int $filepriority): MailevaSending
    {
        $this->filepriority = $filepriority;
        return $this;
    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @param String $name
     *
     * @return MailevaSending
     */
    public function setName(String $name): MailevaSending
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return String
     */
    public function getNotificationEmail(): String
    {
        return $this->notificationEmail;
    }

    /**
     * @param String $notificationEmail
     *
     * @return MailevaSending
     */
    public function setNotificationEmail(String $notificationEmail): MailevaSending
    {
        $this->notificationEmail = $notificationEmail;
        return $this;
    }

    /**
     * @return String
     */
    public function getPostageType()
    {
        return $this->postageType;
    }

    /**
     * @param String $postageType
     *
     * @return MailevaSending
     * @throws MailevaParameterException
     */
    public function setPostageType(String $postageType): MailevaSending
    {

        if (!in_array(strtoupper($postageType),
            [self::POSTAGE_TYPE_ECONOMIC, self::POSTAGE_TYPE_FAST, self::POSTAGE_TYPE_LRE, self::POSTAGE_TYPE_LRCOPRO])) {
            throw new MailevaParameterException(MailevaParameterException::ERROR_POSTAGE_TYPE_DOES_NOT_MATCH,'Postage type should be ' . self::POSTAGE_TYPE_ECONOMIC . ', ' . self::POSTAGE_TYPE_FAST . 'or ' . self::POSTAGE_TYPE_LRE . 'or ' . self::POSTAGE_TYPE_LRCOPRO);
        }

        $this->postageType = strtoupper($postageType);
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine1()
    {
        return $this->senderAddressLine1;
    }

    /**
     * @param String $senderAddressLine1
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine1(String $senderAddressLine1): MailevaSending
    {
        $this->senderAddressLine1 = $senderAddressLine1;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine2()
    {
        return $this->senderAddressLine2;
    }

    /**
     * @param String $senderAddressLine2
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine2(String $senderAddressLine2): MailevaSending
    {
        $this->senderAddressLine2 = $senderAddressLine2;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine3()
    {
        return $this->senderAddressLine3;
    }

    /**
     * @param String $senderAddressLine3
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine3(String $senderAddressLine3): MailevaSending
    {
        $this->senderAddressLine3 = $senderAddressLine3;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine4()
    {
        return $this->senderAddressLine4;
    }

    /**
     * @param String $senderAddressLine4
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine4(String $senderAddressLine4): MailevaSending
    {
        $this->senderAddressLine4 = $senderAddressLine4;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine5()
    {
        return $this->senderAddressLine5;
    }

    /**
     * @param String $senderAddressLine5
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine5(String $senderAddressLine5): MailevaSending
    {
        $this->senderAddressLine5 = $senderAddressLine5;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine6()
    {
        return $this->senderAddressLine6;
    }

    /**
     * @param String $senderAddressLine6
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine6(String $senderAddressLine6): MailevaSending
    {
        $this->senderAddressLine6 = $senderAddressLine6;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderCountryCode(): String
    {
        return $this->senderCountryCode;
    }

    /**
     * @param String $senderCountryCode
     *
     * @return MailevaSending
     */
    public function setSenderCountryCode(String $senderCountryCode): MailevaSending
    {
        $this->senderCountryCode = $senderCountryCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getUID(): array
    {
        $method                 = null;
        $postageType            = is_null($this->getPostageType()) ? "pe" : $this->getPostageType();
        $colorPrinting          = is_null($this->isColorPrinting()) ? "cg" : (String)$this->isColorPrinting();
        $isDuplexPrinting       = is_null($this->isDuplexPrinting()) ? "dg" : (String)$this->isDuplexPrinting();
        $isOptionalAddressSheet = is_null($this->isOptionalAddressSheet()) ? "ot" : (String)$this->isOptionalAddressSheet();

        $getAddressLine1 = is_null($this->getAddressLine1()) ? "a1" : $this->getAddressLine1();
        $getAddressLine2 = is_null($this->getAddressLine2()) ? "a2" : $this->getAddressLine2();
        $getAddressLine3 = is_null($this->getAddressLine3()) ? "a3" : $this->getAddressLine3();
        $getAddressLine4 = is_null($this->getAddressLine4()) ? "a4" : $this->getAddressLine4();
        $getAddressLine5 = is_null($this->getAddressLine5()) ? "a5" : $this->getAddressLine5();
        $getAddressLine6 = is_null($this->getAddressLine6()) ? "a6" : $this->getAddressLine6();

        $getSenderAddressLine1 = is_null($this->getSenderAddressLine1()) ? "s1" : $this->getSenderAddressLine1();
        $getSenderAddressLine2 = is_null($this->getSenderAddressLine2()) ? "s2" : $this->getSenderAddressLine2();
        $getSenderAddressLine3 = is_null($this->getSenderAddressLine3()) ? "s3" : $this->getSenderAddressLine3();
        $getSenderAddressLine4 = is_null($this->getSenderAddressLine4()) ? "s4" : $this->getSenderAddressLine4();
        $getSenderAddressLine5 = is_null($this->getSenderAddressLine5()) ? "s5" : $this->getSenderAddressLine5();
        $getSenderAddressLine6 = is_null($this->getSenderAddressLine6()) ? "s6" : $this->getSenderAddressLine6();

        $pdfText = '';

        try {
            $tmp     = tempnam("/tmp", uniqid("", true));
            $command = 'pdftotext ' . $this->getFile() . ' ' . $tmp;
            exec($command);
            $pdfText = preg_replace('/\s+/', '', file_get_contents($tmp));
            @unlink($tmp);
        } catch (\Throwable $t) {
            error_log($t);
        }

        if (strlen($pdfText) > 30) {
            $getFile = md5(preg_replace('/\s+/', '', $pdfText));
            $method  = self::UID_METHOD_PDFTEXT;
        } else {
            $getFile = md5_file($this->getFile());
            $method  = self::UID_METHOD_MD5_FILE;
        }

        $key = $postageType . $colorPrinting . $isDuplexPrinting . $isOptionalAddressSheet .
            $getFile .
            $getAddressLine1 . $getAddressLine2 . $getAddressLine3 . $getAddressLine4 . $getAddressLine5 . $getAddressLine6 .
            $getSenderAddressLine1 . $getSenderAddressLine2 . $getSenderAddressLine3 . $getSenderAddressLine4 . $getSenderAddressLine5 . $getSenderAddressLine6;

        return [md5($key) . substr(base64_encode($key), 0, 30), $method];
    }

    /**
     * @return bool
     */
    public function isColorPrinting(): bool
    {
        return $this->colorPrinting;
    }

    /**
     * @param bool $colorPrinting
     *
     * @return MailevaSending
     */
    public function setColorPrinting(bool $colorPrinting): MailevaSending
    {
        $this->colorPrinting = $colorPrinting;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDuplexPrinting(): bool
    {
        return $this->duplexPrinting;
    }

    /**
     * @param bool $duplexPrinting
     *
     * @return MailevaSending
     */
    public function setDuplexPrinting(bool $duplexPrinting): MailevaSending
    {
        $this->duplexPrinting = $duplexPrinting;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOptionalAddressSheet(): bool
    {
        return $this->optionalAddressSheet;
    }

    /**
     * @param bool $optionalAddressSheet
     *
     * @return MailevaSending
     */
    public function setOptionalAddressSheet(bool $optionalAddressSheet): MailevaSending
    {
        $this->optionalAddressSheet = $optionalAddressSheet;
        return $this;
    }

    /**
     * @param MailevaApiAdapter $mailevaApiAdapter
     *
     * @return $this
     * @throws MailevaParameterException
     */
    public function validate(MailevaApiAdapter $mailevaApiAdapter)
    {
        $fields = get_object_vars($this);

        if (in_array($mailevaApiAdapter->getType(), [MailevaConnection::LRE, MailevaConnection::LRCOPRO])) {
            if (empty($fields['senderAddressLine1']) && empty($fields['senderAddressLine2'])) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_1_OR_2_NOT_SET,'senderAddressLine1 || senderAddressLine2 not set');
            }

            if (empty($fields['senderAddressLine6'])) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_6_NOT_SET,
                    'senderAddressLine6 not set');
            }

            if (empty($fields['notificationEmail'])) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_NOTIFICATION_EMAIL_NOT_SET, 'notificationEmail not set');
            }
        }

        if (empty($fields['addressLine1']) && empty($fields['addressLine2'])) {
            throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_1_OR_2_NOT_SET,
                'addressLine1 || addressLine2 not set');
        }

        if (empty($fields['addressLine6'])) {
            throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_6_NOT_SET, 'addressLine6 not set');
        }

        if (!empty($fields['notificationEmail'])) {
            if (!preg_match(self::EMAIL_REGEX, $fields['notificationEmail'])) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION,
                    'Wrong email syntax on notificationEmail parameter');
            }
        }

        foreach ($fields as $key => $value) {
            if (stripos($key, 'addressLine') !== false) {
                if (mb_strlen($value) > self::LINE_ADDRESS_MAX_LENGTH) {
                    throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_TOO_LONG_ADRESSE,
                        'too long address on ' . $key . ' : ' . $value);
                }
            }
        }

        #already checked
        unset($fields['addressLine1']);
        unset($fields['addressLine2']);
        unset($fields['addressLine6']);
        unset($fields['senderAddressLine1']);
        unset($fields['senderAddressLine2']);
        unset($fields['senderAddressLine6']);
        unset($fields['notificationEmail']);

        foreach ($fields as $key => $value) {
            if (is_null($value)) {
                throw new MailevaParameterException($key . ' not set');
            }

            if ($key === 'file') {
                if (!file_exists($value)) {
                    throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_FILE_NOT_FOUND, 'file ' . $value . ' not found');
                }
                if (!in_array($mailevaApiAdapter->getType(), [MailevaConnection::LRCOPRO])) {
                    if (filesize($value) >= self::MAX_MB_FILE_MAILEVA) {
                        throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_FILE_IS_TOO_BIG,
                            'The file is too big :' . $value . ' the maximum is ' . self::MAX_MB_FILE_MAILEVA . ' MB');

                    }
                }

            }
        }

        return $this;
    }

    public function toString()
    {
        $var = get_object_vars($this);
        foreach ($var as $key => &$value) {
            if (is_null($value)) {
                unset($var[$key]);
            }
            if (is_object($value) && method_exists($value, 'getJsonData')) {
                $value = $value->getJsonData();
            }
        }
        return var_export($var, true);
    }
}
