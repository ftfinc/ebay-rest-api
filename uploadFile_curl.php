<?php
require_once(__DIR__ . '/vendor/autoload.php');
require './getResultFile_curl.php';

class UploadFile {

    function __construct(){}

    public function uploadFile($accessToken, $taskId, $xmlPath) {

        $curl = curl_init();

        curl_setopt_array($curl, array(

        CURLOPT_URL => 'https://api.ebay.com/sell/feed/v1/task/' . $taskId . '/upload_file',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_SSL_VERIFYHOST=> 0,
        CURLOPT_SSL_VERIFYPEER=> 0,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_HEADER => 1,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file'=> new CURLFILE(realpath($xmlPath)),'type' => 'form-data'),
        CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$accessToken,
        'X-EBAY-C-MARKETPLACE-ID: EBAY_US'
        ),

        ));

        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);
        // var_dump($response);
        curl_close($curl);

        if($error_number) {

            print $error_message;
            throw new Exception($error_message);

        } 


    }
}

?>