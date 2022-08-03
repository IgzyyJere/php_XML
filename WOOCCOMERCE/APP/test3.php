<?php

if(isset($_POST['submit'])) {
    //form's fields name:


    //API url:
    $url = 'http://webzy.com.hr/MOJECIPELE/APP/index.php';
    $ch = curl_init();

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

            
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt($ch, CURLOPT_POST,1 );
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data); 
                curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type:application/json;charset=utf-8") ); 

                $result=curl_exec($ch);

           }


?>
<html>
    <head>
    </head>

    <body>
        <form action="" method="POST">
            <input type="submit" name="submit" value="Send"/>
        </form>

    </body>
</html>