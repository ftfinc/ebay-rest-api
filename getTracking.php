<?php

$zip = new ZipArchive;
$savePath = './zip/2022_05_09.zip';
$details =[];

if ($zip->open($savePath) === TRUE) {
    $zip->extractTo('./unzip/');
    $filename = $zip->getNameIndex(0);
    $zip->close();
    

    $xml = simplexml_load_file('./unzip/' . $filename);

    if($xml === FALSE) {
        echo "ERROR: tracking result xml file read fails<br>";
        throw new Exception("ERROR: tracking result xml file read fails<br>");

    } else {
        
        // $i = 0;
        foreach($xml->SetShipmentTrackingInfoResponse as $detail){

                $details[] = $detail;

                // $i++;
                // if($i == 1000) {
                //     break;
                // }
        }
    }

} else {

    echo 'ERROR: tracking result zip file read fails<br>';
    throw new Exception("ERROR: tracking result zip file read fails<br>");
}


var_dump($details);

?>