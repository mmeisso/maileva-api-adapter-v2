<?php

namespace MailevaApiAdapter\App;

use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use Throwable;

/**
 * Class MailevaSending
 *
 * @package MailevaApiAdapter\App
 */
class MailevaSending
{
    public const LINE_ADDRESS_MAX_LENGTH = 38;
    public const EMAIL_REGEX = '/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
    public const POSTAGE_TYPE_ECONOMIC = 'ECONOMIC';
    public const POSTAGE_TYPE_FAST = 'FAST';
    public const POSTAGE_TYPE_LRE = 'LRE';
    public const POSTAGE_TYPE_LRCOPRO = 'LRCOPRO';
    public const POSTAGE_TYPE_MAILEVA_COPRO = 'MAILEVA_COPRO';
    public const POSTAGE_TYPE_LISTE = [
        self::POSTAGE_TYPE_ECONOMIC,
        self::POSTAGE_TYPE_FAST,
        self::POSTAGE_TYPE_LRE,
        self::POSTAGE_TYPE_LRCOPRO,
        self::POSTAGE_TYPE_MAILEVA_COPRO,
    ];
    public const POSTAGE_TYPE_COPRO_LISTE = [
        self::POSTAGE_TYPE_LRCOPRO,
        self::POSTAGE_TYPE_MAILEVA_COPRO,
    ];

    public const UID_METHOD_PDFTEXT = 'UID_METHOD_PDFTEXT';
    public const UID_METHOD_MD5_FILE = 'UID_METHOD_MD5_FILE';
    public const MAX_MB_FILE_MAILEVA = 20971520; #20MO
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private string $addressLine3 = '';
    private string $addressLine4 = '';
    private string $addressLine5 = '';
    private ?string $addressLine6 = null;
    private ?bool $colorPrinting = null;
    private string $countryCode = 'FR';
    private ?string $customId = null;
    private ?bool $duplexPrinting = null;
    private ?string $file = null;
    private ?string $filename = null;
    private int $filepriority = 1;
    private ?string $name = null;
    private ?int $nbPage = null;
    private ?string $notificationEmail = null;
    private ?string $notificationTreatUndeliveredMail = null;
    private ?bool $optionalAddressSheet = null;
    #LRE
    private ?string $postageType = null;
    private ?string $senderAddressLine1 = null;
    private ?string $senderAddressLine2 = null;
    private string $senderAddressLine3 = '';
    private string $senderAddressLine4 = '';
    private string $senderAddressLine5 = '';
    private ?string $senderAddressLine6 = null;
    private string $senderCountryCode = 'FR';
    private ?bool $treatUndeliveredMail = null;

