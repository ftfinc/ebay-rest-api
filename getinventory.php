<?php
/**
 * Copyright 2016 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Include the SDK by using the autoloader from Composer.
 */
require '/var/www/html/ftfsystem/ebay/vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require '/var/www/html/ftfsystem/ebay/configuration.php';
date_default_timezone_set('Asia/Tokyo');
echo date_default_timezone_get();   

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\GetMyeBaySellingRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

/**
 * Request that eBay returns the list of actively selling items.
 * We want 10 items per page and they should be sorted in descending order by the current price.
 */
$request->ActiveList = new Types\ItemListCustomizationType();
$request->ActiveList->Include = true;
$request->ActiveList->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
$request->ActiveList->Pagination = new Types\PaginationType();
$request->ActiveList->Pagination->EntriesPerPage = 200;
$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_START_TIME_DESCENDING;
// $request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$pageNum = 1;

do {
    $request->ActiveList->Pagination->PageNumber = $pageNum;

    /**
     * Send the request.
     */

    $response = $service->getMyeBaySelling($request);

    //エラーで止まった時は3回までトライ
    // $count = 0;
    // $maxTries = 3;

    // while (true) {
    //     try {
    //         $response = $service->getMyeBaySelling($request);
    //         break;
    //     } catch(Excepton $e) {
    //         sleep(15);
    //         echo "==================\nResults for page $pageNum\n==================<br>";
    //         echo 'エラー発生！！再トライ！！';
    //         echo"\n\n\n\n\n\n\n\n\n\n\n\n\n";
    //         if(++$count === $maxTries) {
    //             echo 'page=' . $pageNum;
    //             $pageNum += 1;
    //             $request->ActiveList->Pagination->PageNumber = $pageNum;
    //         }
    //     }
    // }

    /**
     * Output the result of calling the service operation.
     */
    echo "==================\nResults for page $pageNum\n==================<br>";


    //XXX　2021/09/01　ここは復活させる！

    // ドライバ呼び出しを使用して MySQL データベースに接続します
    // $dsn = 'mysql:dbname=selldb;host=127.0.0.1';
    // $user = 'root';
    // $password = 'MS5PWzH7FhZ4';

    // try {
    //     $dbh = new PDO($dsn, $user, $password);
    //     echo "接続成功\n";
    // } catch (PDOException $e) {
    //     echo "接続失敗: " . $e->getMessage() . "\n";
    //     exit();
    // }

    // $insertSql = 'INSERT INTO items (ebay_id, title , sell_price_ebay,item_id,created_at,status) VALUE (:ebay_id, :title , :sell_price_ebay,:item_id,:created_at,:status)';
    // $updateSql = 'UPDATE items SET ebay_id =:ebay_id ,title =:title , sell_price_ebay =:sell_price_ebay , updated_at = :updated_at,status = :status WHERE item_id =:item_id';
    // $insertPrepare = $dbh->prepare($insertSql);
    // $updatePrepare = $dbh->prepare($updateSql);

    // $date = new DateTime();
    // $date = $date->format('Y-m-d H:i:s');


    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {
            printf(
                "%s: %s\n%s\n\n",
                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                $error->ShortMessage,
                $error->LongMessage
            );
        }
    }

    if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
        foreach ($response->ActiveList->ItemArray->Item as $item) {
            printf(
                "(%s) %s: %s %.2f %s<br>",
                $item->ItemID,
                $item->Title,
                $item->SellingStatus->CurrentPrice->currencyID,
                $item->SellingStatus->CurrentPrice->value,
                $item->SKU,
            );
            // var_dump($item);

            //XXX　2021/09/01　ここは復活させる！

            //ちゃんとSKU被ってたら上書きの処理を入れ込む
            // $sql2 = "SELECT * FROM items WHERE item_id='".$item->SKU."'";
            // $res = $dbh->query($sql2); 
            
            // if($res -> fetchColumn() > 0){

            //     $result = $res->fetch(PDO::FETCH_ASSOC);

            //     if($result['status'] < 3){
            //         //ここでDB登録する
            //         $updatePrepare->bindValue(":ebay_id", $item->ItemID, PDO::PARAM_STR);
            //         $updatePrepare->bindValue(":title", $item->Title, PDO::PARAM_STR);
            //         $updatePrepare->bindValue(":sell_price_ebay", $item->SellingStatus->CurrentPrice->value, PDO::PARAM_STR);
            //         $updatePrepare->bindValue(":item_id", $item->SKU, PDO::PARAM_STR);
            //         $updatePrepare->bindValue(":updated_at", $date, PDO::PARAM_STR);
            //         $updatePrepare->bindValue(":status", 2, PDO::PARAM_STR);


            //         $updatePrepare->execute();

            //     }

                

            // }else{

            //     $insertPrepare->bindValue(":ebay_id", $item->ItemID, PDO::PARAM_STR);
            //     $insertPrepare->bindValue(":title", $item->Title, PDO::PARAM_STR);
            //     $insertPrepare->bindValue(":sell_price_ebay", $item->SellingStatus->CurrentPrice->value, PDO::PARAM_STR);
            //     $insertPrepare->bindValue(":item_id", $item->SKU, PDO::PARAM_STR);
            //     $insertPrepare->bindValue(":created_at", $date, PDO::PARAM_STR);
            //     $insertPrepare->bindValue(":status",2, PDO::PARAM_STR);
            //     $insertPrepare->execute();

            // }

           

            
        }
    }

    $pageNum += 1;
    // if($pageNum == 20) {
    //     break;
    // }
} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
