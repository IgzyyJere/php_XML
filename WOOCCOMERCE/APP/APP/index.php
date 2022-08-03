<?php

#region procuction server connection
$user = 'webzyco1_mojecip';
$db = 'webzyco1_mojecipele';
$passW = '~$FA6i_)mToA';
$link = new mysqli("localhost", $user, $passW, $db);
#endregion



#region LOCAL TEST 
//include 'defini_fields.php';
//$Contextz_Q = new QueryMain_Context();
//$link = new mysqli("localhost", $Contextz_Q->user, $Contextz_Q->passW, $Contextz_Q->db);
#endregion


mysqli_set_charset($link,"utf8");

#region CHECK POST AND AUTH 
// Only allow POST requests
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
  throw new Exception('Only POST requests are allowed');
}


// Make sure Content-Type is application/json 
$content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
if (stripos($content_type, 'application/json') === false) {
  throw new Exception('Content-Type must be application/json');
}



if (!isset($_SERVER['PHP_AUTH_USER'])) {
      header("WWW-Authenticate: Basic Authorization: Basic aWdvcjo2Njc2");
      header("HTTP/1.0 401 Unauthorized");
      // only reached if authentication fails
      print "Sorry - nemaš pristup!\n";
      exit;
} else {
      // AUTORIZACIJA JE PROŠLA
      if($_SERVER['PHP_AUTH_USER'] == "igzyy" && $_SERVER['PHP_AUTH_PW'] == "6676"){
        $data_post = file_get_contents('php://input', true);
        $data =  json_decode($data_post, JSON_THROW_ON_ERROR); ///Decode JSON data to PHP associative array
  
        ///kreiraj json file a dole moraš obrisat
        file_put_contents("data.json", $data_post); //rješava sve
      
      
        $url = "http://webzy.com.hr/MOJECIPELE/APP/data.json";

        $headers = array(
          "Accept: application/json"
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $json = curl_exec($ch);
        $data = json_decode($json,true);

          #region brojac artikala varijabla
          $countProductJson = 0; 
          for($y = 1; $y <= count($data); $y++){
              //echo "($y) = broj broj objekata ".count($data)." ----<br/>";
              $countProductJson++;
          }  
          #endregion

          $date = date('Y-m-d H:i:s');
          $gmtDate = date('Y-m-d H:i:s');
          $return = "";


          for ($x = 0; $x < $countProductJson; $x++) {
            //echo "($x)interni brojac | globalbrojac: ".$countProductJson."<br/>";

            //get data from json data ---
            $source_id = $data[$x]["source_id"];
            $bazzarId = $data[$x]["id"];
            $piceFromBazzarValue = $data[$x]["purchase_price_cents"]; 
            $SKU = $data[$x]["source_id"]; 
            $variantData =  $data[$x]["variant"]; //broj cipele
            $komada = $data[$x]["quantity"];
            $title = $data[$x]["title"];
      

            ///--1--KONTROLA SKU DA LI PORIZVOD POSTOJI
            $getSqlProductID = "select post_id from loxah_postmeta where meta_value like '".$SKU."'";
            $getProductID = mysqli_query($link, $getSqlProductID);
            $productID = mysqli_fetch_assoc($getProductID); 
            if($productID["post_id"] !== null){


              ///--2-- PROVJERI DOSTUPNOST BROJA I DA LI IMA NA STANJU
              $getSqlVariantId = "SELECT * from loxah_posts
              where post_type like 'product_variation' 
              and post_status like 'publish' 
              and post_parent = ".$productID["post_id"]."
              and post_excerpt  like '%".$variantData."'";
              $getVariantId = mysqli_query($link, $getSqlVariantId);
              $VId = mysqli_fetch_assoc($getVariantId);

              //nadji meta_id
              $getSqFindlSTOCK = "select meta_id from loxah_postmeta
              where post_id = ".$VId["ID"]."
              and meta_key like '_stock_status'";
              $getFSTOCK = mysqli_query($link, $getSqFindlSTOCK);
              $stockFControl = mysqli_fetch_assoc($getFSTOCK);

              //nadji jel na stocku ili
              $getSqSTOCK_k = "select meta_value, meta_id from loxah_postmeta
              where meta_id = ".$stockFControl["meta_id"]."
              and meta_key like '_stock_status'";
              $getSTOCK = mysqli_query($link, $getSqSTOCK_k);
              $stockControl = mysqli_fetch_assoc($getSTOCK);

              if($VId["ID"] !== null){
                $st = $stockControl["meta_value"];
                $st1 = 'instock';
                if($st == $st1){

                                #region stock values
                                $getMetaIDSQLQuantty = "select meta_key, meta_id, meta_value from loxah_postmeta where post_id = ".$VId["ID"]." 
                                and meta_key like '_stock'";
                                $getStock = mysqli_query($link, $getMetaIDSQLQuantty);
                                $stockNumber =  mysqli_fetch_assoc($getStock);
                                echo "ID koji se traži u upit----- ".$VId["ID"];


                                $onStock = $stockNumber["meta_value"];
                                $komadOstalo = $onStock - $komada;
                                echo " nađeno u bazi komada ".$onStock; 
                                echo " komada na prodaju ".$komada; 
                                echo " IZRAČUN JE ".$komadOstalo; 
                                echo "kikiriki --" .$stockControl["meta_id"];

                                if($komada > $onStock){
                                  echo "Nema dovoljno na lageru!"; 
                                  exit;
                                }


                                //update qunatity
                                $UpdateSqlQuantity = "UPDATE loxah_postmeta SET meta_value = " .$komadOstalo. " WHERE meta_id = ".$stockNumber["meta_id"];

                                //update stock value
                                $UpdateSqlSales = "UPDATE loxah_postmeta SET meta_value = 'outofstock' WHERE meta_id = ".$stockControl["meta_id"]. " and meta_key like '_stock_status'";
                                $link->query($UpdateSqlQuantity); 

                                //if($komadOstalo == 1){
                                //  $link->query($UpdateSqlSales); //nije više na prodaju jer je nestalo
                                //  echo "skinuo sam jedan komad";
                                //}
                                      
                                if($komadOstalo == 0){
                                  //$link->query($UpdateSqlQuantity);
                                  $link->query($UpdateSqlSales); //nije više na prodaju jer je nestalo
                                  echo "zatvorio prodaju --".$UpdateSqlSales;
                                }
                                
                                else{
                                  echo "problem s stanjem";
                                  echo "komada ostalo - zbroj ". $komadOstalo;
                                }
                                #endregion


                                //calculate price
                                $price = number_format(($piceFromBazzarValue /100), 2, '.', ' ');
                                $PostName = 'Order Bazzar &ndash;baz#'.$bazzarId;
                                //echo "broj (parentID) Id -".$VId["ID"]. "|  post ID :" .$productID["post_id"] . "|   SKU = ".$SKU;
                                //echo "| broj cipele : " .$variantData ." |";
                               // echo " Search bit baz#%".$bazzarId;

                                ///UNOS U POST
                                $InsertQuery = "
                                INSERT INTO  loxah_posts
                                (post_author, post_date, post_date_gmt, post_title, post_status, comment_status, ping_status, post_name, post_type) 
                                VALUES (1, '$date', '$date',
                                'Order Bazzar &ndash;baz#$bazzarId',
                                'wc-completed', 'closed', 'closed', 'order', 'shop_order')";
                          
                                $getPostIdQuery = "select ID from loxah_posts where post_title like '%baz#%$bazzarId%' order by ID DESC limit 1";
                                //echo '<br/> bazar search : '. $getPostIdQuery;
                          
                                          if ($link->query($InsertQuery) === TRUE) 
                                          {
                                                $postId = mysqli_query($link, $getPostIdQuery);
                                                $getPostId = mysqli_fetch_assoc($postId); 
                                                //echo "New Post record created successfully - ".$getPostId['ID'];
                                    
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
                                                      $link->query($InsertMetaData1); 
                                                      $link->query($InsertMetaData2); 
                                                      $link->query($InsertMetaData3); 
                                                      $link->query($InsertMetaData4); 
                                                      $link->query($InsertMetaData5); 
                                                      $link->query($InsertMetaData6); 
                                                      $link->query($InsertMetaData7);
                                                      $link->query($InsertMetaData8);
                                                      $link->query($InsertMetaData9);
                                                      $link->query($InsertMetaData10);
                                                      $link->query($InsertMetaData11);
                                                      $link->query($InsertMetaData12);
                                                      $link->query($InsertMetaData13);
                                                      $link->query($InsertMetaData14);
                                                      $link->query($InsertMetaData15);
                                                      $link->query($InsertMetaData16); //cijena - iznos
                                                      $link->query($InsertMetaData17); 
                                                      $link->query($InsertMetaData18); 
                                    
                                    
                                                                ///3.Unos podataka u WOOCOMMERCE_ORDER_ITEMS samo jedna linija
                                                                $InsertWoData1 = " INSERT INTO loxah_woocommerce_order_items (order_item_name, order_item_type, order_id) VALUES ('".$PostName."', 'line_item', '".$getPostId["ID"]."')";
                                                                $link->query($InsertWoData1); 
                                    
                                    
                                                                ///4. Unos podataka u WOOCOMMERCE_ORDER_ITEMMETA
                                                                ///get product ID = nađi proizvod po SKU
                                                                $getSqlProductID = "select post_id from loxah_postmeta where meta_value like '".$SKU."'"; //nadji cipelu po SKU u bazi
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
                                                                and post_excerpt like '%".$variantData."'"; //broj cipele
                                    
                                                                $getVariantId = mysqli_query($link, $getSqlVariantId);
                                                                $VId = mysqli_fetch_assoc($getVariantId); //problem ako nema broj cipele s tim SKU
                                    
                                    
                                                                $InsertWooMetaData1 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_product_id', '".$productID["post_id"]."')";
                                                                $InsertWooMetaData2 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_variation_id', '".$VId["ID"]."')";
                                                                $InsertWooMetaData3 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_qty', '1')";
                                                                $InsertWooMetaData4 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_tax_class', '')"; 
                                                                $InsertWooMetaData5 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_subtotal', '".$price."')"; 
                                                                $InsertWooMetaData6 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_subtotal_tax', '0')";
                                                                $InsertWooMetaData7 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_line_tax', '0')";
                                                                $InsertWooMetaData8 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','pa_velicina', '".$variantData."')"; 
                                                                $InsertWooMetaData9 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_reduced_stock', '".$komada."')"; 
                                          
                                          
                                                                $link->query($InsertWooMetaData1);  //koji je to proizvod
                                                                $link->query($InsertWooMetaData2);  //variant id broj cipele
                                                                $link->query($InsertWooMetaData3);  //komada
                                                                $link->query($InsertWooMetaData4);  //porez
                                                                $link->query($InsertWooMetaData5);  //cijena
                                                                $link->query($InsertWooMetaData6);  //porez nešto
                                                                $link->query($InsertWooMetaData7);  //porez nešto
                                                                $link->query($InsertWooMetaData8);  //veličina cipele
                                                                $link->query($InsertWooMetaData9);  //smanjeuje se komada

                                                                      //poruka koja se vrača
                                                                      $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code //
                                                                      if(curl_error($ch)) { 
                                                                          echo 'Error: ' . curl_error($ch);
                                                                      };
                                                                      echo "Poruka : ".$status_code;
                                                                      curl_close($ch);

                                                                      //--MAIL
                                                                      $to = "igorsfera7@gmail.com";
                                                                      $subject = "TEST - prodaja bazzar";
                                            
                                                                      if($status_code == "200"){
                                                                        $subject = "TEST - prodaja bazzar";
                                                                        $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                                                                        "broj proizvoda :".$countProductJson."\r\n".
                                                                        "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                                        "Naziv proizvoda : ".$title ."\r\n".
                                                                        "Broj cipele : ".$variantData."\r\n".
                                                                        "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                                                        $headers = "From: info@webzy.com.hr" ;//. "\r\n" .
                                                                        //"CC: igzyy.j@gmail.com";
                                                                        
                                                                        mail($to,$subject,$txt,$headers);
                                            
                                                                      }

                                                                      $link->close();
                                      
                                                                      $fileToDelete = "data.json";
                                                                      //fclose($fileToDelete); //zatvori file
                                                                      //unlink($fileToDelete); //obriši file
                                          
                                        
                                          }else{
                                                //PROIZVOD NIJE UNEŠEN IZ NEKOG RAZLOGA
                                                $return = "fail";
                                                echo json_encode($return);
                                              }
                      }//CHECK JEL IMA STANJE
                      else{
                        echo $st. " -nema dovoljno na lageru ";
                      }
                      
                  }//CHECK PROIZVOD BROJ
                  else {
                    echo "nema broja";
                  }
            }//CHECK PROIZVOD SKU
            else {
              echo "nema proizvoda";
            }

          } ///forloop insert data






      }else{ print "NEMAŠ AUTORIZACIJU 401";}
} //if auth
?>