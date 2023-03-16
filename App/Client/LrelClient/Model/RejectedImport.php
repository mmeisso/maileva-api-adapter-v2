<?php
/**
 * RejectedImport
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\LrelClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Maileva / Envoi et Suivi de Lettres Recommandées En Ligne distribuées par le facteur
 *
 * API pour envoyer et suivre des Lettres Recommandées En Ligne distribuées par le facteur  Elle comprend les fonctions clés pour :   - créer un envoi,  - ajouter des documents et des destinataires,  - choisir ses options,  - suivre la production.  Pour connaitre les notifications (webhooks) concernées par cette API, consultez la documentation de l'API \"notification_center\".
 *
 * The version of the OpenAPI document: 2.5
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.3.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\LrelClient\Model;

use \ArrayAccess;
use \MailevaApiAdapter\App\Client\LrelClient\ObjectSerializer;

/**
 * RejectedImport Class Doc Comment
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\LrelClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class RejectedImport implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'rejected_import';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'correlationId' => 'string',
        'addressLine1' => 'string',
        'addressLine2' => 'string',
        'addressLine3' => 'string',
        'addressLine4' => 'string',
        'addressLine5' => 'string',
        'addressLine6' => 'string',
        'countryCode' => '\MailevaApiAdapter\App\Client\LrelClient\Model\CountryCode',
        'errors' => '\MailevaApiAdapter\App\Client\LrelClient\Model\ErrorResponse[]',
        'documentsOverride' => '\MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsOverrideItem[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'correlationId' => null,
        'addressLine1' => null,
        'addressLine2' => null,
        'addressLine3' => null,
        'addressLine4' => null,
        'addressLine5' => null,
        'addressLine6' => null,
        'countryCode' => null,
        'errors' => null,
        'documentsOverride' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'correlationId' => false,
		'addressLine1' => false,
		'addressLine2' => false,
		'addressLine3' => false,
		'addressLine4' => false,
		'addressLine5' => false,
		'addressLine6' => false,
		'countryCode' => false,
		'errors' => false,
		'documentsOverride' => false
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
        'correlationId' => 'correlation_id',
        'addressLine1' => 'address_line_1',
        'addressLine2' => 'address_line_2',
        'addressLine3' => 'address_line_3',
        'addressLine4' => 'address_line_4',
        'addressLine5' => 'address_line_5',
        'addressLine6' => 'address_line_6',
        'countryCode' => 'country_code',
        'errors' => 'errors',
        'documentsOverride' => 'documents_override'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'correlationId' => 'setCorrelationId',
        'addressLine1' => 'setAddressLine1',
        'addressLine2' => 'setAddressLine2',
        'addressLine3' => 'setAddressLine3',
        'addressLine4' => 'setAddressLine4',
        'addressLine5' => 'setAddressLine5',
        'addressLine6' => 'setAddressLine6',
        'countryCode' => 'setCountryCode',
        'errors' => 'setErrors',
        'documentsOverride' => 'setDocumentsOverride'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'correlationId' => 'getCorrelationId',
        'addressLine1' => 'getAddressLine1',
        'addressLine2' => 'getAddressLine2',
        'addressLine3' => 'getAddressLine3',
        'addressLine4' => 'getAddressLine4',
        'addressLine5' => 'getAddressLine5',
        'addressLine6' => 'getAddressLine6',
        'countryCode' => 'getCountryCode',
        'errors' => 'getErrors',
        'documentsOverride' => 'getDocumentsOverride'
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
        $this->setIfExists('correlationId', $data ?? [], null);
        $this->setIfExists('addressLine1', $data ?? [], null);
        $this->setIfExists('addressLine2', $data ?? [], null);
        $this->setIfExists('addressLine3', $data ?? [], null);
        $this->setIfExists('addressLine4', $data ?? [], null);
        $this->setIfExists('addressLine5', $data ?? [], null);
        $this->setIfExists('addressLine6', $data ?? [], null);
        $this->setIfExists('countryCode', $data ?? [], null);
        $this->setIfExists('errors', $data ?? [], null);
        $this->setIfExists('documentsOverride', $data ?? [], null);
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

        if (!is_null($this->container['correlationId']) && (mb_strlen($this->container['correlationId']) > 32)) {
            $invalidProperties[] = "invalid value for 'correlationId', the character length must be smaller than or equal to 32.";
        }

        if ($this->container['addressLine6'] === null) {
            $invalidProperties[] = "'addressLine6' can't be null";
        }
        if ($this->container['countryCode'] === null) {
            $invalidProperties[] = "'countryCode' can't be null";
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
     * Gets correlationId
     *
     * @return string|null
     */
    public function getCorrelationId()
    {
        return $this->container['correlationId'];
    }

    /**
     * Sets correlationId
     *
     * @param string|null $correlationId Identifiant du destinataire fourni par le client
     *
     * @return self
     */
    public function setCorrelationId($correlationId)
    {
        if (is_null($correlationId)) {
            throw new \InvalidArgumentException('non-nullable correlationId cannot be null');
        }
        if ((mb_strlen($correlationId) > 32)) {
            throw new \InvalidArgumentException('invalid length for $correlationId when calling RejectedImport., must be smaller than or equal to 32.');
        }

        $this->container['correlationId'] = $correlationId;

        return $this;
    }

    /**
     * Gets addressLine1
     *
     * @return string|null
     */
    public function getAddressLine1()
    {
        return $this->container['addressLine1'];
    }

    /**
     * Sets addressLine1
     *
     * @param string|null $addressLine1 Ligne d'adresse n°1 (Société)
     *
     * @return self
     */
    public function setAddressLine1($addressLine1)
    {
        if (is_null($addressLine1)) {
            throw new \InvalidArgumentException('non-nullable addressLine1 cannot be null');
        }
        $this->container['addressLine1'] = $addressLine1;

        return $this;
    }

    /**
     * Gets addressLine2
     *
     * @return string|null
     */
    public function getAddressLine2()
    {
        return $this->container['addressLine2'];
    }

    /**
     * Sets addressLine2
     *
     * @param string|null $addressLine2 Ligne d'adresse n°2 (Civilité, Prénom, Nom)
     *
     * @return self
     */
    public function setAddressLine2($addressLine2)
    {
        if (is_null($addressLine2)) {
            throw new \InvalidArgumentException('non-nullable addressLine2 cannot be null');
        }
        $this->container['addressLine2'] = $addressLine2;

        return $this;
    }

    /**
     * Gets addressLine3
     *
     * @return string|null
     */
    public function getAddressLine3()
    {
        return $this->container['addressLine3'];
    }

    /**
     * Sets addressLine3
     *
     * @param string|null $addressLine3 Ligne d'adresse n°3 (Résidence, Bâtiement ...)
     *
     * @return self
     */
    public function setAddressLine3($addressLine3)
    {
        if (is_null($addressLine3)) {
            throw new \InvalidArgumentException('non-nullable addressLine3 cannot be null');
        }
        $this->container['addressLine3'] = $addressLine3;

        return $this;
    }

    /**
     * Gets addressLine4
     *
     * @return string|null
     */
    public function getAddressLine4()
    {
        return $this->container['addressLine4'];
    }

    /**
     * Sets addressLine4
     *
     * @param string|null $addressLine4 Ligne d'adresse n°4 (N° et libellé de la voie)
     *
     * @return self
     */
    public function setAddressLine4($addressLine4)
    {
        if (is_null($addressLine4)) {
            throw new \InvalidArgumentException('non-nullable addressLine4 cannot be null');
        }
        $this->container['addressLine4'] = $addressLine4;

        return $this;
    }

    /**
     * Gets addressLine5
     *
     * @return string|null
     */
    public function getAddressLine5()
    {
        return $this->container['addressLine5'];
    }

    /**
     * Sets addressLine5
     *
     * @param string|null $addressLine5 Ligne d'adresse n°5 (Lieu dit, BP...)
     *
     * @return self
     */
    public function setAddressLine5($addressLine5)
    {
        if (is_null($addressLine5)) {
            throw new \InvalidArgumentException('non-nullable addressLine5 cannot be null');
        }
        $this->container['addressLine5'] = $addressLine5;

        return $this;
    }

    /**
     * Gets addressLine6
     *
     * @return string
     */
    public function getAddressLine6()
    {
        return $this->container['addressLine6'];
    }

    /**
     * Sets addressLine6
     *
     * @param string $addressLine6 Ligne d'adresse n°6 (Code postal et ville)
     *
     * @return self
     */
    public function setAddressLine6($addressLine6)
    {
        if (is_null($addressLine6)) {
            throw new \InvalidArgumentException('non-nullable addressLine6 cannot be null');
        }
        $this->container['addressLine6'] = $addressLine6;

        return $this;
    }

    /**
     * Gets countryCode
     *
     * @return \MailevaApiAdapter\App\Client\LrelClient\Model\CountryCode
     */
    public function getCountryCode()
    {
        return $this->container['countryCode'];
    }

    /**
     * Sets countryCode
     *
     * @param \MailevaApiAdapter\App\Client\LrelClient\Model\CountryCode $countryCode countryCode
     *
     * @return self
     */
    public function setCountryCode($countryCode)
    {
        if (is_null($countryCode)) {
            throw new \InvalidArgumentException('non-nullable countryCode cannot be null');
        }
        $this->container['countryCode'] = $countryCode;

        return $this;
    }

    /**
     * Gets errors
     *
     * @return \MailevaApiAdapter\App\Client\LrelClient\Model\ErrorResponse[]|null
     */
    public function getErrors()
    {
        return $this->container['errors'];
    }

    /**
     * Sets errors
     *
     * @param \MailevaApiAdapter\App\Client\LrelClient\Model\ErrorResponse[]|null $errors errors
     *
     * @return self
     */
    public function setErrors($errors)
    {
        if (is_null($errors)) {
            throw new \InvalidArgumentException('non-nullable errors cannot be null');
        }
        $this->container['errors'] = $errors;

        return $this;
    }

    /**
     * Gets documentsOverride
     *
     * @return \MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsOverrideItem[]|null
     */
    public function getDocumentsOverride()
    {
        return $this->container['documentsOverride'];
    }

    /**
     * Sets documentsOverride
     *
     * @param \MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsOverrideItem[]|null $documentsOverride documentsOverride
     *
     * @return self
     */
    public function setDocumentsOverride($documentsOverride)
    {
        if (is_null($documentsOverride)) {
            throw new \InvalidArgumentException('non-nullable documentsOverride cannot be null');
        }
        $this->container['documentsOverride'] = $documentsOverride;

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


