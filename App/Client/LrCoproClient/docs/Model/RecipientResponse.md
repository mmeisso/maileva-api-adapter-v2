# # RecipientResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Identifiant du destinataire | [optional]
**customId** | **string** | Identifiant du destinataire fourni par le client | [optional]
**customData** | **string** | Information libre fournie par le client. | [optional]
**sendingMode** | **string** | Mode d&#39;envoi du destinataire. Il peut être papier, électronique ou passer par le service de consentement. Si le consentement est donné par le destinataire, le mode d&#39;envoi sera électronique, sinon il sera papier. | [optional]
**legalStatus** | **string** | Type de destinataire | [optional]
**firstName** | **string** | Prénom du destinataire | [optional]
**lastName** | **string** | Nom du destinataire | [optional]
**email** | **string** | Adresse email du destinataire | [optional]
**addressLine1** | **string** | Ligne d&#39;adresse n°1 (Société) | [optional]
**addressLine2** | **string** | Ligne d&#39;adresse n°2 (Civilité, Prénom, Nom) | [optional]
**addressLine3** | **string** | Ligne d&#39;adresse n°3 (Résidence, Bâtiement ...) | [optional]
**addressLine4** | **string** | Ligne d&#39;adresse n°4 (N° et libellé de la voie) | [optional]
**addressLine5** | **string** | Ligne d&#39;adresse n°5 (Lieu dit, BP...) | [optional]
**addressLine6** | **string** | Ligne d&#39;adresse n°6 (Code postal et ville) | [optional]
**countryCode** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\CountryCode**](CountryCode.md) |  | [optional]
**company** | **string** | Société du destinataire | [optional]
**status** | **string** | Statut du destinataire. &lt;table border&#x3D;\&quot;1\&quot;&gt; &lt;tr bgcolor&#x3D;\&quot;lightgrey\&quot;&gt; &lt;th&gt;Type de statut&lt;/th&gt; &lt;th&gt;Description&lt;/th&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;DRAFT&lt;/td&gt; &lt;td&gt;Ajout d’un destinataire à un envoi non soumis.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;PENDING&lt;/td&gt; &lt;td&gt;Le destinataire appartient à un envoi qui est en cours de validation.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;BLOCKED&lt;/td&gt; &lt;td&gt;Le destinataire appartient à un envoi qui est bloqué.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;ACCEPTED&lt;/td&gt; &lt;td&gt;Le destinataire a été accepté et sera produit.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;REJECTED&lt;/td&gt; &lt;td&gt;Le destinataire a été rejeté, ou appartient à un envoi qui a été rejet.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;CANCELED&lt;/td&gt; &lt;td&gt;Le destinataire appartient à un envoi qui a été annulé.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;PREPARING&lt;/td&gt; &lt;td&gt;Le destinataire est en train d&#39;être produit.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;PROCESSED&lt;/td&gt; &lt;td&gt;Le destinataire a été produit.&lt;/td&gt; &lt;/tr&gt; &lt;/table&gt; | [optional]
**statusDetail** | **string** | Détail d&#39;un statut (cause du rejet) | [optional]
**deliveryStatus** | **string** | statut de distribution. &lt;table border&#x3D;\&quot;1\&quot;&gt; &lt;tr bgcolor&#x3D;\&quot;lightgrey\&quot;&gt; &lt;th&gt;Type de statut&lt;/th&gt; &lt;th&gt;Description&lt;/th&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;DELIVERING&lt;/td&gt; &lt;td&gt;Le courrier de ce destinataire est en cours de distribution.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;ATTEMPTED_DELIVERY&lt;/td&gt; &lt;td&gt;Une tentative de remise du courrier au destinataire a été effectuée.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;DELIVERED&lt;/td&gt; &lt;td&gt;Le courrier a été est remis au destinataire.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;UNDELIVERED&lt;/td&gt; &lt;td&gt;Le courrier n&#39;a pas été remis au destinataire (statut définitif).&lt;/td&gt; &lt;tr&gt;  &lt;/table&gt; | [optional]
**deliveryStatusDetail** | **string** | Détail d&#39;un statut de distribution | [optional]
**statusDate** | **\DateTime** | Date du statut de l&#39;envoi | [optional]
**deliveryStatusDate** | **\DateTime** | Date du statut de distribution | [optional]
**finalSendingMode** | **string** | Mode d&#39;envoi final du destinataire. Si le consentement est donné par le destinataire, le mode d&#39;envoi final sera électronique, sinon il sera papier. | [optional]
**deliveryProof** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DeliveryProofResource**](DeliveryProofResource.md) |  | [optional]
**depositProof** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\DepositProofResource**](DepositProofResource.md) |  | [optional]
**documentsOverride** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ComposedDocument**](ComposedDocument.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
