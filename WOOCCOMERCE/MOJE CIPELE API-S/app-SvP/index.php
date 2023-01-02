<?php

////PRODUKCIJA VERZIJA  API 2.1.0 
#region procuction server connection
$user = 'mojecipe_userSh';
$db = 'mojecipe_dbSho_p';
$passW = 'rLwW0wm@4Eh;';
$link = new mysqli("localhost", $user, $passW, $db);
#endregion

#region procuction server connection
$userE = 'mojecipe_mileSa_VL';
$dbE = 'mojecipe_cr_mpK';
$passWE = 'BVFcUu4Yhg$D';
$linkError = new mysqli("localhost", $userE, $passWE, $dbE);
$date = date('d-m-y H:i:s');
#endregion

mysqli_set_charset($link,"utf8");
mysqli_set_charset($linkError,"utf8");


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
  print "Nemaš pristup!\n";
  $message = "Nemaš pristup ";
  $dataLog = "Nema pristup ";
              $dataToLog = array(
                date("d-m-Y H:i:s"), //Date and time
                $_SERVER['REMOTE_ADDR'], //IP address
                'Error', //Custom text
                $message, //message
                $dataLog//data
              );
              
  //ZAPIS LOG U FILE
  $data = implode(" - ", $dataToLog);
  $data .= PHP_EOL;
  $pathToFile = 'logSales.log';
  file_put_contents($pathToFile, $data, FILE_APPEND);


    $to = "igorsfera7@gmail.com";
    $subject = "Prodaja bazzar - NEMA PRISTUP!!";
    $txt = "PROBLEM U AUTORIZACIJI PRVOG STUPNJA "."\r\n".
    $headers = "From: BazzarReport@mojecipele.com";
    mail($to,$subject,$txt,$headers);
    exit;
 } 