    /**
     * @return String
     */
    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @param String $addressLine1
     *
     * @return MailevaSending
     */
    public function setAddressLine1(string $addressLine1): MailevaSending
    {
        $this->addressLine1 = $addressLine1;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    /**
     * @param String $addressLine2
     *
     * @return MailevaSending
     */
    public function setAddressLine2(string $addressLine2): MailevaSending
    {
        $this->addressLine2 = $addressLine2;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine3(): string
    {
        return $this->addressLine3;
    }

    /**
     * @param String $addressLine3
     *
     * @return MailevaSending
     */
    public function setAddressLine3(string $addressLine3): MailevaSending
    {
        $this->addressLine3 = $addressLine3;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine4(): string
    {
        return $this->addressLine4;
    }

    /**
     * @param String $addressLine4
     *
     * @return MailevaSending
     */
    public function setAddressLine4(string $addressLine4): MailevaSending
    {
        $this->addressLine4 = $addressLine4;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine5(): string
    {
        return $this->addressLine5;
    }

    /**
     * @param String $addressLine5
     *
     * @return MailevaSending
     */
    public function setAddressLine5(string $addressLine5): MailevaSending
    {
        $this->addressLine5 = $addressLine5;
        return $this;
    }

    /**
     * @return String
     */
    public function getAddressLine6(): string
    {
        return $this->addressLine6;
    }

    /**
     * @param String $addressLine6
     *
     * @return MailevaSending
     */
    public function setAddressLine6(string $addressLine6): MailevaSending
    {
        $this->addressLine6 = $addressLine6;
        return $this;
    }

    /**
     * @return String
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param String $countryCode
     *
     * @return MailevaSending
     */
    public function setCountryCode(string $countryCode): MailevaSending
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return String
     */
    public function getCustomId(): string
    {
        return $this->customId;
    }

    /**
     * @param String $customId
     *
     * @return MailevaSending
     */
    public function setCustomId(string $customId): MailevaSending
    {
        $this->customId = $customId;
        return $this;
    }

    /**
     * @return String
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param String $file
     *
     * @return MailevaSending
     */
    public function setFile(string $file): MailevaSending
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return String
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param String $filename
     *
     * @return MailevaSending
     */
    public function setFilename(string $filename): MailevaSending
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return Int
     */
    public function getFilepriority(): int
    {
        return $this->filepriority;
    }

    /**
     * @param Int $filepriority
     *
     * @return MailevaSending
     */
    public function setFilepriority(int $filepriority): MailevaSending
    {
        $this->filepriority = $filepriority;
        return $this;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param String $name
     *
     * @return MailevaSending
     */
    public function setName(string $name): MailevaSending
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     * @throws MailevaCoreException
     */
    public function getNbPage(): int
    {
        if (false === is_null($this->nbPage)) {
            return $this->nbPage;
        }

        $this->nbPage = 0;
        $commandList  = [
            "pdfinfo " . escapeshellarg($this->getFile()) . " 2>/dev/null | grep Pages | awk '{print $2}'",
            'pdftk ' . escapeshellarg($this->getFile()) . " dump_data | sed '/NumberOfPages/!d;s/[^0-9]*//'",
            'echo $(strings < ' . escapeshellarg($this->getFile()) . ' | sed -n \'s|.*/Count -\{0,1\}\([0-9]\{1,\}\).*|\1|p\' | sort -rn | head -n 1)'
        ];

        foreach ($commandList as $command) {
            $output = [];
            exec($command, $output, $result);
            if (isset($output[0]) && (int)$output[0] > 0) {
                $this->nbPage = (int)$output[0];
                break;
            }
        }
        if ($this->nbPage === 0) {
            throw new MailevaCoreException('Impossible to get page number from ' . $this->getFile());
        }

        return $this->nbPage;
    }

    /**
     * @return String
     */
    public function getNotificationEmail(): string
    {
        return $this->notificationEmail;
    }

    /**
     * @param String $notificationEmail
     *
     * @return MailevaSending
     */
    public function setNotificationEmail(string $notificationEmail): MailevaSending
    {
        $this->notificationEmail = $notificationEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotificationTreatUndeliveredMail(): ?string
    {
        return $this->notificationTreatUndeliveredMail;
    }

    /**
     * @param String $notificationTreatUndeliveredMail
     *
     * @return MailevaSending
     */
    public function setNotificationTreatUndeliveredMail(string $notificationTreatUndeliveredMail): MailevaSending
    {
        $this->notificationTreatUndeliveredMail = $notificationTreatUndeliveredMail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostageType(): ?string
    {
        return $this->postageType;
    }

    /**
     * @param String $postageType
     *
     * @return MailevaSending
     * @throws MailevaParameterException
     */
    public function setPostageType(string $postageType): MailevaSending
    {
        $this->postageType = strtoupper($postageType);

        if (!in_array($this->postageType, self::POSTAGE_TYPE_LISTE)) {
            throw new MailevaParameterException(
                MailevaParameterException::ERROR_POSTAGE_TYPE_DOES_NOT_MATCH,
                'Postage type should be one of theses values'. implode('; ',self::POSTAGE_TYPE_LISTE)
            );
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSenderAddressLine1(): ?string
    {
        return $this->senderAddressLine1;
    }

    /**
     * @param String $senderAddressLine1
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine1(string $senderAddressLine1): MailevaSending
    {
        $this->senderAddressLine1 = $senderAddressLine1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSenderAddressLine2(): ?string
    {
        return $this->senderAddressLine2;
    }

    /**
     * @param String $senderAddressLine2
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine2(string $senderAddressLine2): MailevaSending
    {
        $this->senderAddressLine2 = $senderAddressLine2;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine3(): string
    {
        return $this->senderAddressLine3;
    }

    /**
     * @param String $senderAddressLine3
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine3(string $senderAddressLine3): MailevaSending
    {
        $this->senderAddressLine3 = $senderAddressLine3;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine4(): string
    {
        return $this->senderAddressLine4;
    }

    /**
     * @param String $senderAddressLine4
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine4(string $senderAddressLine4): MailevaSending
    {
        $this->senderAddressLine4 = $senderAddressLine4;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine5(): string
    {
        return $this->senderAddressLine5;
    }

    /**
     * @param String $senderAddressLine5
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine5(string $senderAddressLine5): MailevaSending
    {
        $this->senderAddressLine5 = $senderAddressLine5;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderAddressLine6(): ?string
    {
        return $this->senderAddressLine6;
    }

    /**
     * @param String $senderAddressLine6
     *
     * @return MailevaSending
     */
    public function setSenderAddressLine6(string $senderAddressLine6): MailevaSending
    {
        $this->senderAddressLine6 = $senderAddressLine6;
        return $this;
    }

    /**
     * @return String
     */
    public function getSenderCountryCode(): string
    {
        return $this->senderCountryCode;
    }

    /**
     * @param String $senderCountryCode
     *
     * @return MailevaSending
     */
    public function setSenderCountryCode(string $senderCountryCode): MailevaSending
    {
        $this->senderCountryCode = $senderCountryCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getUID(): array
    {
        $postageType            = is_null($this->getPostageType()) ? "pe" : $this->getPostageType();
        $colorPrinting          = is_null($this->isColorPrinting()) ? "cg" : (string)$this->isColorPrinting();
        $isDuplexPrinting       = is_null($this->isDuplexPrinting()) ? "dg" : (string)$this->isDuplexPrinting();
        $isOptionalAddressSheet = is_null($this->isOptionalAddressSheet()) ? "ot" : (string)$this->isOptionalAddressSheet();
        $isTreatUndeliveredMail = is_null($this->isTreatUndeliveredMail()) ? "tu" : (string)$this->isTreatUndeliveredMail();

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
            for ($pageNumber = 1; $pageNumber <= $this->getNbPage(); $pageNumber++) {
                $tmp     = tempnam("/tmp", uniqid("", true));
                $command = 'pdftotext -f ' . $pageNumber . ' -l ' . $pageNumber . ' ' . $this->getFile() . ' ' . $tmp;
                exec($command);
                $pdfText = preg_replace('/\s+/', '', file_get_contents($tmp));
                if (strlen($pdfText) < 30) {
                    $pdfText = '';
                    @unlink($tmp);
                    break;
                }
                @unlink($tmp);
            }

            if ($pdfText !== '') {
                $tmp     = tempnam("/tmp", uniqid("", true));
                $command = 'pdftotext ' . $this->getFile() . ' ' . $tmp;
                exec($command);
                $pdfText = preg_replace('/\s+/', '', file_get_contents($tmp));
                @unlink($tmp);
            }
        } catch (Throwable $t) {
            error_log($t);
        }

        if (strlen($pdfText) > 30) {
            $getFile = md5(preg_replace('/\s+/', '', $pdfText));
            $method  = self::UID_METHOD_PDFTEXT;
        } else {
            $getFile = md5_file($this->getFile());
            $method  = self::UID_METHOD_MD5_FILE;
        }

        $key = $postageType . $colorPrinting . $isDuplexPrinting . $isOptionalAddressSheet . $isTreatUndeliveredMail .
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
     * @return bool
     */
    public function isTreatUndeliveredMail(): bool
    {
        return $this->treatUndeliveredMail;
    }

    /**
     * @param bool $treatUndeliveredMail
     *
     * @return MailevaSending
     */
    public function setTreatUndeliveredMail(bool $treatUndeliveredMail): MailevaSending
    {
        $this->treatUndeliveredMail = $treatUndeliveredMail;
        return $this;
    }

    public function toString(): ?string
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

    /**
     * @param string $mailevaConnectionType
     * @return $this
     * @throws MailevaParameterException
     */
    public function validate(string $mailevaConnectionType): self
    {
        $fields = get_object_vars($this);

        # Validate special fields linked to LRE,LREL or MAILEVA_COPRO
        $connectionTypeList = [MailevaConnection::LRE, MailevaConnection::MAILEVA_COPRO, MailevaConnection::LRCOPRO];
        if (in_array($mailevaConnectionType, $connectionTypeList)) {
            if (empty($fields['senderAddressLine1']) && empty($fields['senderAddressLine2'])) {
                throw new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_1_OR_2_NOT_SET,
                    'senderAddressLine1 || senderAddressLine2 not set'
                );
            }

            if (empty($fields['senderAddressLine6'])) {
                throw new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_SENDERADDRESS_LINE_6_NOT_SET,
                    'senderAddressLine6 not set'
                );
            }

            if (empty($fields['notificationEmail'])) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_NOTIFICATION_EMAIL_NOT_SET, 'notificationEmail not set');
            }
        }

        if (empty($fields['addressLine1']) && empty($fields['addressLine2'])) {
            throw new MailevaParameterException(
                MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_1_OR_2_NOT_SET,
                'addressLine1 || addressLine2 not set'
            );
        }

        if (empty($fields['addressLine6'])) {
            throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_ADDRESS_LINE_6_NOT_SET, 'addressLine6 not set');
        }

        foreach ($fields as $key => $value) {
            if (stripos($key, 'addressLine') !== false) {
                if (mb_strlen($value) > self::LINE_ADDRESS_MAX_LENGTH) {
                    throw new MailevaParameterException(
                        MailevaParameterException::ERROR_MAILEVA_TOO_LONG_ADRESSE,
                        'too long address on ' . $key . ' : ' . $value
                    );
                }
            }
        }

        if (!empty($fields['notificationEmail'])) {
            if (!preg_match(self::EMAIL_REGEX, $fields['notificationEmail'])) {
                throw new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION,
                    'Wrong email syntax on notificationEmail parameter'
                );
            }
        }

        if ($fields['treatUndeliveredMail'] === true) {
            if (empty($fields['notificationTreatUndeliveredMail'])) {
                throw new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_NOTIFICATION_TREAT_UNDELIVERED_MAIL_NOT_SET,
                    'notificationTreatUndeliveredMail not set'
                );
            }

            if (!preg_match(self::EMAIL_REGEX, $fields['notificationTreatUndeliveredMail'])) {
                throw new MailevaParameterException(
                    MailevaParameterException::ERROR_MAILEVA_WRONG_EMAIL_SYNTAX_NOTIFICATION,
                    'Wrong email syntax on notificationTreatUndeliveredMail parameter'
                );
            }
        } else {
            unset($fields['notificationTreatUndeliveredMail']);
        }

        #already checked
        unset($fields['addressLine1']);
        unset($fields['addressLine2']);
        unset($fields['addressLine6']);
        unset($fields['senderAddressLine1']);
        unset($fields['senderAddressLine2']);
        unset($fields['senderAddressLine6']);
        unset($fields['notificationEmail']);
        unset($fields['nbPage']);

        foreach ($fields as $key => $value) {
            if (is_null($value)) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_KEY_NOT_SET, $key . ' not set');
            }

            if ($key === 'file') {
                if (!file_exists($value)) {
                    throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_FILE_NOT_FOUND, 'file ' . $value . ' not found');
                }
                if ($this->isNotCopro()) {
                    if (filesize($value) >= self::MAX_MB_FILE_MAILEVA) {
                        throw new MailevaParameterException(
                            MailevaParameterException::ERROR_MAILEVA_FILE_IS_TOO_BIG,
                            'The file is too big :' . $value . ' the maximum is ' . self::MAX_MB_FILE_MAILEVA . ' MB'
                        );
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isCopro(): bool
    {
        return in_array($this->postageType,self::POSTAGE_TYPE_COPRO_LISTE);
    }
    /**
     * @return bool
     */
    public function isNotCopro(): bool
    {
        return !$this->isCopro();
    }
}
