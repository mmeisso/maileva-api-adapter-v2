# # RecipientResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Identifiant du destinataire |
**customId** | **string** | Identifiant du destinataire fourni par le client | [optional]
**customData** | **string** | Information libre fournie par le client | [optional]
**addressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) | [optional]
**addressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) | [optional]
**addressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) | [optional]
**addressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) | [optional]
**addressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) | [optional]
**addressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) |
**countryCode** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\CountryCode**](CountryCode.md) |  |
**documentsOverride** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\DocumentsOverrideItem[]**](DocumentsOverrideItem.md) | Liste de bribes de documents. Si ce champ n&#39;est pas renseigné,  le destinataire recevra tous les documents associé à l&#39;envoi.  Si ce champ est renseigné, le destinataire recevra la liste de  bribes de documents indiquées (dans l&#39;ordre des éléments du tableau). | [optional]
**status** | [**\MailevaApiAdapter\App\Client\LrelClient\Model\RecipientStatus**](RecipientStatus.md) |  |
**statusDetail** | **string** | Détail d&#39;un statut (cause du rejet) | [optional]
**lastDeliveryStatus** | **string** | Dernier statut de distribution | [optional]
**lastDeliveryStatusDate** | **string** | Date du dernier statut de distribution | [optional]
**postagePrice** | **float** | Coût de l&#39;affranchissement en euros | [optional]
**registeredNumber** | **string** | Numéro de recommandé | [optional]
**archiveDate** | **\DateTime** | Date d&#39;archivage du pli | [optional]
**archiveUrl** | **string** | URL de l&#39;archive du pli | [optional]
**acknowledgementOfReceiptArchiveDate** | **\DateTime** | Date d&#39;archivage de l&#39;avis de réception (AR) | [optional]
**acknowledgementOfReceiptUrl** | **string** | URL de l&#39;archive de l&#39;avis de réception | [optional]
**pagesCount** | **int** | Nombre de pages. Ce nombre de pages inclut l&#39;éventuelle page porte-adresse (payante ou obligatoire) mais n&#39;inclut pas les pages blanches ajoutées au verso par Maileva. | [optional]
**billedPagesCount** | **int** | Nombre de pages facturées (disponible à partir du statut ACCEPTED). Ce nombre de pages inclut la page porte-adresse payante (DL) mais n&#39;inclut pas la page porte-adresse obligatoire (C4) ni les pages blanches ajoutées au verso par Maileva. | [optional]
**sheetsCount** | **int** | Nombre de feuilles (disponible à partir du statut ACCEPTED). Ce nombre de feuilles inclut la page porte-adresse éventuelle (payante ou obligatoire). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
