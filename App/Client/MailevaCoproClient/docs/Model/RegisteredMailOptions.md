# # RegisteredMailOptions

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**duplexPrinting** | **bool** | Impression recto verso | [optional] [default to true]
**archivingDuration** | **int** | Durée d&#39;archivage optionnelle pour envoi papier (en années). Par défaut, elle est à 0. | [optional] [default to self::ARCHIVING_DURATION_0]
**acknowledgementOfReceiptScanning** | **bool** | Gestion électronique des avis de réception (AR). Cette option indique que Maileva doit recevoir, numériser, mettre en ligne l’image et archiver physiquement les Avis de Réception. Pour cela, la première ligne de l’adresse de l’expéditeur sera conservée, mais les 5 autres lignes et le pays seront remplacés par l’adresse de Maileva. Cette option nécessite que l’option avis de réception soit activée. | [optional] [default to false]
**senderAddressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) de l&#39;expéditeur |
**senderAddressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) de l&#39;expéditeur | [optional]
**senderAddressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) de l&#39;expéditeur | [optional]
**senderAddressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) de l&#39;expéditeur | [optional]
**senderAddressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) de l&#39;expéditeur | [optional]
**senderAddressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) de l&#39;expéditeur |
**senderCountryCode** | [**\MailevaApiAdapter\App\Client\MailevaCoproClient\Model\CountryCode**](CountryCode.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
