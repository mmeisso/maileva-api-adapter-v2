# # SendingCreation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**withHealthData** | **bool** | Cet envoi contient des données de santé.  Attention, vous devez posséder un droit spécifique pour utiliser cette option. Si vous n&#39;avez pas ce droit, votre envoi tombera en erreur. | [optional] [default to false]
**name** | **string** | Nom de l&#39;envoi | [optional]
**customId** | **string** | Identifiant de l&#39;envoi défini par le client | [optional]
**customData** | **string** | Information libre fournie par le client | [optional]
**colorPrinting** | **bool** | Impression couleur | [optional] [default to true]
**duplexPrinting** | **bool** | Impression recto verso | [optional] [default to true]
**optionalAddressSheet** | **bool** | Feuille porte adresse optionnelle | [optional] [default to false]
**notificationEmail** | **string** | E-mail du destinataire des notifications | [optional]
**printSenderAddress** | **bool** | Impression de l&#39;adresse expéditeur | [optional] [default to false]
**senderAddressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) de l&#39;expéditeur | [optional]
**senderAddressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) de l&#39;expéditeur | [optional]
**senderAddressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) de l&#39;expéditeur | [optional]
**senderAddressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) de l&#39;expéditeur | [optional]
**senderAddressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) de l&#39;expéditeur | [optional]
**senderAddressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) de l&#39;expéditeur | [optional]
**senderCountryCode** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\CountryCode**](CountryCode.md) |  | [optional]
**archivingDuration** | **int** | Durée d&#39;archivage en années | [optional] [default to self::ARCHIVING_DURATION_0]
**returnEnvelope** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\ReturnEnvelope**](ReturnEnvelope.md) |  | [optional]
**envelopeWindowsType** | **string** | enveloppe simple ou double fenêtre (si format DL) | [optional]
**postageType** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\PostageType**](PostageType.md) |  | [optional]
**treatUndeliveredMail** | **bool** | Gestion électronique des PND | [optional] [default to false]
**notificationTreatUndeliveredMail** | **string[]** | Liste des emails de notification des PND | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
