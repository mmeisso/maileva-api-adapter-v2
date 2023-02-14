# # DeliveryStatusesResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**deliveryStatuses** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\DeliveryStatusesResponseDeliveryStatusesInner[]**](DeliveryStatusesResponseDeliveryStatusesInner.md) | Dans le cadre d&#39;un envoi de courrier simple, seule l&#39;option gestion des PND (plis non distribuables) peut faire l&#39;objet d&#39;un statut de distribution. - N : Numérisé &lt;table border&#x3D;\&quot;1\&quot;&gt;   &lt;tr bgcolor&#x3D;\&quot;lightgrey\&quot;&gt;     &lt;th&gt;Code&lt;/th&gt;     &lt;th&gt;Source&lt;/th&gt;     &lt;th&gt;Description&lt;/th&gt;   &lt;/tr&gt;   &lt;tr&gt;     &lt;td&gt;N10&lt;/td&gt;     &lt;td&gt;Maileva&lt;/td&gt;     &lt;td&gt;PND (Pli Non Distribuable) pour un courrier&lt;/td&gt;   &lt;/tr&gt; &lt;/table&gt; | [optional]
**paging** | [**\MailevaApiAdapter\App\Client\SimpleSendingClient\Model\PagingResponse**](PagingResponse.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
