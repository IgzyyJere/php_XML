<?php

#region procuction server connection
$user = 'mojecipe_mojecipedev';
$db = 'mojecipe_dev';
$passW = '*p{XDDIN7;VK';
$link = new mysqli("localhost", $user, $passW, $db);
#endregion

#region procuction server connection
$userE = 'mojecipe_mileSa_VL';
$dbE = 'mojecipe_cr_mpK';
$passWE = 'BVFcUu4Yhg$D';
$linkError = new mysqli("localhost", $userE, $passWE, $dbE);
$date = date('yy-m-d H:i:s');
#endregion




#region DATA LOG
$message = "";
$dataLog = "";
$dataToLog = array(
  date("d-m-Y H:i:s"), //Date and time
  $_SERVER['REMOTE_ADDR'], //IP address
  'Open - insert - error', //Custom text
  $message, //message
  $dataLog//data
);

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
      header("WWW-Authenticate: Basic Authorization: Basic bW9qZSFjaXBlbGVfMjJAQjpNcFk0dnlGTmVrMzRNU050TkZxTg==");
      header("HTTP/1.0 401 Unauthorized");
      // only reached if authentication fails
      print "Sorry - nemaš pristup!\n";
      $message = "Sorry - nemaš pristup";
      $dataLog = "nema pristup";
                  $dataToLog = array(
                    date("d-m-Y H:i:s"), //Date and time
                    $_SERVER['REMOTE_ADDR'], //IP address
                    'Error', //Custom text
                    $message, //message
                    $dataLog//data
                  );
                  
             
                    $ErrorInsert = "
                    INSERT INTO tbl_BazzarELog
                    (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                    ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                    $linkError->query($ErrorInsert);
                   // echo ".$ErrorInsert.";
                    

        $to = "igorsfera7@gmail.com";
        $subject = "Prodaja bazzar - NEMA PRISTUP!!";
        $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".

        $headers = "From: BazzarReport@mojecipele.com";
        
        mail($to,$subject,$txt,$headers);


        


        exit;
     } 


