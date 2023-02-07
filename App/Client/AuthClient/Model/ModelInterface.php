<?php
/**
 * ModelInterface
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  MailevaApiAdapter\App\Client\AuthClient\Model
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Maileva / Authentification
 *
 * # Description générale     L'authentification aux API Maileva est régie par un serveur d'authentification centrale qui implémente le protocole OAuth2. Le serveur d'authentification délivre des jetons d'accès (*token*). La présente documentation décrit les différentes méthodes pour obetnir un jeton.      Ensuite, lors des appels aux API Maileva, ce jeton d'accès devra être envoyé dans l'entête HTTP Authorization de la requête de la manière suivante :  ```sh Authorization: Bearer <access_token> ```   # Identification des applications clientes    Pour qu'une application cliente (Site web, application mobile, partenaire) puisse interroger et authentifier des utilisateurs, elle doit s'enregistrer auprès de Maileva afin de pouvoir appeler (au nom de l'utilisateur connecté) les API. Maileva fournit alors un jeu d'identifiants *client_id*, *client_secret* qui permettra à l'application d'être identifiée auprès du serveur OAuth2.  # Les modes d'authentification OAuth2 Le protocole OAuth2 prévoit plusieurs modes d'authentification, appelés *grant_type*, suivant les cas d'utilisation.  - Ressource Owner Password Credentials grant_type : ce mode est basé sur un appel serveur à serveur (machine-2-machine ou m2m) sans aucune IHM ni jeu de redirection (l'utilisateur n'étant pas forcément derrière un navigateur). Ce mode est conçu principalement pour des applications riches (dans lesquelles les redirections web ne sont pas évidentes) ou encore pour des applications souhaitant proposer leur propre IHM ou une page d'authentification autre que celle du serveur d'authentification OAuth2 Maileva. Ce mode d'authentification nécessite une qualification de la part de Maileva pour être accessible. Cette authentification s'utilise en appelant la méthode `POST /oauth2/token`  - Client Credentials grant_type : ce mode peut s'assimiler à l'authentification classique par login et mot de passe (Basic Auth par exemple). Ce mode est adapté aux applications accédant à leurs propres ressources. L'utilisateur et l'application cliente se confondent. Ce mode d'authentification nécessite une qualification de la part de Maileva pour être accessible. Cette authentification s'utilise en appelant la méthode `POST /oauth2/token`    # Format du jeton    Le jeton d'accès retourné par l'application d'authentification est au format JWT ([JSON Web Token](https://jwt.io/)).      Le format et la taille de ce jeton est succeptible d'évoluer.    # Références    OAuth2 RFC-6749 : https://tools.ietf.org/html/rfc6749      OAuth2 portal : https://oauth.net/2/      Comprendre OAuth2 : http://www.bubblecode.net/fr/2016/01/22/comprendre-oauth2/      jwt.io : https://jwt.io/
 *
 * The version of the OpenAPI document: 2.0
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.3.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MailevaApiAdapter\App\Client\AuthClient\Model;

/**
 * Interface abstracting model access.
 *
 * @package MailevaApiAdapter\App\Client\AuthClient\Model
 * @author  OpenAPI Generator team
 */
interface ModelInterface
{
    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName();

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes();

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats();

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     *
     * @return array
     */
    public static function attributeMap();

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters();

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters();

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array
     */
    public function listInvalidProperties();

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool
     */
    public function valid();

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool;

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool;
}
