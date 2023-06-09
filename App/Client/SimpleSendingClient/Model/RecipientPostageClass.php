<?php
/**
 * RecipientPostageClass
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\SimpleSendingClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Maileva / Envoi et Suivi de Courriers simples
 *
 * API pour envoyer et suivre des courriers postaux.  Elle comprend les fonctions clés pour :   - créer un envoi,  - ajouter des documents et des destinataires,  - choisir ses options,  - suivre la production.  Pour connaitre les notifications (webhooks) concernées par cette API, consultez la documentation de l'API \"notification_center\".
 *
 * The version of the OpenAPI document: 2.6
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.3.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\SimpleSendingClient\Model;
use \MailevaApiAdapter\App\Client\SimpleSendingClient\ObjectSerializer;

/**
 * RecipientPostageClass Class Doc Comment
 *
 * @category Class
 * @description Catégorie de l&#39;affranchissement
 * @package  MailevaApiAdapter\App\Client\SimpleSendingClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class RecipientPostageClass
{
    /**
     * Possible values of this enum
     */
    public const PRIORITY = 'PRIORITY';

    public const PRIORITY_INDUSTRIAL = 'PRIORITY_INDUSTRIAL';

    public const ECONOMY = 'ECONOMY';

    public const ECONOMY_INDUSTRIAL = 'ECONOMY_INDUSTRIAL';

    public const GREEN_LETTER = 'GREEN_LETTER';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::PRIORITY,
            self::PRIORITY_INDUSTRIAL,
            self::ECONOMY,
            self::ECONOMY_INDUSTRIAL,
            self::GREEN_LETTER
        ];
    }
}


