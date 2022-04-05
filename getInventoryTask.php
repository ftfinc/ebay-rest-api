<?php
require_once(__DIR__ . '/vendor/autoload.php');

class GetInventoryTask {

    function __construct(){}

    public function getInventoryTask($accessToken, $taskId) {


        // Configure OAuth2 access token for authorization: api_auth
        $config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);


        $apiInstance = new Ansas\Ebay\Api\InventoryTaskApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );
        

        try {
            $response = $apiInstance->getInventoryTask($taskId);
            $status = $response['status'];
            return $status;

        } catch (Exception $e) {
            // echo 'Exception when calling InventoryTaskApi->getInventoryTask: ', $e->getMessage(), PHP_EOL;
            throw $e;
        }

    }

}

