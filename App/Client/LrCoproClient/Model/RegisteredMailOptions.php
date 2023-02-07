<?php
/**
 * RegisteredMailOptions
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\LrCoproClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Maileva / Création et envoi de Maileva copro réservé aux professionnels de l'immobilier
 *
 * API pour créer et envoyer des Lettres Recommandées Copro réservées aux professionnels de l'immobilier.  En fonction du canal d'envoi défini, la Lettre Recommandée Copro sera envoyée de manière électronique ou papier.  Il est possible de définir un canal d'envoi (papier ou électronique) ou de passer par l'API <a href=\"/developpeur/electronic_consents\">electronic_consents</a> pour récupérer le canal d'envoi accepté par le destinataire.    Cette API comprend les fonctions clés pour :   - créer un envoi,  - ajouter des documents et des destinataires,  - choisir ses options (Nom, Champ libre, référence dossier, référence client)  - envoyer ses lettres recommandées copro  - gérer ses modes d'envoi : papier ou électronique  - suivre ses envois et télécharger les preuves de dépôt et justificatifs de réception.     **Paramétrage de compte expéditeur :**     Chaque expéditeur d'une Maileva Copro doit posséder un compte expéditeur. Il est donc nécessaire de paramétrer son compte expéditeur en passant par l'API <a href=\"/developpeur/electronic_mail_emitter\">electronic_mail_emitter</a> ou en se connectant à son espace client, depuis le lien reçu par notification e-mail et en suivant les étapes de paramétrage de compte.
 *
 * The version of the OpenAPI document: 1.37
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.3.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\LrCoproClient\Model;

use \ArrayAccess;
use \MailevaApiAdapter\App\Client\LrCoproClient\ObjectSerializer;

/**
 * RegisteredMailOptions Class Doc Comment
 *
 * @category Class
 * @description 
 * @package  MailevaApiAdapter\App\Client\LrCoproClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class RegisteredMailOptions implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'registered_mail_options';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'duplexPrinting' => 'bool',
        'archivingDuration' => 'int',
        'acknowledgementOfReceiptScanning' => 'bool',
        'senderAddressLine1' => 'string',
        'senderAddressLine2' => 'string',
        'senderAddressLine3' => 'string',
        'senderAddressLine4' => 'string',
        'senderAddressLine5' => 'string',
        'senderAddressLine6' => 'string',
        'senderCountryCode' => '\MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'duplexPrinting' => null,
        'archivingDuration' => null,
        'acknowledgementOfReceiptScanning' => null,
        'senderAddressLine1' => null,
        'senderAddressLine2' => null,
        'senderAddressLine3' => null,
        'senderAddressLine4' => null,
        'senderAddressLine5' => null,
        'senderAddressLine6' => null,
        'senderCountryCode' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'duplexPrinting' => false,
		'archivingDuration' => false,
		'acknowledgementOfReceiptScanning' => false,
		'senderAddressLine1' => false,
		'senderAddressLine2' => false,
		'senderAddressLine3' => false,
		'senderAddressLine4' => false,
		'senderAddressLine5' => false,
		'senderAddressLine6' => false,
		'senderCountryCode' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'duplexPrinting' => 'duplex_printing',
        'archivingDuration' => 'archiving_duration',
        'acknowledgementOfReceiptScanning' => 'acknowledgement_of_receipt_scanning',
        'senderAddressLine1' => 'sender_address_line_1',
        'senderAddressLine2' => 'sender_address_line_2',
        'senderAddressLine3' => 'sender_address_line_3',
        'senderAddressLine4' => 'sender_address_line_4',
        'senderAddressLine5' => 'sender_address_line_5',
        'senderAddressLine6' => 'sender_address_line_6',
        'senderCountryCode' => 'sender_country_code'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'duplexPrinting' => 'setDuplexPrinting',
        'archivingDuration' => 'setArchivingDuration',
        'acknowledgementOfReceiptScanning' => 'setAcknowledgementOfReceiptScanning',
        'senderAddressLine1' => 'setSenderAddressLine1',
        'senderAddressLine2' => 'setSenderAddressLine2',
        'senderAddressLine3' => 'setSenderAddressLine3',
        'senderAddressLine4' => 'setSenderAddressLine4',
        'senderAddressLine5' => 'setSenderAddressLine5',
        'senderAddressLine6' => 'setSenderAddressLine6',
        'senderCountryCode' => 'setSenderCountryCode'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'duplexPrinting' => 'getDuplexPrinting',
        'archivingDuration' => 'getArchivingDuration',
        'acknowledgementOfReceiptScanning' => 'getAcknowledgementOfReceiptScanning',
        'senderAddressLine1' => 'getSenderAddressLine1',
        'senderAddressLine2' => 'getSenderAddressLine2',
        'senderAddressLine3' => 'getSenderAddressLine3',
        'senderAddressLine4' => 'getSenderAddressLine4',
        'senderAddressLine5' => 'getSenderAddressLine5',
        'senderAddressLine6' => 'getSenderAddressLine6',
        'senderCountryCode' => 'getSenderCountryCode'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    public const ARCHIVING_DURATION_0 = 0;
    public const ARCHIVING_DURATION_1 = 1;
    public const ARCHIVING_DURATION_3 = 3;
    public const ARCHIVING_DURATION_6 = 6;
    public const ARCHIVING_DURATION_10 = 10;

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getArchivingDurationAllowableValues()
    {
        return [
            self::ARCHIVING_DURATION_0,
            self::ARCHIVING_DURATION_1,
            self::ARCHIVING_DURATION_3,
            self::ARCHIVING_DURATION_6,
            self::ARCHIVING_DURATION_10,
        ];
    }

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('duplexPrinting', $data ?? [], true);
        $this->setIfExists('archivingDuration', $data ?? [], self::ARCHIVING_DURATION_0);
        $this->setIfExists('acknowledgementOfReceiptScanning', $data ?? [], false);
        $this->setIfExists('senderAddressLine1', $data ?? [], null);
        $this->setIfExists('senderAddressLine2', $data ?? [], null);
        $this->setIfExists('senderAddressLine3', $data ?? [], null);
        $this->setIfExists('senderAddressLine4', $data ?? [], null);
        $this->setIfExists('senderAddressLine5', $data ?? [], null);
        $this->setIfExists('senderAddressLine6', $data ?? [], null);
        $this->setIfExists('senderCountryCode', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getArchivingDurationAllowableValues();
        if (!is_null($this->container['archivingDuration']) && !in_array($this->container['archivingDuration'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'archivingDuration', must be one of '%s'",
                $this->container['archivingDuration'],
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['senderAddressLine1'] === null) {
            $invalidProperties[] = "'senderAddressLine1' can't be null";
        }
        if ($this->container['senderAddressLine6'] === null) {
            $invalidProperties[] = "'senderAddressLine6' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets duplexPrinting
     *
     * @return bool|null
     */
    public function getDuplexPrinting()
    {
        return $this->container['duplexPrinting'];
    }

    /**
     * Sets duplexPrinting
     *
     * @param bool|null $duplexPrinting Impression recto verso
     *
     * @return self
     */
    public function setDuplexPrinting($duplexPrinting)
    {
        if (is_null($duplexPrinting)) {
            throw new \InvalidArgumentException('non-nullable duplexPrinting cannot be null');
        }
        $this->container['duplexPrinting'] = $duplexPrinting;

        return $this;
    }

    /**
     * Gets archivingDuration
     *
     * @return int|null
     */
    public function getArchivingDuration()
    {
        return $this->container['archivingDuration'];
    }

    /**
     * Sets archivingDuration
     *
     * @param int|null $archivingDuration Durée d'archivage optionnelle pour envoi papier (en années). Par défaut, elle est à 0.
     *
     * @return self
     */
    public function setArchivingDuration($archivingDuration)
    {
        if (is_null($archivingDuration)) {
            throw new \InvalidArgumentException('non-nullable archivingDuration cannot be null');
        }
        $allowedValues = $this->getArchivingDurationAllowableValues();
        if (!in_array($archivingDuration, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'archivingDuration', must be one of '%s'",
                    $archivingDuration,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['archivingDuration'] = $archivingDuration;

        return $this;
    }

    /**
     * Gets acknowledgementOfReceiptScanning
     *
     * @return bool|null
     */
    public function getAcknowledgementOfReceiptScanning()
    {
        return $this->container['acknowledgementOfReceiptScanning'];
    }

    /**
     * Sets acknowledgementOfReceiptScanning
     *
     * @param bool|null $acknowledgementOfReceiptScanning Gestion électronique des avis de réception (AR). Cette option indique que Maileva doit recevoir, numériser, mettre en ligne l’image et archiver physiquement les Avis de Réception. Pour cela, la première ligne de l’adresse de l’expéditeur sera conservée, mais les 5 autres lignes et le pays seront remplacés par l’adresse de Maileva. Cette option nécessite que l’option avis de réception soit activée.
     *
     * @return self
     */
    public function setAcknowledgementOfReceiptScanning($acknowledgementOfReceiptScanning)
    {
        if (is_null($acknowledgementOfReceiptScanning)) {
            throw new \InvalidArgumentException('non-nullable acknowledgementOfReceiptScanning cannot be null');
        }
        $this->container['acknowledgementOfReceiptScanning'] = $acknowledgementOfReceiptScanning;

        return $this;
    }

    /**
     * Gets senderAddressLine1
     *
     * @return string
     */
    public function getSenderAddressLine1()
    {
        return $this->container['senderAddressLine1'];
    }

    /**
     * Sets senderAddressLine1
     *
     * @param string $senderAddressLine1 Ligne d'adresse n°1 (Société) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine1($senderAddressLine1)
    {
        if (is_null($senderAddressLine1)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine1 cannot be null');
        }
        $this->container['senderAddressLine1'] = $senderAddressLine1;

        return $this;
    }

    /**
     * Gets senderAddressLine2
     *
     * @return string|null
     */
    public function getSenderAddressLine2()
    {
        return $this->container['senderAddressLine2'];
    }

    /**
     * Sets senderAddressLine2
     *
     * @param string|null $senderAddressLine2 Ligne d'adresse n°2 (Civilité, Prénom, Nom) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine2($senderAddressLine2)
    {
        if (is_null($senderAddressLine2)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine2 cannot be null');
        }
        $this->container['senderAddressLine2'] = $senderAddressLine2;

        return $this;
    }

    /**
     * Gets senderAddressLine3
     *
     * @return string|null
     */
    public function getSenderAddressLine3()
    {
        return $this->container['senderAddressLine3'];
    }

    /**
     * Sets senderAddressLine3
     *
     * @param string|null $senderAddressLine3 Ligne d'adresse n°3 (Résidence, Bâtiement ...) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine3($senderAddressLine3)
    {
        if (is_null($senderAddressLine3)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine3 cannot be null');
        }
        $this->container['senderAddressLine3'] = $senderAddressLine3;

        return $this;
    }

    /**
     * Gets senderAddressLine4
     *
     * @return string|null
     */
    public function getSenderAddressLine4()
    {
        return $this->container['senderAddressLine4'];
    }

    /**
     * Sets senderAddressLine4
     *
     * @param string|null $senderAddressLine4 Ligne d'adresse n°4 (N° et libellé de la voie) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine4($senderAddressLine4)
    {
        if (is_null($senderAddressLine4)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine4 cannot be null');
        }
        $this->container['senderAddressLine4'] = $senderAddressLine4;

        return $this;
    }

    /**
     * Gets senderAddressLine5
     *
     * @return string|null
     */
    public function getSenderAddressLine5()
    {
        return $this->container['senderAddressLine5'];
    }

    /**
     * Sets senderAddressLine5
     *
     * @param string|null $senderAddressLine5 Ligne d'adresse n°5 (Lieu dit, BP...) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine5($senderAddressLine5)
    {
        if (is_null($senderAddressLine5)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine5 cannot be null');
        }
        $this->container['senderAddressLine5'] = $senderAddressLine5;

        return $this;
    }

    /**
     * Gets senderAddressLine6
     *
     * @return string
     */
    public function getSenderAddressLine6()
    {
        return $this->container['senderAddressLine6'];
    }

    /**
     * Sets senderAddressLine6
     *
     * @param string $senderAddressLine6 Ligne d'adresse n°6 (Code postal et ville) de l'expéditeur
     *
     * @return self
     */
    public function setSenderAddressLine6($senderAddressLine6)
    {
        if (is_null($senderAddressLine6)) {
            throw new \InvalidArgumentException('non-nullable senderAddressLine6 cannot be null');
        }
        $this->container['senderAddressLine6'] = $senderAddressLine6;

        return $this;
    }

    /**
     * Gets senderCountryCode
     *
     * @return \MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode|null
     */
    public function getSenderCountryCode()
    {
        return $this->container['senderCountryCode'];
    }

    /**
     * Sets senderCountryCode
     *
     * @param \MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode|null $senderCountryCode senderCountryCode
     *
     * @return self
     */
    public function setSenderCountryCode($senderCountryCode)
    {
        if (is_null($senderCountryCode)) {
            throw new \InvalidArgumentException('non-nullable senderCountryCode cannot be null');
        }
        $this->container['senderCountryCode'] = $senderCountryCode;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


