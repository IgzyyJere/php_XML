<?php

if(isset($_POST['submit'])) {
    //form's fields name:
    $name = $_POST['nameField'];
    $email = $_POST['emailField'];

    //API url:
    $url = 'http://webzy.com.hr/MOJECIPELE/APP/index.php';

    //JSON data(not exact, but will be compiled to JSON) file:
    //add as many data as you need (according to prosperworks doc):
    ///https://stackoverflow.com/questions/16920291/post-request-with-json-body
    //https://reqbin.com/req/c-eanbjsr1/curl-get-xml-example
    //https://reqbin.com/req/v0crmky0/rest-api-post-example
            $data = array(
                            'name' => $name,
                            'email' =>  $email
            );

            $ch = curl_init( $url );
            $bodyData=json_encode(array()); // here you send body Data

             $data = json_encode(
                 array('
    
                 [{
                     "title": "Kurac",
                     "source_id": "Q251111",
                     "id": "A4NRD1111",
                     "sku": "ZELENE BALERINKE S MAŠNICOM - 40 - Order P4J",
                     "ean": null,
                     "purchase_price_cents": 8950,
                     "currency": "kn",
                     "quantity": 1,
                     "variant": "37"
                 }]'
                 ));

              

            curl_setopt( $ch, CURLOPT_POSTFIELDS, $bodyData );

            curl_setopt( $ch, CURLOPT_HTTPHEADER,  array("Authorization-Key: 5996880420","headerdata: ".$data.",Content-Type:application/json;charset=utf-8"));

            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

            $result = curl_exec($ch);

            curl_close($ch);
            //var_dump($bodyData);
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