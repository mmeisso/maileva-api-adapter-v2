<?php
/**
 * RecipientUpdate
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
 * RecipientUpdate Class Doc Comment
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\LrCoproClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class RecipientUpdate implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'RecipientUpdate';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'customId' => 'string',
        'customData' => 'string',
        'sendingMode' => 'string',
        'legalStatus' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'company' => 'string',
        'email' => 'string',
        'addressLine1' => 'string',
        'addressLine2' => 'string',
        'addressLine3' => 'string',
        'addressLine4' => 'string',
        'addressLine5' => 'string',
        'addressLine6' => 'string',
        'countryCode' => '\MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode',
        'documentsOverride' => '\MailevaApiAdapter\App\Client\LrCoproClient\Model\ComposedDocument'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'customId' => null,
        'customData' => null,
        'sendingMode' => null,
        'legalStatus' => null,
        'firstName' => null,
        'lastName' => null,
        'company' => null,
        'email' => null,
        'addressLine1' => null,
        'addressLine2' => null,
        'addressLine3' => null,
        'addressLine4' => null,
        'addressLine5' => null,
        'addressLine6' => null,
        'countryCode' => null,
        'documentsOverride' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'customId' => false,
		'customData' => false,
		'sendingMode' => false,
		'legalStatus' => false,
		'firstName' => false,
		'lastName' => false,
		'company' => false,
		'email' => false,
		'addressLine1' => false,
		'addressLine2' => false,
		'addressLine3' => false,
		'addressLine4' => false,
		'addressLine5' => false,
		'addressLine6' => false,
		'countryCode' => false,
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
        'customId' => 'custom_id',
        'customData' => 'custom_data',
        'sendingMode' => 'sending_mode',
        'legalStatus' => 'legal_status',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'company' => 'company',
        'email' => 'email',
        'addressLine1' => 'address_line_1',
        'addressLine2' => 'address_line_2',
        'addressLine3' => 'address_line_3',
        'addressLine4' => 'address_line_4',
        'addressLine5' => 'address_line_5',
        'addressLine6' => 'address_line_6',
        'countryCode' => 'country_code',
        'documentsOverride' => 'documents_override'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'customId' => 'setCustomId',
        'customData' => 'setCustomData',
        'sendingMode' => 'setSendingMode',
        'legalStatus' => 'setLegalStatus',
        'firstName' => 'setFirstName',
        'lastName' => 'setLastName',
        'company' => 'setCompany',
        'email' => 'setEmail',
        'addressLine1' => 'setAddressLine1',
        'addressLine2' => 'setAddressLine2',
        'addressLine3' => 'setAddressLine3',
        'addressLine4' => 'setAddressLine4',
        'addressLine5' => 'setAddressLine5',
        'addressLine6' => 'setAddressLine6',
        'countryCode' => 'setCountryCode',
        'documentsOverride' => 'setDocumentsOverride'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'customId' => 'getCustomId',
        'customData' => 'getCustomData',
        'sendingMode' => 'getSendingMode',
        'legalStatus' => 'getLegalStatus',
        'firstName' => 'getFirstName',
        'lastName' => 'getLastName',
        'company' => 'getCompany',
        'email' => 'getEmail',
        'addressLine1' => 'getAddressLine1',
        'addressLine2' => 'getAddressLine2',
        'addressLine3' => 'getAddressLine3',
        'addressLine4' => 'getAddressLine4',
        'addressLine5' => 'getAddressLine5',
        'addressLine6' => 'getAddressLine6',
        'countryCode' => 'getCountryCode',
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

    public const SENDING_MODE_USE_CONSENT = 'USE_CONSENT';
    public const SENDING_MODE_REGISTERED_MAIL = 'REGISTERED_MAIL';
    public const SENDING_MODE_ELECTRONIC_NOTICE = 'ELECTRONIC_NOTICE';
    public const LEGAL_STATUS_PROFESSIONAL = 'PROFESSIONAL';
    public const LEGAL_STATUS_INDIVIDUAL = 'INDIVIDUAL';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getSendingModeAllowableValues()
    {
        return [
            self::SENDING_MODE_USE_CONSENT,
            self::SENDING_MODE_REGISTERED_MAIL,
            self::SENDING_MODE_ELECTRONIC_NOTICE,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getLegalStatusAllowableValues()
    {
        return [
            self::LEGAL_STATUS_PROFESSIONAL,
            self::LEGAL_STATUS_INDIVIDUAL,
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
        $this->setIfExists('customId', $data ?? [], null);
        $this->setIfExists('customData', $data ?? [], null);
        $this->setIfExists('sendingMode', $data ?? [], null);
        $this->setIfExists('legalStatus', $data ?? [], null);
        $this->setIfExists('firstName', $data ?? [], null);
        $this->setIfExists('lastName', $data ?? [], null);
        $this->setIfExists('company', $data ?? [], null);
        $this->setIfExists('email', $data ?? [], null);
        $this->setIfExists('addressLine1', $data ?? [], null);
        $this->setIfExists('addressLine2', $data ?? [], null);
        $this->setIfExists('addressLine3', $data ?? [], null);
        $this->setIfExists('addressLine4', $data ?? [], null);
        $this->setIfExists('addressLine5', $data ?? [], null);
        $this->setIfExists('addressLine6', $data ?? [], null);
        $this->setIfExists('countryCode', $data ?? [], null);
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

        if (!is_null($this->container['customData']) && (mb_strlen($this->container['customData']) > 255)) {
            $invalidProperties[] = "invalid value for 'customData', the character length must be smaller than or equal to 255.";
        }

        if (!is_null($this->container['customData']) && (mb_strlen($this->container['customData']) < 0)) {
            $invalidProperties[] = "invalid value for 'customData', the character length must be bigger than or equal to 0.";
        }

        $allowedValues = $this->getSendingModeAllowableValues();
        if (!is_null($this->container['sendingMode']) && !in_array($this->container['sendingMode'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'sendingMode', must be one of '%s'",
                $this->container['sendingMode'],
                implode("', '", $allowedValues)
            );
        }

        $allowedValues = $this->getLegalStatusAllowableValues();
        if (!is_null($this->container['legalStatus']) && !in_array($this->container['legalStatus'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'legalStatus', must be one of '%s'",
                $this->container['legalStatus'],
                implode("', '", $allowedValues)
            );
        }

        if (!is_null($this->container['firstName']) && (mb_strlen($this->container['firstName']) > 50)) {
            $invalidProperties[] = "invalid value for 'firstName', the character length must be smaller than or equal to 50.";
        }

        if (!is_null($this->container['firstName']) && (mb_strlen($this->container['firstName']) < 1)) {
            $invalidProperties[] = "invalid value for 'firstName', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['lastName']) && (mb_strlen($this->container['lastName']) > 50)) {
            $invalidProperties[] = "invalid value for 'lastName', the character length must be smaller than or equal to 50.";
        }

        if (!is_null($this->container['lastName']) && (mb_strlen($this->container['lastName']) < 1)) {
            $invalidProperties[] = "invalid value for 'lastName', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['company']) && (mb_strlen($this->container['company']) > 38)) {
            $invalidProperties[] = "invalid value for 'company', the character length must be smaller than or equal to 38.";
        }

        if (!is_null($this->container['company']) && (mb_strlen($this->container['company']) < 0)) {
            $invalidProperties[] = "invalid value for 'company', the character length must be bigger than or equal to 0.";
        }

        if (!is_null($this->container['email']) && !preg_match("/^[\\w]{1,}[\\w.+-]{0,}@[\\w-]{2,}([.][a-zA-Z]{2,}|[.][\\w-]{2,}[.][a-zA-Z]{2,})+$/", $this->container['email'])) {
            $invalidProperties[] = "invalid value for 'email', must be conform to the pattern /^[\\w]{1,}[\\w.+-]{0,}@[\\w-]{2,}([.][a-zA-Z]{2,}|[.][\\w-]{2,}[.][a-zA-Z]{2,})+$/.";
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
     * @param string|null $customId Identifiant du destinataire fourni par le client
     *
     * @return self
     */
    public function setCustomId($customId)
    {
        if (is_null($customId)) {
            throw new \InvalidArgumentException('non-nullable customId cannot be null');
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
            throw new \InvalidArgumentException('invalid length for $customData when calling RecipientUpdate., must be smaller than or equal to 255.');
        }
        if ((mb_strlen($customData) < 0)) {
            throw new \InvalidArgumentException('invalid length for $customData when calling RecipientUpdate., must be bigger than or equal to 0.');
        }

        $this->container['customData'] = $customData;

        return $this;
    }

    /**
     * Gets sendingMode
     *
     * @return string|null
     */
    public function getSendingMode()
    {
        return $this->container['sendingMode'];
    }

    /**
     * Sets sendingMode
     *
     * @param string|null $sendingMode Mode d'envoi du destinataire. Il peut être papier, électronique ou passer par le service de consentement. Si le consentement est donné par le destinataire, le mode d'envoi sera électronique, sinon il sera papier.
     *
     * @return self
     */
    public function setSendingMode($sendingMode)
    {
        if (is_null($sendingMode)) {
            throw new \InvalidArgumentException('non-nullable sendingMode cannot be null');
        }
        $allowedValues = $this->getSendingModeAllowableValues();
        if (!in_array($sendingMode, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'sendingMode', must be one of '%s'",
                    $sendingMode,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['sendingMode'] = $sendingMode;

        return $this;
    }

    /**
     * Gets legalStatus
     *
     * @return string|null
     */
    public function getLegalStatus()
    {
        return $this->container['legalStatus'];
    }

    /**
     * Sets legalStatus
     *
     * @param string|null $legalStatus Type de destinataire
     *
     * @return self
     */
    public function setLegalStatus($legalStatus)
    {
        if (is_null($legalStatus)) {
            throw new \InvalidArgumentException('non-nullable legalStatus cannot be null');
        }
        $allowedValues = $this->getLegalStatusAllowableValues();
        if (!in_array($legalStatus, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'legalStatus', must be one of '%s'",
                    $legalStatus,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['legalStatus'] = $legalStatus;

        return $this;
    }

    /**
     * Gets firstName
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->container['firstName'];
    }

    /**
     * Sets firstName
     *
     * @param string|null $firstName Prénom du destinataire (envoi électronique seulement)
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        if (is_null($firstName)) {
            throw new \InvalidArgumentException('non-nullable firstName cannot be null');
        }
        if ((mb_strlen($firstName) > 50)) {
            throw new \InvalidArgumentException('invalid length for $firstName when calling RecipientUpdate., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($firstName) < 1)) {
            throw new \InvalidArgumentException('invalid length for $firstName when calling RecipientUpdate., must be bigger than or equal to 1.');
        }

        $this->container['firstName'] = $firstName;

        return $this;
    }

    /**
     * Gets lastName
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->container['lastName'];
    }

    /**
     * Sets lastName
     *
     * @param string|null $lastName Nom du destinataire (envoi électronique seulement)
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        if (is_null($lastName)) {
            throw new \InvalidArgumentException('non-nullable lastName cannot be null');
        }
        if ((mb_strlen($lastName) > 50)) {
            throw new \InvalidArgumentException('invalid length for $lastName when calling RecipientUpdate., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($lastName) < 1)) {
            throw new \InvalidArgumentException('invalid length for $lastName when calling RecipientUpdate., must be bigger than or equal to 1.');
        }

        $this->container['lastName'] = $lastName;

        return $this;
    }

    /**
     * Gets company
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->container['company'];
    }

    /**
     * Sets company
     *
     * @param string|null $company Société du destinataire (envoi électronique seulement)
     *
     * @return self
     */
    public function setCompany($company)
    {
        if (is_null($company)) {
            throw new \InvalidArgumentException('non-nullable company cannot be null');
        }
        if ((mb_strlen($company) > 38)) {
            throw new \InvalidArgumentException('invalid length for $company when calling RecipientUpdate., must be smaller than or equal to 38.');
        }
        if ((mb_strlen($company) < 0)) {
            throw new \InvalidArgumentException('invalid length for $company when calling RecipientUpdate., must be bigger than or equal to 0.');
        }

        $this->container['company'] = $company;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string|null $email Adresse email du destinataire
     *
     * @return self
     */
    public function setEmail($email)
    {
        if (is_null($email)) {
            throw new \InvalidArgumentException('non-nullable email cannot be null');
        }

        if ((!preg_match("/^[\\w]{1,}[\\w.+-]{0,}@[\\w-]{2,}([.][a-zA-Z]{2,}|[.][\\w-]{2,}[.][a-zA-Z]{2,})+$/", $email))) {
            throw new \InvalidArgumentException("invalid value for \$email when calling RecipientUpdate., must conform to the pattern /^[\\w]{1,}[\\w.+-]{0,}@[\\w-]{2,}([.][a-zA-Z]{2,}|[.][\\w-]{2,}[.][a-zA-Z]{2,})+$/.");
        }

        $this->container['email'] = $email;

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
     * @return string|null
     */
    public function getAddressLine6()
    {
        return $this->container['addressLine6'];
    }

    /**
     * Sets addressLine6
     *
     * @param string|null $addressLine6 Ligne d'adresse n°6 (Code postal et ville)
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
     * @return \MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode|null
     */
    public function getCountryCode()
    {
        return $this->container['countryCode'];
    }

    /**
     * Sets countryCode
     *
     * @param \MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode|null $countryCode countryCode
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
     * Gets documentsOverride
     *
     * @return \MailevaApiAdapter\App\Client\LrCoproClient\Model\ComposedDocument|null
     */
    public function getDocumentsOverride()
    {
        return $this->container['documentsOverride'];
    }

    /**
     * Sets documentsOverride
     *
     * @param \MailevaApiAdapter\App\Client\LrCoproClient\Model\ComposedDocument|null $documentsOverride documentsOverride
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


