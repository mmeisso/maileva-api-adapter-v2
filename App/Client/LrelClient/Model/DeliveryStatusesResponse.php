<?php
/**
 * DeliveryStatusesResponse
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
 * DeliveryStatusesResponse Class Doc Comment
 *
 * @category Class
 * @description Liste des statuts de distribution
 * @package  MailevaApiAdapter\App\Client\LrelClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class DeliveryStatusesResponse implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'delivery_statuses_response';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'deliveryStatuses' => '\MailevaApiAdapter\App\Client\LrelClient\Model\DeliveryStatusesResponseDeliveryStatusesInner[]',
        'paging' => '\MailevaApiAdapter\App\Client\LrelClient\Model\PagingResponse'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'deliveryStatuses' => null,
        'paging' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'deliveryStatuses' => false,
		'paging' => false
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
        'deliveryStatuses' => 'delivery_statuses',
        'paging' => 'paging'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'deliveryStatuses' => 'setDeliveryStatuses',
        'paging' => 'setPaging'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'deliveryStatuses' => 'getDeliveryStatuses',
        'paging' => 'getPaging'
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
        $this->setIfExists('deliveryStatuses', $data ?? [], null);
        $this->setIfExists('paging', $data ?? [], null);
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
     * Gets deliveryStatuses
     *
     * @return \MailevaApiAdapter\App\Client\LrelClient\Model\DeliveryStatusesResponseDeliveryStatusesInner[]|null
     */
    public function getDeliveryStatuses()
    {
        return $this->container['deliveryStatuses'];
    }

    /**
     * Sets deliveryStatuses
     *
     * @param \MailevaApiAdapter\App\Client\LrelClient\Model\DeliveryStatusesResponseDeliveryStatusesInner[]|null $deliveryStatuses Les différents statuts sont décrit dans un tableau suivant.    Il y a 2 types de suivi :     - suivi de production, jusqu'à la remise en poste     - suivi de distribution sui commence à la remise en poste jusqu'à la remise au destinataire (ou le retour à l'expéditeur    NB : le staut de distribution inclut également le cas de la numérisation par   nos services de l'Avis de Réception d'un recommandé ou des Plis Non   Distriubuables (PND).    - A : Acheminement   - P : Présentation   - D : Distribution   - N : Numérisé  <table border=\"1\">   <tr bgcolor=\"lightgrey\">     <th>Code</th>     <th>Source</th>     <th>Description</th>   </tr>   <tr>     <td>A01</td>     <td>La Poste</td>     <td>Pris en charge</td>   </tr>   <tr>     <td>A02</td>     <td>La Poste</td>     <td>Avisé</td>   </tr>   <tr>     <td>A03</td>     <td>La Poste</td>     <td>Départ de France</td>   </tr>   <tr>     <td>A04</td>     <td>La Poste</td>     <td>Arrivée</td>   </tr>   <tr>     <td>A05</td>     <td>La Poste</td>     <td>Tentative de distribution infructueuse</td>   </tr>   <tr>     <td>A06</td>     <td>La Poste</td>     <td>Dépôt</td>   </tr>   <tr>     <td>A07</td>     <td>La Poste</td>     <td>Départ</td>   </tr>   <tr>     <td>A08</td>     <td>La Poste</td>     <td>Arrivée en France</td>   </tr>   <tr>     <td>A09</td>     <td>La Poste</td>     <td>Attente douane / dédouanement</td>   </tr>   <tr>     <td>A10</td>     <td>La Poste</td>     <td>Dédouané, distribution en cours</td>   </tr>   <tr>     <td>A11</td>     <td>La Poste</td>     <td>Renvoyé vers la bonne destination</td>   </tr>   <tr>     <td>A12</td>     <td>La Poste</td>     <td>Renvoyé vers la bonne destination suite à correction de l'adresse par La Poste</td>   </tr>   <tr>     <td>A13</td>     <td>La Poste</td>     <td>Pli manquant au dépôt</td>   </tr>   <tr>     <td>A14</td>     <td>La Poste</td>     <td>Non distribuable pour cause de dépassement du délai de mise à disposition du recommandé en ligne</td>   </tr>   <tr>     <td>A15</td>     <td>La Poste</td>     <td>Non distribuable en attente d'un contact client auprès du service Consommateurs</td>   </tr>   <tr>     <td>A16</td>     <td>La Poste</td>     <td>Non distribuable pour cause de refus par le destinataire</td>   </tr>   <tr>     <td>A17</td>     <td>La Poste</td>     <td>Non distribuable délai de conservation expiré (CGV)</td>   </tr>   <tr>     <td>A18</td>     <td>La Poste</td>     <td>Non distribuable - refus</td>   </tr>   <tr>     <td>A19</td>     <td>La Poste</td>     <td>Non distribuable</td>   </tr>   <tr>     <td>A20</td>     <td>La Poste</td>     <td>En cours de traitement</td>   </tr>   <tr>     <td>A21</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause d'accès à la boîte aux lettres impossible</td>   </tr>   <tr>     <td>A22</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause de boîte aux lettres non identifiable</td>   </tr>   <tr>     <td>A23</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause d'adresse incorrecte</td>   </tr>   <tr>     <td>A24</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur suite à des recherches de La Poste</td>   </tr>   <tr>     <td>A25</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur sur demande de l'expéditeur</td>   </tr>   <tr>     <td>A26</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur</td>   </tr>   <tr>     <td>A27</td>     <td>La Poste</td>     <td>Renvoyé vers la bonne destination sur demande de l'expéditeur</td>   </tr>   <tr>     <td>P01</td>     <td>La Poste</td>     <td>Attend d'être retiré au guichet</td>   </tr>   <tr>     <td>P02</td>     <td>La Poste</td>     <td>En attente de seconde présentation</td>   </tr>   <tr>     <td>P03</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause de dépassement de délai d'instance</td>   </tr>   <tr>     <td>P04</td>     <td>La Poste</td>     <td>Retour à l'expéditeur - refus</td>   </tr>   <tr>     <td>P05</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause de refus à l'adresse</td>   </tr>   <tr>     <td>P06</td>     <td>La Poste</td>     <td>Retourné à l'expéditeur pour cause de refus de paiement</td>   </tr>   <tr>     <td>D01</td>     <td>La Poste</td>     <td>Distribué</td>   </tr>   <tr>     <td>N01</td>     <td>Maileva</td>     <td>AR Signé : RAR distribué</td>   </tr>   <tr>     <td>N02</td>     <td>Maileva</td>     <td>PND (Pli Non Distribuable) pour une LR</td>   </tr>   <tr>     <td>N03</td>     <td>Maileva</td>     <td>Non réclamé</td>   </tr>   <tr>     <td>N04</td>     <td>Maileva</td>     <td>Décédé</td>   </tr>   <tr>     <td>N05</td>     <td>Maileva</td>     <td>Refusé</td>   </tr>   <tr>     <td>N06</td>     <td>Maileva</td>     <td>Impossibilité de signer</td>   </tr>   <tr>     <td>N07</td>     <td>Maileva</td>     <td>Adresse incomplète</td>   </tr>   <tr>     <td>N08</td>     <td>Maileva</td>     <td>Refus détérioré</td>   </tr>   <tr>     <td>N09</td>     <td>Maileva</td>     <td>Régime international</td>   </tr>   <tr>     <td>N10</td>     <td>Maileva</td>     <td>PND (Pli Non Distribuable) pour un courrier</td>   </tr> </table>
     *
     * @return self
     */
    public function setDeliveryStatuses($deliveryStatuses)
    {
        if (is_null($deliveryStatuses)) {
            throw new \InvalidArgumentException('non-nullable deliveryStatuses cannot be null');
        }
        $this->container['deliveryStatuses'] = $deliveryStatuses;

        return $this;
    }

    /**
     * Gets paging
     *
     * @return \MailevaApiAdapter\App\Client\LrelClient\Model\PagingResponse|null
     */
    public function getPaging()
    {
        return $this->container['paging'];
    }

    /**
     * Sets paging
     *
     * @param \MailevaApiAdapter\App\Client\LrelClient\Model\PagingResponse|null $paging paging
     *
     * @return self
     */
    public function setPaging($paging)
    {
        if (is_null($paging)) {
            throw new \InvalidArgumentException('non-nullable paging cannot be null');
        }
        $this->container['paging'] = $paging;

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


