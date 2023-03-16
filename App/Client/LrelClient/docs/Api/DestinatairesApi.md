# MailevaApiAdapter\App\Client\LrelClient\DestinatairesApi

All URIs are relative to https://api.sandbox.maileva.net/registered_mail/v2, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**patchRecipient()**](DestinatairesApi.md#patchRecipient) | **PATCH** /sendings/{sending_id}/recipients/{recipient_id} | Modification partielle d&#39;un destinataire |
| [**sendingsSendingIdRecipientsDelete()**](DestinatairesApi.md#sendingsSendingIdRecipientsDelete) | **DELETE** /sendings/{sending_id}/recipients | Suppression de tous les destinataires |
| [**sendingsSendingIdRecipientsGet()**](DestinatairesApi.md#sendingsSendingIdRecipientsGet) | **GET** /sendings/{sending_id}/recipients | Liste des destinataires d&#39;un envoi |
| [**sendingsSendingIdRecipientsImportsPost()**](DestinatairesApi.md#sendingsSendingIdRecipientsImportsPost) | **POST** /sendings/{sending_id}/recipients/imports | Ajout d&#39;un ou de plusieurs destinataires à un envoi |
| [**sendingsSendingIdRecipientsPost()**](DestinatairesApi.md#sendingsSendingIdRecipientsPost) | **POST** /sendings/{sending_id}/recipients | Ajout d&#39;un destinataire à l&#39;envoi |
| [**sendingsSendingIdRecipientsRecipientIdDelete()**](DestinatairesApi.md#sendingsSendingIdRecipientsRecipientIdDelete) | **DELETE** /sendings/{sending_id}/recipients/{recipient_id} | Suprression d&#39;un destinataire |
| [**sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet()**](DestinatairesApi.md#sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet) | **GET** /sendings/{sending_id}/recipients/{recipient_id}/delivery_statuses | Liste des statuts de distribution d&#39;un destinataire |
| [**sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet()**](DestinatairesApi.md#sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet) | **GET** /sendings/{sending_id}/recipients/{recipient_id}/download_acknowledgement_of_receipt | Télécharger l&#39;avis de réception archivé du destinataire |
| [**sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet()**](DestinatairesApi.md#sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet) | **GET** /sendings/{sending_id}/recipients/{recipient_id}/download_archive | Téléchargement du courrier envoyé au destinataire |
| [**sendingsSendingIdRecipientsRecipientIdGet()**](DestinatairesApi.md#sendingsSendingIdRecipientsRecipientIdGet) | **GET** /sendings/{sending_id}/recipients/{recipient_id} | Détail d&#39;un destinataire |


## `patchRecipient()`

```php
patchRecipient($sendingId, $recipientId, $recipientCreation): \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse
```

Modification partielle d'un destinataire

Permet de modifier partiellement un destinataire

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire
$recipientCreation = new \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation(); // \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation

try {
    $result = $apiInstance->patchRecipient($sendingId, $recipientId, $recipientCreation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->patchRecipient: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |
| **recipientCreation** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation**](../Model/RecipientCreation.md)|  | |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsDelete()`

```php
sendingsSendingIdRecipientsDelete($sendingId)
```

Suppression de tous les destinataires

Permet de supprimer tous les destinataires d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi

try {
    $apiInstance->sendingsSendingIdRecipientsDelete($sendingId);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |

### Return type

void (empty response body)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsGet()`

```php
sendingsSendingIdRecipientsGet($sendingId, $startIndex, $count): \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientsResponse
```

Liste des destinataires d'un envoi

Permet de récupérer la liste des destinataires d'un envoi. Cette liste peut être paginée. Par défaut, la pagination est de 50 résultats. Elle peut atteindre 500 au maximum.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$startIndex = 1; // float | Le premier élément à retourner
$count = 50; // float | Le nombre d'élément à retourner

try {
    $result = $apiInstance->sendingsSendingIdRecipientsGet($sendingId, $startIndex, $count);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **startIndex** | **float**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **float**| Le nombre d&#39;élément à retourner | [optional] [default to 50] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientsResponse**](../Model/RecipientsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsImportsPost()`

```php
sendingsSendingIdRecipientsImportsPost($sendingId, $importRecipients): \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientsImportResponse
```

Ajout d'un ou de plusieurs destinataires à un envoi

Permet d'ajouter un ou plusieurs destinataires à un envoi. Le nombre de destinataires à l'importation est limité à 5000.  Chaque ligne d’adresse doit contenir au plus 38 caractères. La ligne d’adresse 1 ou 2 doit être définie. La ligne d’adresse 6 doit être définie. Pour les adresses françaises, la ligne d’adresse 6 doit contenir  un code postal sur 5 chiffres, suivi d’un espace, suivi d’une ville.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$importRecipients = new \MailevaApiAdapter\App\Client\LrelClient\Model\ImportRecipients(); // \MailevaApiAdapter\App\Client\LrelClient\Model\ImportRecipients

try {
    $result = $apiInstance->sendingsSendingIdRecipientsImportsPost($sendingId, $importRecipients);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsImportsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **importRecipients** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\ImportRecipients**](../Model/ImportRecipients.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientsImportResponse**](../Model/RecipientsImportResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsPost()`

```php
sendingsSendingIdRecipientsPost($sendingId, $recipientCreation): \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse
```

Ajout d'un destinataire à l'envoi

Permet d'ajouter un destinataire à l'envoi.  Le nombre de destinataires est limité à 5000.   Chaque ligne d’adresse doit contenir au plus 38 caractères. La ligne d’adresse 1 ou 2 doit être définie. La ligne d’adresse 6 doit être définie.  Pour les adresses françaises, la ligne d’adresse 6 doit contenir un code  postal sur 5 chiffres, suivi d’un espace, suivi d’une ville.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientCreation = new \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation(); // \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation

try {
    $result = $apiInstance->sendingsSendingIdRecipientsPost($sendingId, $recipientCreation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientCreation** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientCreation**](../Model/RecipientCreation.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsRecipientIdDelete()`

```php
sendingsSendingIdRecipientsRecipientIdDelete($sendingId, $recipientId)
```

Suprression d'un destinataire

Permet de supprimer un destinataire d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $apiInstance->sendingsSendingIdRecipientsRecipientIdDelete($sendingId, $recipientId);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsRecipientIdDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

void (empty response body)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet()`

```php
sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet($sendingId, $recipientId, $startIndex, $count): \MailevaApiAdapter\App\Client\LrelClient\Model\DeliveryStatusesResponse
```

Liste des statuts de distribution d'un destinataire

Permet de lister les statuts de distribution d'un destinataire.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire
$startIndex = 1; // float | Le premier élément à retourner
$count = 50; // float | Le nombre d'élément à retourner

try {
    $result = $apiInstance->sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet($sendingId, $recipientId, $startIndex, $count);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsRecipientIdDeliveryStatusesGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |
| **startIndex** | **float**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **float**| Le nombre d&#39;élément à retourner | [optional] [default to 50] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\DeliveryStatusesResponse**](../Model/DeliveryStatusesResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet()`

```php
sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet($sendingId, $recipientId): \SplFileObject
```

Télécharger l'avis de réception archivé du destinataire

Cette API permet de télécharger au format PDF l'avis de réception archivé du destinataire.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet($sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsRecipientIdDownloadAcknowledgementOfReceiptGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

**\SplFileObject**

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/zip`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet()`

```php
sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet($sendingId, $recipientId): \SplFileObject
```

Téléchargement du courrier envoyé au destinataire

Permet de télécharger au format PDF le courrier envoyé au destinataire.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet($sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsRecipientIdDownloadArchiveGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

**\SplFileObject**

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/zip`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdRecipientsRecipientIdGet()`

```php
sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId): \MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse
```

Détail d'un destinataire

Permet d'obtenir le détail d'un destinataire d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\LrelClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DestinatairesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$recipientId = 'recipientId_example'; // string | Identifiant du destinataire

try {
    $result = $apiInstance->sendingsSendingIdRecipientsRecipientIdGet($sendingId, $recipientId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DestinatairesApi->sendingsSendingIdRecipientsRecipientIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **recipientId** | **string**| Identifiant du destinataire | |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientResponse**](../Model/RecipientResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
