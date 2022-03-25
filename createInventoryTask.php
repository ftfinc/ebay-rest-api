<?php
require_once(__DIR__ . '/vendor/autoload.php');

$setting = require 'configuration.php';
// print($setting['sandbox']['authToken']);

// Configure OAuth2 access token for authorization: api_auth
$config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($setting['sandbox']['authToken']);


$apiInstance = new Ansas\Ebay\Api\InventoryTaskApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$createInventoryTaskRequest = new \Ansas\Ebay\Model\CreateInventoryTaskRequest(); // \Ansas\Ebay\Model\CreateInventoryTaskRequest | The request payload containing the version, feedType, and optional filterCriteria.
$xEBAYCMARKETPLACEID = 'facerecords'; // string | The ID of the eBay marketplace where the item is hosted. Note: This value is case sensitive. For example: X-EBAY-C-MARKETPLACE-ID:EBAY_US This identifies the eBay marketplace that applies to this task. See MarketplaceIdEnum.

try {
    $apiInstance->createInventoryTask($createInventoryTaskRequest, $xEBAYCMARKETPLACEID);
} catch (Exception $e) {
    echo 'Exception when calling InventoryTaskApi->createInventoryTask: ', $e->getMessage(), PHP_EOL;
}

// test