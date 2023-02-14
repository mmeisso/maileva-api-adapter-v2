# MailevaApiAdapter\App\Client\SimpleSendingClient\EnvoiApi

All URIs are relative to https://api.sandbox.maileva.net/mail/v2, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**sendingsGet()**](EnvoiApi.md#sendingsGet) | **GET** /sendings | Liste des envois |
| [**sendingsPost()**](EnvoiApi.md#sendingsPost) | **POST** /sendings | Création d&#39;un envoi |
| [**sendingsSendingIdDelete()**](EnvoiApi.md#sendingsSendingIdDelete) | **DELETE** /sendings/{sending_id} | Suppression d&#39;un envoi |
| [**sendingsSendingIdGet()**](EnvoiApi.md#sendingsSendingIdGet) | **GET** /sendings/{sending_id} | Détail d&#39;un envoi |
| [**sendingsSendingIdPatch()**](EnvoiApi.md#sendingsSendingIdPatch) | **PATCH** /sendings/{sending_id} | Modification partielle d&#39;un envoi |
| [**sendingsSendingIdSubmitPost()**](EnvoiApi.md#sendingsSendingIdSubmitPost) | **POST** /sendings/{sending_id}/submit | Finalisation d&#39;un envoi |


## `sendingsGet()`

```php
sendingsGet($startIndex, $count): \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingsResponse
```

Liste des envois

Permet d'obtenir la liste des envois.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$startIndex = 1; // float | Le premier élément à retourner
$count = 50; // float | Le nombre d'élément à retourner

try {
    $result = $apiInstance->sendingsGet($startIndex, $count);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **startIndex** | **float**| Le premier élément à retourner | [optional] [default to 1] |
| **count** | **float**| Le nombre d&#39;élément à retourner | [optional] [default to 50] |

### Return type

[**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingsResponse**](../Model/SendingsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsPost()`

```php
sendingsPost($sendingCreation): \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse
```

Création d'un envoi

Permet de créer un envoi. Cet envoi sera en état de brouillon (DRAFT), il faudra soummettre cet envoi pour qu'il soit envoyé en production.  Les principales options sont : - Le coloris d'impression : couleur ou noir et blanc, - Le format d'impression : recto-verso ou recto seul, - L'ajout d'une page porte-adresse, - Le type d'enveloppe est choisi automatiquement. 1 à 5 feuilles (feuille porte-adresse et enveloppe retour incluses) : enveloppe DL. 6 à 45 feuilles (hors feuille porte-adresse, enveloppe retour incluse) : enveloppe C4. - Le type de fenêtre sur l'enveloppe : simple ou double fenêtre - Le type d'affranchissement : rapide ou économique - e-mail de notification, - Impression de l'adresse expéditeur, - Durée d'archivage : 0 an, 1 an, 3 ans, 6 ans ou 10 ans - gestion électronique des plis non distribuables (PND) - ajout d'une enveloppe retour

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingCreation = new \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingCreation(); // \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingCreation

try {
    $result = $apiInstance->sendingsPost($sendingCreation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingCreation** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingCreation**](../Model/SendingCreation.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdDelete()`

```php
sendingsSendingIdDelete($sendingId)
```

Suppression d'un envoi

Permet de supprimer un envoi.  Seuls les envois en état de brouillon (DRAFT) peuvent être supprimés.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi

try {
    $apiInstance->sendingsSendingIdDelete($sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsSendingIdDelete: ', $e->getMessage(), PHP_EOL;
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

## `sendingsSendingIdGet()`

```php
sendingsSendingIdGet($sendingId): \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse
```

Détail d'un envoi

Permet de récupérer le détail d'un envoi à partir de son identifiant.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi

try {
    $result = $apiInstance->sendingsSendingIdGet($sendingId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsSendingIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |

### Return type

[**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdPatch()`

```php
sendingsSendingIdPatch($sendingId, $sendingUpdate): \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse
```

Modification partielle d'un envoi

Permet de modifier un envoi.  Seuls les envois en état de brouillon (DRAFT) peuvent être modifiés.  Seuls les paramètres pour lesquels une valeur est fournie sont modifiés.  Si votre système ne permet pas d'utiliser le verbe PATCH, il est possible d'utiliser le verbe POST.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi
$sendingUpdate = new \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingUpdate(); // \MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingUpdate

try {
    $result = $apiInstance->sendingsSendingIdPatch($sendingId, $sendingUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsSendingIdPatch: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sendingId** | **string**| Identifiant d&#39;un envoi | |
| **sendingUpdate** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingUpdate**](../Model/SendingUpdate.md)|  | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\SendingResponse**](../Model/SendingResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth), [oAuth2PasswordProduction](../../README.md#oAuth2PasswordProduction), [oAuth2PasswordSandbox](../../README.md#oAuth2PasswordSandbox)

### HTTP request headers

- **Content-Type**: `application/merge-patch+json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendingsSendingIdSubmitPost()`

```php
sendingsSendingIdSubmitPost($sendingId)
```

Finalisation d'un envoi

Permet de soumettre l'envoi et de déclencher ainsi la demande de production.  Un envoi soumis ne peut pas être annulé.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerAuth
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordProduction
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: oAuth2PasswordSandbox
$config = MailevaApiAdapter\App\Client\SimpleSendingClient\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new MailevaApiAdapter\App\Client\SimpleSendingClient\Api\EnvoiApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sendingId = 'sendingId_example'; // string | Identifiant d'un envoi

try {
    $apiInstance->sendingsSendingIdSubmitPost($sendingId);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiApi->sendingsSendingIdSubmitPost: ', $e->getMessage(), PHP_EOL;
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
