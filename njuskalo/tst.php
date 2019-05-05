<?php
header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="utf-8"?>';

$link = new mysqli("localhost", "nekrettomisl_userP", "If!k%&C*70lN", "nekrettomisl_nekretW");
mysqli_set_charset($link,"utf8");

//session_start ();
include 'defini_fields.php';
$Contextz_Q = new QueryMain_Context();
echo '<ad_list>';
 // echo'<k>'.$Contextz_Q->f.'</k>';


//////
//////  STANOVI PRODAJA
//////

$container = mysqli_query($link, $Contextz_Q->queryOglasi1);
while($row = mysqli_fetch_assoc($container)){
$tekst = $row["post_content"];


//polja - detalji
$Qdetails = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row["ID"]."
and uudqv_postmeta.meta_key = 'REAL_HOMES_property_price'
and uudqv_postmeta.meta_value >= 0";
$cijena = mysqli_query($link, $Qdetails);
$cijenaRow = mysqli_fetch_assoc($cijena);




//naslovna slika
$QslikeFe = "select DISTINCT  uudqv_posts.guid
from uudqv_posts
INNER JOIN uudqv_postmeta ON uudqv_postmeta.meta_value = uudqv_posts.ID
WHERE uudqv_posts.post_type = 'attachment'
AND uudqv_postmeta.meta_key = '_thumbnail_id'
AND uudqv_postmeta.post_id = ".$row["ID"];
$slika = mysqli_query($link, $QslikeFe);
$slikeRow = mysqli_fetch_assoc($slika);






  //lokacija uudqv // //lokacija uudqv iz WP baze
  $CityWP= "SELECT uudqv_terms.name
                from uudqv_terms
                RIGHT JOIN uudqv_term_taxonomy on uudqv_terms.term_id = uudqv_term_taxonomy.term_id
                LEFT JOIN uudqv_term_relationships ON uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id
                JOIN uudqv_posts on uudqv_posts.ID = uudqv_term_relationships.object_id
                WHERE uudqv_posts.ID = ".$row['ID'].
                " AND uudqv_term_taxonomy.taxonomy = 'property-city'
                GROUP BY uudqv_term_taxonomy.parent";
                $WPLokacija = mysqli_query($link, $CityWP);
                $WPLOKACIJARow = mysqli_fetch_assoc($WPLokacija);
  
    $zupanijaname = $WPLOKACIJARow["name"];
    
    $QZupanije1 = "SELECT * FROM zupanije WHERE nazivZupanije LIKE '$zupanijaname'";   //source iz baze wp-a kroz city name, upit na zupanije  
    $zupanija = mysqli_query($link, $QZupanije1);
    $njuskaZupanija = mysqli_fetch_assoc($zupanija);

    $QNjuskaloKvart_Lost = "SELECT  DISTINCT naziv, id, zupanija, grad, njuskaloId from kvartovi WHERE kvartovi.naziv like '".$WPLOKACIJARow["name"]."%'"; 
    $kvartNjuskao_lost = mysqli_query($link, $QNjuskaloKvart_Lost);
    $njuskaloKvartRow_Lost = mysqli_fetch_assoc($kvartNjuskao_lost);

          // if($njuskaZupanija["id"] > 0) //ako smo našli županiju idemo pogledati gradove
          // {
          //       $QGradovi1 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaZupanija["id"]." and naziv like = '%".$WPLOKACIJARow["name"]."%'";    
          //       $grad_njuskaloId = mysqli_query($link, $QGradovi1);
          //       $nuskaloGradRow = mysqli_fetch_assoc($grad_njuskaloId);

          //       //ako ima grad tada idemo tražit i kvart
                 $QNjuskalo_Kvart = "SELECT * from kvartovi WHERE kvartovi.grad = ".$nuskaloGradRow["id"]." and naziv like = '%".$WPLOKACIJARow["name"]."%'";  
          //       $kvart_njuskaloId = mysqli_query($link,  $QNjuskalo_Kvart);
          //       $njuskaloKvartRow = mysqli_fetch_assoc($kvart_njuskaloId);  
          // }
          // else{
          //       //ako ima grad tada idemo tražit i kvart
          //       $QNjuskalo_Kvart = "SELECT * from kvartovi WHERE kvartovi.naziv like = '".$WPLOKACIJARow["name"]."'";  
          //       $kvart_njuskaloId = mysqli_query($link,  $QNjuskalo_Kvart);
          //       $njuskaloKvartRow = mysqli_fetch_assoc($kvart_njuskaloId);  


          //        $QGradovi1 = "SELECT * from gradovi WHERE gradovi.naziv like = '".$WPLOKACIJARow["name"]."'";    
          //       $grad_njuskaloId = mysqli_query($link, $QGradovi1);
          //       $nuskaloGradRow = mysqli_fetch_assoc($grad_njuskaloId);
          // }


          // if($njuskaZupanija["id"] > 0) //ako smo našli županiju idemo pogledati gradove
          // {
                 $QGradovi1 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaZupanija["id"];
                 $grad_njuskaloId = mysqli_query($link, $QGradovi1);
                 $nuskaloGradRow = mysqli_fetch_assoc($grad_njuskaloId);

                 //ako ima grad tada idemo tražit i kvart
                 $QNjuskalo_Kvart = "SELECT * from kvartovi WHERE kvartovi.grad = ".$nuskaloGradRow["id"]; 
                 $kvart_njuskaloId = mysqli_query($link,  $QNjuskalo_Kvart);
                 $njuskaloKvartRow = mysqli_fetch_assoc($kvart_njuskaloId);  

                  if($njuskaloKvartRow["njuskaloId"] < 1){
                      $njuskaloKvartRow["njuskaloId"] = $njuskaloKvartRow_Lost["njuskaloId"];
                      $njuskaloKvartRow["naziv"] = $njuskaloKvartRow_Lost["naziv"];
                  }
           //}
     


    




    //$QTbl_Lokacija3 = "SELECT * FROM kvartovi WHERE id = ".$nuskaloGradRow["id"];

            ///karta i google zapisi
                    $QMap = "SELECT * FROM uudqv_postmeta where uudqv_postmeta.post_id = ".$row["ID"].
                    " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                    " and uudqv_postmeta.meta_value >= 0";
                    $map = mysqli_query($link, $QMap);
                    $gMapRow = mysqli_fetch_assoc($map);
                    // $rest = substr($gMapRow["meta_value"], 0, 8);
                    // $rest2 = substr($gMapRow["meta_value"], 8, 8);
                    // echo $rest;
                    //  echo $rest2;
                      ///https://github.com/uudqvPlugins/realhomes-xml-csv-property-listings-import/blob/master/realhomes-add-on.php

                      if(!is_null($gMapRow["meta_value"]) || $gMapRow["meta_value"] != ''){
                          $rest = explode(",", $gMapRow["meta_value"]);
                          $Lon = $rest[1];
                          $Lat = $rest[0];
                      }else{
                        $Lat = 0;
                        $Lon = 0;
                      }
                  

                    



                    //orignal kaže uudqv
                    // $property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
                    // if ( ! empty( $property_location ) ) {
                    // 	$lat_lng = explode( ',', $property_location );
                    // 	$current_property_data[ 'lat' ] = $lat_lng[ 0 ];
                    // 	$current_property_data[ 'lng' ] = $lat_lng[ 1 ];
                    // }

                      $QbrojSoba = "SELECT meta_value FROM uudqv_postmeta where 
                      uudqv_postmeta.post_id = ".$row["ID"]. 
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                      and uudqv_postmeta.meta_value >= 0";
                      $brSoba = mysqli_query($link, $QbrojSoba);
                      $sobeRow = mysqli_fetch_assoc($brSoba);

                    





                      $QFeaturesT1 = "SELECT  uudqv_terms.name
                                      from uudqv_term_relationships
                                      LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                      LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                      LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                      WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                      AND post_status='publish'
                                      AND uudqv_posts.ID = ".$row["ID"].
                                      " AND uudqv_terms.name = 'Teretni Lift'";
                                      $liftT = mysqli_query($link, $QFeaturesT1);
                                      $liftRow = mysqli_fetch_assoc($liftT);


                      $QFeaturesT1_ = "SELECT  uudqv_terms.name
                                      from uudqv_term_relationships
                                      LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                      LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                      LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                      WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                      AND post_status='publish'
                                      AND uudqv_posts.ID = ".$row["ID"].
                                      " AND uudqv_terms.name = 'Lift'";
                                      $liftT_ = mysqli_query($link, $QFeaturesT1_);
                                      $liftRow_ = mysqli_fetch_assoc($liftT_);


                                      
                                    
                                  



                      $QSize = "SELECT meta_value FROM uudqv_postmeta
                      where uudqv_postmeta.post_id = ".$row["ID"]. 
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_size'
                      and uudqv_postmeta.meta_value >= 0";
                      $size_ = mysqli_query($link, $QSize);
                      $sizeRow = mysqli_fetch_assoc($size_); 
                      $size = $sizeRow["meta_value"];




                      $QYearBuild = "SELECT meta_value FROM uudqv_postmeta
                      where uudqv_postmeta.post_id = ".$row["ID"].
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                      and uudqv_postmeta.meta_value >= 0";
                      $yearB = mysqli_query($link, $QYearBuild);
                      $year = mysqli_fetch_assoc($yearB);


                      $Grijanje = "SELECT  uudqv_terms.name
                                  from uudqv_term_relationships
                                  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row["ID"]."
                                    AND uudqv_terms.name = 'Plinsko etažno'
                                  OR uudqv_terms.name = 'Radijatori na struju'
                                  OR uudqv_terms.name = 'Toplana'";
                          $grijanjeTip = mysqli_query($link, $Grijanje);
                          $GrijanjeRow = mysqli_fetch_assoc($grijanjeTip);        


                                

                      $QParking = "SELECT uudqv_terms.name from uudqv_term_relationships 
                      LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID 
                      LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id 
                      LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id 
                      WHERE uudqv_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND uudqv_posts.ID = ".$row["ID"]. 
                      " AND uudqv_terms.name = 'Parking' ";
                      $parking = mysqli_query($link, $QParking);
                      $ParkingRow = mysqli_fetch_assoc($parking);



                                  $QKlima = "SELECT  uudqv_terms.name
                                            from uudqv_term_relationships
                                            LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                            LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                            WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row["ID"]. 
                                              " AND uudqv_terms.name = 'Klima uređaj' ";
                      $klima = mysqli_query($link, $QKlima);
                      $KlimaRow = mysqli_fetch_assoc($klima);



                      
                                  $QVlList = "SELECT  uudqv_terms.name
                                            from uudqv_term_relationships
                                            LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                            LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                            WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row["ID"]. 
                                              " AND uudqv_terms.name = 'Vlasnički list u posjedu'";
                      $Vlist = mysqli_query($link, $QVlList);
                      $VlistRow = mysqli_fetch_assoc($Vlist);



                      $QBazen = "SELECT  uudqv_terms.name
                                  from uudqv_term_relationships
                                  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row["ID"]. 
                                    " AND uudqv_terms.name = 'Bazen'";
                                    $Bazen = mysqli_query($link, $QBazen);
                                    $BazenRow = mysqli_fetch_assoc($Bazen);



                                    $QKablovska = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND uudqv_terms.name = 'Kablovska'";
                                                    $Kablovska = mysqli_query($link, $QKablovska);
                                                    $KablovskaRow = mysqli_fetch_assoc($Kablovska);


                                                    
                                    $QSatelit = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND uudqv_terms.name = 'Satelitska'";
                                                    $satelit = mysqli_query($link, $QSatelit);
                                                    $SatelitRow = mysqli_fetch_assoc($satelit);


                                          $QAlarm = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND uudqv_terms.name = 'Alarm'";
                                                    $alarm = mysqli_query($link, $QAlarm);
                                                    $AlarmRow = mysqli_fetch_assoc($alarm);


                                                    $QTelefon = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"].
                                                    " AND uudqv_terms.name = 'Telefon (upotreba)'";
                                                    $telefon_ = mysqli_query($link, $QTelefon);
                                                    $TelefonRow_ = mysqli_fetch_assoc($telefon_);
                                                    


                                                  $QTelefon_L = "SELECT  uudqv_terms.name
                                                  from uudqv_term_relationships
                                                  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                  AND post_status='publish'
                                                  AND uudqv_posts.ID = ".$row["ID"].
                                                  " AND uudqv_terms.name = 'Telefon'";
                                                  $telefon_L = mysqli_query($link, $QTelefon_L);
                                                  $TelefonRow_L = mysqli_fetch_assoc($telefon_L);

 

echo '<ad_item class="ad_flats">
    <user_id>444900</user_id>
        <original_id>s-'.$row["ID"].'</original_id>';
        echo '<category_id>9580</category_id>',"\n";
       
//naslov
  echo '<title>',$row['post_title'],'</title>';
  //link na stranicu
      echo '<external_url>'.$row["guid"].'</external_url>', "\n";
           //tekst oglasa
           $html = preg_replace('#<iframe[^>]+>.*?</iframe>#is', '', $tekst);
          // $html = $tekst;
            echo '<description_raw>'; 
                echo '<![CDATA[',$html,']]>';
            echo '</description_raw>',"\n";

                echo '<price>',$cijenaRow['meta_value'],'</price>
                <currency_id>2</currency_id>',"\n";
                   
                  //slike                  
                  echo '<image_list>',"\n";
                                  echo '<image>'. $slikeRow["guid"].'</image>',"\n";
                                      //galerija slika
                                      $Qgalerija = "select DISTINCT uudqv_posts.guid
                                      from uudqv_posts
                                      INNER JOIN uudqv_postmeta ON (uudqv_postmeta.meta_value = uudqv_posts.ID)
                                      WHERE uudqv_posts.post_type = 'attachment'
                                      AND uudqv_postmeta.meta_key = 'REAL_HOMES_property_images'
                                      AND uudqv_postmeta.post_id = ".$row["ID"].
                                      " ORDER BY uudqv_posts.post_date DESC";
                                                                $gallery = mysqli_query($link, $Qgalerija);
                                                                while( $galleryRow = mysqli_fetch_assoc($gallery)){
                                                                      echo '<image>'. $galleryRow["guid"].'</image>',"\n";
                                                                }    
                  echo '</image_list>',"\n";



                                      //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                      echo '<additional_contact></additional_contact>',"\n";


                  echo'<GRADWP>'.$WPLOKACIJARow["name"].'</GRADWP>'; //ovo je prvo kroz to ide, to je iz Wordpress
                  echo'<U>'. $QZupanije1.'</U>'; //ovo je prvo kroz to ide, to je iz Wordpress $QZupanije1  $QGradovi1
                  echo'<U1>'. $QGradovi1.'</U1>'; //
                  echo'<U2>'.$QNjuskalo_Kvart.'</U2>';
                  echo'<zupanijaID>'.$njuskaZupanija["id"].'</zupanijaID>'; //nalazi iz gradova po ID zupanije---
                  echo'<gradID>'.$nuskaloGradRow["id"].'</gradID>'; //ovo dobije iz zupanijeRow ime zupanije iz tablice kvartovi
                  echo'<grad>'.$nuskaloGradRow["naziv"].'</grad>'; //isto samo naziv
                  echo'<njuskaloKvart1>'.$njuskaloKvartRow["njuskaloId"].'</njuskaloKvart1>';
                  echo'<njuskaloKvart>'.$njuskaloKvartRow_Lost["njuskaloId"].'</njuskaloKvart>';
                  echo'<njuskaloKvartName>'.$njuskaloKvartRow_Lost["naziv"].'</njuskaloKvartName>';



                                      //određivanje lokacija
                                      echo '<level_0_location_id>';
                                      //zupanija
                                      echo $njuskaZupanija["njuskaloId"].'</level_0_location_id>',"\n";
                                      
                                      //grad
                                      echo '<level_1_location_id>'.$nuskaloGradRow["njuskaloId"].'</level_1_location_id>',"\n";
                                                            //gradovi zupanija          
                                    //  switch($njuskaloKvartRow["grad"]){     //nađi u tablici od njušakala exceliic samo id grad, ako je grad id taj da možemo 
                                        //ovo je grad ID, u tablici kvart selektiraj neki kvart u gradu kao centar
                                        //switchat id kvarta
                                        // case 5:
                                        //     $o = 2678;
                                        //     break;

                                            // case 1:
                                            // $o = 2619;
                                            // break;

                                            // case 138:
                                            // $o = 10;
                                            // break;

                                            // case 6:
                                            // $o = 14;
                                            // break;

                                            // case 142:
                                            // $o = 21;
                                            // break;

                                            // case 3:
                                            // $o = 26;
                                            // break;

                                            // case 141:
                                            // $o = 31;
                                            // break;

                                            // case 4:
                                            // $o = 50;
                                            // break;

                                            // case 8:
                                            // $o = 61;
                                            // break;

                                            // case 9:
                                            // $o = 76;
                                            // break;

                                            // case 5:
                                            // $o = 82;
                                            // break;

                                            // case 137:
                                            // $o = 91;
                                            // break;

                                            // case 7:
                                            // $o = 102;
                                            // break;
                                            // ///po njuškalo id
                                            // case 140:
                                            // $o = 2732;
                                            // break;

                                            // case 138:
                                            // $o = 2597;
                                            // break;

                                            // case 2:
                                            // $o = 2613;
                                            // break;

                                            // case 139:
                                            // $o = 2623;
                                            // break;


                                            // case 144:
                                            // $o = 2771;
                                            // break;

                                            // case 9:
                                            // $o = 2771;
                                            // break;

                                            // case 84:
                                            // $o = 8758;
                                            // break;

                                            // case 78:
                                            // $o = 2247;
                                            // break;

                                            // case 373:
                                            // $o = 5772;
                                            // break;

                                            // case 217:
                                            // $o = 2823;
                                            // break;

                                            // default:
                                            // $o = 1111;

                                      // }                                

                                              //ovaj uvjet jebe dobijam 1
                                             if($njuskaloKvartRow_Lost["njuskaloId"] = 0 || is_null($njuskaloKvartRow_Lost["njuskaloId"])){
                                                // $njuskaloKvartRow["njuskaloId"] = $njuskaloKvartRow_Lost["njuskaloId"];
                                                 echo '<level_2_location_id>'.$njuskaloKvartRow["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                               }

                                              //  else{
                                              //       if($WPLOKACIJARow["name"] = "Grad Zagreb")
                                              //       {echo '<level_2_location_id>2656</level_2_location_id>',"\n";}
                                              //         else{echo '<level_2_location_id>'.$njuskaloKvartRow_Lost["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski 
                                              //     }
                                              //  }
                                                 
                                               
                                           
                                              
                                  

                                      //ulica (mikrolokacija po JAKO starom)
                                      echo '<street_name>0</street_name>',"\n";


                                      //Lokacija na google karti
                                        if ( $Lon AND $Lat ) {
                                            echo '<location_x>'.$Lon.'</location_x>',"\n";
                                            echo '<location_y>'.$Lat.'</location_y>',"\n";
                                        }else{
                                              echo '<location_x>'.$njuskaloKvartRow_Lost["lng"].'</location_x>',"\n";
                                              echo '<location_y>'.$njuskaloKvartRow_Lost["lat"].'</location_y>',"\n";
                                        }


                                        echo '<flat_type_id>0</flat_type_id>',"\n";


                                        //broj etaža
                                        if(strstr($row['post_content'], "Broj etaža :")){
                                                    $etaza = strstr($row['post_content'], "Broj etaža :",0);
                                                    $etaza = substr($etaza,14,1);
                                                    switch ($etaza){
                                                      case "1":
                                                      $etaza = "184";
                                                      break;

                                                      case "2":
                                                        $etaza = "185";
                                                        break;

                                                        case "3":
                                                        $etaza = "186";
                                                        break;
                                                      }
                                                    
                                            echo '<floor_count_id>'. $etaza.'</floor_count_id>',"\n";
                                          }   else{
                                            echo '<floor_count_id>0</floor_count_id>',"\n";
                                          }




                                        //Broj soba
                                          echo '<room_count_id>';
                                          $sobe = $sobeRow["meta_value"];
                                          if($sobe != ''){
                                                    switch ($sobe){
                                                      case "1";
                                                      $sobe= "188";
                                                      break;
                                                      case "2";
                                                      $sobe = "189";
                                                      break;
                                                      case "3";
                                                      $sobe = "190";
                                                      break;
                                                      case "4";
                                                      $sobe = "191";
                                                      break;
                                                    }
                              
                                          }else{$sobe = 0;}
                                              
                                            echo $sobe;
                                            echo '</room_count_id>',"\n";




                                            //kat
                                            echo '<flat_floor_id>';
                                            $broj = "0";
                                              if(strstr($row['post_content'], "Zgrada ima katova :")){
                                                        $broj = strstr($row['post_content'], "Zgrada ima katova :",0);
                                                          $broj = substr($broj,20,1);
                                                switch($broj){
                                                            case "1";
                                                            $broj = "193";
                                                            break;
                                                            case "2":
                                                            $broj = "192";
                                                            break;
                                                      
                                                            case "3":
                                                            $broj = "194";
                                                            break;
                                                      
                                                            case "4":
                                                            $broj = "192";
                                                            break;    
                                                      
                                                            case "5":
                                                            $broj = "218";
                                                            break;
                                                }


                                              }else{$broj = 0;}
                                                  echo $broj;
                                                echo '</flat_floor_id>',"\n";




                                                //lift
                                                
                                                  if($liftRow["name"] || $liftRow_["name"]){
                                                      echo '<elevator>1</elevator>',"\n";
                                                    }


                                                //površina
                                                if($size > 0){
                                                      echo '<main_area>'.$size.'</main_area>',"\n";
                                                }

                                                //vrt površina
                                                  echo '<garden_area>0</garden_area>',"\n";

                                                  //balkon površina
                                                echo '<balcony_area>0</balcony_area>',"\n";

                                                //terasa površina
                                                echo '<terace_area>0</terace_area>',"\n";

                                                    
                                              
                                                //godina izgradnje 
                                                  if ($year['meta_value']){
                                                      echo '<year_built>'.$year['meta_value'].'</year_built>',"\n";
                                                  }else{
                                                    echo '<year_built>0</year_built>',"\n";
                                                  }


                                                if(strstr($row['post_content'], "Adaptacija :")){
                                                          $adap = strstr($row['post_content'], "Adaptacija :",0);
                                                          $adap = substr($adap,12,7);
                                                          echo '<year_last_rebuild>',$adap,'</year_last_rebuild>',"\n";
                                                }else{
                                                  echo '<year_last_rebuild>0</year_last_rebuild>',"\n";
                                                }

                                                //novogradnja
                                                  echo '<new_building>0</new_building>',"\n";
                                          

                                            //grijanje

                                            echo '<heating_type_id>';
                                                switch ($GrijanjeRow["name"])
                                                {
                                                
                                                    case "Plinsko etažno":
                                                    case "Toplana":
                                                    $broj = "224";
                                                    break;
                                                  
                                                    case "Radijatori na struju":
                                                    $broj = "225";
                                                    break;

                                                    case "":
                                                    $broj = "0";
                                                    break;
                                                
                                                }

                                                echo $broj;

                                            echo '</heating_type_id>',"\n";


                                            echo '<parking_spot_count>';
                                        
                                            if($ParkingRow["name"]){
                                            echo '1';
                                            }else{echo '0';}
                                            echo '</parking_spot_count>'."\n";

                //LOOKUP LISTA
                echo '<lookup_list>';
                                          
                                  
                                                      //telefon
                                                      if($TelefonRow_["name"] !== null || $TelefonRow_L["name"] !== null){
                                                            echo '<lookup_item code="installations">223</lookup_item>',"\n";
                                                      }else{echo '<lookup_item code="installations">0</lookup_item>',"\n";}
                                                  

                                                      //grijanje
                                                  if ($GrijanjeRow["name"] == "Toplana"){ 
                                                        echo '<lookup_item code="heating">229</lookup_item>',"\n";   
                                                      }

                                                  if ($KlimaRow["name"]) {
                                                      echo '<lookup_item code="heating">231</lookup_item>',"\n";
                                                      }


                                                    //Vlasnički list
                                                    if($VlistRow["name"]){
                                                        echo '<lookup_item code="permits">232</lookup_item>',"\n"; 
                                                    }else{
                                                                  //vlista alternativa 
                                                                    $gVDozvola = strstr($row['post_content'], "Vlasnički list:",0);
                                                                    $gVDozvola = substr($gVDozvola,14,4);
                                                                    if($gVDozvola){
                                                                        echo '<lookup_item code="permits">232</lookup_item>',"\n";           
                                                                    }          
                                                    }

                                                

                                                    //građevinska 
                                                      if(strstr($row['post_content'], "Građevinska dozvola:")){
                                                          $gDozvola = strstr($row['post_content'], "Građevinska dozvola:",0);
                                                          $gDozvola = substr($gDozvola,21,4);
                                                          if($gDozvola){
                                                              echo '<lookup_item code="permits">233</lookup_item>',"\n";           
                                                          }  
                                                  }


                                                      //uporabna 
                                                      if(strstr($row['post_content'], "Uporabna dozvola:")){
                                                          $gUDozvola = strstr($row['post_content'], "Uporabna dozvola:",0);
                                                          $gUDozvola = substr($gUDozvola,17,4);
                                                          if($gUDozvola){
                                                              echo '<lookup_item code="permits">234</lookup_item>',"\n";           
                                                          }  
                                                  }


                                                      //bazen                                                      
                                                    if ($BazenRow["name"]) {
                                                    echo '<lookup_item code="garden">164</lookup_item>',"\n";   
                                                    }

                                                      //roštilj    
                                                      $gRostilj = strstr($row['post_content'], "Ugrađen roštilj",0);
                                                      if ($gRostilj) {
                                                      echo '<lookup_item code="garden">166</lookup_item>',"\n";
                                                      }


                                                          //electronics
                                                            if ($KablovskaRow["name"]) {
                                                            echo '<lookup_item code="electronics">167</lookup_item>',"\n"; 
                                                            }

                                                                if ($SatelitRow['name'] ) {
                                                                      echo '<lookup_item code="electronics">168</lookup_item>',"\n";
                                                                    }

                                                                    //alarm
                                                                    if ( $AlarmRow['name'] ) {
                                                                        echo '<lookup_item code="electronics">171</lookup_item>',"\n";   
                                                                        }


                                                          

                                                                 
     
     
        echo '</lookup_list>',"\n";// KRAJ LOOPa
  

        echo '</ad_item>',"\n"; //end nekretnine
                                           //  mysqli_free_result($row);
                                           //  mysqli_free_result($slikeRow);
                                           //  mysqli_free_result($gallRow);
                                            // mysqli_free_result($WPLOKACIJARow);
                                            // mysqli_free_result($cijenaRow);
                                           //  mysqli_free_result($njuskaZupanija);
                                            // mysqli_free_result($gMapRow);
                                            // mysqli_free_result($brSoba);
                                            // mysqli_free_result($liftT);
                                            // mysqli_free_result($sizeRow);
                                            // mysqli_free_result($year);
                                           // mysqli_free_result($grijanjeTip);
                                           // mysqli_free_result($parking);
                                          //  mysqli_free_result($klima);
                                          //  mysql_free_result($Vlist); ne radi
                                         //  mysqli_free_result($BazenRow);
                                        // mysqli_free($Kablovska);

}// KRAJ LOOPa stanova prodaja



                                                                    

echo '</ad_list>';




?>

