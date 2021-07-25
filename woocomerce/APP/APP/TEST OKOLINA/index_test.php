<?php

//////samo za test looop i zapisa


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
              $countSumProductJson++;
          }  
          #endregion
          
          $date = date('Y-m-d H:i:s');
          $gmtDate = date('Y-m-d H:i:s');
          $return = "";
          $countProductJson = 0;
            
          $json = file_get_contents('data.json');
          $data = json_decode($json);
            //foreach ($data as $obj) {
                // var_dump($obj->source_id);
            //}

            foreach($data as $obj){
                            
                        $countProductJson = $countProductJson + 1;

                        echo $obj->source_id . ' , ';

                        //get data from json data ---
                        $source_id = $obj->source_id; //moj id SKU
                        $bazzarId = $obj->id;  //prodaja artikla id od bazzara
                        $piceFromBazzarValue = $obj->purchase_price_cents; //CIJENA
                        $SKU = $obj->source_id; //SKU
                        $variantData =  $obj->variant;  //broj cipele
                        $komada = $obj->quantity; 
                        $title = $obj->title; 
                        
                    
                        
                        $message = "Element - " .$SKU;
                                $dataLog = " TEST LOG  ";
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
                                            
                                $to = "igorsfera7@gmail.com";
                                $subject = "Prodaja artila na Bazzaru";
                                $txt = "Upravo je prodan artikl na bazzar shopu,"."\r\n".
                                "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
                                "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
                                "Naziv proizvoda : ".$title ."\r\n".
                                "Broj cipele : ".$variantData."\r\n".
                                "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
                                $headers = "From: BazzarReport@mojecipele.com"; //"\r\n" .
                                // "CC: info@mojecipele.com";
                                
                                //mail($to,$subject,$txt,$headers);
                                $message = 'šđćčž';
                                $ErrorInsert = "
                                INSERT INTO tbl_BazzarELog
                                (dateTimeevent, status, Opis_Error, ipAdress, SKU, bazzarID) VALUES 
                                ('$date',        'ERROR','".$message."', '".$_SERVER['REMOTE_ADDR']."' , '$SKU', '$bazzarId')";  //$bazzarId
                                $linkError->query($ErrorInsert);
                                 echo ".$ErrorInsert.";

                

                    

            } ///forloop insert data


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

    

          $to = "igorsfera7@gmail.com";
          $subject = "Prodaja bazzar - POKUŠAJ BEZ AUTORIZACIJE";
          $txt = "401 NEMA AUTORIZACIJU 2 STUPANJ,"."\r\n".
          "broj proizvoda :" .$countProductJson. " od :" .$countSumProductJson."\r\n". 
          "Proizvod (Bazzar sales id , SKU): ".$bazzarId. " ," .$SKU."\r\n".
          "Naziv proizvoda : ".$title ."\r\n".
          "Broj cipele : ".$variantData."\r\n".
          "Post ID proizvoda koji je nađen : " . $productID["post_id"] . ",  SKU(".$SKU.")";
          $headers = "From: BazzarReport@mojecipele.com";
          //mail($to,$subject,$txt,$headers);
        } //END 2 STUPANJ AUTORIZACIJE
} //ELSE 1. AUTORIJZACIJA ERROR




//clean up file
if($countProductJson === $countSumProductJson ){
  $fileToDelete = "data.json";
  $json_arr = '';
  file_put_contents('data.json', json_encode($json_arr));
}


?>