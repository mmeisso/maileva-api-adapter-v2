<?php
/**
 * SendingUpdate
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\MailevaCoproClient
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
 * OpenAPI Generator version: 6.3.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\MailevaCoproClient\Model;

use \ArrayAccess;
use \MailevaApiAdapter\App\Client\MailevaCoproClient\ObjectSerializer;

/**
 * SendingUpdate Class Doc Comment
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\MailevaCoproClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class SendingUpdate implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'SendingUpdate';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'name' => 'string',
        'customId' => 'string',
        'customData' => 'string',
        'registeredMailOptions' => '\MailevaApiAdapter\App\Client\MailevaCoproClient\Model\RegisteredMailOptions',
        'electronicNoticeOptions' => '\MailevaApiAdapter\App\Client\MailevaCoproClient\Model\ElectronicNoticeOptions'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'name' => null,
        'customId' => null,
        'customData' => null,
        'registeredMailOptions' => null,
        'electronicNoticeOptions' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'name' => false,
		'customId' => false,
		'customData' => false,
		'registeredMailOptions' => false,
		'electronicNoticeOptions' => false
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
        'name' => 'name',
        'customId' => 'custom_id',
        'customData' => 'custom_data',
        'registeredMailOptions' => 'registered_mail_options',
        'electronicNoticeOptions' => 'electronic_notice_options'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'name' => 'setName',
        'customId' => 'setCustomId',
        'customData' => 'setCustomData',
        'registeredMailOptions' => 'setRegisteredMailOptions',
        'electronicNoticeOptions' => 'setElectronicNoticeOptions'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'name' => 'getName',
        'customId' => 'getCustomId',
        'customData' => 'getCustomData',
        'registeredMailOptions' => 'getRegisteredMailOptions',
        'electronicNoticeOptions' => 'getElectronicNoticeOptions'
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
        $this->setIfExists('name', $data ?? [], null);
        $this->setIfExists('customId', $data ?? [], null);
        $this->setIfExists('customData', $data ?? [], null);
        $this->setIfExists('registeredMailOptions', $data ?? [], null);
        $this->setIfExists('electronicNoticeOptions', $data ?? [], null);
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

        if (!is_null($this->container['name']) && (mb_strlen($this->container['name']) > 256)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be smaller than or equal to 256.";
        }

        if (!is_null($this->container['name']) && (mb_strlen($this->container['name']) < 1)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['customId']) && (mb_strlen($this->container['customId']) > 38)) {
            $invalidProperties[] = "invalid value for 'customId', the character length must be smaller than or equal to 38.";
        }

        if (!is_null($this->container['customId']) && (mb_strlen($this->container['customId']) < 0)) {
            $invalidProperties[] = "invalid value for 'customId', the character length must be bigger than or equal to 0.";
        }

        if (!is_null($this->container['customData']) && (mb_strlen($this->container['customData']) > 255)) {
            $invalidProperties[] = "invalid value for 'customData', the character length must be smaller than or equal to 255.";
        }

        if (!is_null($this->container['customData']) && (mb_strlen($this->container['customData']) < 0)) {
            $invalidProperties[] = "invalid value for 'customData', the character length must be bigger than or equal to 0.";
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
     * Gets name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string|null $name Nom de l'envoi
     *
     * @return self
     */
    public function setName($name)
    {
        if (is_null($name)) {
            throw new \InvalidArgumentException('non-nullable name cannot be null');
        }
        if ((mb_strlen($name) > 256)) {
            throw new \InvalidArgumentException('invalid length for $name when calling SendingUpdate., must be smaller than or equal to 256.');
        }
        if ((mb_strlen($name) < 1)) {
            throw new \InvalidArgumentException('invalid length for $name when calling SendingUpdate., must be bigger than or equal to 1.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets customId
     *
     * @return string|null
     */
    public function getCustomId()
    {
        return $this->container['customId'];
    }

    /**
     * Sets customId
     *
     * @param string|null $customId Identifiant de l'envoi défini par le client
     *
     * @return self
     */
    public function setCustomId($customId)
    {
        if (is_null($customId)) {
            throw new \InvalidArgumentException('non-nullable customId cannot be null');
        }
        if ((mb_strlen($customId) > 38)) {
            throw new \InvalidArgumentException('invalid length for $customId when calling SendingUpdate., must be smaller than or equal to 38.');
        }
        if ((mb_strlen($customId) < 0)) {
            throw new \InvalidArgumentException('invalid length for $customId when calling SendingUpdate., must be bigger than or equal to 0.');
        }

        $this->container['customId'] = $customId;

        return $this;
    }

    /**
     * Gets customData
     *
     * @return string|null
     */
    public function getCustomData()
    {
        return $this->container['customData'];
    }

    /**
     * Sets customData
     *
     * @param string|null $customData Information libre fournie par le client.
     *
     * @return self
     */
    public function setCustomData($customData)
    {
        if (is_null($customData)) {
            throw new \InvalidArgumentException('non-nullable customData cannot be null');
        }
        if ((mb_strlen($customData) > 255)) {
            throw new \InvalidArgumentException('invalid length for $customData when calling SendingUpdate., must be smaller than or equal to 255.');
        }
        if ((mb_strlen($customData) < 0)) {
            throw new \InvalidArgumentException('invalid length for $customData when calling SendingUpdate., must be bigger than or equal to 0.');
        }

        $this->container['customData'] = $customData;

        return $this;
    }

    /**
     * Gets registeredMailOptions
     *
     * @return \MailevaApiAdapter\App\Client\MailevaCoproClient\Model\RegisteredMailOptions|null
     */
    public function getRegisteredMailOptions()
    {
        return $this->container['registeredMailOptions'];
    }

    /**
     * Sets registeredMailOptions
     *
     * @param \MailevaApiAdapter\App\Client\MailevaCoproClient\Model\RegisteredMailOptions|null $registeredMailOptions registeredMailOptions
     *
     * @return self
     */
    public function setRegisteredMailOptions($registeredMailOptions)
    {
        if (is_null($registeredMailOptions)) {
            throw new \InvalidArgumentException('non-nullable registeredMailOptions cannot be null');
        }
        $this->container['registeredMailOptions'] = $registeredMailOptions;

        return $this;
    }

    /**
     * Gets electronicNoticeOptions
     *
     * @return \MailevaApiAdapter\App\Client\MailevaCoproClient\Model\ElectronicNoticeOptions|null
     */
    public function getElectronicNoticeOptions()
    {
        return $this->container['electronicNoticeOptions'];
    }

    /**
     * Sets electronicNoticeOptions
     *
     * @param \MailevaApiAdapter\App\Client\MailevaCoproClient\Model\ElectronicNoticeOptions|null $electronicNoticeOptions electronicNoticeOptions
     *
     * @return self
     */
    public function setElectronicNoticeOptions($electronicNoticeOptions)
    {
        if (is_null($electronicNoticeOptions)) {
            throw new \InvalidArgumentException('non-nullable electronicNoticeOptions cannot be null');
        }
        $this->container['electronicNoticeOptions'] = $electronicNoticeOptions;

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


