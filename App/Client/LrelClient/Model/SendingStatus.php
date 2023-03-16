<?php
/**
 * SendingStatus
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
use \MailevaApiAdapter\App\Client\LrelClient\ObjectSerializer;

/**
 * SendingStatus Class Doc Comment
 *
 * @category Class
 * @description Statut d&#39;un envoi : &lt;table border&#x3D;1&gt;   &lt;tr&gt;     &lt;td&gt;DRAFT&lt;/td&gt;     &lt;td&gt;L&#39;envoi est au statut de brouillon, non validé par l’utilisateur&lt;/td&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;PENDING&lt;/td&gt;     &lt;td&gt;Le client a fait un envoi, mais il n’a pas encore été analysé par le système ou l&#39;envoi a été reçu mais il n’a pas encore été analysé&lt;/td&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;ACCEPTED&lt;/td&gt;     &lt;td&gt;L&#39;envoi a été accepté et il sera traité&lt;/td&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;REJECTED&lt;/td&gt;     &lt;td&gt;L&#39;envoi est refusé&lt;/td&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;PROCESSED&lt;/td&gt;     &lt;td&gt;L&#39;envoi a été traité et tous les destinataires étaient valides&lt;/td&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;PROCESSED_WITH_ERRORS&lt;/td&gt;     &lt;td&gt;L&#39;envoi a été traité mais certains destinataires n’étaient pas valides&lt;/td&gt;   &lt;/tr&gt; &lt;/table&gt;
 * @package  MailevaApiAdapter\App\Client\LrelClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class SendingStatus
{
    /**
     * Possible values of this enum
     */
    public const DRAFT = 'DRAFT';

    public const PENDING = 'PENDING';

    public const ACCEPTED = 'ACCEPTED';

    public const REJECTED = 'REJECTED';

    public const PROCESSED = 'PROCESSED';

    public const PROCESSED_WITH_ERRORS = 'PROCESSED_WITH_ERRORS';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::DRAFT,
            self::PENDING,
            self::ACCEPTED,
            self::REJECTED,
            self::PROCESSED,
            self::PROCESSED_WITH_ERRORS
        ];
    }
}


