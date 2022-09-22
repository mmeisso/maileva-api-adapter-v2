<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:47
 */

namespace MailevaApiAdapter\App\Core;

use MailevaApiAdapter\App\Core\Http\Request\Method;

/**
 * Class Routing
 *
 * @package MailevaApiAdapter\App\Core
 */
class Routing
{

    const REQUIRED = "REQUIRED";
    /**
     * Permet d’obtenir un jeton d’authentification OAuth2 en utilisant le mode d’authentification Implicit Credentials.
     * Si l’identification de l’application (client_id) est réussie, l’utilisateur est redirigé vers la page d’authentification Maileva. Il est alors invité à saisir ces identifiants de connexion. Si ces identifiants sont corrects, il est alors redirigé vers l’application cliente d’origine où le token d’accès est passé dans le fragment de l’URL de redirection fournie en paramètre (redirect_uri).
     * Exemple d’url appelée en retour http://my-application.com/redirect_page#access_token=2YotnFZFEjr1zCsicMWpAA&expires_in=3600&state=123-dfd-fdd-fd1
     */
    const GET_AUTHENTICATION =
        [
            'authenticated_route' => false,
            'method'              => Method::GET,
            'url'                 => '/oauth2/authorize',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'body' => Routing::REQUIRED
            ],
        ];
    /**
     * Permet d’obtenir un jeton d’authentification OAuth2 utilisant le mode d’authentification Ressource Owner Password Credentials ou le mode Client Credentials.
     * Mode Ressource Owner Password Credentials Le paramètre grant_type doit être positionné à password. Les paramètres username et password sont obligatoires.
     * Mode Client Credentials Le paramètre grant_type doit être positionné à client_credentials. Les paramètres username et password ne sont pas requis.
     */
    const POST_AUTHENTICATION =
        [
            'authenticated_route' => false,
            'method'              => Method::POST,
            'url'                 => '/openid-connect/token',
            'headers'             => [
                'accept'        => 'application/json',
                'Authorization' => Routing::REQUIRED,
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'cache-control' => 'no-cache'
            ],
            'params'              => [
                'grant_type' => 'password',
                'username'   => Routing::REQUIRED,
                'password'   => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de créer un envoi.
     * Le champ obligatoire pour créer un envoi est le nom. Sont autorisés les majuscules, minuscules, caractères spéciaux et lettres accentuées. La longueur de champs est de 256 caractères maximum.
     */
    const POST_SENDING =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'body' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de créer un envoi.
     * Le champ obligatoire pour créer un envoi est le nom. Sont autorisés les majuscules, minuscules, caractères spéciaux et lettres accentuées. La longueur de champs est de 256 caractères maximum.
     */
    const GET_SENDINGS =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings',
            'headers'             => [
                'accept' => 'application/json',
            ],
            'params'              => [
                'start_index' => 1,
                'count'       => 1
            ],
        ];
    /**
     * Cette API permet de récupérer un envoi à partir de son identifiant.
     */
    const GET_SENDING_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}',
            'headers'             => [
                'accept' => 'application/json',
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de récupérer le status  d'envoi LRE à partir de son identifiant et de l'identifiant du destinataire.
     */
    const GET_SENDING_DELIVERY_STATUSES_BY_SENDING_ID_AND_RECIPIENT_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/recipients/{recipient_id}/delivery_statuses',
            'headers'             => [
                'accept' => 'application/json',
            ],
            'params'              => [
                'sending_id'   => Routing::REQUIRED,
                'recipient_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de supprimer un envoi.
     */
    const DELETE_SENDING_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::DELETE,
            'url'                 => '/sendings/{sending_id}',
            'headers'             => [
                'accept' => 'application/json',
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet d’ajouter un document à l’envoi.
     * Le document ajouté ne peut dépasser 20Mo.
     * Le document téléchargé se positionne en dernière position de la liste de documents.
     */
    const POST_DOCUMENT_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/documents',
            'headers'             => [
                'accept'  => 'application/json',
                'encType' => 'multipart/form-data'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'multipart'  => Routing::REQUIRED,
                //'document' => Routing::REQUIRED,
                //'metadata' => Routing::REQUIRED
            ],

        ];
    /**
     * Cette API permet de récupérer la liste des documents associés à l’envoi.
     * La liste des documents de l’envoi peut être paginée. Par défaut et au maximum, la pagination est de 30 résultats.
     */
    const GET_DOCUMENTS_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/documents',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id'  => Routing::REQUIRED,
                'start_index' => 1,
                'count'       => 1
            ]
        ];
    /**
     * Cette API permet d’ordonner les documents de l’envoi.
     * L’ordre des documents choisi sert de référence à l’opération de prévisualisation du courrier et à sa mise sous pli.
     */
    const POST_DOCUMENT_POSITION_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/documents/{document_id}/set_position',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id'  => Routing::REQUIRED,
                'document_id' => Routing::REQUIRED,
                'position'    => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet d’ajouter un document depuis la bibliothèque, à l’envoi.
     * Le document téléchargé se positionne en dernière position de la liste de documents.
     */
    const POST_DOCUMENT_FROM_LIBRARY =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/documents/import_from_library',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'file_id'    => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de supprimer un document d’un envoi.
     */
    const DELETE_DOCUMENT_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::DELETE,
            'url'                 => '/sendings/{sending_id}/documents/{document_id}',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id'  => Routing::REQUIRED,
                'document_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de récupérer le détail d’un document utilisé lors de l’envoi.
     */
    const GET_DOCUMENT_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/documents/{document_id}',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id'  => Routing::REQUIRED,
                'document_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet d’ajouter un ou plusieurs destinataire(s) à l’envoi.
     */
    const POST_RECIPIENT_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/recipients',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'body'       => Routing::REQUIRED
            ],
        ];
    /**
     * @deprecated
     * Cette API permet d’ajouter un ou plusieurs destinataire(s) à l’envoi de manière asynchrone.
     */
    const POST_IMPORT_RECIPIENTS_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/recipients/imports',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'body'       => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de connaitre l’état d’avancement des destinataire(s) importé(s).
     */
    const GET_IMPORT_RECIPIENTS_BY_SENDING_ID_AND_IMPORT_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/recipients/imports/{import_id}',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'import_id'  => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de récupérer la liste des destinataires de l’envoi.
     * Cette liste peut être paginée. Par défaut, la pagination est de 50 résultats. Elle peut atteindre 500 au maximum.
     */
    const GET_RECIPIENTS_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/recipients',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id'  => Routing::REQUIRED,
                'start_index' => 1,
                'count'       => 1
            ],
        ];
    /**
     * Cette API permet de supprimer tous les destinataires d’un envoi.
     */
    const DELETE_RECIPIENTS_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::DELETE,
            'url'                 => '/sendings/{sending_id}/recipients',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet d’ajouter un destinataire à l’envoi depuis le carnet d’adresses.
     */
    const POST_IMPORT_RECIPIENTS_BY_SENDING_ID_FROM_ADDRESS_BOOK =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/recipients/import_from_address_book',
            'headers'             => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'body'       => Routing::REQUIRED
            ],
        ];
    /**
     * Cette API permet de lister les données d’un destinataire d’un envoi.
     */
    const GET_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/recipients/{recipient_id}',
            'headers'             => [
                'accept' => 'application/json'
            ],
            'params'              => [
                'sending_id'   => Routing::REQUIRED,
                'recipient_id' => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de supprimer un destinataire d’un envoi.
     */
    const DELETE_RECIPIENT_BY_SENDING_ID_AND_RECIPIENT_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::DELETE,
            'url'                 => '/sendings/{sending_id}/recipients/{recipient_id}',
            'headers'             => [
                'accept' => 'application/json',
            ],
            'params'              => [
                'sending_id'   => Routing::REQUIRED,
                'recipient_id' => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de choisir les options liées à l’envoi d’un courrier :
     *
     * le mode d’envoi : rapide ou économique (rapide, par défaut),
     * le coloris d’impression : couleur ou noir et blanc (couleur, par défaut),
     * le format d’impression : recto ou recto-verso (recto-verso, par défaut),
     * l’ajout d’une page porte-adresse : oui /non,
     * la gestion électronique des PND (Plis Non Distribués) : oui ou non (non, par défaut),
     * le suivi des notifications par e-mail : l’adresse e-mail à renseigner à laquelle les notifications doivent être envoyées.
     */
    const PATCH_SENDING_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::PATCH,
            'url'                 => '/sendings/{sending_id}/options',
            'headers'             => [
                'accept'       => '*/*',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'body'       => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de choisir les options liées à l’envoi d’un courrier LRE:
     *
     * le mode d’envoi : rapide ou économique (rapide, par défaut),
     * le coloris d’impression : couleur ou noir et blanc (couleur, par défaut),
     * le format d’impression : recto ou recto-verso (recto-verso, par défaut),
     * l’ajout d’une page porte-adresse : oui /non,
     * la gestion électronique des PND (Plis Non Distribués) : oui ou non (non, par défaut),
     * le suivi des notifications par e-mail : l’adresse e-mail à renseigner à laquelle les notifications doivent être envoyées.
     */
    const PATCH_LRE_SENDING_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::PATCH,
            'url'                 => '/sendings/{sending_id}',
            'headers'             => [
                'accept'       => '*/*',
                'Content-Type' => 'application/json'
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'body'       => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de valider l’envoi et de déclencher ainsi la demande de production.
     */
    const POST_SENDING_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::POST,
            'url'                 => '/sendings/{sending_id}/submit',
            'headers'             => [
                'accept' => '*/*',
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de télécharger la preuve de dépot LRE.
     */
    const DOWNLOAD_DEPOSIT_PROOF_BY_SENDING_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/download_deposit_proof',
            'headers'             => [
                'accept' => '*/*',
            ],
            'params'              => [
                'sending_id' => Routing::REQUIRED,
                'sink'       => Routing::REQUIRED

            ],
        ];
    /**
     * Cette API permet de télécharger l'avis de réception de la LRE.
     */
    const DOWNLOAD_ACKNOWLEDGEMENT_OF_RECEIPT_BY_SENDING_ID_AND_RECIPIENT_ID =
        [
            'authenticated_route' => true,
            'method'              => Method::GET,
            'url'                 => '/sendings/{sending_id}/recipients/{recipient_id}/download_acknowledgement_of_receipt',
            'headers'             => [
                'accept' => '*/*',
            ],
            'params'              => [
                'sending_id'   => Routing::REQUIRED,
                'recipient_id' => Routing::REQUIRED,
                'sink'         => Routing::REQUIRED

            ],
        ];
}


