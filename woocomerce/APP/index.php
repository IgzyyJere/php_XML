<?php

//https://stackoverflow.com/questions/47236018/posting-json-data-and-request-header-using-curl-php
$user = 'webzyco1_mojecip';
$db = 'webzyco1_mojecipele';
$passW = '~$FA6i_)mToA';

$link = new mysqli("localhost", $user, $passW, $db);
mysqli_set_charset($link,"utf8");




//samo za tesetiranje
 $headData = apache_request_headers();


 //Make sure that the content type of the POST request has been set to application/json
 $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
 if(strcasecmp($contentType, 'application/json') != 0){
     throw new Exception('Content type must be: application/json');
 }

 //$data = json_decode(file_get_contents('php://input'), true);  
 $json = trim(file_get_contents('php://input'));
 $data = json_decode($json, true);
 

     //If json_decode failed, the JSON is invalid.
     if(!is_array($data)){
        throw new Exception('Received content contained invalid JSON!');
    }
 
 if($headData['headerdata']){
     $cc1 = "ok";
         foreach ($headData  as $header => $value) {
             $cc1 = $header . ': ' . $value;
         }
 }else{
      $cc1 = "none";
 }
 


$countProductJson = 0;
    //brojać artikala
    for($y = 1; $y <= count($data); $y++){
        //echo "($y) = broj broj objekata ".count($data)." ----<br/>";
        $countProductJson++;
    }     


    $date = date('Y-m-d H:i:s');
    $gmtDate = date('Y-m-d H:i:s');
    $return = "";

 
    //brojač unosa
    for ($x = 0; $x < $countProductJson; $x++) {
            //echo "($x)interni brojac | globalbrojac: ".$countProductJson."<br/>";


            //get data from json data
            $source_id = $data[$x]["source_id"];
            $bazzarId = $data[$x]["id"];
            $piceFromBazzarValue = $data[$x]["purchase_price_cents"]; 
            $SKU = $data[$x]["source_id"]; 
            $variantData =  $data[$x]["variant"];
            $komada = $data[$x]["quantity"];

            //calculate price
            $price = number_format(($piceFromBazzarValue /100), 2, '.', ' ');
            $PostName = 'Order Bazzar &ndash;baz#'.$bazzarId;

            //echo "cijena - ".$price;
            //echo "proizvod id : ".$source_id;

            ///UNOS U POST
            $InsertQuery = "
            INSERT INTO  loxah_posts
            (post_author, post_date, post_date_gmt, post_title, post_status, comment_status, ping_status, post_name, post_type) 
            VALUES (1, '$date', '$date',
            'Order Bazzar &ndash;baz#$bazzarId',
            'wc-completed', 'closed', 'closed', 'order', 'shop_order')";

            $getPostIdQuery = "select ID from loxah_posts where post_title like '%baz#%$bazzarId%'";
            //echo '<br/> bazar search : '. $getPostIdQuery;

            if ($link->query($InsertQuery) === TRUE) 
             {
                  $postId = mysqli_query($link, $getPostIdQuery);
                  $getPostId = mysqli_fetch_assoc($postId); 
                  //echo "<h1>New Post record created successfully - ".$getPostId['ID']."</h1>";

                        //2. insert post meta podaci o prodaji
                        $InsertMetaData1 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_order_stock_reduced','yes')";

                        $InsertMetaData2 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_customer_user','0') ";

                        $InsertMetaData3 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_payment_method','Bazzar shop')";

                        $InsertMetaData4 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_payment_method_title','Bazzar shop/online plačanje') ";

                        $InsertMetaData5 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_created_via','Bazzar')"; 

                        $InsertMetaData6 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_billing_first_name','Bazzar')";

                        $InsertMetaData7 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_billing_last_name','Bazzar')"; 

                        $InsertMetaData8 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].",'_billing_company',' Prati me d.o.o')";

                        $InsertMetaData9 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].",'_billing_address_1','')";

                        $InsertMetaData10 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].",'_billing_city','Zagreb')";

                        $InsertMetaData11 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_billing_postcode','10000')";

                        $InsertMetaData12 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_billing_country','Croatia')";

                        $InsertMetaData13 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_shipping_country','HR')";

                        $InsertMetaData14 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_order_currency','HRK')";


                        //cijena - iznos
                        $InsertMetaData15 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].",'_order_total','".$price."')"; 

                        
                        $InsertMetaData16 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].",'_prices_include_tax','no')"; 

                        $InsertMetaData17 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_order_tax','25') "; 

                        $InsertMetaData18 = "
                        INSERT INTO loxah_postmeta
                        (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_paid_date','".$date ."')"; 


                        ///insert
                    //    $link->query($InsertMetaData1); 
                     //   $link->query($InsertMetaData2); 
                     //   $link->query($InsertMetaData3); 
                     //   $link->query($InsertMetaData4); 
                     //   $link->query($InsertMetaData5); 
                     //   $link->query($InsertMetaData6); 
                      //  $link->query($InsertMetaData7);
                      //  $link->query($InsertMetaData8);
                      //  $link->query($InsertMetaData9);
                      //  $link->query($InsertMetaData10);
                      //  $link->query($InsertMetaData11);
                      //  $link->query($InsertMetaData12);
                       // $link->query($InsertMetaData13);
                      //  $link->query($InsertMetaData14);
                      //  $link->query($InsertMetaData15);
                      //  $link->query($InsertMetaData16); //cijena - iznos
                      //  $link->query($InsertMetaData17); 
                       // $link->query($InsertMetaData18); 


                        ///3.Unos podataka u WOOCOMMERCE_ORDER_ITEMS samo jedna linija
                        $InsertWoData1 = " INSERT INTO loxah_woocommerce_order_items (order_item_name, order_item_type, order_id) VALUES ('".$PostName."', 'line_item', '".$getPostId["ID"]."')";
                        $link->query($InsertWoData1); 

 
                        ///4. Unos podataka u WOOCOMMERCE_ORDER_ITEMMETA
                            ///get product ID
                            $getSqlProductID = "select post_id from loxah_postmeta  where meta_value  = '".$SKU."'";
                            $getProductID = mysqli_query($link, $getSqlProductID);
                            $productID = mysqli_fetch_assoc($getProductID); 


                            ////get order ID
                            $getSqlOrderID = "select order_item_id from loxah_woocommerce_order_items where order_id  = '".$getPostId["ID"]."'";
                            $getOrderID = mysqli_query($link, $getSqlOrderID);
                            $orderID =  mysqli_fetch_assoc($getOrderID);

                            ////get variant id
                            $getSqlVariantId = "SELECT ID from loxah_posts
                            where post_type like 'product_variation' 
                            and post_status like 'publish' 
                            and post_parent = ".$productID["post_id"]."
                            and post_excerpt  like '%".$variantData."'";

                            $getVariantId = mysqli_query($link, $getSqlVariantId);
                            $VId = mysqli_fetch_assoc($getVariantId);

                            $InsertWooMetaData1 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_product_id', '".$productID["post_id"]."')";
                            $InsertWooMetaData2 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_variation_id', '".$VId["ID"]."')";
                            $InsertWooMetaData3 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_qty', '1')";
                            $InsertWooMetaData4 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_tax_class', '')"; 
                            $InsertWooMetaData5 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_subtotal', '".$price."')"; 
                            $InsertWooMetaData6 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_subtotal_tax', '0')";
                            $InsertWooMetaData7 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_tax', '0')";
                            $InsertWooMetaData8 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','pa_velicina', '".$variantData."')"; 
                            $InsertWooMetaData9 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_reduced_stock', '".$komada."')"; 
    

                           // $link->query($InsertWooMetaData1);  //koji je to proizvod
                          //  $link->query($InsertWooMetaData2);  //variant id broj cipele
                           // $link->query($InsertWooMetaData3);  //komada
                           // $link->query($InsertWooMetaData4);  //porez
                           // $link->query($InsertWooMetaData5);  //cijena
                          //  $link->query($InsertWooMetaData6);  //porez nešto
                          //  $link->query($InsertWooMetaData7);  //porez nešto
                           // $link->query($InsertWooMetaData8);  //veličina cipele
                          //  $link->query($InsertWooMetaData9);  //smanjeuje se komada

            } 
            else 
            {
                //echo "ERROR-------------: " . $InsertQuery . "<br>" . $link->error;
                $return = "Fail - problem";
                echo json_encode($return);
            }
    }





    //echo 'BROJ PROIZVODA = '.$countProductJson;
    $return = "Success -- uspješan poziv";
    echo json_encode($return);
    $link->close();
    
    
    //mail
    $to = "igorsfera7@gmail.com";
    $subject = "TEST - prodaja bazzar";
    $txt = "Upravo je prodan artikl na bazzar shopu ".  $PostName ."\r\n". $return ."\r\n". "Podaci su : ".implode(", ", $data) . " ili ". $data->title;
    $headers = "From: info@webzy.com.hr"; //. "\r\n" .
    //"CC: igzyy.j@gmail.com";
    
    mail($to,$subject,$txt,$headers);

?>

