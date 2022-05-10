<?php

require_once(__DIR__ . '/vendor/autoload.php');

class GetTask {

    function __construct(){}

    public function getTask($accessToken, $taskId) {

        // Configure OAuth2 access token for authorization: api_auth
        $config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);


        $apiInstance = new Ansas\Ebay\Api\TaskApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );
        // $taskId = 'task-14-1244505138'; // string | The ID of the task. This ID was generated when the task was created.

        try {
            $result = $apiInstance->getTask($taskId);
            $status = $result['status'];
            return $status;
        } catch (Exception $e) {

            // echo 'Exception when calling TaskApi->getTask: ', $e->getMessage(), PHP_EOL;
            throw $e;
        }

    }
}




?>