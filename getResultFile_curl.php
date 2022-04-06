<?php

require_once(__DIR__ . '/vendor/autoload.php');

class GetResultFile {

    function __construct(){}

    public function getResultFile($accessToken, $taskId) {


        $url = 'https://api.ebay.com/sell/feed/v1/task/' . $taskId . '/download_result_file';

        $date = date("Y_m_d");
        echo $date . '<br>';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Ebay App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        if (!is_null($accessToken)) {
            $request_headers = [
                'Content-Type:application/json',
                'Accept: application/octet-stream',
                'Accept-Charset: utf-8',
                'Accept-Language: EBAY_US',
                'Authorization:Bearer '. $accessToken,
            ];
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

        $savePath = './zip/' . $date . '.zip';
        echo $savePath . '<br>';
        $fp = fopen($savePath, 'w');
        curl_setopt($curl, CURLOPT_FILE, $fp);


        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);

        curl_close($curl);
        fclose($fp);

        if($error_number) {

            print $error_message;
            throw new Exception($error_message);

        } else {

            $zip = new ZipArchive;

            $details =[];

            if ($zip->open($savePath) === TRUE) {
                $zip->extractTo('./unzip/');
                $filename = $zip->getNameIndex(0);
                $zip->close();
              
            
                $xml = simplexml_load_file('./unzip/' . $filename);
            
                if($xml === FALSE) {
                    echo "ERROR: xml file read fails<br>";
                    throw new Exception("ERROR: xml file read fails<br>");

                } else {
                   
                    $i = 0;
                    foreach($xml->ActiveInventoryReport->SKUDetails as $detail){
            
                            $details[] = $detail;

                            $i++;
                            if($i == 1000) {
                                break;
                            }
                    }
                }
            
            } else {

                echo 'ERROR: zip file read fails<br>';
                throw new Exception("ERROR: zip file read fails<br>");
            }
            

            return $details;

        }
        
   
       

    }
}


?>
