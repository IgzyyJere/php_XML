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



//brojac za galerije slike
//galerija slika
// $QgalCount = "select DISTINCT  count(uudqv_posts.guid)
//   from uudqv_posts
//   INNER JOIN uudqv_postmeta ON (uudqv_postmeta.meta_value = uudqv_posts.ID)
//   WHERE uudqv_posts.post_type = 'attachment'
//   AND uudqv_postmeta.meta_key = 'REAL_HOMES_property_images'
//   AND uudqv_postmeta.post_id = ".$row["ID"].
//   " ORDER BY uudqv_posts.post_date DESC";
//   $gall = mysqli_query($link, $QgalCount);
//   $gallRow = mysqli_fetch_assoc($gall);
//   $picCount = $gallRow["count(uudqv_posts.guid)"];


  //lokacija WP
  $QlokacijaZupanija = "SELECT wp_terms.name
                from wp_terms
                RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                JOIN uudqv_posts on uudqv_posts.ID = wp_term_relationships.object_id
                WHERE uudqv_posts.ID = ".$row['ID'].
                " AND wp_term_taxonomy.taxonomy = 'property-city'
                GROUP BY wp_term_taxonomy.parent";
                $zupanija = mysqli_query($link, $QlokacijaZupanija);
                $zupanijaRow = mysqli_fetch_assoc($zupanija);

                
                
              //  $zupanijaRow["name"]; //ime zupanije iz baze




    $QTbl_Lokacija1 = "SELECT * from zupanije
                      where zupanije.nazivZupanije = '".$zupanijaRow["name"]."'";        
                      $zupanija_njuskaloId = mysqli_query($link, $QTbl_Lokacija1);
                      $njuskaloZupRow = mysqli_fetch_assoc($zupanija_njuskaloId);

                              if($njuskaloZupRow["id"] > 0)
                              {
                                    $QTbl_Lokacija2 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaloZupRow["id"];    
                                    $grad_njuskaloId = mysqli_query($link, $QTbl_Lokacija2);
                                    $nuskaloGradRow = mysqli_fetch_assoc($grad_njuskaloId);
                              }else{
                                $nuskaloGradRow = null;
                              }



                            
                              
                                    $Njuskalo_Lokacija2 = "SELECT * from kvartovi WHERE kvartovi.zupanija = ".$nuskaloGradRow["id"];    
                                    $kvart_njuskaloId = mysqli_query($link,  $Njuskalo_Lokacija2);
                                    $nuskaloKvartRow = mysqli_fetch_assoc($kvart_njuskaloId);
                            
                            
                              







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
                      ///https://github.com/WPPlugins/realhomes-xml-csv-property-listings-import/blob/master/realhomes-add-on.php

                      if(!is_null($gMapRow["meta_value"]) || $gMapRow["meta_value"] != ''){
                          $rest = explode(",", $gMapRow["meta_value"]);
                          $Lon = $rest[1];
                          $Lat = $rest[0];
                      }else{
                        $Lat = 0;
                        $Lon = 0;
                      }
                  

                    



                    //orignal kaže WP
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

                    





                      $QFeaturesT1 = "SELECT  wp_terms.name
                                      from wp_term_relationships
                                      LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                      LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                      LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                      WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                      AND post_status='publish'
                                      AND uudqv_posts.ID = ".$row["ID"].
                                      " AND wp_terms.name = 'Teretni Lift'";
                                      $liftT = mysqli_query($link, $QFeaturesT1);
                                      $liftRow = mysqli_fetch_assoc($liftT);


                      $QFeaturesT1_ = "SELECT  wp_terms.name
                                      from wp_term_relationships
                                      LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                      LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                      LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                      WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                      AND post_status='publish'
                                      AND uudqv_posts.ID = ".$row["ID"].
                                      " AND wp_terms.name = 'Lift'";
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


                      $Grijanje = "SELECT  wp_terms.name
                                  from wp_term_relationships
                                  LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row["ID"]."
                                    AND wp_terms.name = 'Plinsko etažno'
                                  OR wp_terms.name = 'Radijatori na struju'
                                  OR wp_terms.name = 'Toplana'";
                          $grijanjeTip = mysqli_query($link, $Grijanje);
                          $GrijanjeRow = mysqli_fetch_assoc($grijanjeTip);        


                                

                      $QParking = "SELECT wp_terms.name from wp_term_relationships 
                      LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID 
                      LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                      LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                      WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND uudqv_posts.ID = ".$row["ID"]. 
                      " AND wp_terms.name = 'Parking' ";
                      $parking = mysqli_query($link, $QParking);
                      $ParkingRow = mysqli_fetch_assoc($parking);



                                  $QKlima = "SELECT  wp_terms.name
                                            from wp_term_relationships
                                            LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                            LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                            WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row["ID"]. 
                                              " AND wp_terms.name = 'Klima uređaj' ";
                      $klima = mysqli_query($link, $QKlima);
                      $KlimaRow = mysqli_fetch_assoc($klima);



                      
                                  $QVlList = "SELECT  wp_terms.name
                                            from wp_term_relationships
                                            LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                            LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                            WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row["ID"]. 
                                              " AND wp_terms.name = 'Vlasnički list u posjedu'";
                      $Vlist = mysqli_query($link, $QVlList);
                      $VlistRow = mysqli_fetch_assoc($Vlist);



                      $QBazen = "SELECT  wp_terms.name
                                  from wp_term_relationships
                                  LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row["ID"]. 
                                    " AND wp_terms.name = 'Bazen'";
                                    $Bazen = mysqli_query($link, $QBazen);
                                    $BazenRow = mysqli_fetch_assoc($Bazen);



                                    $QKablovska = "SELECT  wp_terms.name
                                                    from wp_term_relationships
                                                    LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND wp_terms.name = 'Kablovska'";
                                                    $Kablovska = mysqli_query($link, $QKablovska);
                                                    $KablovskaRow = mysqli_fetch_assoc($Kablovska);


                                                    
                                    $QSatelit = "SELECT  wp_terms.name
                                                    from wp_term_relationships
                                                    LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND wp_terms.name = 'Satelitska'";
                                                    $satelit = mysqli_query($link, $QSatelit);
                                                    $SatelitRow = mysqli_fetch_assoc($satelit);


                                          $QAlarm = "SELECT  wp_terms.name
                                                    from wp_term_relationships
                                                    LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"]. 
                                                    " AND wp_terms.name = 'Alarm'";
                                                    $alarm = mysqli_query($link, $QAlarm);
                                                    $AlarmRow = mysqli_fetch_assoc($alarm);


                                                    $QTelefon = "SELECT  wp_terms.name
                                                    from wp_term_relationships
                                                    LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row["ID"].
                                                    " AND wp_terms.name = 'Telefon (upotreba)'";
                                                    $telefon_ = mysqli_query($link, $QTelefon);
                                                    $TelefonRow_ = mysqli_fetch_assoc($telefon_);
                                                    


                                                  $QTelefon_L = "SELECT  wp_terms.name
                                                  from wp_term_relationships
                                                  LEFT JOIN uudqv_posts ON wp_term_relationships.object_id = uudqv_posts.ID
                                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                  AND post_status='publish'
                                                  AND uudqv_posts.ID = ".$row["ID"].
                                                  " AND wp_terms.name = 'Telefon'";
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
            echo '<description_raw>'; 
                echo '<![CDATA[',$tekst,']]>';
            echo '</description_raw>',"\n";

                echo '<price>',$cijenaRow['meta_value'],'</price>
                <currency_id>2</currency_id>',"\n";


                  //slike                  
                  echo '<image_list>',"\n";
                                  echo '<image>glavna slika : '. $slikeRow["guid"].'</image>',"\n";
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


                                      //određivanje lokacija
                                      echo '<level_0_location_id>';
                                      //zupanija
                                      echo $njuskaloZupRow["njuskaloId"].'</level_0_location_id>',"\n";
                                      
                                      //grad
                                      echo '<level_1_location_id>'.$nuskaloGradRow["njuskaloId"].'</level_1_location_id>',"\n";
                                                            //gradovi zupanija          
                                    //  switch($nuskaloKvartRow["grad"]){     //nađi u tablici od njušakala exceliic samo id grad, ako je grad id taj da možemo 
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



                                      //kvart -- koji ima samo za ZG a druge ne
                                    //  echo '<level_2_location_id>'.$o.'</level_2_location_id>',"\n";
                                    if($nuskaloKvartRow["njuskaloId"] == 0 || is_null($nuskaloKvartRow["njuskaloId"])){
                                      $nuskaloKvartRow["njuskaloId"] = 111;
                                      echo '<level_2_location_id>'.$nuskaloKvartRow["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                    }else{
                                    echo '<level_2_location_id>'.$nuskaloKvartRow["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                  }


                                      //ulica (mikrolokacija po JAKO starom)
                                      echo '<street_name>0</street_name>',"\n";


                                      //Lokacija na google karti
                                        if ( $Lon AND $Lat ) {
                                            echo '<location_x>'.$Lon.'</location_x>',"\n";
                                            echo '<location_y>'.$Lat.'</location_y>',"\n";
                                        }else{
                                              echo '<location_x>0</location_x>',"\n";
                                              echo '<location_y>0</location_y>',"\n";
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
                                           // mysqli_free_result($row);
                                            // mysqli_free_result($slikeRow);
                                            // mysqli_free_result($gallRow);
                                            // mysqli_free_result($zupanijaRow);
                                           //  mysqli_free_result($cijenaRow);
                                            // mysqli_free_result($njuskaloZupRow);
                                            // mysqli_free_result($gMapRow);
                                            // mysqli_free_result($brSoba);
                                            // mysqli_free_result($liftT);
                                            // mysqli_free_result($sizeRow);
                                            // mysqli_free_result($year);
                                            mysqli_free_result($grijanjeTip);
                                            mysqli_free_result($parking);
                                            mysqli_free_result($klima);
                                          //  mysql_free_result($Vlist); ne radi
                                         //  mysqli_free_result($BazenRow);
                                        // mysqli_free($Kablovska);

}// KRAJ LOOPa stanova prodaja



                                                                    

echo '</ad_list>';




?>

