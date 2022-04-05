<?php

class EbayAPI
{
    protected $devID;
    protected $appID;
    protected $certID;
    protected $clientID;
    protected $serverUrl;
    public $userToken;
    protected $paypalEmailAddress;
    protected $ruName;


    public function __construct()
    {
        $this->devID = 'e30794c9-5639-4a0a-a71c-ae8169728ec2'; // these prod keys are different from sandbox keys
        $this->appID = 'FTFINC-facereco-PRD-9a5965275-20384bb1';
        $this->certID = 'PRD-a5965275af49-05e3-4f34-b0ae-7915';
        $this->clientID = 'FTFINC-facereco-PRD-9a5965275-20384bb1';
        //set the Server to use (Sandbox or Production)
        $this->serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with

        $this->authCode = 'v%5E1.1%23i%5E1%23f%5E0%23p%5E3%23I%5E3%23r%5E1%23t%5EUl41XzM6QjU1MUQxNzVGNUM2RTRFRUQ1OURCOEJGOURBMjgwNTBfMV8xI0VeMjYw'; 
        $this->authToken ="";
        $this->refreshToken ="v^1.1#i^1#r^1#p^3#f^0#I^3#t^Ul4xMF85OjAxMjcxNzg5RkMyRTUyNjk2NjE4MDIwOEQ4MUM2MTg2XzJfMSNFXjI2MA==";
        $this->ruName= "FTF_INC-FTFINC-facereco-iouofn";

        $this->paypalEmailAddress= 'PAYPAL_EMAIL_ADDRESS';
        
    }

    public function firstAuthAppToken() {
        $url = "https://auth.ebay.com/oauth2/authorize?client_id=".$this->clientID."&response_type=code&redirect_uri=".$this->ruName."&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly"; 
return $url;      
    }

    public function authorizationToken()
    {
        $link = "https://api.ebay.com/identity/v1/oauth2/token";
        $codeAuth = base64_encode($this->clientID.':'.$this->certID);
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.$codeAuth
        ));
        // curl_setopt($ch, CURLHEADER_UNIFIED, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=".$this->authCode."&redirect_uri=".$this->ruName);
        $response = curl_exec($ch);
        $json = json_decode($response, true);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if($json != null)
        {   
            var_dump($json);
            // $this->authToken = $json["access_token"];
            // $this->refreshToken = $json["refresh_token"]; 
        } 
    }

    public function refreshToken()
    {
        $link = "https://api.ebay.com/identity/v1/oauth2/token";
        $codeAuth = base64_encode($this->clientID.':'.$this->certID);
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.$codeAuth
        ));
        // echo $this->refreshToken;
        // curl_setopt($ch, CURLHEADER_SEPARATE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=".$this->refreshToken."&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly");
        $response = curl_exec($ch);
        $json = json_decode($response, true);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if($json != null)
        {
            $this->authToken = $json["access_token"];
            // var_dump($json);
        } 
    }
}

// $ebay_api = new EbayAPI;
// $url = $ebay_api->firstAuthAppToken();
// echo $url;

// $ebay_api->authorizationToken();
// echo 'accesstoken :' . $ebayapi->authToken;
// echo 'refreshToken :' . $ebayapi->refreshTokeh;

// $ebay_api->refreshToken();

?>