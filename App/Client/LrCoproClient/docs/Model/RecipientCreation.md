# # RecipientCreation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sendingMode** | **string** | Mode d&#39;envoi du destinataire. Il peut être papier, électronique ou passer par le service de consentement. Si le consentement est donné par le destinataire, le mode d&#39;envoi sera électronique, sinon il sera papier. |
**customId** | **string** | Identifiant du destinataire fourni par le client. | [optional]
**customData** | **string** | Information libre fournie par le client. | [optional]
**registeredMailDetail** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RegisteredMailDetail**](RegisteredMailDetail.md) |  | [optional]
**electronicNoticeDetail** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ElectronicNoticeDetail**](ElectronicNoticeDetail.md) |  | [optional]
**documentsOverride** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ComposedDocument**](ComposedDocument.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
