# MailevaApiAdapter\App\Client\AuthClient\AuthApi

All URIs are relative to https://connexion.maileva.com/auth/realms/services/protocol/openid-connect, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**tokenPost()**](AuthApi.md#tokenPost) | **POST** /token |  |


## `tokenPost()`

```php
tokenPost($authorization, $grantType, $username, $password): \MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse
```



Permet d'obtenir un jeton d'authentification OAuth2 utilisant le mode d'authentification `Ressource Owner Password Credentials` ou le mode `Client Credentials`.  Mode `Ressource Owner Password Credentials` Le paramètre *grant_type* doit être positionné à *password*. Les paramètres *username* et *password* sont obligatoires.  Mode `Client Credentials` Le paramètre *grant_type* doit être positionné à *client_credentials*. Les paramètres *username* et *password* ne sont pas requis.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new MailevaApiAdapter\App\Client\AuthClient\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = 'authorization_example'; // string | Identifiant de l'application et son mot de passe. De la forme Basic base64(client_id:client_secret)
$grantType = 'grantType_example'; // string | Mode d’authentification
$username = 'username_example'; // string | Identifiant de l’utilisateur Maileva
$password = 'password_example'; // string | Mot de passe de l’utilisateur

try {
    $result = $apiInstance->tokenPost($authorization, $grantType, $username, $password);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->tokenPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Identifiant de l&#39;application et son mot de passe. De la forme Basic base64(client_id:client_secret) | |
| **grantType** | **string**| Mode d’authentification | |
| **username** | **string**| Identifiant de l’utilisateur Maileva | [optional] |
| **password** | **string**| Mot de passe de l’utilisateur | [optional] |

### Return type

[**\MailevaApiAdapter\App\Client\AuthClient\Model\TokenResponse**](../Model/TokenResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/x-www-form-urlencoded`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
