<?php
require './token.php';
require './createTask.php';
require './uploadFile_curl.php';
require './getXML.php';
require './getTrackingResultFile.php';
require './getTask.php';

date_default_timezone_set('Asia/Tokyo');

$date = date("Y_m_d");
echo $date . '<br>';

try {
    // アクセストークン取得
    $ebay_api = new EbayAPI;
    $ebay_api->refreshToken();
    $accessToken = $ebay_api->authToken;

    // タスクの作成
    echo 'タスク作成開始<br>';
    $createTask = new CreateTask;
    $taskId = $createTask->createTask($accessToken);
    echo 'task id: ' . $taskId . '<br>';

} catch (Exception $e) {
    print("accesstoken taskId ERROR occured: ");
    print($e->getMessage());
    exit();
}

// $taskId = 'task-14-1244607337';
// $accessToken = 'v^1.1#i^1#r^0#p^3#f^0#I^3#t^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';

// xmlファイルの取得
try {
    echo 'xmlファイル取得<br>';
    $getXml = new getXML;
    $getXml->getXML($date);
    echo 'xmlファイル取得完了<br>';
} catch(Exception $e) {
    print($e->getMessage());
    exit();
}

$xmlPath = './xml/'. $date . '.xml';

if(isset($taskId) && isset($accessToken)) {

    try {
        // xmlファイルのアップロード
        echo 'xmlファイルアップロード開始<br>';
        $uploadFile = new UploadFile;
        $uploadFile->uploadFile($accessToken, $taskId, $xmlPath);
        echo 'xmlファイルアップロード完了<br>';

    }catch(Exception $e) {
        print('file upload error: ');
        print($e->getMessage());
        exit();
    }

    try {

        
        while(true) {
            
            // タスクステータスの確認
            echo 'タスクステータスの確認開始<br>';
            $getTask = new GetTask;
            $status = $getTask->getTask($accessToken, $taskId);
            echo 'status: ' . $status . '<br>';
            
            // タスクステータスがCOMPLETEDになった場合に修了
            if($status == 'COMPLETED') {

                    // 結果ファイルの取得
                    echo '結果ファイルの取得開始<br>';
                    $getTrackingResult = new GetTrackingResultFile;
                    $details = $getTrackingResult->getResultFile($accessToken, $taskId, $date);
                    echo '結果ファイルの取得完了<br>';
                    break;
    
            } else if($status == "CREATED" || $status == "QUEUED" || $status == "IN_PROCESS") {
    
                sleep(30);
            
            } else {
                throw new Exception('ERROR: get task status error status: ' . $status);
            }
        }

    } catch (Exception $e) {
        print($e->getMessage());
        exit();
    }
    
   
    // 結果の画面表示
    if(!is_null($details)) {
    
        foreach ($details as $detail) {
    
            printf(
                "(%s) %s : %s<br>",
                $detail->OrderID,
                $detail->OrderLineItemID,
                $detail->Ack
            );
        }
    
    } else {
        echo "ERROR: no tracking result file";
    }

} else {
    print("ERROR: no taskID or accesstoken");
}


?>