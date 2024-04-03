<?php
//PHP CALL HANDASHAKE HEADERS
//PO TUTORIALU ZA API : 
//
//
//
//);

$url_to_call = "http://localhost:8001/apiExperimnentphp/api_call_GET.php";

$jsonData = array(
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3'
);
$jsonString = json_encode($jsonData);

$headers = array(
    //'HTTPAUTH:CURLAUTH_BASIC',
    //'username:igzyy',
    //'password:6676'

    'Content-Type:application/json',
    "Accept: application/json",

    //'Authorization: Basic '. base64_encode("igzyy:6676")
    'options: '.$jsonString
);

$conext = stream_context_create(
 [
        'http' => [ implode("\r\n", $headers)]
 ]

 
);

$response = file_get_contents($url_to_call, false, $conext);
//echo $response;




?>