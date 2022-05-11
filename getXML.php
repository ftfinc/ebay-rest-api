<?php

require_once(__DIR__ . '/vendor/autoload.php');

class getXML {

    function __construct(){}

    public function getXML($date) {

        // curlの実行 xmlファイルの取得
        $url = 'https://ftfsystem.work/ebayface/trading/set-tracking-xml.php';

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Ebay App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $xml = curl_exec($curl);
        
        // 受け取ったXMLレスポンスをPHPの連想配列へ変換
        $xmlObj = simplexml_load_string($xml);
        $xmlObj->asXML('./xml/' . $date . '.xml');
        $err = curl_error($curl);

        curl_close($curl);

        if($err) {
            throw new Exception('ERROR: XMLファイル取り込みエラー' . $err);
        } 
    }
}



?>