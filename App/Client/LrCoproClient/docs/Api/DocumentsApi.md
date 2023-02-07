# MailevaApiAdapter\App\Client\LrCoproClient\DocumentsApi

All URIs are relative to https://api.maileva.com/real_estate/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createDocument()**](DocumentsApi.md#createDocument) | **POST** /sendings/{sending_id}/documents | Ajout d&#39;un document à l&#39;envoi. |
| [**deleteDocument()**](DocumentsApi.md#deleteDocument) | **DELETE** /sendings/{sending_id}/documents/{document_id} | Suppression d&#39;un document |
| [**getDocument()**](DocumentsApi.md#getDocument) | **GET** /sendings/{sending_id}/documents/{document_id} | Détail d&#39;un document |
| [**getDocuments()**](DocumentsApi.md#getDocuments) | **GET** /sendings/{sending_id}/documents | Liste des documents d&#39;un envoi |
| [**updateDocument()**](DocumentsApi.md#updateDocument) | **PATCH** /sendings/{sending_id}/documents/{document_id} | Modification des metadata d&#39;un document |


## `createDocument()`

```php
createDocument($authorization, $sendingId, $document, $metadata): \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse
```

Ajout d'un document à l'envoi.

Permet d'ajouter un document à l'envoi.  Les documents autorisés sont les documents imprimables - PDF - doc(x) - xls(x) - txt  Les documents ajoutés pour un envoi ne doivent pas dépasser 50Mo au total. Le nombre total de documents est limité à 30.   Les documents ajoutés pour un envoi ne doivent pas être inférieur à 4 feuilles et ne doivent pas dépasser 200 feuilles au total (page porte adresse comprise).  Dans le cas ou l'option recto est activée, le nombre de page minimum est de 4 et le nombre maximum de page est limité à 199 (hors page porte adresse).  Dans le cas ou l'option recto/verso est activée, le nombre de page minimum est de 7 et le nombre maximum de page est limité à 398 (hors page porte adresse).   Le document doit être transmis en mutipart ainsi que la metadata. La metadata est constituée de priority (permet de définir l'ordre de priorité des documents dans l'envoi), de name (permet de donner un nom au fichier) et adjust (permet d'ajuster la taille).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$document = "/path/to/file.txt"; // \SplFileObject
$metadata = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentCreationMetadata(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentCreationMetadata

try {
    $result = $apiInstance->createDocument($authorization, $sendingId, $document, $metadata);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->createDocument: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **document** | **\SplFileObject****\SplFileObject**|  | |
| **metadata** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentCreationMetadata**](../Model/DocumentCreationMetadata.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse**](../Model/DocumentResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteDocument()`

```php
deleteDocument($authorization, $sendingId, $documentId)
```

Suppression d'un document

Permet de supprimer un document d'un envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$documentId = 'documentId_example'; // string | Identifiant du document

try {
    $apiInstance->deleteDocument($authorization, $sendingId, $documentId);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->deleteDocument: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **documentId** | **string**| Identifiant du document | |

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

## `getDocument()`

```php
getDocument($authorization, $sendingId, $documentId): \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse
```

Détail d'un document

Permet de récupérer le détail d'un document utilisé lors de l'envoi.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$documentId = 'documentId_example'; // string | Identifiant du document

try {
    $result = $apiInstance->getDocument($authorization, $sendingId, $documentId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->getDocument: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **documentId** | **string**| Identifiant du document | |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse**](../Model/DocumentResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getDocuments()`

```php
getDocuments($authorization, $sendingId, $startIndex, $count, $sort, $desc): \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentsResponse
```

Liste des documents d'un envoi

Permet de récupérer la liste des documents associés à l'envoi. La liste des documents d'un envoi peut être paginée. Par défaut et au maximum, la pagination est de 30 résultats.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$startIndex = 1; // int | Le premier élément à retourner
$count = 30; // int | Le nombre d'élément à retourner
$sort = 'sort_example'; // string
$desc = 'desc_example'; // string

try {
    $result = $apiInstance->getDocuments($authorization, $sendingId, $startIndex, $count, $sort, $desc);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->getDocuments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **startIndex** | **int**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **int**| Le nombre d&#39;élément à retourner | [optional] [default to 30] |
| **sort** | **string**|  | [optional] |
| **desc** | **string**|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentsResponse**](../Model/DocumentsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateDocument()`

```php
updateDocument($authorization, $sendingId, $documentId, $metadata): \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse
```

Modification des metadata d'un document

Permet de modifier les metadata d'un document (priority, name, adjust)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\LrCoproClient\Api\DocumentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Bearer {access_token}
$sendingId = 'sendingId_example'; // string | Identifiant de l'envoi
$documentId = 'documentId_example'; // string | Identifiant du document
$metadata = new \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentUpdateMetadata(); // \MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentUpdateMetadata

try {
    $result = $apiInstance->updateDocument($authorization, $sendingId, $documentId, $metadata);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DocumentsApi->updateDocument: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Bearer {access_token} | |
| **sendingId** | **string**| Identifiant de l&#39;envoi | |
| **documentId** | **string**| Identifiant du document | |
| **metadata** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentUpdateMetadata**](../Model/DocumentUpdateMetadata.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DocumentResponse**](../Model/DocumentResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
