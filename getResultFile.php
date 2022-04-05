<?php

require_once(__DIR__ . '/vendor/autoload.php');

$setting = require 'configuration.php';
require './token.php';

$ebay_api = new EbayAPI;
$ebay_api->refreshToken();
$accessToken = $ebay_api->authToken;

// Configure OAuth2 access token for authorization: api_auth
$config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);


$apiInstance = new Ansas\Ebay\Api\TaskApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$taskId = 'task-16-1239960149'; // string | The ID of the task associated with the file you want to download. This ID was generated when the task was created.

try {
    $result = $apiInstance->getResultFile($taskId);
    var_dump($result);

} catch (Exception $e) {
    echo 'Exception when calling TaskApi->getResultFile: ', $e->getMessage(), PHP_EOL;
}