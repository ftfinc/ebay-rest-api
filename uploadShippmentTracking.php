<?php
require './token.php';
require './createTask.php';
require './uploadFile_curl.php';
require './getXML.php';
require './getTrackingResultFile.php';
require './getTask.php';

date_default_timezone_set('Asia/Tokyo');

$date = date("Y_m_d_H_i_s");
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
                "%s : %s<br>",
                $detail->OrderID,
                $detail->Ack
            );
        }

        echo '完了<br>';
    
    } else {
        echo "ERROR: no tracking result file";
    }

} else {
    print("ERROR: no taskID or accesstoken");
}


?>