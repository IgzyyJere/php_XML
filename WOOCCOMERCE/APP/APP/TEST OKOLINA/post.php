<?php

if(isset($_POST['submit'])) {
    //form's fields name:
    $name = $_POST['nameField'];
    $email = $_POST['emailField'];

    $curl = curl_init();

    $username = "moje!cipele_22@B";
    $password = "MpY4vyFNek34MSNtNFqN";

    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://mojecipele.com/TEST/app-SvP/index.php',
     // CURLOPT_URL => 'https://mojecipele.com/TEST/app-SvP/index2_test.php',
      CURLOPT_RETURNTRANSFER => true,
     // CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'[
        
    


   {
      "title":"Bordo Tenisice",
      "source_id":"P85",
      "id":"JJ5QKVN",
      "variant":"38",
      "sku":" Bordo Tenisice - 38 - Order M2QX5E",
      "purchase_price_cents":3299,
      "currency":"kn",
      "quantity":1,
      "order_status":"waiting_acceptance"
   },
   {
      "title":"Ženske tenisice sa kariranom mašnicom",
      "source_id":"N3",
      "id":"NMAXNAX",
      "variant":"38",
      "sku":" Ženske tenisice sa kariranom mašnicom - 38 - Order M2QX5E",
      "purchase_price_cents":3299,
      "currency":"kn",
      "quantity":1,
      "order_status":"waiting_acceptance"
   },
   {
      "title":"Zlatne Metalizirane Tenisice",
      "source_id":"M284",
      "id":"AXMEXDZ",
      "variant":"36",
      "sku":" Zlatne Metalizirane Tenisice - 38 - Order M2QX5E",
      "purchase_price_cents":3299,
      "currency":"kn",
      "quantity":1
      "order_status":"canceled"
   },
   {
      "title":"Zelene Mint Tenisice",
      "source_id":"S53",
      "id":"3EJV4J5",
      "variant":"38",
      "sku":" Zelene Mint Tenisice - 38 - Order M2QX5E",
      "purchase_price_cents":9193,
      "currency":"kn",
      "quantity":1,
      "order_status":"canceled
   },
   {
      "title":"Crne Tenisice",
      "source_id":"S61",
      "id":"VD59XGV",
      "variant":"38",
      "sku":" Crne Tenisice - 38 - Order M2QX5E",
      "purchase_price_cents":9193,
      "currency":"kn",
      "quantity":1,
      "order_status":"canceled
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
            <h1>Test just hit POST to test me</h1>
            <br>
  
            <input type="submit" name="submit" value="Send data"/>
        </form>

    </body>
</html>