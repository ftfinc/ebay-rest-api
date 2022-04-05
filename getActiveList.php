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

} catch (Exception $e) {
    print("accesstoken taskId ERROR occured: ");
    print($e->getMessage());

}


// $taskId = 'task-16-1239960149';
// $taskId = 'task-16-1131244006';
// $accessToken = 'v^1.1#i^1#r^0#p^3#f^0#I^3#t^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';
echo 'task id: ' . $taskId . '<br>';


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
                    echo "status: " . $status . '<br>';
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
    

    $dsn = 'mysql:dbname=selldb;host=127.0.0.1';
    $user = 'root';
    $password = 'Mah4pFoyUh,2';

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
