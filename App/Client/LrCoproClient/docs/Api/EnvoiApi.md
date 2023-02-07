# MailevaApiAdapter\App\Client\LrCoproClient\EnvoiApi

All URIs are relative to https://api.maileva.com/real_estate/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**checkSending()**](EnvoiApi.md#checkSending) | **POST** /sendings/{sending_id}/check | Vérification de l&#39;envoi avant soumission |
| [**createSending()**](EnvoiApi.md#createSending) | **POST** /sendings | Création d&#39;un envoi |
| [**deleteSending()**](EnvoiApi.md#deleteSending) | **DELETE** /sendings/{sending_id} | Suppression d&#39;un envoi |
| [**findSendings()**](EnvoiApi.md#findSendings) | **GET** /sendings | Liste des envois |
| [**getCheckSending()**](EnvoiApi.md#getCheckSending) | **GET** /sendings/{sending_id}/check | Liste des envois vérifiés avant soumission |
| [**getSending()**](EnvoiApi.md#getSending) | **GET** /sendings/{sending_id} | Détail d&#39;un envoi |
| [**getSubmitSending()**](EnvoiApi.md#getSubmitSending) | **GET** /sendings/{sending_id}/submit | Contrôle l&#39;état d&#39;un envoi après soumission |
| [**submitSending()**](EnvoiApi.md#submitSending) | **POST** /sendings/{sending_id}/submit | Finalisation d&#39;un envoi |
| [**updateSending()**](EnvoiApi.md#updateSending) | **PATCH** /sendings/{sending_id} | Modification des options d&#39;envoi |


## `checkSending()`

```php
checkSending($authorization, $sendingId)
```

Vérification de l'envoi avant soumission

Permet de vérifier l'envoi avant soumission (asynchrone).  Cette vérification est à réaliser systématiquement au moment du SUBMIT de l'envoi.  Il est nécessaire d'indiquer un canal d'envoi (SENDING MODE) - Lettre Recommandé (REGISTERED_MAIL) - Electronique (ELECTRONIC_NOTICE) - Consentement (USE_CONSENT), le canal étant défini en fonction du consentement donné par le destinataire  En fonction du canal d'envoi défini, des informations d'envoi et destinataires sont nécessaires.  __Informations d'envoi obligatoires pour les envois papiers  :__  - Le format d'impression : recto-verso ou recto seul - Durée d'archivage optionnelle : 0 an, 3, 6 ou 10 ans - gestion électronique des plis non distribuables (PND) - informations liées à l'expediteur  __Informations destinataires pour un envoi papier :__ - address_line_1 - address_line_2 - address_line_3 - address_line_4 - address_line_5 - address_line_6  Chaque ligne d’adresse doit contenir au plus 38 caractères.  La ligne d’adresse 1 ou 2 doit être définie obligatoirement. La ligne d’adresse 6 doit être définie obligatoirement. Pour les adresses françaises, la ligne d’adresse 6 doit contenir un code postal sur 5 chiffres, suivi d’un espace, suivi d’une ville.  __Informations d'envoi obligatoires pour les envois électroniques :__  - Objet de la notification qui sera envoyée au destinataire - Message personnalisé - Complément d'information afin de rajouter une mention libre juste après le nom et prénom (ou société) de l’expéditeur.   __Informations destinataires  pour un envoi électronique :__ - Legal status - first_name - last_name - company - email  Seul le champs \"société\" est facultatif, les autres étant obligatoires.   Pour les envois passant par le consentement des destinataires, l'ensemble des champs sont nécessaires afin de pouvoir effectuer l'envoi en version papier ou en version électonique.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->checkSending($authorization, $sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->checkSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createSending()`

```php
createSending($authorization, $sendingCreation): \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse
```

Création d'un envoi

Permet de créer un envoi. Cet envoi sera en état de brouillon (statut DRAFT), il est donc nécessaire de soummettre l'envoi afin qu'il soit envoyé en production.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingCreation = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingCreation(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingCreation | Nouvel envoi

try {
    $result = $apiInstance->createSending($authorization, $sendingCreation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->createSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingCreation** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingCreation**](../Model/SendingCreation.md)| Nouvel envoi | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteSending()`

```php
deleteSending($sendingId)
```

Suppression d'un envoi

Permet de supprimer un envoi.  Seuls les envois en état de brouillon (DRAFT) peuvent être supprimés.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->deleteSending($sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->deleteSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `findSendings()`

```php
findSendings($authorization, $startIndex, $count, $sort, $desc): \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingsResponse
```

Liste des envois

Permet d'obtenir la liste des envois. Il est possible de rajouter un attribut dans les paramètres afin de filtrer la liste des envois. La liste des envois peut être paginée. Par défaut, la pagination est de 50 résultats. Elle peut être modifiée pour atteindre jusqu'à 500 résultats.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$startIndex = 1; // int | Le premier élément à retourner
$count = 50; // int | Le nombre d'élément à retourner
$sort = 'sort_example'; // string
$desc = 'desc_example'; // string

try {
    $result = $apiInstance->findSendings($authorization, $startIndex, $count, $sort, $desc);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->findSendings: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **startIndex** | **int**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **int**| Le nombre d&#39;élément à retourner | [optional] [default to 50] |
| **sort** | **string**|  | [optional] |
| **desc** | **string**|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingsResponse**](../Model/SendingsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getCheckSending()`

```php
getCheckSending($authorization, $sendingId)
```

Liste des envois vérifiés avant soumission

Permet de connaitre l'état du contrôle de l'envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->getCheckSending($authorization, $sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->getCheckSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSending()`

```php
getSending($sendingId): \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse
```

Détail d'un envoi

Permet de récupérer le détail d'un envoi à partir de son identifiant.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $result = $apiInstance->getSending($sendingId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->getSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSubmitSending()`

```php
getSubmitSending($authorization, $sendingId)
```

Contrôle l'état d'un envoi après soumission

Permet de connaitre l'état du contrôle de l'envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->getSubmitSending($authorization, $sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->getSubmitSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `submitSending()`

```php
submitSending($authorization, $sendingId)
```

Finalisation d'un envoi

Permet de soumettre l'envoi (asynchrone) et déclencher ainsi la demande de production.  Un envoi soumis ne peut pas être annulé.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->submitSending($authorization, $sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->submitSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateSending()`

```php
updateSending($authorization, $sendingId, $sendingUpdate): \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse
```

Modification des options d'envoi

Permet de modifier les options liées à un envoi.  Seuls les envois en état de brouilon (DRAFT) peuvent être modifiés.  Seuls les paramètres pour lesquels une valeur est fournie sont modifiés.  Si votre système ne permet pas d'utiliser le verbe PATCH, il est possible d'utiliser le verbe POST.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$sendingUpdate = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingUpdate(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingUpdate

try {
    $result = $apiInstance->updateSending($authorization, $sendingId, $sendingUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->updateSending: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **sendingUpdate** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingUpdate**](../Model/SendingUpdate.md)|  | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
