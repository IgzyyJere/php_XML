<?php

$output = "";
$info = "";

if(isset($_POST['submit'])) {
    //form's fields name:


    //API url:
    //$url = 'http://webzy.com.hr/MOJECIPELE/APP/index.php';
    $url ="https://www.webzy.com.hr/cipele/app-SvP/index.php";


            //  $data = json_encode(
            //      array(   ));

            // $username = "igzyy";
            // $password = "ci";
            //     curl_setopt($ch, CURLOPT_URL,$url);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            //     curl_setopt($ch, CURLOPT_POST,1 );
            //     curl_setopt($ch, CURLOPT_POSTFIELDS,$data); 

            //     //curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

            //     curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization: Value=Token token=111111", "Content-Type:application/json;charset=utf-8"));
            //     //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            //     $output = curl_exec($ch);
            //     $info = curl_getinfo($ch);
            //     $result=curl_exec($ch);






            //  $data = <<<DATA
            //  [
            //      {
            //             "title": "Kurac",
            //             "source_id": "Q26",
            //             "id": "A4NRD1111",
            //             "sku": "CRVENE BALERINKE S MAŠNICOM",
            //             "ean": null,
            //             "purchase_price_cents": 8952,
            //             "currency": "kn",
            //             "quantity": 1,
            //             "variant": "40"
            //         },
            //         {
            //             "title": "Kurac2",
            //             "source_id": "Q25",
            //             "id": "A4NRD1111",
            //             "sku": "ZELENE BALERINKE S MAŠNICOM - 42 - Order P4J",
            //             "ean": null,
            //             "purchase_price_cents": 8950,
            //             "currency": "kn",
            //             "quantity": 1,
            //             "variant": "37"
            //         }     
            // ]  
            // DATA;

            // $data = json_encode(
            //     array('
   
            //     [
            //         {
            //             "title": "Kurac",
            //             "source_id": "Q25",
            //             "id": "A4NRD1",
            //             "sku": "ZELENE BALERINKE S MAŠNICOM - 40 - Order P4J",
            //             "ean": null,
            //             "purchase_price_cents": 8950,
            //             "currency": "kn",
            //             "quantity": 1,
            //             "variant": "40"
            //         },
            //         {
            //             "title": "Kurac2",
            //             "source_id": "Q26",
            //             "id": "A4NRD2",
            //             "sku": "ZELENE BALERINKE S MAŠNICOM - 42 - Order P4J",
            //             "ean": null,
            //             "purchase_price_cents": 9050,
            //             "currency": "kn",
            //             "quantity": 1,
            //             "variant": "42"
            //         }
            //     ]'
            //     ));




            $data = json_encode(array(' 
                [
                    {
                      "title": "PINK NATIKAČE KONOPASTE PETE",
                      "source_id": "U459",
                      "id": "R56RD",
                      "sku": "PINK NATIKAČE KONOPASTE PETE - 41 - Order KAM",
                      "ean": null,
                      "purchase_price_cents": 18000,
                      "currency": "kn",
                      "quantity": 1,
                      "variant": "41"
                    },
                    {
                        "title": "PINK NATIKAČE KONOPASTE PETE",
                        "source_id": "U459",
                        "id": "R56RD",
                        "sku": "PINK NATIKAČE KONOPASTE PETE - 41 - Order KAM",
                        "ean": null,
                        "purchase_price_cents": 18000,
                        "currency": "kn",
                        "quantity": 1,
                        "variant": "38"
                    }
                  ]'
            ));

            $headers = array(
                "Accept: application/json",
                "Content-Type: application/json;charset=utf-8",
                "Cookie: PH_HPXY_CHECK=s1",
                "Content-Length: " . strlen($data),
                "Authorization: Basic bW9qZSFjaXBlbGVfMjJAQjpNcFk0dnlGTmVrMzRNU050TkZxTg==",

             );

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //vrati nešto
                curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $resp = curl_exec($curl);
                curl_close($curl);
              

           }


?>
<html>
    <head>
    </head>

    <body>
        <form action="" method="POST">
            <input type="submit" name="submit" value="Send"/>
        </form>

  <?php var_dump($resp); ?>

    </body>
</html>