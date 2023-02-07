# MailevaApiAdapter\App\Client\LrCoproClient\DestinatairesApi

All URIs are relative to https://api.maileva.com/real_estate/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createRecipient()**](DestinatairesApi.md#createRecipient) | **POST** /sendings/{sending_id}/recipients | Ajout d&#39;un destinataire à l&#39;envoi |
| [**deleteAllRecipients()**](DestinatairesApi.md#deleteAllRecipients) | **DELETE** /sendings/{sending_id}/recipients | Suppression de tous les destinataires |
| [**deleteRecipient()**](DestinatairesApi.md#deleteRecipient) | **DELETE** /sendings/{sending_id}/recipients/{recipient_id} | Suppression d&#39;un destinataire |
| [**downloadDeliveryProof()**](DestinatairesApi.md#downloadDeliveryProof) | **GET** /sendings/{sending_id}/recipients/{recipient_id}/download_delivery_proof | Télécharger le justificatif de réception du destinataire (accusé de reception, refus ou non réclamation) |
| [**downloadDepositProof()**](DestinatairesApi.md#downloadDepositProof) | **GET** /sendings/{sending_id}/recipients/{recipient_id}/download_deposit_proof | Télécharger la preuve de dépot du destinataire |
| [**getRecipient()**](DestinatairesApi.md#getRecipient) | **GET** /sendings/{sending_id}/recipients/{recipient_id} | Détail d&#39;un destinataire |
| [**getRecipients()**](DestinatairesApi.md#getRecipients) | **GET** /sendings/{sending_id}/recipients | Liste des destinataires d&#39;un envoi |
| [**updateRecipient()**](DestinatairesApi.md#updateRecipient) | **PATCH** /sendings/{sending_id}/recipients/{recipient_id} | Modification partielle d&#39;un destinataire |


## `createRecipient()`

```php
createRecipient($authorization, $sendingId, $recipientCreation): \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse
```

Ajout d'un destinataire à l'envoi

Permet d'ajouter un destinataire à l'envoi. Le nombre de destinataires est limité à 30 000. Les documents ajoutés pour un envoi ne doivent pas dépasser 200 feuilles au total.          Il est nécessaire d'indiquer un canal d'envoi (SENDING MODE) - Lettre Recommandé (REGISTERED_MAIL) - Electronique (ELECTRONIC_NOTICE) - Consentement (USE_CONSENT), le canal étant défini en fonction du consentement donné par le destinataire  En fonction du canal d'envoi défini, des informations destinataires sont nécessaires.  __Informations destinataires pour le sending_mode \"REGISTERED_MAIL\" :__ - address_line_1 - address_line_2 - address_line_3 - address_line_4 - address_line_5 - address_line_6  Chaque ligne d’adresse doit contenir au plus 38 caractères.  La ligne d’adresse 1 ou 2 doit être définie obligatoirement. La ligne d’adresse 6 doit être définie obligatoirement. Pour les adresses françaises, la ligne d’adresse 6 doit contenir un code postal sur 5 chiffres, suivi d’un espace, suivi d’une ville.  __Informations destinataires  pour le sending_mode \"ELECTRONIC_NOTICE\" :__ - Legal status - first_name - last_name - company - email  Seul le champs \"société\" est facultatif, les autres étant obligatoires.   Pour les destinataires passant par le mode d'envoi \"USE_CONSENT\" les champs obligatoires des destinataires papier et electronique sont à définir.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientCreation = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientCreation(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientCreation | Nouveau destinataire

try {
    $result = $apiInstance->createRecipient($authorization, $sendingId, $recipientCreation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->createRecipient: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientCreation** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientCreation**](../Model/RecipientCreation.md)| Nouveau destinataire | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteAllRecipients()`

```php
deleteAllRecipients($authorization, $sendingId)
```

Suppression de tous les destinataires

Permet de supprimer tous les destinataires d'un envoi. Disponible pour les envois en statut Draft seulement.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi

try {
    $apiInstance->deleteAllRecipients($authorization, $sendingId);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->deleteAllRecipients: ', $e->getMessage(), PHP_EOL;
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

## `deleteRecipient()`

```php
deleteRecipient($authorization, $sendingId, $recipientId)
```

Suppression d'un destinataire

Permet de supprimer un destinataire d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $apiInstance->deleteRecipient($authorization, $sendingId, $recipientId);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->deleteRecipient: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

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

## `downloadDeliveryProof()`

```php
downloadDeliveryProof($sendingId, $recipientId): string
```

Télécharger le justificatif de réception du destinataire (accusé de reception, refus ou non réclamation)

Permet de télécharger au format PDF le justificatif de réception du destinataire. Pour les envois papiers, il est nécessaire d'utiliser l'option \"acknowledgement_of_receipt_scanning\" afin que l'AR soit numérisé et disponible depuis cet url. Si l'option n'est pas activée, l'expéditeur reçoit son AR en version papier.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->downloadDeliveryProof($sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->downloadDeliveryProof: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/pdf`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `downloadDepositProof()`

```php
downloadDepositProof($authorization, $sendingId, $recipientId): string
```

Télécharger la preuve de dépot du destinataire

Permet de télécharger la preuve de dépôt du destinataire. Seules les preuves de dépôt des envois électronique sont disponibles. Concernant le papier, les preuves de dépôt sont transmises à l'expéditeur par recommandé papier.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->downloadDepositProof($authorization, $sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->downloadDepositProof: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/pdf`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getRecipient()`

```php
getRecipient($authorization, $sendingId, $recipientId): \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse
```

Détail d'un destinataire

Permet de lister les données d'un destinataire d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->getRecipient($authorization, $sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->getRecipient: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getRecipients()`

```php
getRecipients($authorization, $sendingId, $startIndex, $count, $sort, $desc): \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientsResponse
```

Liste des destinataires d'un envoi

Permet de récupérer la liste des destinataires d'un envoi. Cette liste peut être paginée. Par défaut, la pagination est de 50 résultats. Elle peut atteindre 500 au maximum.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string
$startIndex = 1; // int | Le premier élément à retourner
$count = 50; // int | Le nombre d'élément à retourner
$sort = 'sort_example'; // string
$desc = 'desc_example'; // string

try {
    $result = $apiInstance->getRecipients($authorization, $sendingId, $startIndex, $count, $sort, $desc);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->getRecipients: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**|  | |
| **startIndex** | **int**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **int**| Le nombre d&#39;élément à retourner | [optional] [default to 50] |
| **sort** | **string**|  | [optional] |
| **desc** | **string**|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientsResponse**](../Model/RecipientsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateRecipient()`

```php
updateRecipient($authorization, $sendingId, $recipientId, $recipientUpdate): \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse
```

Modification partielle d'un destinataire

Permet de modifier partiellement un destinataire

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire
$recipientUpdate = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientUpdate(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientUpdate

try {
    $result = $apiInstance->updateRecipient($authorization, $sendingId, $recipientId, $recipientUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->updateRecipient: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |
| **recipientUpdate** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientUpdate**](../Model/RecipientUpdate.md)|  | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
