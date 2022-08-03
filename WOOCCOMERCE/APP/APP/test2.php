<?php

if(isset($_POST['submit'])) {
    //form's fields name:
    $name = $_POST['nameField'];
    $email = $_POST['emailField'];

    $curl = curl_init();

$username = "igzyy";
$password = "6676";

    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost:8001/php_XML/woocomerce/APP/index.php',
      CURLOPT_RETURNTRANSFER => true,
     // CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'[
      {
        "title": "Champagne Sandale Na Blok Petu",
        "source_id": "S145",
        "id": "R56RD",
        "sku": " Champagne Sandale Na Blok Petu - 41 - Order KAM",
        "ean": null,
        "purchase_price_cents": 18000,
        "currency": "kn",
        "quantity": 1,
        "variant": "43"
      }
    ]',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Cookie: PH_HPXY_CHECK=s1',
        'Authorization: Basic '. base64_encode($username.':'.$password),

      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
    
           }


?>
<html>
    <head>
    </head>

    <body>

        <form action="" method="POST">
            <h1>tt</h1>
            Name: <input type="text" name="nameField"/>
            <br>
            Email: <input type="text" name="emailField"/>
            <input type="submit" name="submit" value="Send"/>
        </form>

    </body>
</html>