// AUTORIZACIJA JE PROŠLA
else {
      
      if($_SERVER['PHP_AUTH_USER'] == "moje!cipele_22@B" && $_SERVER['PHP_AUTH_PW'] == "MpY4vyFNek34MSNtNFqN"){
        $data_post = file_get_contents('php://input', true);
        $data =  json_decode($data_post, JSON_THROW_ON_ERROR); ///Decode JSON data to PHP associative array
  
        ///kreiraj json file a dole moraš obrisat
        file_put_contents("data.json", $data_post); //rješava sve
      
      
        $url = "https://mojecipele.com/TEST/app-SvP/data.json";

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
          $countSumProductJson = 0; 
          for($y = 1; $y <= count($data); $y++){
              //echo "($y) = broj broj objekata ".count($data)." ----<br/>";
              $countSumProductJson++;
          }  
          #endregion

          $date = date('Y-m-d H:i:s');
          $gmtDate = date('Y-m-d H:i:s');
          $return = "";


        
            $countProductJson = 0;

            foreach($data as $valueData){
            $countProductJson = $countProductJson+1;

         

            //get data from json data ---
            $source_id = $valueData["source_id"]; //$data[$x]["source_id"]; //moj id
            $bazzarId = $valueData["id"]; //$data[$x]["id"]; //prodaja id od bazzara
            $piceFromBazzarValue = $valueData["purchase_price_cents"]; //$data[$x]["purchase_price_cents"]; 
            $SKU = $valueData["source_id"]; //$data[$x]["source_id"]; //SKU
            $variantData =  $valueData["variant"]; //$data[$x]["variant"]; //broj cipele
            $komada = $valueData["quantity"]; //$data[$x]["quantity"];
            $title = $valueData["title"]; //$data[$x]["title"];
            
            //kontrolna varijabla (ako je false nema prodaje a ako je true ima prodaje)
            $checkForGo = false;
      

            ///--1--KONTROLA SKU DA LI PORIZVOD POSTOJI PO SKU
            $getSqlProductID = "select post_id from loxah_postmeta where meta_value like '".$SKU."'";
            $getProductID = mysqli_query($link, $getSqlProductID);
            $productID = mysqli_fetch_assoc($getProductID); 

            if($productID["post_id"] !== null){


              ///--2-- PROVJERI DOSTUPNOST BROJA I DA LI IMA NA STANJU MORAM DOBITI ID OD PODATAKA GORE
              $getSqlVariantId = "SELECT ID from loxah_posts
              where post_type like 'product_variation' 
              and post_status like 'publish' 
              and post_parent = ".$productID["post_id"]."
              and post_excerpt  LIKE '%".$variantData."'";
             
              $getVariantId = mysqli_query($link, $getSqlVariantId);
              $VId = mysqli_fetch_assoc($getVariantId);

              ///---3--nadji meta_id ZA STOCK
              $getSqFindlSTOCK = "select meta_id from loxah_postmeta
              where post_id = ".$VId["ID"]."
              and meta_key like '_stock_status'";
              
              $getFSTOCK = mysqli_query($link, $getSqFindlSTOCK);
              $stockFControl = mysqli_fetch_assoc($getFSTOCK);

              /// ---4--- NADJI PODATKE O STOCKU PREKO META_ID
              $getSqSTOCK_k = "select meta_value, meta_id from loxah_postmeta
              where meta_id = ".$stockFControl["meta_id"]."
              and meta_key like '_stock_status'";
              
              
              $getSTOCK = mysqli_query($link, $getSqSTOCK_k);
              $stockControl = mysqli_fetch_assoc($getSTOCK);


              if($VId["ID"] !== null){

                $INSTOCK = $stockControl["meta_value"];
                $st1 = 'instock';
                
                //if($INSTOCK == $st1){
                if(strcmp($INSTOCK, $st1) == 0){

                               
                                ///5. NAĐI BROJEVNO STANJE CIPELE
                                $getMetaIDSQLQuantty = "select meta_key, meta_id, meta_value from loxah_postmeta where post_id = ".$VId["ID"]." 
                                and meta_key like '_stock'";
                                $getStock = mysqli_query($link, $getMetaIDSQLQuantty);
                                $stockNumber =  mysqli_fetch_assoc($getStock);
                                //echo "ID koji se traži u upit----- ".$VId["ID"];


                                $onStock = $stockNumber["meta_value"];
                                $komadOstalo = $onStock - $komada;
                                //echo " nađeno u bazi komada ".$onStock; 
                                // echo " komada na prodaju ".$komada; 
                                // echo " IZRAČUN JE ".$komadOstalo; 
                                //echo "kikiriki --" .$stockControl["meta_id"];
                                $checkForGo = true;
 
                                //AKO JE NARUĐBA VEČA OD STATUSA CIPELA
                                if($komada > $onStock || $onStock === 0){
                                    
                                                  echo "Nema dovoljno na lageru!";
                                                  $message = "Nema dovoljno na lageru prozvod SKU : ".$SKU.", prodaja bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData . " ,na skladištu je upravo :".$onStock ;
                                                  $dataLog = "SKU :".$SKU; 
                                                              $dataToLog = array(
                                                                date("d-m-Y H:i:s"), //Date and time
                                                                $_SERVER['REMOTE_ADDR'], //IP address
                                                                'Error', //Custom text
                                                                $message, //message
                                                                $dataLog//data
                                                              );

                                                              $ErrorInsert = "
                                                              INSERT INTO tbl_BazzarELog
                                                              (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                                              ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                                                              $linkError->query($ErrorInsert);
                                                             
                                                              
                                                              $to = "igorsfera7@gmail.com";
                                                              $subject = "Pokušaj prodaje bazzar - NEMA DOVOLJNO NA LAGERU, NARUĐBA JE PREVELIKA";
                                                              $txt = "Upravo je pokušana prodaja artikla na bazzar shopu kojeg nema na lageru,"."\r\n".
                                                              "broj proizvoda :".$countProductJson."\r\n".
                                                              "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                              "Naziv proizvoda : ".$title ."\r\n".
                                                              "Broj cipele : ".$variantData."\r\n".
                                                              "Stanje cipele  : ".$onStock."\r\n".
                                                              "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                                              $headers = "From: BazzarReport@mojecipele.com";
                                                              mail($to,$subject,$txt,$headers);
                                                              $checkForGo = false;

                                                              exit;
                                                }
                                   
                                ///GREŠKA U SUSTAVU - OBIĆNO AKO NIJE NAĐEN U 4 KORAKU                
                                if($checkForGo === false){
                                    //PROIZVOD NIJE UNEŠEN IZ NEKOG RAZLOGA
                                    $return = "ERROR";
                                    echo json_encode($return);
                                    $message = "PROIZVOD NIJE UNESEN IZ NEKOG RAZLOGA, SKU : ".$SKU.", bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                    $dataLog = "ERROR FAIL 1";
                                    $dataToLog = array(
                                      date("d-m-Y H:i:s"), //Date and time
                                      $_SERVER['REMOTE_ADDR'], //IP address
                                      'Error', //Custom text
                                      $message, //message
                                      $dataLog//data
                                    );

                                    $ErrorInsert = "
                                    INSERT INTO tbl_BazzarELog
                                    (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                    ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                                    $linkError->query($ErrorInsert);
                                   // echo ".$ErrorInsert.";

                                    $to = "igorsfera7@gmail.com";
                                    $subject = "Prodaja bazzar - GREŠKA U SUSTAVU";
                                    $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                                    "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                    "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                    "Naziv proizvoda : ".$title ."\r\n".
                                    "Broj cipele : ".$variantData."\r\n".
                                    "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                    $headers = "From: BazzarReport@mojecipele.com"; 
                                    mail($to,$subject,$txt,$headers);
                                    exit;
                                   }
                                    
                                ///OVDJE JE KNJIŽENJE
                                else{
                                        
                                    $checkForGo = true;
                                        
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
                                     // echo "zatvorio prodaju --".$UpdateSqlSales;
                                    }
                                    
                                    
                                    
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
                          
                                              if ($link->query($InsertQuery) === TRUE && $checkForGo === true) 
                                              {
                                                    $postId = mysqli_query($link, $getPostIdQuery);
                                                    $getPostId = mysqli_fetch_assoc($postId); 
                                                    //echo "New Post record created successfully - ".$getPostId['ID'];
                                                    $message = "USPJEŠAN UNOS SKU : ".$SKU.", sales bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                                    $dataLog = "SKU :".$SKU;
                                                    
                                                    $dataToLog = array(
                                                      date("d-m-Y H:i:s"), //Date and time
                                                      $_SERVER['REMOTE_ADDR'], //IP address
                                                      'OK', //Custom text
                                                      $message, //message
                                                      $dataLog//data
                                                    );

                                                    $ErrorInsert = "
                                                    INSERT INTO tbl_BazzarELog
                                                    (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                                    ('$date',        'OK','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                                                    $linkError->query($ErrorInsert);
                                                 
                                        
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
                                                                          $subject = "Prodaja bazzar";
                                                
                                                                          //VRATI PORUKU DA JE RJEŠENO "200"
                                                                          if($status_code == 200){
                                                                            $subject = "Prodaja bazzar";
                                                                            $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                                                                            "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                                                            "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                                            "Naziv proizvoda : ".$title ."\r\n".
                                                                            "Broj cipele : ".$variantData."\r\n".
                                                                            "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                                                            $headers = "From: BazzarReport@mojecipele.com";// "\r\n" .
                                                                            //"CC: info@mojecipele.com";
                                                                            
                                                                            mail($to,$subject,$txt,$headers);
                                                
                                                                          }
                                                                          //ako nije kod status 200
                                                                          else{
                                                                            $message = "STATUS KOD ERROR SKU : ".$SKU.", sales bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                                                            $dataLog = "ERROR KOD :".$status_code;
                                                                            $dataToLog = array(
                                                                              date("d-m-Y H:i:s"), //Date and time
                                                                              $_SERVER['REMOTE_ADDR'], //IP address
                                                                              'Error', //Custom text
                                                                              $message, //message
                                                                              $dataLog//data
                                                                            );

                                                                            $ErrorInsert = "
                                                                            INSERT INTO tbl_BazzarELog
                                                                            (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                                                            ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                                                                            $linkError->query($ErrorInsert);
                                                                           // echo ".$ErrorInsert.";
                                                                          }
    
                                                                          $link->close();
                                          
                                                                          $fileToDelete = "data.json";
    
                                        
                                              }///nema problema s stanjem
                                    
                                              else{
                                              //echo "problem s stanjem";
                                              //echo "komada ostalo - zbroj ". $komadOstalo;
                                              $message = "Problem s stanjem SKU : ".$SKU.", sales bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                              $dataLog = "SKU :".$SKU;
                                                  $dataToLog = array(
                                                    date("d-m-Y H:i:s"), //Date and time
                                                    $_SERVER['REMOTE_ADDR'], //IP address
                                                    'Error', //Custom text
                                                    $message, //message
                                                    $dataLog//data
                                                  );

                                                  $ErrorInsert = "
                                                  INSERT INTO tbl_BazzarELog
                                                  (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                                  ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                                                  $linkError->query($ErrorInsert);
                                                 // echo ".$ErrorInsert.";
            
                                              $to = "igorsfera7@gmail.com";
                                              $subject = "Prodaja bazzar - PROBLEM S STANJEM";
                                              $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                                              "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                              "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                              "Naziv proizvoda : ".$title ."\r\n".
                                              "Broj cipele : ".$variantData."\r\n".
                                              "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                              $headers = "From: BazzarReport@mojecipele.com";
                                              mail($to,$subject,$txt,$headers);
                                            }
                                }

                                   
                                   
                      }//CHECK JEL IMA STANJE
                      
                      
                      
                  else{
                   // echo $st. " -nema dovoljno na lageru ";
                    $message = "NEMA DOVOLJNO NA LAGERU SKU : ".$SKU.", sales bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                    $dataLog = "ERROR FAIL 2, NEMA DOVOLJNO ". $st;
                    $dataToLog = array(
                      date("d-m-Y H:i:s"), //Date and time
                      $_SERVER['REMOTE_ADDR'], //IP address
                      'Open', //Custom text
                      $message, //message
                      $dataLog//data
                    );

                    $ErrorInsert = "
                    INSERT INTO tbl_BazzarELog
                    (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                    ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                    $linkError->query($ErrorInsert);
                   // echo ".$ErrorInsert.";
    
                        $to = "igorsfera7@gmail.com";
                        $subject = "Prodaja bazzar - NEMA PRIZVODA NA LAGERU";
                        $txt = "Upravo je pokušano prodati artikl na bazzar shopu koji nije na stanju,"."\r\n".
                        "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                        "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                        "Naziv proizvoda : ".$title ."\r\n".
                        "Broj cipele : ".$variantData."\r\n".
                        "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                        $headers = "From: BazzarReport@mojecipele.com";// "\r\n" 
                       // "CC: info@mojecipele.com";
                        mail($to,$subject,$txt,$headers);
    
                  }
                  
                  
                  
                      
                  }//CHECK PROIZVOD 
                  
              ///nije nađen proizvod po id posto     
              else {
                echo "nema broja";
                $message = "NEMA BROJA SKU : ".$SKU.", bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                $dataLog = "ERROR FAIL 3, NEMA BROJA ". $st;
                $dataToLog = array(
                  date("d-m-Y H:i:s"), //Date and time
                  $_SERVER['REMOTE_ADDR'], //IP address
                  'Error', //Custom text
                  $message, //message
                  $dataLog//data
                );

                $ErrorInsert = "
                INSERT INTO tbl_BazzarELog
                (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                $linkError->query($ErrorInsert);
               // echo ".$ErrorInsert.";

                        $to = "igorsfera7@gmail.com";
                        $subject = "Prodaja bazzar - NEMA TRAŽENOG BROJA";
                        $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                        "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                        "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                        "Naziv proizvoda : ".$title ."\r\n".
                        "Broj cipele : ".$variantData."\r\n".
                        "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                        $headers = "From: BazzarReport@mojecipele.com"; //"\r\n" .
                      //  "CC: info@mojecipele.com";  
                        mail($to,$subject,$txt,$headers);
              }
              }//CHECK PROIZVOD SKU
            
            
            //NIJE NAĐEN SKU U BAZI
            else {
              echo "nema proizvoda";
              $message = "NEMA PROIZVODA SKU : ".$SKU.", sales bazzarID : ". $bazzarId.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
              $dataLog = "ERROR FAIL 4, NEMA PROIZVODA ". $st;
                      $dataToLog = array(
                        date("d-m-Y H:i:s"), //Date and time
                        $_SERVER['REMOTE_ADDR'], //IP address
                        'Error', //Custom text
                        $message, //message
                        $dataLog//data
                      );

                      $ErrorInsert = "
                      INSERT INTO tbl_BazzarELog
                      (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                      ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
                      $linkError->query($ErrorInsert);
                     // echo ".$ErrorInsert.";
              

              $to = "igorsfera7@gmail.com";
              $subject = "Prodaja bazzar - ERROR - NEMA PROIZVODA";
              $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
              "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
              "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
              "Naziv proizvoda : ".$title ."\r\n".
              "Broj cipele : ".$variantData."\r\n".
              "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
              $headers = "From: BazzarReport@mojecipele.com"; //"\r\n" .
             // "CC: info@mojecipele.com";
              mail($to,$subject,$txt,$headers);

            }

          } ///forloop insert data






      }else{
         print "NEMAŠ AUTORIZACIJU 401";
          $message = "401";
          $dataLog = "401 ";
          $dataToLog = array(
            date("d-m-Y H:i:s"), //Date and time
            $_SERVER['REMOTE_ADDR'], //IP address
            'Error 401 POKUŠAJ BEZ AUTORIZACIJE', //Custom text
            $message, //message
            $dataLog//data
          );

          $ErrorInsert = "
          INSERT INTO tbl_BazzarELog
          (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
          ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , 'SKU', 0)";
          $linkError->query($ErrorInsert);
         // echo ".$ErrorInsert.";

          $to = "igorsfera7@gmail.com";
          $subject = "Prodaja bazzar - POKUŠAJ BEZ AUTORIZACIJE";
          $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
          "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
          "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
          "Naziv proizvoda : ".$title ."\r\n".
          "Broj cipele : ".$variantData."\r\n".
          "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
          $headers = "From: BazzarReport@mojecipele.com"; //"\r\n" .
         // "CC: info@mojecipele.com";
          
          mail($to,$subject,$txt,$headers);
        }
} //if auth

$data = implode(" - ", $dataToLog);
$data .= PHP_EOL;
$pathToFile = 'logSales.log';
file_put_contents($pathToFile, $data, FILE_APPEND);

?>