//1. STUPANJ  AUTORIZACIJE JE PROŠLA
else {
  
  //2. STUPANJ  AUTORIZACIJE JE PROŠLA
  if($_SERVER['PHP_AUTH_USER'] == "moje!cipele_22@B" && $_SERVER['PHP_AUTH_PW'] == "MpY4vyFNek34MSNtNFqN")
  {
    $data_post = file_get_contents('php://input', true);
    $data =  json_decode($data_post, JSON_THROW_ON_ERROR); ///Decode JSON data to PHP associative array

    ///kreiraj json file a dole moraš obrisat
    file_put_contents("data.json", $data_post); //rješava sve
    $url = "https://mojecipele.com/app-SvP/data.json";
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
          $countSumProductJson++;
      }  
      #endregion
      
      $date = date('Y-m-d H:i:s');
      $gmtDate = date('Y-m-d H:i:s');
      $return = "";
      $countProductJson = 0;
        
      $json = file_get_contents('data.json');
      $data = json_decode($json);

        foreach($data as $obj){
                        
                    $countProductJson = $countProductJson + 1;

                    echo $obj->source_id . ' , ';
                    $checkForGo = false; //KONTROLNA VARIJABLA default je false

                    //get data from json data ---
                    $source_id = $obj->source_id; //moj id SKU
                    $bazzarId = $obj->id;  //prodaja artikla id od bazzara
                    $piceFromBazzarValue = $obj->purchase_price_cents; //CIJENA
                    $SKU = $obj->source_id; //SKU
                    $variantData =  $obj->variant;  //broj cipele
                    $komada = $obj->quantity; 
                    $title = $obj->title; 
                    $bazzarSKU = $obj->sku;
                    $bazzar_status = $obj->order_status; //upgrade polje, najvažnije polj
                    

                    $BazzarInvoiceID = substr($bazzarSKU, strpos($bazzarSKU, "Order") +5); //bazzar day id

                    ///--1--KONTROLA SKU DA LI PORIZVOD POSTOJI PO SKU
                    $getSqlProductID = "select post_id from loxah_postmeta where meta_value like '".$SKU."'";
                    $getProductID = mysqli_query($link, $getSqlProductID);
                    $productID = mysqli_fetch_assoc($getProductID); 

                    ///SKU CHECK
                    if($productID["post_id"] !== null)
                    {
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

                                      ///NAPUNI STANJE I PROVJERI DA LI JE POLJE 'instock'
                                      $INSTOCK = $stockControl["meta_value"];
                                      $st1 = 'instock';

                                      //CHECK INSTOCKVALUE
                                      if(strcmp($INSTOCK, $st1) == 0){

                                           ///5. NAĐI BROJEVNO STANJE CIPELE
                                          $getMetaIDSQLQuantty = "select meta_key, meta_id, meta_value from loxah_postmeta where post_id = ".$VId["ID"]." 
                                          and meta_key like '_stock'";
                                          $getStock = mysqli_query($link, $getMetaIDSQLQuantty);
                                          $stockNumber =  mysqli_fetch_assoc($getStock);

                                          $onStock = $stockNumber["meta_value"];
                                          $komadOstalo = $onStock - $komada;
                                          $checkForGo = true;


                                                   //AKO JE NARUĐBA VEČA OD STATUSA CIPELA
                                                  if($komada > $onStock || $onStock === 0){

                                                    echo "Nema dovoljno na lageru za prodaju!";
                                                    $message = "Nema dovoljno na lageru prozvod SKU : : ".$SKU.", bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se rezervira :".$komada." ,broj cipele :".$variantData;
                                                    $dataLog = "SKU :" .$SKU;
                                                                $dataToLog = array(
                                                                  date("d-m-Y H:i:s"), //Date and time
                                                                  $_SERVER['REMOTE_ADDR'], //IP address
                                                                  'Error', //Custom text
                                                                  $message, //message
                                                                  $dataLog//data
                                                                );

                                                    //ZAPIS LOG U FILE
                                                    $data = implode(" - ", $dataToLog);
                                                    $data .= PHP_EOL;
                                                    $pathToFile = 'logSales.log';
                                                    file_put_contents($pathToFile, $data, FILE_APPEND);


                                                          $ErrorInsert = "
                                                          INSERT INTO tbl_BazzarELog
                                                          (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES 
                                                          ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$BazzarInvoiceID', '$bazzarId')"; 
                                                          $linkError->query($ErrorInsert);

                                                          $to = "info@mojecipele.com";
                                                          $subject = "Pokušaj rezervacije bazzar - NEMA DOVOLJNO NA LAGERU, NARUĐBA JE PREVELIKA";
                                                          $txt = "Upravo je pokušana prodaja artikla na bazzar shopu kojeg nema dovoljno na lageru za prodaju,"."\r\n".
                                                          "broj proizvoda :".$countProductJson."\r\n".
                                                          "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                                                          "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                          "Naziv proizvoda : ".$title ."\r\n".
                                                          "Broj cipele : ".$variantData."\r\n".
                                                          "Stanje cipele  : ".$onStock."\r\n".
                                                          "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                                          $headers = "From: BazzarReport@mojecipele.com"."\r\n";
                                                          //"CC: info@mojecipele.com";
                                                          mail($to,$subject,$txt,$headers);

                                                          $checkForGo = false;
                                                          exit; //izađi van


                                                  }///END AKO JE NARUĐBA VEČA OD STATUSA CIPELA

                                                  //AKO JE OK S STANJEM
                                                  else{

                                                      //ako je sve ok
                                                      if($checkForGo === true){
                                                           // echo '(SVE JE OK OVDJE KNJIŽIMO STANJE : '.$SKU.' )';

                                                           if($bazzar_status === 'waiting_acceptance')
                                                           {



                                                                                                                 //update qunatity
                                                                                                                  $UpdateSqlQuantity = "UPDATE loxah_postmeta SET meta_value = " .$komadOstalo. " WHERE meta_id = ".$stockNumber["meta_id"];
                                                                                  
                                                                                                                  //update stock value
                                                                                                                  $UpdateSqlSales = "UPDATE loxah_postmeta SET meta_value = 'outofstock' WHERE meta_id = ".$stockControl["meta_id"]. " and meta_key like '_stock_status'";
                                                                                                                  $link->query($UpdateSqlQuantity); 

                                                                                                                  if($komadOstalo == 0){
                                                                                                                    $link->query($UpdateSqlSales); //nije više na prodaju jer je nestalo
                                                                                                                  }

                                                                                                                  //calculate price
                                                                                                                  $price = number_format(($piceFromBazzarValue /100), 2, '.', ' ');
                                                                                                                  $PostName = 'Order Bazzar &ndash;baz#'.$bazzarId;

                                                                                                                  ///UNOS U POST
                                                                                                                  $InsertQuery = "
                                                                                                                  INSERT INTO  loxah_posts
                                                                                                                  (post_author, post_date, post_date_gmt, post_title, post_status, comment_status, ping_status, post_name, post_type) 
                                                                                                                  VALUES (1, '$date', '$date',
                                                                                                                  'Order Bazzar &ndash;baz#$bazzarId',
                                                                                                                  'wc-completed', 'closed', 'closed', 'order', 'shop_order')";

                                                                                                                  $getPostIdQuery = "select ID from loxah_posts where post_title like '%baz#%$bazzarId%' order by ID DESC limit 1";
                                                                                                                 
                                                                                                                  //ako je unos uspješan
                                                                                                                  if ($link->query($InsertQuery) === TRUE) 
                                                                                                                  {
                                                                                                                    $postId = mysqli_query($link, $getPostIdQuery);
                                                                                                                    $getPostId = mysqli_fetch_assoc($postId); 

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
                                                                                                                              (post_id, meta_key, meta_value) VALUES (".$getPostId["ID"].", '_order_currency','EUR')"; //HRK
                                                                                                            
                                                                                                            
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
                                                                                                                              $InsertWooMetaData3 = "INSERT INTO loxah_woocommerce_order_itemmeta (order_item_id, meta_key, meta_value) VALUES ('".$orderID["order_item_id"]."','_qty', '".$komada."')"; ///bug! stavi koliko je naručeno
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
                                                                                                                            
                                                                                                                            #region poruka  
                                                                                                                        
                                                                                                                              $message = "USPJEŠNA REZERVACIJA I UNOS PRODAJE SKU : ".$SKU.", bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                                                                                                              $subject = "Rezervacija artikla na Bazzaru";
                                                                                                                              $txt = "Upravo je REZERVIRAN  artikl na bazzar shopu,"."\r\n".
                                                                                                                              "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                                                                                                              "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                                                                                                                              "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                                                                                              "Naziv proizvoda : ".$title ."\r\n".
                                                                                                                              "Broj cipele : ".$variantData."\r\n".
                                                                                                                              "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";

                                                                                                                              $ErrorInsert = "
                                                                                                                              INSERT INTO tbl_BazzarELog
                                                                                                                              (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES 
                                                                                                                              ('$date',        'OK','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$BazzarInvoiceID', '$bazzarId')"; 
                                                                                                                              $linkError->query($ErrorInsert);
                                                                                                                            } 

                                                                  else{
                                                                    $message = "OTKAZANA PRODAJA SKU : ".$SKU.", bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                                                    $subject = "OTKAZANO!";
                                                                    $txt = "Upravo je OTKAZANA PRODAJA na bazzar shopu,"."\r\n".
                                                                    "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                                                    "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                                                                    "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                                                    "Naziv proizvoda : ".$title ."\r\n".
                                                                    "Broj cipele : ".$variantData."\r\n".
                                                                    "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";

                                                                    $ErrorInsert = "
                                                                    INSERT INTO tbl_BazzarELog
                                                                    (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES 
                                                                    ('$date',        'OTKAZAN','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$BazzarInvoiceID', '$bazzarId')"; 
                                                                    $linkError->query($ErrorInsert);
                                                                  }
                                                                                                                            #region hvatanje i zapis loga test
                                                                                                                            
                                                                                                                            $dataLog = "SKU :" .$SKU;
                                                                                                                            $dataToLog = array(date("d-m-Y H:i:s"),  
                                                                                                                                                $_SERVER['REMOTE_ADDR'], //IP address
                                                                                                                                                $message, 
                                                                                                                                                $dataLog
                                                                                                                                                );
                                                                                                                            
                                                                                                                            //ZAPIS LOG U FILE
                                                                                                                            $data = implode(" - ", $dataToLog);
                                                                                                                            $data .= PHP_EOL;
                                                                                                                            $pathToFile = 'logSales.log';
                                                                                                                            file_put_contents($pathToFile, $data, FILE_APPEND);
                                                                                                                                        
                                                                                                                            $to = "info@mojecipele.com";
                                                                                                                        
                                                                                                                            $headers = "From: BazzarReport@mojecipele.com"."\r\n";
                                                                                                                            //"CC: info@mojecipele.com";
                                                                                                                            
                                                                                                                            mail($to,$subject,$txt,$headers);

                                                                                                                            #endregion 
                                                            }//end ako je unos uspiješan

                                                      }//end ako je sve ok

                                                  }///END AKO JE OK S STANJEM
                                      

                                      } //END CHECK INSTOCKVALUE

                                      //ako je outofstock
                                      else
                                      {

                                        //echo '(NEMA NA STANJU ZA PRODAJU : '.$SKU.' )';

                                        if($bazzar_status == "cancelled")
                                        {
                                          $message = "OTKAZANA PRODAJA : ".$SKU.", bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                          $subject = "otkazana prodaja, moraš provjeriti stanje cipele";
                                          $txt = "Upravo je OTKAZAN artikl koji nije na stanju, postoji mogučnost da ga vračaš na stanje "."\r\n".
                                          "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                          "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                                          "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                          "Naziv proizvoda : ".$title ."\r\n".
                                          "Broj cipele : ".$variantData."\r\n".
                                          "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";

                                          $ErrorInsert = "
                                          INSERT INTO tbl_BazzarELog
                                          (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES 
                                          ('$date', 'OTKAZANO','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$BazzarInvoiceID', '$bazzarId')"; 
                                          $linkError->query($ErrorInsert);
                                        }

                                        else{
                                          $message = "NEMA DOVOLJNO NA STANJU ZA REZERVACIJU : ".$SKU.", bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                                          $subject = "Rezervacija, artikla nema ga na stanju";
                                          $txt = "Upravo je pokušana rezervacija artikla koji nije na stanju,"."\r\n".
                                          "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                          "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                                          "Proizvod (Bazzar id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                          "Naziv proizvoda : ".$title ."\r\n".
                                          "Broj cipele : ".$variantData."\r\n".
                                          "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";

                                          $ErrorInsert = "
                                          INSERT INTO tbl_BazzarELog
                                          (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES 
                                          ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$BazzarInvoiceID', '$bazzarId')"; 
                                           $linkError->query($ErrorInsert);
                                        }

                                        #region hvatanje i zapis loga test
                                        
                                        $dataLog = "SKU :" .$SKU;
                                        $dataToLog = array(date("d-m-Y H:i:s"),  
                                                             $_SERVER['REMOTE_ADDR'], //IP address
                                                             $message, 
                                                             $dataLog
                                                             );
                                         
                                         //ZAPIS LOG U FILE
                                         $data = implode(" - ", $dataToLog);
                                         $data .= PHP_EOL;
                                         $pathToFile = 'logSales.log';
                                         file_put_contents($pathToFile, $data, FILE_APPEND);
                                                     
                                         $to = "info@mojecipele.com";
                                        
                                         $headers = "From: BazzarReport@mojecipele.com" . "\r\n";
                                          //"CC: info@mojecipele.com";
                                         
                                         mail($to,$subject,$txt,$headers);
                                       
                                      }//end of oautofstock
                        


                    
                    }//END SKU CHECK

                    //NEMA SKU PROIZVODA
                    else 
                    {
                      echo "nema proizvoda";
                      $message = "NEMA PROIZVODA SKU : ".$SKU.", sales bazzarID : ". $bazzarId. ", Bazzar InvoiceID : ".$BazzarInvoiceID.", komada se prodaje :".$komada." ,broj cipele :".$variantData;
                      $dataLog = "ERROR FAIL 4, NEMA PROIZVODA ". $st;
                              $dataToLog = array(
                                date("d-m-Y H:i:s"), //Date and time
                                $_SERVER['REMOTE_ADDR'], //IP address
                                'Error', //Custom text
                                $message, //message
                                $dataLog//data
                              );


                      //ZAPIS LOG U FILE
                      $data = implode(" - ", $dataToLog);
                      $data .= PHP_EOL;
                      $pathToFile = 'logSales.log';
                      file_put_contents($pathToFile, $data, FILE_APPEND);
        
                              $ErrorInsert = "
                              INSERT INTO tbl_BazzarELog
                              (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID, BazzarSKUID) VALUES  
                              ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU',  '$BazzarInvoiceID', '$bazzarId')";
                              $linkError->query($ErrorInsert);
                             
                      
        
                            $to = "info@mojecipele.com";
                            $subject = "Prodaja bazzar - ERROR - NEMA PROIZVODA";
                            $txt = "Upravo je pokušana rezervacija proizvoda koji nije nađen u shopu "."\r\n".
                            "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                            "BAZZAR SALES ID : ".$BazzarInvoiceID."\r\n".
                            "Proizvod (Bazzar id , SKU koji ne postoji) : ".$bazzarId. " ," .$SKU."\r\n".
                            "Naziv proizvoda : ".$title ."\r\n".
                            "Broj cipele : ".$variantData."\r\n".
                            $headers = "From: BazzarReport@mojecipele.com"."\r\n";
                            //"CC: info@mojecipele.com";
                            mail($to,$subject,$txt,$headers);
        
                    } //END NEMA SKU CHECK

        } ///forloop insert data

        //poruka koja se vrača NAKON AUTORIZACIJE
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code //
        if(curl_error($ch)) { 
            echo 'Error: ' . curl_error($ch);
        };
        echo $status_code;
        curl_close($ch);

        
    }////AUTORIZACIJA 2. STUPANJ
  
   //2. STUPANJ  AUTORIZACIJE NIJE PROŠLA
  else
   {
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

    //ZAPIS LOG U FILE
    $data = implode(" - ", $dataToLog);
    $data .= PHP_EOL;
    $pathToFile = 'logSales.log';
    file_put_contents($pathToFile, $data, FILE_APPEND);

      $to = "igorsfera7@gmail.com";
      $subject = "Prodaja bazzar - POKUŠAJ BEZ AUTORIZACIJE";
      $txt = "401 NEMA AUTORIZACIJU 2 STUPANJ,"."\r\n".
      $headers = "From: BazzarReport@mojecipele.com";
      mail($to,$subject,$txt,$headers);

    } //END 2 STUPANJ AUTORIZACIJE
} //ELSE 1. AUTORIJZACIJA ERROR



//clean up file
if($countProductJson === $countSumProductJson ){
$fileToDelete = "data.json";
$json_arr = '';
file_put_contents('data.json', json_encode($json_arr));
}




?>