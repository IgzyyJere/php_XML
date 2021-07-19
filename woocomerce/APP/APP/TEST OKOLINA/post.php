<?php

if(isset($_POST['submit'])) {
    //form's fields name:
    $name = $_POST['nameField'];
    $email = $_POST['emailField'];

    $curl = curl_init();

$username = "moje!cipele_22@B";
$password = "MpY4vyFNek34MSNtNFqN";

    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://www.webzy.com.hr/cipele/app-SvP/index.php',
      CURLOPT_RETURNTRANSFER => true,
     // CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'[
        {
          "title": "BIJELE NATIKAČE KONOPASTE PETE",
          "source_id": "U468",
          "id": "U468",
          "sku": "BIJELE NATIKAČE KONOPASTE PETE",
          "ean": null,
          "purchase_price_cents": 179,
          "currency": "kn",
          "quantity": 1,
          "variant": "41"
        },
        {
            "title": "BIJELE NATIKAČE KONOPASTE PETE",
            "source_id": "U468",
            "id": "U468",
            "sku": "BIJELE NATIKAČE KONOPASTE PETE",
            "ean": null,
            "purchase_price_cents": 179,
            "currency": "kn",
            "quantity": 2,
            "variant": "38"
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
            <h1>Test just hit POST</h1>
            <br>
  
            <input type="submit" name="submit" value="Send data"/>
        </form>

    </body>
</html>