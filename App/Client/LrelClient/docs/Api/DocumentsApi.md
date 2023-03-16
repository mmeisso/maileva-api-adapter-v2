# MailevaApiAdapter\App\Client\LrelClient\DocumentsApi

All URIs are relative to https://api.sandbox.maileva.net/registered_mail/v2, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**sendingsSendingIdDocumentsDocumentIdDelete()**](DocumentsApi.md#sendingsSendingIdDocumentsDocumentIdDelete) | **DELETE** /sendings/{sending_id}/documents/{document_id} | Suppression d&#39;un document |
| [**sendingsSendingIdDocumentsDocumentIdGet()**](DocumentsApi.md#sendingsSendingIdDocumentsDocumentIdGet) | **GET** /sendings/{sending_id}/documents/{document_id} | Détail d&#39;un document |
| [**sendingsSendingIdDocumentsDocumentIdSetPriorityPost()**](DocumentsApi.md#sendingsSendingIdDocumentsDocumentIdSetPriorityPost) | **POST** /sendings/{sending_id}/documents/{document_id}/set_priority | Classement des documents |
| [**sendingsSendingIdDocumentsGet()**](DocumentsApi.md#sendingsSendingIdDocumentsGet) | **GET** /sendings/{sending_id}/documents | Liste des documents d&#39;un envoi |
| [**sendingsSendingIdDocumentsPost()**](DocumentsApi.md#sendingsSendingIdDocumentsPost) | **POST** /sendings/{sending_id}/documents | Ajout d&#39;un document à l&#39;envoi. |


## `sendingsSendingIdDocumentsDocumentIdDelete()`

```php
sendingsSendingIdDocumentsDocumentIdDelete($sendingId, $documentId)
```

Suppression d'un document

Permet de supprimer un document d'un envoi.

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


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$documentId = 'documentId_example'; // string | Identifiant du document

try {
    $apiInstance->sendingsSendingIdDocumentsDocumentIdDelete($sendingId, $documentId);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->sendingsSendingIdDocumentsDocumentIdDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **documentId** | **string**| Identifiant du document | |

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

## `sendingsSendingIdDocumentsDocumentIdGet()`

```php
sendingsSendingIdDocumentsDocumentIdGet($sendingId, $documentId): \MailevaApiAdapter\App\Client\LrelClient\Model\DocumentResponse
```

Détail d'un document

Permet de récupérer le détail d'un document utilisé lors de l'envoi.

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


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$documentId = 'documentId_example'; // string | Identifiant du document

try {
    $result = $apiInstance->sendingsSendingIdDocumentsDocumentIdGet($sendingId, $documentId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->sendingsSendingIdDocumentsDocumentIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **documentId** | **string**| Identifiant du document | |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\DocumentResponse**](../Model/DocumentResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdDocumentsDocumentIdSetPriorityPost()`

```php
sendingsSendingIdDocumentsDocumentIdSetPriorityPost($sendingId, $documentId, $priority)
```

Classement des documents

Permet d'ordonner les documents d'un envoi.  Les documents seront imprimés et mis sous pli dans l'ordre choisi.

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


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$documentId = 'documentId_example'; // string | Identifiant du document
$priority = new \MailevaApiAdapter\App\Client\LrelClient\Model\Priority(); // \MailevaApiAdapter\App\Client\LrelClient\Model\Priority

try {
    $apiInstance->sendingsSendingIdDocumentsDocumentIdSetPriorityPost($sendingId, $documentId, $priority);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->sendingsSendingIdDocumentsDocumentIdSetPriorityPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **documentId** | **string**| Identifiant du document | |
| **priority** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\Priority**](../Model/Priority.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdDocumentsGet()`

```php
sendingsSendingIdDocumentsGet($sendingId, $startIndex, $count): \MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsResponse
```

Liste des documents d'un envoi

Permet de récupérer la liste des documents associés à l'envoi. La liste des documents d'un envoi peut être paginée. Par défaut et au maximum, la pagination est de 30 résultats.

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


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$startIndex = 1; // float | Le premier élément à retourner
$count = 30; // float | Le nombre d'élément à retourner

try {
    $result = $apiInstance->sendingsSendingIdDocumentsGet($sendingId, $startIndex, $count);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->sendingsSendingIdDocumentsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **startIndex** | **float**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **float**| Le nombre d&#39;élément à retourner | [optional] [default to 30] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsResponse**](../Model/DocumentsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdDocumentsPost()`

```php
sendingsSendingIdDocumentsPost($sendingId, $document, $metadata): \MailevaApiAdapter\App\Client\LrelClient\Model\DocumentResponse
```

Ajout d'un document à l'envoi.

Permet d'ajouter un document à l'envoi. Les types de documents autorisés sont :   - Adobe (.pdf)   - Word (.doc, .docx et .rtf)   - Texte (.txt)   - Excel (.xls, .xlsx)  Le document ajouté ne doit pas dépasser 20 Mo. Le nombre total de documents est limité à 30 par envoi. Le document doit être transmis en mutipart ainsi que la metadata. La metadata est constituée de *priority* (permet de définir l'ordre d'impression des documents) et de *name* (permet de donner un nom au fichier). La première page du document est positionné systématiquement sur le recto de la feuille.  Le  nombre de feuille d’un envoi ne doit pas dépasser la capacité de l’enveloppe    - Enveloppe grand format C4 (210x300 mm, Double fenêtre) : 45 feuilles maximum (hors feuille porte-adresse, enveloppe retour incluse)    - Enveloppe petit format DL (114x229 mm Simple ou Double-fenêtre) : 5 feuilles maximum (feuille porte-adresse et enveloppe retour incluses)

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


$apiInstance = new MailevaApiAdapter\App\Client\LrelClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$document = "/path/to/file.txt"; // \SplFileObject
$metadata = new \MailevaApiAdapter\App\Client\LrelClient\Model\SendingsSendingIdDocumentsGetRequestMetadata(); // \MailevaApiAdapter\App\Client\LrelClient\Model\SendingsSendingIdDocumentsGetRequestMetadata

try {
    $result = $apiInstance->sendingsSendingIdDocumentsPost($sendingId, $document, $metadata);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->sendingsSendingIdDocumentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **document** | **\SplFileObject****\SplFileObject**|  | [optional] |
| **metadata** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\SendingsSendingIdDocumentsGetRequestMetadata**](../Model/SendingsSendingIdDocumentsGetRequestMetadata.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrelClient\Model\DocumentResponse**](../Model/DocumentResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
