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
        $config = require './configuration.php';

        $this->devID = $config['production']['credentials']['devId']; // these prod keys are different from sandbox keys
        $this->appID = $config['production']['credentials']['appId'];
        $this->certID = $config['production']['credentials']['certId'];
        $this->clientID = $config['production']['credentials']['clientId'];
        //set the Server to use (Sandbox or Production)
        $this->serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with

        $this->authCode = ''; 
        $this->authToken = '';
        $this->refreshToken =$config['production']['refreshToken'];
        $this->ruName= $config['production']['ruName'];

        
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

?>