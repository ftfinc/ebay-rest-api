<?php

$zip = new ZipArchive;

$details =[];

if ($zip->open('./zip/file.zip') === TRUE) {
    $zip->extractTo('./unzip/');
    $filename = $zip->getNameIndex(0);
    $zip->close();
    echo '成功';

    $xml = simplexml_load_file('./unzip/' . $filename);

    if($xml === FALSE) {
        echo "fails";
    } else {
        print('seikou');
        $i = 0;
        foreach($xml->ActiveInventoryReport->SKUDetails as $detail){

                print($detail->SKU . " " . $detail->Quantity . " " . $detail->ItemID . " " . $detail->Price . "     ");
                $details[] = $detail;

                $i++;
                if($i == 10) {
                    break;
                }
        }
    }

} else {
    echo '失敗';
}


var_dump($details);



?>