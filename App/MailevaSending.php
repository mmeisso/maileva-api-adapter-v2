<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Exception\MailevaParameterException;

/**
 * Class MailevaSending
 * @package MailevaApiAdapter\App
 */
class MailevaSending
{

    /**@var String */
    Private $name = null;
    /**@var String */
    Private $postageType = null;
    /**@var Bool */
    Private $colorPrinting = null;
    /**@var Bool */
    Private $duplexPrinting = null;
    /**@var Bool */
    Private $optionalAddressSheet = null;
    /**@var String */
    Private $notificationEmail = '';
    /**@var String */
    Private $file = null;
    /**@var Int */
    Private $filepriority = 1;
    /**@var String */
    Private $filename = null;
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
    /**@var String */
    Private $countryCode = 'FR';
    /**@var String */
    Private $customId = null;


    public function validate()
    {
        $fields = get_object_vars($this);

        foreach ($fields as $key => $value) {
            if (is_null($value)) {
                throw new MailevaParameterException($key . ' not set');
            }

        }


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
    public function getPostageType(): String
    {
        return $this->postageType;
    }

    /**
     * @param String $postageType
     * @return MailevaSending
     * @throws MailevaParameterException
     */
    public function setPostageType(String $postageType): MailevaSending
    {

        if (!in_array(strtoupper($postageType), ['FAST', 'ECONOMIC'])) {
            throw new MailevaParameterException('Postage type should be FAST or ECONOMIC');
        }

        $this->postageType = strtoupper($postageType);
        return $this;
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
     * @return MailevaSending
     */
    public function setOptionalAddressSheet(bool $optionalAddressSheet): MailevaSending
    {
        $this->optionalAddressSheet = $optionalAddressSheet;
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
    public function getFile(): String
    {
        return $this->file;
    }

    /**
     * @param String $file
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
     * @return Int
     */
    public function getFilepriority(): Int
    {
        return $this->filepriority;
    }

    /**
     * @param Int $filepriority
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
    public function getFilename(): String
    {
        return $this->filename;
    }

    /**
     * @param String $filename
     * @return MailevaSending
     */
    public function setFilename(String $filename): MailevaSending
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine1(): String
    {
        return $this->addressLine1;
    }

    /**
     * @param String $addressLine1
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
     * @return MailevaSending
     */
    public function setCustomId(String $customId): MailevaSending
    {
        $this->customId = $customId;
        return $this;
    }

}