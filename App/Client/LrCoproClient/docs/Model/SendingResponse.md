# # SendingResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** |  | [optional]
**name** | **string** | Nom de l&#39;envoi |
**customId** | **string** | Identifiant de l&#39;envoi défini par le client | [optional]
**customData** | **string** | Information libre fournie par le client. | [optional]
**registeredMailOptions** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\RegisteredMailOptions**](RegisteredMailOptions.md) |  | [optional]
**electronicNoticeOptions** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ElectronicNoticeOptions**](ElectronicNoticeOptions.md) |  | [optional]
**status** | **string** | Statut d&#39;un envoi : &lt;table border&#x3D;\&quot;1\&quot;&gt; &lt;tr bgcolor&#x3D;\&quot;lightgrey\&quot;&gt; &lt;th&gt;Type de statut&lt;/th&gt; &lt;th&gt;Description&lt;/th&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;DRAFT&lt;/td&gt; &lt;td&gt;L&#39;envoi est au statut de brouillon, non validé par l’utilisateur&lt;/td&gt; &lt;/tr&gt; &lt;td&gt;PENDING&lt;/td&gt; &lt;td&gt;Le client a fait un envoi, mais il n’a pas encore été analysé par le système ou l&#39;envoi a été reçu mais il n’a pas encore été analysé&lt;/td&gt; &lt;/tr&gt; &lt;/tr&gt; &lt;td&gt;BLOCKED&lt;/td&gt; &lt;td&gt;L&#39;envoi est bloqué pour problème de paiement. Il sera automatiquement débloqué une fois le paiement régularisé.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;ACCEPTED&lt;/td&gt; &lt;td&gt;L&#39;envoi est compatible avec nos critères de validation et va être traité.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;REJECTED&lt;/td&gt; &lt;td&gt;L&#39;envoi est rejeté et ne peut être traité (exemple : incompatibilité d&#39;options, de document, paiement...)&lt;/td&gt; &lt;/tr&gt; &lt;/tr&gt; &lt;td&gt;CANCELED&lt;/td&gt; &lt;td&gt;L’envoi a été annulé par l&#39;utilisateur.&lt;/td&gt; &lt;/tr&gt; &lt;/tr&gt; &lt;td&gt;PREPARING&lt;/td&gt; &lt;td&gt;L’envoi est en cours de production.&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;PROCESSED&lt;/td&gt; &lt;td&gt;L&#39;envoi a été traité et tous les destinataires étaient valides&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;PROCESSED_WITH_ERRORS&lt;/td&gt; &lt;td&gt;L&#39;envoi a été traité mais certains destinataires n’étaient pas valides&lt;/td&gt; &lt;/tr&gt; &lt;/table&gt; | [optional]
**orderId** | **string** | Identifiant interne Maileva de la commande. | [optional]
**orderReference** | **string** | Reference interne Maileva de la commande. | [optional]
**submissionDate** | **\DateTime** | Date et heure de soumission | [optional]
**processedDate** | **\DateTime** | Date et heure de production | [optional]
**archiveDate** | **\DateTime** | Date et heure d&#39;archivage&#39; | [optional]
**createdBy** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ByModel**](ByModel.md) |  | [optional]
**modifiedBy** | [**\MailevaApiAdapter\App\Client\LrCoproClient\Model\ByModel**](ByModel.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
