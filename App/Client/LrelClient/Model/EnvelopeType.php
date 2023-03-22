<?php
/**
 * EnvelopeType
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

/**
 * EnvelopeType Class Doc Comment
 *
 * @category Class
 * @description Type de l&#39;envelope
 * @package  MailevaApiAdapter\App\Client\LrelClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class EnvelopeType
{
    /**
     * Possible values of this enum
     */
    public const DL = 'DL';

    public const C4 = 'C4';

    public const C6 = 'C6';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::DL,
            self::C4,
            self::C6
        ];
    }
}


