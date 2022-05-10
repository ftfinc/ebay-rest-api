<?php
require_once(__DIR__ . '/vendor/autoload.php');

class CreateTask {

    function __construct(){}

    public function createTask($accessToken) {

        // Configure OAuth2 access token for authorization: api_auth
        $config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);


        $apiInstance = new Ansas\Ebay\Api\TaskApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );

        $data = array(
            'schemaVersion' => '1.0',
            'feedType' => 'LMS_SET_SHIPMENT_TRACKING_INFO',
        );
        
        $createTaskRequest = new \Ansas\Ebay\Model\CreateTaskRequest($data); // \Ansas\Ebay\Model\CreateTaskRequest | description not needed
        $xEBAYCMARKETPLACEID = 'EBAY_US'; // string | The ID of the eBay marketplace where the item is hosted. <p> <span class=\"tablenote\"><strong>Note:</strong> This value is case sensitive.</span></p><p>For example:</p><p><code>X-EBAY-C-MARKETPLACE-ID:EBAY_US</code></p><p>This identifies the eBay marketplace that applies to this task. See <a href=\"/api-docs/sell/feed/types/bas:MarketplaceIdEnum\">MarketplaceIdEnum</a>.</p>

        try {
            $response = $apiInstance->createTask($createTaskRequest, $xEBAYCMARKETPLACEID);
            $url = $response['location'][0];
            $task_id = str_replace('https://api.ebay.com/sell/feed/v1/task/', '', $url);
            return $task_id;
            // var_dump($response);
        } catch (Exception $e) {
            echo 'Exception when calling TaskApi->createTask: ', $e->getMessage(), PHP_EOL;
        }
        
    }

}


