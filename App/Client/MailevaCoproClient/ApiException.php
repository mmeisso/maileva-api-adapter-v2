<?php
/**
 * ApiException
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

namespace MailevaApiAdapter\App\Client\MailevaCoproClient;

use \Exception;

/**
 * ApiException Class Doc Comment
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\MailevaCoproClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ApiException extends Exception
{
    /**
     * The HTTP body of the server response either as Json or string.
     *
     * @var \stdClass|string|null
     */
    protected $responseBody;

    /**
     * The HTTP header of the server response.
     *
     * @var string[]|null
     */
    protected $responseHeaders;

    /**
     * The deserialized response object
     *
     * @var \stdClass|string|null
     */
    protected $responseObject;

    /**
     * Constructor
     *
     * @param string                $message         Error message
     * @param int                   $code            HTTP status code
     * @param string[]|null         $responseHeaders HTTP response header
     * @param \stdClass|string|null $responseBody    HTTP decoded body of the server response either as \stdClass or string
     */
    public function __construct($message = "", $code = 0, $responseHeaders = [], $responseBody = null, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

    /**
     * Gets the HTTP response header
     *
     * @return string[]|null HTTP response header
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Gets the HTTP body of the server response either as Json or string
     *
     * @return \stdClass|string|null HTTP body of the server response either as \stdClass or string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Sets the deserialized response object (during deserialization)
     *
     * @param mixed $obj Deserialized response object
     *
     * @return void
     */
    public function setResponseObject($obj)
    {
        $this->responseObject = $obj;
    }

    /**
     * Gets the deserialized response object (during deserialization)
     *
     * @return mixed the deserialized response object
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }
}
