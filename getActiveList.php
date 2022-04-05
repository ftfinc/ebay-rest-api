<?php
require './token.php';
require './createInventoryTask.php';
require './getInventoryTask.php';
require './getResultFile_curl.php';

try {
    // get accesstoken
    $ebay_api = new EbayAPI;
    $ebay_api->refreshToken();
    $accessToken = $ebay_api->authToken;
   
    //make task and get taskid
    $createTask = new CreateInventoryTask;
    $taskId = $createTask->createInventoryTask($accessToken);
    echo 'task id: ' . $taskId . '<br>';

} catch (Exception $e) {
    print("accesstoken taskId ERROR occured: ");
    print($e->getMessage());

}


if(isset($taskId) && isset($accessToken)) {

    try {

        // get task status and get item list
        while(true) {

            // get task status
            $getInventoryTask = new GetInventoryTask;
            $status = $getInventoryTask->getinventoryTask($accessToken, $taskId);
            echo 'status: ' . $status . '<br>';

            // when task is COMPLETED, get item lists
            if($status == "COMPLETED") {

                $getResultList = new GetResultFile;
                $details = $getResultList->getResultFile($accessToken, $taskId);
                // var_dump($details);
                break;
            
            } else if($status == "CREATED" || $status == "QUEUED" || $status == "IN_PROCESS") {

                    sleep(30);
                
            } else {
                throw new Exception('ERROR: get task status error status: ' . $status);
            }
        }
        
    } catch (Exception $e) {

        print("ERROR :get Inventory list occur");
        print($e->getMessage());
        exit();
    }
    

    $dsn = 'mysql:dbname=sell_update;host=127.0.0.1';
    $user = 'root';
    $config = require './configuration.php';
    $password = $config['db_pass'];

    try {
        $dbh = new PDO($dsn, $user, $password);
        echo('DB success<br>');

    } catch (PDOException $e) {
        echo'DB fails: ' . $e->getMessage();
        exit();
    }

    $insertSql = 'INSERT INTO items (ebay_id, sell_price_ebay,item_id,created_at,status) VALUE (:ebay_id, :sell_price_ebay,:item_id,:created_at,:status)';
    $updateSql = 'UPDATE items SET ebay_id =:ebay_id, sell_price_ebay =:sell_price_ebay , updated_at = :updated_at,status = :status WHERE item_id =:item_id';

    $insertPrepare = $dbh->prepare($insertSql);
    $updatePrepare = $dbh->prepare($updateSql);

    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');

    if(!is_null($details)) {

        foreach ($details as $detail) {

            printf(
                "(%s) %.2f %s Quantity:%s<br>",
                $detail->ItemID,
                $detail->Price,
                $detail->SKU,
                $detail->Quantity
            );
    
            if($detail->Quantity > 0) {

                $sql2 = "SELECT * FROM items WHERE item_id='" . $detail->SKU . "'";
                $res = $dbh->query($sql2);
        
                if($res->fetchColumn() > 0) {
        
                    $result = $res->fetch(PDO::FETCH_ASSOC);
        
                    if($result['status'] < 3) {
        
                        $updatePrepare->bindValue(":ebay_id", $detail->ItemID, PDO::PARAM_STR);
                        $updatePrepare->bindValue(":sell_price_ebay", $detail->Price, PDO::PARAM_STR);
                        $updatePrepare->bindValue(":item_id", $detail->SKU, PDO::PARAM_STR);
                        $updatePrepare->bindValue(":updated_at", $date, PDO::PARAM_STR);
                        $updatePrepare->bindValue(":status", 2, PDO::PARAM_STR);
                        $updatePrepare->execute();
                    }
        
                } else {
        
                    $insertPrepare->bindValue(":ebay_id", $detail->ItemID, PDO::PARAM_STR);
                    $insertPrepare->bindValue(":sell_price_ebay", $detail->Price, PDO::PARAM_STR);
                    $insertPrepare->bindValue(":item_id", $detail->SKU, PDO::PARAM_STR);
                    $insertPrepare->bindValue(":created_at", $date, PDO::PARAM_STR);
                    $insertPrepare->bindValue(":status",2, PDO::PARAM_STR);
                    $insertPrepare->execute();

                }

            }
            

        }
        

    } else {
        echo "ERROR: no inventory list";
    }


} else {
    print("ERROR: no taskID or accesstoken");


}






?>
