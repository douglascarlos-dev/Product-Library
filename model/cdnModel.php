<?php
include_once 'connection.php';

class Cdn extends Connection {

    private $file;

    public function setFile($file){
        $this->file=$file;
        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    function upload($file) {

        $REGION = 'br';
        $BASE_HOSTNAME = 'storage.bunnycdn.com';
        $HOSTNAME = (!empty($REGION)) ? "{$REGION}.{$BASE_HOSTNAME}" : $BASE_HOSTNAME;
        $STORAGE_ZONE_NAME = 'my-storage-douglas';
        $FILENAME_TO_UPLOAD = '/files/' . $file;
        $ACCESS_KEY = '7b093bf1-6fa6-4153-b5e79f5bd1a4-6e32-425c';
        $FILE_PATH = './files/' . $file;
        $url = "https://{$HOSTNAME}/{$STORAGE_ZONE_NAME}/{$FILENAME_TO_UPLOAD}";

        $ch = curl_init();

        $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_PUT => true,
        CURLOPT_INFILE => fopen($FILE_PATH, 'r'),
        CURLOPT_INFILESIZE => filesize($FILE_PATH),
        CURLOPT_HTTPHEADER => array(
            "AccessKey: {$ACCESS_KEY}",
            'Content-Type: application/octet-stream'
        )
        );

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if (!$response) {
        die("Error: " . curl_error($ch));
        } else {
        //print_r($response);
        }

        curl_close($ch);

    }

    function delete($file) {

        $REGION = 'br';
        $BASE_HOSTNAME = 'storage.bunnycdn.com';
        $HOSTNAME = (!empty($REGION)) ? "{$REGION}.{$BASE_HOSTNAME}" : $BASE_HOSTNAME;
        $STORAGE_ZONE_NAME = 'my-storage-douglas';
        $FILENAME_TO_DELETE= '/files/' . $file;;

        $ACCESS_KEY = '7b093bf1-6fa6-4153-b5e79f5bd1a4-6e32-425c';

        $url = "https://{$HOSTNAME}/{$STORAGE_ZONE_NAME}/{$FILENAME_TO_DELETE}";

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST=> 'DELETE',
            CURLOPT_HTTPHEADER => array(
                "AccessKey: {$ACCESS_KEY}"
            )
            );
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        if (!$response) {
        die("Error: " . curl_error($ch));
        } else {
        //print_r($response);
        }

        curl_close($ch);

    }

}

?>