<?php
require_once(__DIR__ . '/vendor/autoload.php');

class uploadFile {

    function __construct() {}

    public function uploadFile($accessToken, $taskId, $xmlPath, $datetime) {

        // Configure OAuth2 access token for authorization: api_auth
        $config = Ansas\Ebay\Configuration::getDefaultConfiguration()->setAccessToken($accessToken);


        $apiInstance = new Ansas\Ebay\Api\TaskApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $config
        );
        $taskId = $taskId; // string | The task_id associated with the file that will be uploaded. This ID was generated when the specified task was created.
        $creationDate = $datetime; // string | The file creation date. <br /><br /><b> Format: </b> UTC <code>yyyy-MM-ddThh:mm:ss.SSSZ</code><p><b>For example:</b><p>Created on September 8, 2019</p><p><code>2019-09-08T00:00:00.000Z</code></p>
        $fileName = '2022_05_09.xml'; // \SplFileObject | The name of the file including its extension (for example, xml or csv) to be uploaded.
        $modificationDate = $datetime; // string | The file modified date. <br /><br /><b> Format: </b> UTC <code>yyyy-MM-ddThh:mm:ss.SSSZ</code><p><b>For example:</b><p>Created on September 9, 2019</p><p><code>2019-09-09T00:00:00.000Z</code></p>
        $name = './xml/2022_05.09.xml'; // string | A content identifier. The only presently supported name is <code>file</code>.
        $readDate = $datetime; // string | The date you read the file. <br /><br /><b> Format: </b> UTC <code>yyyy-MM-ddThh:mm:ss.SSSZ</code><p><b>For example:</b><p>Created on September 10, 2019</p><p><code>2019-09-10T00:00:00.000Z</code></p>
        $size = 56; // int | The size of the file.
        $type = 'form-data'; // string | The file type. The only presently supported type is <code>form-data</code>.

        try {
            $result = $apiInstance->uploadFile($taskId, $creationDate, $fileName, $modificationDate, $name, $readDate, $size, $type);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling TaskApi->uploadFile: ', $e->getMessage(), PHP_EOL;
        }

    }
}
