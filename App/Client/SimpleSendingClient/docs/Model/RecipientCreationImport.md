# # RecipientCreationImport

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**correlationId** | **string** | Identifiant du destinataire pour la référence | [optional]
**customId** | **string** | Identifiant du destinataire fourni par le client | [optional]
**customData** | **string** | Information libre fournie par le client | [optional]
**addressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) | [optional]
**addressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) | [optional]
**addressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) | [optional]
**addressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) | [optional]
**addressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) | [optional]
**addressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) |
**countryCode** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\CountryCode**](CountryCode.md) |  |
**documentsOverride** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\DocumentsOverrideItem[]**](DocumentsOverrideItem.md) | Liste de bribes de documents. Si ce champ n&#39;est pas renseigné,  le destinataire recevra tous les documents associé à l&#39;envoi.  Si ce champ est renseigné, le destinataire recevra la liste de  bribes de documents indiquées (dans l&#39;ordre des éléments du tableau). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
