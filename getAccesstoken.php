<?php
require './token.php';



// get accesstoken
$ebay_api = new EbayAPI;
$ebay_api->refreshToken();
$accessToken = $ebay_api->authToken;
echo $accessToken;