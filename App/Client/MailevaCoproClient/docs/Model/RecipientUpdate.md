# # RecipientUpdate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**customId** | **string** | Identifiant du destinataire fourni par le client | [optional]
**customData** | **string** | Information libre fournie par le client. | [optional]
**sendingMode** | **string** | Mode d&#39;envoi du destinataire. Il peut être papier, électronique ou passer par le service de consentement. Si le consentement est donné par le destinataire, le mode d&#39;envoi sera électronique, sinon il sera papier. | [optional]
**legalStatus** | **string** | Type de destinataire | [optional]
**firstName** | **string** | Prénom du destinataire (envoi électronique seulement) | [optional]
**lastName** | **string** | Nom du destinataire (envoi électronique seulement) | [optional]
**company** | **string** | Société du destinataire (envoi électronique seulement) | [optional]
**email** | **string** | Adresse email du destinataire | [optional]
**addressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) | [optional]
**addressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) | [optional]
**addressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) | [optional]
**addressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) | [optional]
**addressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) | [optional]
**addressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) | [optional]
**countryCode** | [**\MailevaApiAdapter\App\Client\MailevaCoproClient\Model\CountryCode**](CountryCode.md) |  | [optional]
**documentsOverride** | [**\MailevaApiAdapter\App\Client\MailevaCoproClient\Model\ComposedDocument**](ComposedDocument.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
