<?php
require_once(__DIR__ . '/vendor/autoload.php');

class CreateInventoryTask {

    function __construct() {}


    public function createInventoryTask($accessToken) {

        $config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);

        $apiInstance = new Ansas\Ebay\Api\InventoryTaskApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );
        $data = array(
            'schemaVersion' => '1.0',
            'feedType' => 'LMS_ACTIVE_INVENTORY_REPORT',
            'filterCriteria' => [
                'listingFormat' => 'FIXED_PRICE',
                'listingStatus' => 'ACTIVE'
                ]
        //      'inventoryFileTemplate' => 'InventoryFileTemplateEnum : STANDARD'
        );
        $createInventoryTaskRequest = new \Ansas\Ebay\Model\CreateInventoryTaskRequest($data); // \Ansas\Ebay\Model\CreateInventoryTaskRequest | The request payload containing the version, feedType, and optional filterCriteria.
        $xEBAYCMARKETPLACEID = 'EBAY_US'; // string | The ID of the eBay marketplace where the item is hosted. Note: This value is case sensitive. For example: X-EBAY-C-MARKETPLACE-ID:EBAY_US This identifies the eBay marketplace that applies to this task. See MarketplaceIdEnum.

        try {
            $response = $apiInstance->createInventoryTask($createInventoryTaskRequest, $xEBAYCMARKETPLACEID);
            $url = $response['location'][0];
            $task_id = str_replace('https://api.ebay.com/sell/feed/v1/task/', '', $url);
            return $task_id;
            // var_dump($response);
        } catch (Exception $e) {
            // echo 'Exception when calling InventoryTaskApi->createInventoryTask: ', $e->getMessage(), PHP_EOL;
            throw $e;
        }

    }
}
