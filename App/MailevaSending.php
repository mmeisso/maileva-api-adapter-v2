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

    const POSTAGE_TYPE_ECONOMIC = "ECONOMIC";
    const POSTAGE_TYPE_FAST = "FAST";
    const POSTAGE_TYPE_LRE = "LRE";

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
     * @throws MailevaParameterException
     */
    public function setFile(String $file): MailevaSending
    {
        if (!file_exists($file)) {
            throw new MailevaParameterException($file . 'does not exist');
        }

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

        if (!in_array(strtoupper($postageType), [self::POSTAGE_TYPE_ECONOMIC, self::POSTAGE_TYPE_FAST, self::POSTAGE_TYPE_LRE])) {
            throw new MailevaParameterException('Postage type should be ' . self::POSTAGE_TYPE_ECONOMIC . ', ' . self::POSTAGE_TYPE_FAST. 'or ' . self::POSTAGE_TYPE_LRE);
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
     * @return string
     */
    public function getUID(): String
    {
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

        $getFile = is_null($this->getFile()) ? "fe" : file_exists($this->getFile()) ? md5_file($this->getFile()) : "";

        $key = $postageType . $colorPrinting . $isDuplexPrinting . $isOptionalAddressSheet .
            $getFile .
            $getAddressLine1 . $getAddressLine2 . $getAddressLine3 . $getAddressLine4 . $getAddressLine5 . $getAddressLine6 .
            $getSenderAddressLine1 . $getSenderAddressLine2 . $getSenderAddressLine3 . $getSenderAddressLine4 . $getSenderAddressLine5 . $getSenderAddressLine6;

        return md5($key) . substr(base64_encode($key), 0, 30);
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

        if ($mailevaApiAdapter->getType() !== MailevaConnection::LRE) {
            unset($fields['notificationEmail']);
            unset($fields['senderAddressLine1']);
            unset($fields['senderAddressLine2']);
            unset($fields['senderAddressLine3']);
            unset($fields['senderAddressLine4']);
            unset($fields['senderAddressLine5']);
            unset($fields['senderAddressLine6']);
        } else {
            unset($fields['postageType']);
        }

        foreach ($fields as $key => $value) {
            if (is_null($value)) {
                throw new MailevaParameterException($key . ' not set');
            }
        }

        return $this;
    }
}