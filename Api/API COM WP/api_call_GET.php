<?php
//PHP CALL HANDASHAKE HEADERS
//PO TUTORIALU ZA API : 
//
//
//
//);


// Check if Authorization header exists
//if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
//    http_response_code(401);
//    exit("Authorization header is required");
//}


// Check if the Authorization header is in the correct format (Basic Authentication)
//if (strpos($_SERVER['HTTP_AUTHORIZATION'], 'Basic') !== 0) {
//    http_response_code(401);
//    exit("Invalid Authorization header");
//}

// Extract username and password from the Authorization header
//list($type, $credentials) = explode(' ', $_SERVER['HTTP_AUTHORIZATION'], 2);
//list($username, $password) = explode(':', base64_decode($credentials));


// Check if username and password match --OVDJE JE AUTORIZACIJA
//if ($username !== 'igzyy' || $password !== '6676') {
//    http_response_code(401);
//    exit("Invalid username or password");
//}


// Check if callback parameter exists
//if (!isset($_GET['callback'])) {
//    http_response_code(400);
//    exit("Callback parameter is required");
//}


//Execute your API logic
// For example, you can return a JSON response with a callback function

//$jsonData = file_get_contents('php://input');
//$data = json_decode($jsonData, true);
//$_REQUEST = $data;

// Example: Get Authorization header

$headers = [];
foreach ($_SERVER as $key => $value) {
    if (substr($key, 0, 5) === 'HTTP_') {
        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
    }
}


if (isset($headers['options'])) {
     $opt = $headers['options'];
    echo "Authorization header: $opt";
} else {
    echo "not found";
}



$data = array('message' => 'Hello, world!');
$response = json_encode($data);
echo "$callback($response)";

?>