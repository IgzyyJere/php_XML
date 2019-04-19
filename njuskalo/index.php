<?php
header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="utf-8"?>';

$link = new mysqli("localhost", "root", "", "nekreninetestwp");
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
                                            $Qdetails = "SELECT meta_value FROM wp_postmeta
                                            where wp_postmeta.post_id = ".$row["ID"]."
                                            and wp_postmeta.meta_key = 'REAL_HOMES_property_price'
                                            and wp_postmeta.meta_value >= 0";
                                            $cijena = mysqli_query($link, $Qdetails);
                                            $cijenaRow = mysqli_fetch_assoc($cijena);
                                            



                                            //naslovna slika
                                            $QslikeFe = "select DISTINCT  wp_posts.guid
                                            from wp_posts
                                            INNER JOIN wp_postmeta ON wp_postmeta.meta_value = wp_posts.ID
                                            WHERE wp_posts.post_type = 'attachment'
                                            AND wp_postmeta.meta_key = '_thumbnail_id'
                                            AND wp_postmeta.post_id = ".$row["ID"];
                                            $slika = mysqli_query($link, $QslikeFe);
                                            $slikeRow = mysqli_fetch_assoc($slika);
                                            


                                            //brojac za galerije slike
                                            //galerija slika
                                            // $QgalCount = "select DISTINCT  count(wp_posts.guid)
                                            //   from wp_posts
                                            //   INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                            //   WHERE wp_posts.post_type = 'attachment'
                                            //   AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                            //   AND wp_postmeta.post_id = ".$row["ID"].
                                            //   " ORDER BY wp_posts.post_date DESC";
                                            //   $gall = mysqli_query($link, $QgalCount);
                                            //   $gallRow = mysqli_fetch_assoc($gall);
                                            //   $picCount = $gallRow["count(wp_posts.guid)"];


                                              //lokacija WP
                                             $QlokacijaZupanija = "SELECT wp_terms.name
                                                            from wp_terms
                                                            RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                            LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                                            JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                                            WHERE wp_posts.ID = ".$row["ID"].
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
                                                                $QMap = "SELECT * FROM wp_postmeta where wp_postmeta.post_id = ".$row["ID"].
                                                                " and wp_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                                                                " and wp_postmeta.meta_value >= 0";
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

                                                                 $QbrojSoba = "SELECT meta_value FROM wp_postmeta where 
                                                                 wp_postmeta.post_id = ".$row["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $brSoba = mysqli_query($link, $QbrojSoba);
                                                                  $sobeRow = mysqli_fetch_assoc($brSoba);

                                                                

                              
                                 


                                                                  $QFeaturesT1 = "SELECT  wp_terms.name
                                                                                 from wp_term_relationships
                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                 AND post_status='publish'
                                                                                 AND wp_posts.ID = ".$row["ID"].
                                                                                 " AND wp_terms.name = 'Teretni Lift'";
                                                                                 $liftT = mysqli_query($link, $QFeaturesT1);
                                                                                 $liftRow = mysqli_fetch_assoc($liftT);


                                                                  $QFeaturesT1_ = "SELECT  wp_terms.name
                                                                                 from wp_term_relationships
                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                 AND post_status='publish'
                                                                                 AND wp_posts.ID = ".$row["ID"].
                                                                                 " AND wp_terms.name = 'Lift'";
                                                                                 $liftT_ = mysqli_query($link, $QFeaturesT1_);
                                                                                 $liftRow_ = mysqli_fetch_assoc($liftT_);


                                                                                 
                                                                                
                                                                             



                                                                 $QSize = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $size_ = mysqli_query($link, $QSize);
                                                                 $sizeRow = mysqli_fetch_assoc($size_); 
                                                                 $size = $sizeRow["meta_value"];


                                

                                                                 $QYearBuild = "SELECT meta_value FROM wp_postmeta
                                                                  where wp_postmeta.post_id = ".$row["ID"].
                                                                  " and wp_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $yearB = mysqli_query($link, $QYearBuild);
                                                                  $year = mysqli_fetch_assoc($yearB);


                                                                  $Grijanje = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row["ID"]."
                                                                               AND wp_terms.name = 'Plinsko etažno'
                                                                              OR wp_terms.name = 'Radijatori na struju'
                                                                              OR wp_terms.name = 'Toplana'";
                                                                      $grijanjeTip = mysqli_query($link, $Grijanje);
                                                                      $GrijanjeRow = mysqli_fetch_assoc($grijanjeTip);        


                                                                           
                                       
                                                                  $QParking = "SELECT wp_terms.name from wp_term_relationships 
                                                                  LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID 
                                                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                                                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                                                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND wp_posts.ID = ".$row["ID"]. 
                                                                  " AND wp_terms.name = 'Parking' ";
                                                                  $parking = mysqli_query($link, $QParking);
                                                                  $ParkingRow = mysqli_fetch_assoc($parking);



                                                                             $QKlima = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row["ID"]. 
                                                                                         " AND wp_terms.name = 'Klima uređaj' ";
                                                                  $klima = mysqli_query($link, $QKlima);
                                                                  $KlimaRow = mysqli_fetch_assoc($klima);



                                                                  
                                                                             $QVlList = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row["ID"]. 
                                                                                         " AND wp_terms.name = 'Vlasnički list u posjedu'";
                                                                  $Vlist = mysqli_query($link, $QVlList);
                                                                  $VlistRow = mysqli_fetch_assoc($Vlist);



                                                                  $QBazen = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row["ID"]. 
                                                                                " AND wp_terms.name = 'Bazen'";
                                                                                $Bazen = mysqli_query($link, $QBazen);
                                                                                $BazenRow = mysqli_fetch_assoc($Bazen);



                                                                                $QKablovska = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row["ID"]. 
                                                                                                " AND wp_terms.name = 'Kablovska'";
                                                                                                $Kablovska = mysqli_query($link, $QKablovska);
                                                                                                $KablovskaRow = mysqli_fetch_assoc($Kablovska);


                                                                                                
                                                                                $QSatelit = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row["ID"]. 
                                                                                                " AND wp_terms.name = 'Satelitska'";
                                                                                                $satelit = mysqli_query($link, $QSatelit);
                                                                                                $SatelitRow = mysqli_fetch_assoc($satelit);


                                                                                      $QAlarm = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row["ID"]. 
                                                                                                " AND wp_terms.name = 'Alarm'";
                                                                                                $alarm = mysqli_query($link, $QAlarm);
                                                                                                $AlarmRow = mysqli_fetch_assoc($alarm);


                                                                                                $QTelefon = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row["ID"].
                                                                                                " AND wp_terms.name = 'Telefon (upotreba)'";
                                                                                                $telefon_ = mysqli_query($link, $QTelefon);
                                                                                                $TelefonRow_ = mysqli_fetch_assoc($telefon_);
                                                                                                


                                                                                              $QTelefon_L = "SELECT  wp_terms.name
                                                                                              from wp_term_relationships
                                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                              AND post_status='publish'
                                                                                              AND wp_posts.ID = ".$row["ID"].
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
                                                $Qgalerija = "select DISTINCT wp_posts.guid
                                                from wp_posts
                                                INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                WHERE wp_posts.post_type = 'attachment'
                                                AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                AND wp_postmeta.post_id = ".$row["ID"].
                                                " ORDER BY wp_posts.post_date DESC";
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
                                                switch($nuskaloKvartRow["grad"]){     //nađi u tablici od njušakala exceliic samo id grad, ako je grad id taj da možemo 
                                                  //ovo je grad ID, u tablici kvart selektiraj neki kvart u gradu kao centar
                                                  //switchat id kvarta
                                                  case 5:
                                                      $o = 2;
                                                      break;

                                                      case 1:
                                                      $o = 7;
                                                      break;

                                                      case 138:
                                                      $o = 10;
                                                      break;

                                                      case 6:
                                                      $o = 14;
                                                      break;

                                                      case 142:
                                                      $o = 21;
                                                      break;

                                                      case 3:
                                                      $o = 26;
                                                      break;

                                                      case 141:
                                                      $o = 31;
                                                      break;

                                                      case 4:
                                                      $o = 50;
                                                      break;

                                                      case 8:
                                                      $o = 61;
                                                      break;

                                                      case 9:
                                                      $o = 76;
                                                      break;

                                                      case 5:
                                                      $o = 82;
                                                      break;

                                                      case 137:
                                                      $o = 91;
                                                      break;

                                                      case 7:
                                                      $o = 102;
                                                      break;
                                                      ///po njuškalo id
                                                      case 140:
                                                      $o = 2732;
                                                      break;

                                                      case 138:
                                                      $o = 2597;
                                                      break;

                                                      case 2:
                                                      $o = 2613;
                                                      break;

                                                      case 139:
                                                      $o = 2623;
                                                      break;


                                                      case 144:
                                                      $o = 2771;
                                                      break;

                                                      case 9:
                                                      $o = 2771;
                                                      break;

                                                      case 84:
                                                      $o = 8758;
                                                      break;

                                                      case 78:
                                                      $o = 2247;
                                                      break;

                                                      case 373:
                                                      $o = 5772;
                                                      break;

                                                      case 217:
                                                      $o = 2823;
                                                      break;

                                                      default:
                                                      $o = 1111;

                                                }                                



                                                //kvart -- koji ima samo za ZG a druge ne
                                                echo '<level_2_location_id>'.$o.'</level_2_location_id>',"\n";
                                    


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




//////
//////  STANOVI NAJAM
//////

$container2 = mysqli_query($link, $Contextz_Q->queryOglasi2);
while($row2 = mysqli_fetch_assoc($container2)){
$tekst2 = $row2["post_content"];


                                              //polja - detalji
                                            $Qdetails2 = "SELECT meta_value FROM wp_postmeta
                                            where wp_postmeta.post_id = ".$row2["ID"]."
                                            and wp_postmeta.meta_key = 'REAL_HOMES_property_price'
                                            and wp_postmeta.meta_value >= 0";
                                            $cijena2 = mysqli_query($link, $Qdetails2);
                                            $cijenaRow2 = mysqli_fetch_assoc($cijena2);
                                            



                                            //naslovna slika
                                            $QslikeFe2 = "select DISTINCT  wp_posts.guid
                                            from wp_posts
                                            INNER JOIN wp_postmeta ON wp_postmeta.meta_value = wp_posts.ID
                                            WHERE wp_posts.post_type = 'attachment'
                                            AND wp_postmeta.meta_key = '_thumbnail_id'
                                            AND wp_postmeta.post_id = ".$row2["ID"];
                                            $slika2 = mysqli_query($link, $QslikeFe2);
                                            $slikeRow2 = mysqli_fetch_assoc($slika2);


                             


                                              //lokacija WP
                                             $QlokacijaZupanija2 = "SELECT wp_terms.name
                                                            from wp_terms
                                                            RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                            LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                                            JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                                            WHERE wp_posts.ID = ".$row2["ID"].
                                                            " AND wp_term_taxonomy.taxonomy = 'property-city'
                                                            GROUP BY wp_term_taxonomy.parent";
                                                            $zupanija2 = mysqli_query($link, $QlokacijaZupanija2);
                                                            $zupanijaRow2 = mysqli_fetch_assoc($zupanija2);
  

                                      


                                               $QTbl_Lokacija2 = "SELECT * from zupanije
                                                                 where zupanije.nazivZupanije = '".$zupanijaRow2["name"]."'";        
                                                                 $zupanija_njuskaloId2 = mysqli_query($link, $QTbl_Lokacija2);
                                                                 $njuskaloZupRow2 = mysqli_fetch_assoc($zupanija_njuskaloId2);

                                                                          if($njuskaloZupRow2["id"] > 0)
                                                                          {
                                                                                $QTbl_Lokacija2_ = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaloZupRow2["id"];    
                                                                                $grad_njuskaloId2 = mysqli_query($link, $QTbl_Lokacija2_);
                                                                                $nuskaloGradRow = mysqli_fetch_assoc($grad_njuskaloId2);
                                                                          }else{
                                                                            $nuskaloGradRow2 = null;
                                                                          }
                                            
                                          


                                                //$QTbl_Lokacija3 = "SELECT * FROM kvartovi WHERE id = ".$nuskaloGradRow["id"];

                                                       ///karta i google zapisi
                                                                $QMap2 = "SELECT * FROM wp_postmeta where wp_postmeta.post_id = ".$row2["ID"].
                                                                " and wp_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                                                                " and wp_postmeta.meta_value >= 0";
                                                                $map2 = mysqli_query($link, $QMap2);
                                                                $gMapRow2 = mysqli_fetch_assoc($map2);
                                            

                                                                 if(!is_null($gMapRow2["meta_value"]) || $gMapRow2["meta_value"] != ''){
                                                                     $rest2 = explode(",", $gMapRow2["meta_value"]);
                                                                     $Lon2 = $rest2[1];
                                                                     $Lat2 = $rest2[0];
                                                                 }else{
                                                                   $Lat2 = 0;
                                                                   $Lon2 = 0;
                                                                 }


                                                                 

                                                            $QbrojSoba2 = "SELECT meta_value FROM wp_postmeta where 
                                                                 wp_postmeta.post_id = ".$row2["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $brSoba2 = mysqli_query($link, $QbrojSoba2);
                                                                  $sobeRow2 = mysqli_fetch_assoc($brSoba2);

                                                                

                              
                              

                                                                 $QSize2 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row2["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $size_2 = mysqli_query($link, $QSize2);
                                                                 $sizeRow2 = mysqli_fetch_assoc($size_2); 
                                                                 $size2 = $sizeRow2["meta_value"];


                                

                                                                 $QYearBuild2 = "SELECT meta_value FROM wp_postmeta
                                                                  where wp_postmeta.post_id = ".$row2["ID"].
                                                                  " and wp_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $yearB2 = mysqli_query($link, $QYearBuild2);
                                                                  $year2 = mysqli_fetch_assoc($yearB2);



                                                                    $Grijanje2 = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row2["ID"]."
                                                                               AND wp_terms.name = 'Plinsko etažno'
                                                                              OR wp_terms.name = 'Radijatori na struju'
                                                                              OR wp_terms.name = 'Toplana'";
                                                                      $grijanjeTip2 = mysqli_query($link, $Grijanje2);
                                                                      $GrijanjeRow2 = mysqli_fetch_assoc($grijanjeTip2); 


                                                                           $QParking2 = "SELECT wp_terms.name from wp_term_relationships 
                                                                  LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID 
                                                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                                                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                                                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND wp_posts.ID = ".$row2["ID"]. 
                                                                  " AND wp_terms.name = 'Parking' ";
                                                                  $parking2 = mysqli_query($link, $QParking2);
                                                                  $ParkingRow2 = mysqli_fetch_assoc($parking2);



                                                                             $QKlima2 = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row2["ID"]. 
                                                                                         " AND wp_terms.name = 'Klima uređaj' ";
                                                                  $klima2 = mysqli_query($link, $QKlima2);
                                                                  $KlimaRow2 = mysqli_fetch_assoc($klima2);



                                                                                 $QVlList2 = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row2["ID"]. 
                                                                                         " AND wp_terms.name = 'Vlasnički list u posjedu'";
                                                                  $Vlist2 = mysqli_query($link, $QVlList2);
                                                                  $VlistRow2 = mysqli_fetch_assoc($Vlist2);



                                                                  $QBazen2 = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row2["ID"]. 
                                                                                " AND wp_terms.name = 'Bazen'";
                                                                                $Bazen2 = mysqli_query($link, $QBazen2);
                                                                                $BazenRow2 = mysqli_fetch_assoc($Bazen2);



                                                                                $QKablovska2 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row2["ID"]. 
                                                                                                " AND wp_terms.name = 'Kablovska'";
                                                                                                $Kablovska2 = mysqli_query($link, $QKablovska2);
                                                                                                $KablovskaRow2 = mysqli_fetch_assoc($Kablovska2);


                                                                                                
                                                                                $QSatelit2 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row2["ID"]. 
                                                                                                " AND wp_terms.name = 'Satelitska'";
                                                                                                $satelit2 = mysqli_query($link, $QSatelit2);
                                                                                                $SatelitRow2 = mysqli_fetch_assoc($satelit2);


                                                                                      $QAlarm2 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row2["ID"]. 
                                                                                                " AND wp_terms.name = 'Alarm'";
                                                                                                $alarm2 = mysqli_query($link, $QAlarm2);
                                                                                                $AlarmRow2 = mysqli_fetch_assoc($alarm2);



                                                                                    $QTelefon2 = "SELECT  wp_terms.name
                                                                                    from wp_term_relationships
                                                                                    LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                    AND post_status='publish'
                                                                                    AND wp_posts.ID = ".$row2["ID"].
                                                                                    " AND wp_terms.name = 'Telefon (upotreba)'";
                                                                                    $telefon_2 = mysqli_query($link, $QTelefon2);
                                                                                    $TelefonRow_2 = mysqli_fetch_assoc($telefon_2);


                                                                                    $QTelefon_L2 = "SELECT  wp_terms.name
                                                                                    from wp_term_relationships
                                                                                    LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                    AND post_status='publish'
                                                                                    AND wp_posts.ID = ".$row2["ID"].
                                                                                    " AND wp_terms.name = 'Telefon'";
                                                                                    $telefon_L2 = mysqli_query($link, $QTelefon_L2);
                                                                                    $TelefonRow_L2 = mysqli_fetch_assoc($telefon_L2);
                                                                                    
                                                             
                                 



echo '<ad_item class="ad_flats_lease">
    <user_id>444900</user_id>
        <original_id>s-'.$row2["ID"].'</original_id>';
        echo  '<category_id>10920</category_id>',"\n";


        //naslov
            echo '<title> Stan: ',$row2['post_title'],'</title>';
            //link na stranicu
               echo '<external_url>'.$row2["guid"].'</external_url>', "\n";
                    //tekst oglasa
                      echo '<description_raw>'; 
                          echo '<![CDATA[',$tekst2,']]>';
                      echo '</description_raw>',"\n";

                          echo '<price>',$cijenaRow2['meta_value'],'</price>
                          <currency_id>2</currency_id>',"\n";
    
    
                            //slike                  
                            echo '<image_list>',"\n";
                                            echo '<image>glavna slika : '. $slikeRow2["guid"].'</image>',"\n";
                                                //galerija slika
                                                $Qgalerija2 = "select DISTINCT wp_posts.guid
                                                from wp_posts
                                                INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                WHERE wp_posts.post_type = 'attachment'
                                                AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                AND wp_postmeta.post_id = ".$row2["ID"].
                                                " ORDER BY wp_posts.post_date DESC";
                                                                          $gallery2 = mysqli_query($link, $Qgalerija2);
                                                                          while($galleryRow2= mysqli_fetch_assoc($gallery2)){
                                                                                echo '<image>'. $galleryRow2["guid"].'</image>',"\n";
                                                                          }    
                            echo '</image_list>',"\n";

                            
                                                //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                                echo '<additional_contact></additional_contact>',"\n";


                                                //određivanje lokacija
                                                echo '<level_0_location_id>';
                                                //zupanija
                                                echo $njuskaloZupRow2["njuskaloId"].'</level_0_location_id>',"\n";
                                                
                                                //grad
                                                echo '<level_1_location_id>'.$nuskaloGradRow2["njuskaloId"].'</level_1_location_id>',"\n";

                                                //kvart
                                                echo '<level_2_location_id></level_2_location_id>',"\n";


                                                //ulica (mikrolokacija po JAKO starom)
                                                echo '<street_name>0</street_name>',"\n";


                                                //Lokacija na google karti
                                                  if ( $Lon2 AND $Lat2 ) {
                                                      echo '<location_x>'.$Lon2.'</location_x>',"\n";
                                                      echo '<location_y>'.$Lat2.'</location_y>',"\n";
                                                  }else{
                                                       echo '<location_x>0</location_x>',"\n";
                                                       echo '<location_y>0</location_y>',"\n";
                                                  }


                                                 echo '<flat_type_id>0</flat_type_id>',"\n";


                                                 //broj etaža
                                                  if(strstr($row2['post_content'], "Broj etaža :")){
                                                             $etaza = strstr($row2['post_content'], "Broj etaža :",0);
                                                             $etaza = substr($etaza2,14,1);
                                                             switch ($etaza2){
                                                               case "1":
                                                               $etaza2 = "184";
                                                               break;

                                                               case "2":
                                                                 $etaza2 = "185";
                                                                 break;

                                                                 case "3":
                                                                 $etaza2 = "186";
                                                                 break;
                                                                }
                                                             
                                                      echo '<floor_count_id>'. $etaza2.'</floor_count_id>',"\n";
                                                            }   else{
                                                                    echo '<floor_count_id>0</floor_count_id>',"\n";
                                                                    }


                                                                       //Broj soba
                                                   echo '<room_count_id>';
                                                    $sobe2 = $sobeRow2["meta_value"];
                                                    if($sobe2 != ''){
                                                              switch ($sobe2){
                                                                case "1";
                                                                $sobe2 = "188";
                                                                break;
                                                                case "2";
                                                                $sobe2 = "189";
                                                                break;
                                                                case "3";
                                                                $sobe2 = "190";
                                                                break;
                                                                case "4";
                                                                $sobe2 = "191";
                                                                break;
                                                              }
                                        
                                                    }else{$sobe2 = 0;}
                                                       
                                                     echo $sobe2;
                                                      echo '</room_count_id>',"\n";


                                                             //kat
                                                      echo '<flat_floor_id>';
                                                      $broj2 = "0";
                                                       if(strstr($row2['post_content'], "Zgrada ima katova :")){
                                                                 $broj2 = strstr($row2['post_content'], "Zgrada ima katova :",0);
                                                                   $broj2 = substr($broj2,20,1);
                                                         switch($broj){
                                                                     case "1";
                                                                     $broj2 = "193";
                                                                     break;
                                                                     case "2":
                                                                     $broj2 = "192";
                                                                     break;
                                                                
                                                                     case "3":
                                                                     $broj2 = "194";
                                                                     break;
                                                                
                                                                     case "4":
                                                                     $broj2 = "192";
                                                                     break;    
                                                                
                                                                     case "5":
                                                                     $broj2 = "218";
                                                                     break;
                                                         }


                                                       }else{$broj2 = 0;}
                                                           echo $broj2;
                                                          echo '</flat_floor_id>',"\n";

                                                      

                                                          //površina
                                                          if($size2 > 0){
                                                                echo '<main_area>'.$size2.'</main_area>',"\n";
                                                          }

                                                          //vrt površina
                                                           echo '<garden_area>0</garden_area>',"\n";

                                                           //balkon površina
                                                          echo '<balcony_area>0</balcony_area>',"\n";

                                                          //terasa površina
                                                          echo '<terace_area>0</terace_area>',"\n";


                                                              
                                                          //godina izgradnje 
                                                           if ($year2['meta_value']){
                                                               echo '<year_built>'.$year2['meta_value'].'</year_built>',"\n";}


                                                                   if(strstr($row2['post_content'], "Adaptacija :")){
                                                                   $adap2 = strstr($row2['post_content'], "Adaptacija :",0);
                                                                   $adap2 = substr($adap2,12,7);
                                                                    echo '<year_last_rebuild>',$adap2,'</year_last_rebuild>',"\n";
                                                          }

                                                          //novogradnja
                                                           echo '<new_building>0</new_building>',"\n";

                                                                       //grijanje

                                                      echo '<heating_type_id>';
                                                          switch ($GrijanjeRow2["name"])
                                                          {
                                                          
                                                              case "Plinsko etažno":
                                                              case "Toplana":
                                                              $broj2 = "224";
                                                              break;
                                                           
                                                              case "Radijatori na struju":
                                                              $broj2 = "225";
                                                              break;

                                                              case "":
                                                              $broj2 = "0";
                                                              break;
                                                          
                                                          }

                                                          echo $broj2;

                                                      echo '</heating_type_id>',"\n";
                                                             echo '<parking_spot_count>';
                                                  
                                                     if($ParkingRow2["name"]){
                                                      echo '1';
                                                     }else{echo '0';}
                                                      echo '</parking_spot_count>'."\n";


                                                        //oprema prijevoz
                                                        echo '<furnish_level_id></furnish_level_id>',"\n";
                                                        echo '<bus_proximity></bus_proximity>';
                                                        echo '<tram_proximity></tram_proximity>';

                              //LOOKUP LISTA
                              echo '<lookup_list>';

                                                              //telefon
                                                                if($TelefonRow_2["name"] !== null || $TelefonRow_L2["name"] !== null){
                                                                      echo '<lookup_item code="installations">223</lookup_item>',"\n";
                                                                }else{echo '<lookup_item code="installations">0</lookup_item>',"\n";}

                                                                //grijanje
                                                            if ($GrijanjeRow2["name"] == "Toplana"){ 
                                                                  echo '<lookup_item code="heating">229</lookup_item>',"\n";   
                                                                }

                                                            if ($KlimaRow2["name"]) {
                                                                echo '<lookup_item code="heating">231</lookup_item>',"\n";
                                                                }


                                                                
                                                              //Vlasnički list
                                                              if($VlistRow2["name"]){
                                                                  echo '<lookup_item code="permits">232</lookup_item>',"\n"; 
                                                              }else{
                                                                            //vlista alternativa 
                                                                              $gVDozvola2 = strstr($row2['post_content'], "Vlasnički list:",0);
                                                                              $gVDozvola2 = substr($gVDozvola2,14,4);
                                                                              if($gVDozvola2){
                                                                                  echo '<lookup_item code="permits">232</lookup_item>',"\n";           
                                                                              }          
                                                              }

                                                         

                                                              //građevinska 
                                                                if(strstr($row2['post_content'], "Građevinska dozvola:")){
                                                                   $gDozvola2 = strstr($row2['post_content'], "Građevinska dozvola:",0);
                                                                   $gDozvola2 = substr($gDozvola2,21,4);
                                                                   if($gDozvola2){
                                                                       echo '<lookup_item code="permits">233</lookup_item>',"\n";           
                                                                   }  
                                                            }

                                                                      //uporabna 
                                                                if(strstr($row2['post_content'], "Uporabna dozvola:")){
                                                                   $gUDozvola2 = strstr($row2['post_content'], "Uporabna dozvola:",0);
                                                                   $gUDozvola2 = substr($gUDozvola2,17,4);
                                                                   if($gUDozvola2){
                                                                       echo '<lookup_item code="permits">234</lookup_item>',"\n";           
                                                                   }  
                                                            }


                                                                  //bazen                                                      
                                                              if ($BazenRow2["name"]) {
                                                              echo '<lookup_item code="garden">164</lookup_item>',"\n";   
                                                              }


                                                                 //roštilj    
                                                                $gRostilj2 = strstr($row2['post_content'], "Ugrađen roštilj",0);
                                                                if ($gRostilj2) {
                                                                echo '<lookup_item code="garden">166</lookup_item>',"\n";
                                                                }

                                                                  //electronics
                                                                      if ($KablovskaRow2["name"]) {
                                                                      echo '<lookup_item code="electronics">167</lookup_item>',"\n"; 
                                                                      }

                                                                          if ($SatelitRow2['name'] ) {
                                                                               echo '<lookup_item code="electronics">168</lookup_item>',"\n";
                                                                              }

                                                                              //alarm
                                                                              if ( $AlarmRow2['name'] ) {
                                                                                  echo '<lookup_item code="electronics">171</lookup_item>',"\n";   
                                                                                  }

                              echo '</lookup_list>',"\n";// KRAJ LOOPa




                                                      
                                                           




 echo '</ad_item>',"\n"; //end nekretnine
}// kraj loop najam stanova


//////
//////  POSLOVNI NAJAM
//////

$container3 = mysqli_query($link, $Contextz_Q->queryOglasi3);
while($row3 = mysqli_fetch_assoc($container3)){
$tekst3 = $row3["post_content"];


                                              //polja - detalji
                                            $Qdetails3 = "SELECT meta_value FROM wp_postmeta
                                            where wp_postmeta.post_id = ".$row3["ID"]."
                                            and wp_postmeta.meta_key = 'REAL_HOMES_property_price'
                                            and wp_postmeta.meta_value >= 0";
                                            $cijena3 = mysqli_query($link, $Qdetails3);
                                            $cijenaRow3 = mysqli_fetch_assoc($cijena3);
                                            



                                            //naslovna slika
                                            $QslikeFe3 = "select DISTINCT  wp_posts.guid
                                            from wp_posts
                                            INNER JOIN wp_postmeta ON wp_postmeta.meta_value = wp_posts.ID
                                            WHERE wp_posts.post_type = 'attachment'
                                            AND wp_postmeta.meta_key = '_thumbnail_id'
                                            AND wp_postmeta.post_id = ".$row3["ID"];
                                            $slika3 = mysqli_query($link, $QslikeFe3);
                                            $slikeRow3 = mysqli_fetch_assoc($slika3);


                             


                                              //lokacija WP
                                             $QlokacijaZupanija3 = "SELECT wp_terms.name
                                                            from wp_terms
                                                            RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                            LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                                            JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                                            WHERE wp_posts.ID = ".$row3["ID"].
                                                            " AND wp_term_taxonomy.taxonomy = 'property-city'
                                                            GROUP BY wp_term_taxonomy.parent";
                                                            $zupanija3 = mysqli_query($link, $QlokacijaZupanija3);
                                                            $zupanijaRow3 = mysqli_fetch_assoc($zupanija3);
  

                                      


                                               $QTbl_Lokacija3 = "SELECT * from zupanije
                                                                 where zupanije.nazivZupanije = '".$zupanijaRow3["name"]."'";        
                                                                 $zupanija_njuskaloId3 = mysqli_query($link, $QTbl_Lokacija3);
                                                                 $njuskaloZupRow3 = mysqli_fetch_assoc($zupanija_njuskaloId3);

                                                                          if($njuskaloZupRow3["id"] > 0)
                                                                          {
                                                                                $QTbl_Lokacija3_ = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaloZupRow3["id"];    
                                                                                $grad_njuskaloId3 = mysqli_query($link, $QTbl_Lokacija3_);
                                                                                $nuskaloGradRow3 = mysqli_fetch_assoc($grad_njuskaloId3);
                                                                          }else{
                                                                            $nuskaloGradRow3 = null;
                                                                          }
                                            
                                          


                                                //$QTbl_Lokacija3 = "SELECT * FROM kvartovi WHERE id = ".$nuskaloGradRow["id"];

                                                       ///karta i google zapisi
                                                                $QMap3 = "SELECT * FROM wp_postmeta where wp_postmeta.post_id = ".$row3["ID"].
                                                                " and wp_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                                                                " and wp_postmeta.meta_value >= 0";
                                                                $map3 = mysqli_query($link, $QMap3);
                                                                $gMapRow3 = mysqli_fetch_assoc($map3);
                                            

                                                                 if(!is_null($gMapRow3["meta_value"]) || $gMapRow3["meta_value"] != ''){
                                                                     $rest3 = explode(",", $gMapRow3["meta_value"]);
                                                                     $Lon3 = $rest3[1];
                                                                     $Lat3 = $rest3[0];
                                                                 }else{
                                                                   $Lat3 = 0;
                                                                   $Lon3 = 0;
                                                                 }


                                                                 

                                                            $QbrojSoba3 = "SELECT meta_value FROM wp_postmeta where 
                                                                 wp_postmeta.post_id = ".$row3["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $brSoba3 = mysqli_query($link, $QbrojSoba3);
                                                                  $sobeRow3 = mysqli_fetch_assoc($brSoba3);

                                                                

                              
                              

                                                                 $QSize3 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row3["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $size_3 = mysqli_query($link, $QSize3);
                                                                 $sizeRow3 = mysqli_fetch_assoc($size_3); 
                                                                 $size3 = $sizeRow3["meta_value"];


                                

                                                                 $QYearBuild3 = "SELECT meta_value FROM wp_postmeta
                                                                  where wp_postmeta.post_id = ".$row3["ID"].
                                                                  " and wp_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $yearB3 = mysqli_query($link, $QYearBuild3);
                                                                  $year3 = mysqli_fetch_assoc($yearB3);



                                                                    $Grijanje3 = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row3["ID"]."
                                                                               AND wp_terms.name = 'Plinsko etažno'
                                                                              OR wp_terms.name = 'Radijatori na struju'
                                                                              OR wp_terms.name = 'Toplana'";
                                                                      $grijanjeTip3 = mysqli_query($link, $Grijanje3);
                                                                      $GrijanjeRow3 = mysqli_fetch_assoc($grijanjeTip3); 


                                                                           $QParking3 = "SELECT wp_terms.name from wp_term_relationships 
                                                                  LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID 
                                                                  LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                                                                  LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                                                                  WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND wp_posts.ID = ".$row3["ID"]. 
                                                                  " AND wp_terms.name = 'Parking' ";
                                                                  $parking3 = mysqli_query($link, $QParking3);
                                                                  $ParkingRow3 = mysqli_fetch_assoc($parking3);



                                                                             $QKlima3 = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row3["ID"]. 
                                                                                         " AND wp_terms.name = 'Klima uređaj' ";
                                                                  $klima3 = mysqli_query($link, $QKlima3);
                                                                  $KlimaRow3 = mysqli_fetch_assoc($klima3);



                                                                                 $QVlList3 = "SELECT  wp_terms.name
                                                                                        from wp_term_relationships
                                                                                        LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                        LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                        LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                        WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                        AND post_status='publish'
                                                                                        AND wp_posts.ID = ".$row3["ID"]. 
                                                                                         " AND wp_terms.name = 'Vlasnički list u posjedu'";
                                                                  $Vlist3 = mysqli_query($link, $QVlList3);
                                                                  $VlistRow3 = mysqli_fetch_assoc($Vlist3);



                                                                  $QBazen3 = "SELECT  wp_terms.name
                                                                              from wp_term_relationships
                                                                              LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                              LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                              LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                              WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                              AND post_status='publish'
                                                                              AND wp_posts.ID = ".$row3["ID"]. 
                                                                                " AND wp_terms.name = 'Bazen'";
                                                                                $Bazen3 = mysqli_query($link, $QBazen3);
                                                                                $BazenRow3 = mysqli_fetch_assoc($Bazen3);



                                                                                $QKablovska3 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row3["ID"]. 
                                                                                                " AND wp_terms.name = 'Kablovska'";
                                                                                                $Kablovska3 = mysqli_query($link, $QKablovska3);
                                                                                                $KablovskaRow3 = mysqli_fetch_assoc($Kablovska3);


                                                                                                
                                                                                $QSatelit3 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row3["ID"]. 
                                                                                                " AND wp_terms.name = 'Satelitska'";
                                                                                                $satelit3 = mysqli_query($link, $QSatelit3);
                                                                                                $SatelitRow3 = mysqli_fetch_assoc($satelit3);


                                                                                      $QAlarm3 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row3["ID"]. 
                                                                                                " AND wp_terms.name = 'Alarm'";
                                                                                                $alarm3 = mysqli_query($link, $QAlarm3);
                                                                                                $AlarmRow3 = mysqli_fetch_assoc($alarm3);



                                                                                    $QTelefon3 = "SELECT  wp_terms.name
                                                                                    from wp_term_relationships
                                                                                    LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                    AND post_status='publish'
                                                                                    AND wp_posts.ID = ".$row3["ID"].
                                                                                    " AND wp_terms.name = 'Telefon (upotreba)'";
                                                                                    $telefon_3 = mysqli_query($link, $QTelefon3);
                                                                                    $TelefonRow_3 = mysqli_fetch_assoc($telefon_3);


                                                                                    $QTelefon_L3 = "SELECT  wp_terms.name
                                                                                    from wp_term_relationships
                                                                                    LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                    AND post_status='publish'
                                                                                    AND wp_posts.ID = ".$row3["ID"].
                                                                                    " AND wp_terms.name = 'Telefon'";
                                                                                    $telefon_L3 = mysqli_query($link, $QTelefon_L3);
                                                                                    $TelefonRow_L3 = mysqli_fetch_assoc($telefon_L3);


                                                                                    $QKuhinja = "SELECT  wp_terms.name
                                                                                    from wp_term_relationships
                                                                                    LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                    LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                    WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                    AND post_status='publish'
                                                                                    AND wp_posts.ID = ".$row3["ID"].
                                                                                    " AND wp_terms.name = 'Čajna kuhinja'";
                                                                                    $cajna_kuhinja = mysqli_query($link, $QKuhinja);
                                                                                    $cajnaKuhinjaRow = mysqli_fetch_assoc($cajna_kuhinja);



                                                                                    


echo '<ad_item class="ad_business_space">
    <user_id>444900</user_id>
        <original_id>s-'.$row3["ID"].'</original_id>';
        echo  '<category_id>9585</category_id>',"\n";


        //naslov
            echo '<title> Poslovni prostor: ',$row3['post_title'],'</title>';
            //link na stranicu
               echo '<external_url>'.$row3["guid"].'</external_url>', "\n";
                    //tekst oglasa
                      echo '<description_raw>'; 
                          echo '<![CDATA[',$tekst3,']]>';
                      echo '</description_raw>',"\n";

                          echo '<price>',$cijenaRow3['meta_value'],'</price>
                          <currency_id>2</currency_id>',"\n";
    
    
                            //slike                  
                            echo '<image_list>',"\n";
                                            echo '<image>glavna slika : '. $slikeRow3["guid"].'</image>',"\n";
                                                //galerija slika
                                                $Qgalerija3 = "select DISTINCT wp_posts.guid
                                                from wp_posts
                                                INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                WHERE wp_posts.post_type = 'attachment'
                                                AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                AND wp_postmeta.post_id = ".$row3["ID"].
                                                " ORDER BY wp_posts.post_date DESC";
                                                                          $gallery3 = mysqli_query($link, $Qgalerija3);
                                                                          while($galleryRow3= mysqli_fetch_assoc($gallery3)){
                                                                                echo '<image>'. $galleryRow3["guid"].'</image>',"\n";
                                                                          }    
                            echo '</image_list>',"\n";

                            
                                                //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                                echo '<additional_contact></additional_contact>',"\n";


                                                //određivanje lokacija
                                                echo '<level_0_location_id>';
                                                //zupanija
                                                echo $njuskaloZupRow3["njuskaloId"].'</level_0_location_id>',"\n";
                                                
                                                //grad
                                                echo '<level_1_location_id>'.$nuskaloGradRow3["njuskaloId"].'</level_1_location_id>',"\n";

                                                //kvart
                                                echo '<level_2_location_id></level_2_location_id>',"\n";


                                                //ulica (mikrolokacija po JAKO starom)
                                                echo '<street_name>0</street_name>',"\n";


                                                //Lokacija na google karti
                                                  if ( $Lon3 AND $Lat3 ) {
                                                      echo '<location_x>'.$Lon3.'</location_x>',"\n";
                                                      echo '<location_y>'.$Lat3.'</location_y>',"\n";
                                                  }else{
                                                       echo '<location_x>0</location_x>',"\n";
                                                       echo '<location_y>0</location_y>',"\n";
                                                  }


                                                  echo '<position_id>277</position_id>';


                                                  
                                                  //  echo '<room_count_id>';
                                                  //   $sobe2 = $sobeRow2["meta_value"];
                                                  //   if($sobe2 != ''){
                                                  //  //Broj soba
                                                  //             switch ($sobe2){
                                                  //               case "1";
                                                  //               $sobe2 = "188";
                                                  //               break;
                                                  //               case "2";
                                                  //               $sobe2 = "189";
                                                  //               break;
                                                  //               case "3";
                                                  //               $sobe2 = "190";
                                                  //               break;
                                                  //               case "4";
                                                  //               $sobe2 = "191";
                                                  //               break;
                                                  //             }
                                        
                                                  //   }else{$sobe2 = 0;}
                                                       
                                                  //    echo $sobe2;
                                                  //     echo '</room_count_id>',"\n";

                                                  //vrsta poslovnog prostora



                                                                                                $type;
                                                                                                $QLokal_ured = mysqli_query($link, $Contextz_Q->queryLokalOffice);
                                                                                                while($office = mysqli_fetch_assoc($QLokal_ured)){
                                                                                                if($office["ID"]){$type = 1;};
                                                                                                }

                                                                                                $QLokal_ured = mysqli_query($link, $Contextz_Q->queryLokalUli);
                                                                                                while($office = mysqli_fetch_assoc($QLokal_ured)){
                                                                                                if($office["ID"]){$type = 2;};
                                                                                                }

                                                                                                $QLokal_ured = mysqli_query($link, $Contextz_Q->queryLokalUli);
                                                                                                while($office = mysqli_fetch_assoc($QLokal_ured)){
                                                                                                if($office["ID"]){$type = 2;};
                                                                                                }

                                                                                                $QLokal_ured = mysqli_query($link, $Contextz_Q->queryLokalUgostiteljstvo);
                                                                                                while($office = mysqli_fetch_assoc($QLokal_ured)){
                                                                                                if($office["ID"]){$type = 4;};
                                                                                                }

                                                                                                 $QLokal_ured = mysqli_query($link, $Contextz_Q->queryLokalHotel);
                                                                                                while($office = mysqli_fetch_assoc($QLokal_ured)){
                                                                                                if($office["ID"]){$type = 7;};
                                                                                                }



                                                                                                //  $vrati = array ( 0 => "-", 1 => "ured", 2 => "ulični lokal", 3 => "trgovina", 4 => "kafić", 5 => "tihi obrt", 6 => "proizvodnja", 7 => "mini hotel", 8 => "skladište", 9 => "restoran", 10 => "club", 11 => "hala", 12 => "kozmetički salon" ); 
                                                                                              switch ($type){
                                                                                              
                                                                                                  case '1':
                                                                                                  $stan = "272";
                                                                                                  break;
                                                                                                  
                                                                                                  case '2':
                                                                                                  $stan = "273";
                                                                                                  break;
                                                                                                  
                                                                                                  case '3':
                                                                                                  $stan = "270";
                                                                                                  break;
                                                                                                  
                                                                                                  case '4':
                                                                                                  $stan = "274";
                                                                                                  break;
                                                                                                  
                                                                                                  case '5':
                                                                                                  $stan = "271";
                                                                                                  break;
                                                                                                  
                                                                                                  case '6':
                                                                                                  $stan = "275";
                                                                                                  break;
                                                                                                  
                                                                                                  case '7':
                                                                                                  $stan = "274";
                                                                                                  break;
                                                                                                  
                                                                                                  case '8':
                                                                                                  $stan = "275";
                                                                                                  break;
                                                                                                  
                                                                                                  case '9':
                                                                                                  $stan = "274";
                                                                                                  break;
                                                                                                  
                                                                                                  case '10':
                                                                                                  $stan = "274";
                                                                                                  break;
                                                                                                  
                                                                                                  case '11':
                                                                                                  $stan = "275";
                                                                                                  break;
                                                                                                  
                                                                                                  case '12':
                                                                                                  $stan = "271";
                                                                                                  break;
                                                                                              }

                                                                                              echo '<space_usage_id>'.$stan.'</space_usage_id>',"\n";


                                                             //kat
                                                      // echo '<flat_floor_id>';
                                                      // $broj2 = "0";
                                                      //  if(strstr($row2['post_content'], "Zgrada ima katova :")){
                                                      //            $broj2 = strstr($row2['post_content'], "Zgrada ima katova :",0);
                                                      //              $broj2 = substr($broj2,20,1);
                                                      //    switch($broj){
                                                      //                case "1";
                                                      //                $broj2 = "193";
                                                      //                break;
                                                      //                case "2":
                                                      //                $broj2 = "192";
                                                      //                break;
                                                                
                                                      //                case "3":
                                                      //                $broj2 = "194";
                                                      //                break;
                                                                
                                                      //                case "4":
                                                      //                $broj2 = "192";
                                                      //                break;    
                                                                
                                                      //                case "5":
                                                      //                $broj2 = "218";
                                                      //                break;
                                                      //    }


                                                      //  }else{$broj2 = 0;}
                                                      //      echo $broj2;
                                                      //     echo '</flat_floor_id>',"\n";

                                                      

                                                          //površina
                                                          if($size3 > 0){
                                                                echo '<main_area>'.$size3.'</main_area>',"\n";
                                                          
                                                          }
                                                        
                                                       

                                                          //vrt površina
                                                           echo '<garden_area>0</garden_area>',"\n";

                                                           //balkon površina
                                                          echo '<balcony_area>0</balcony_area>',"\n";

                                                          //terasa površina
                                                          echo '<terace_area>0</terace_area>',"\n";


                                                              
                                                          //godina izgradnje 
                                                           if ($year2['meta_value']){
                                                               echo '<year_built>'.$year2['meta_value'].'</year_built>',"\n";}


                                                                   if(strstr($row2['post_content'], "Adaptacija :")){
                                                                   $adap2 = strstr($row2['post_content'], "Adaptacija :",0);
                                                                   $adap2 = substr($adap2,12,7);
                                                                    echo '<year_last_rebuild>',$adap2,'</year_last_rebuild>',"\n";
                                                          }

                                                          //novogradnja
                                                           echo '<new_building>0</new_building>',"\n";

                                                                       //grijanje

                                                      echo '<heating_type_id>';
                                                          switch ($GrijanjeRow2["name"])
                                                          {
                                                          
                                                              case "Plinsko etažno":
                                                              case "Toplana":
                                                              $broj2 = "224";
                                                              break;
                                                           
                                                              case "Radijatori na struju":
                                                              $broj2 = "225";
                                                              break;

                                                              case "":
                                                              $broj2 = "0";
                                                              break;
                                                          
                                                          }

                                                          echo $broj2;

                                                      echo '</heating_type_id>',"\n";
                                                             echo '<parking_spot_count>';
                                                  
                                                     if($ParkingRow2["name"]){
                                                      echo '1';
                                                     }else{echo '0';}
                                                      echo '</parking_spot_count>'."\n";


                                                        //oprema prijevoz
                                                        echo '<furnish_level_id></furnish_level_id>',"\n";
                                                        echo '<bus_proximity></bus_proximity>';
                                                        echo '<tram_proximity></tram_proximity>';

                              //LOOKUP LISTA
                              echo '<lookup_list>';

                                                              //telefon
                                                                if($TelefonRow_2["name"] !== null || $TelefonRow_L2["name"] !== null){
                                                                      echo '<lookup_item code="installations">223</lookup_item>',"\n";
                                                                }else{echo '<lookup_item code="installations">0</lookup_item>',"\n";}

                                                                //grijanje
                                                            if ($GrijanjeRow2["name"] == "Toplana"){ 
                                                                  echo '<lookup_item code="heating">229</lookup_item>',"\n";   
                                                                }

                                                            if ($KlimaRow2["name"]) {
                                                                echo '<lookup_item code="heating">231</lookup_item>',"\n";
                                                                }


                                                                
                                                              //Vlasnički list
                                                              if($VlistRow2["name"]){
                                                                  echo '<lookup_item code="permits">232</lookup_item>',"\n"; 
                                                              }else{
                                                                            //vlista alternativa 
                                                                              $gVDozvola2 = strstr($row2['post_content'], "Vlasnički list:",0);
                                                                              $gVDozvola2 = substr($gVDozvola2,14,4);
                                                                              if($gVDozvola2){
                                                                                  echo '<lookup_item code="permits">232</lookup_item>',"\n";           
                                                                              }          
                                                              }

                                                         

                                                              //građevinska 
                                                                if(strstr($row2['post_content'], "Građevinska dozvola:")){
                                                                   $gDozvola2 = strstr($row2['post_content'], "Građevinska dozvola:",0);
                                                                   $gDozvola2 = substr($gDozvola2,21,4);
                                                                   if($gDozvola2){
                                                                       echo '<lookup_item code="permits">233</lookup_item>',"\n";           
                                                                   }  
                                                            }

                                                                      //uporabna 
                                                                if(strstr($row2['post_content'], "Uporabna dozvola:")){
                                                                   $gUDozvola2 = strstr($row2['post_content'], "Uporabna dozvola:",0);
                                                                   $gUDozvola2 = substr($gUDozvola2,17,4);
                                                                   if($gUDozvola2){
                                                                       echo '<lookup_item code="permits">234</lookup_item>',"\n";           
                                                                   }  
                                                            }


                                                                  //bazen                                                      
                                                              if ($BazenRow2["name"]) {
                                                              echo '<lookup_item code="garden">164</lookup_item>',"\n";   
                                                              }


                                                                 //roštilj    
                                                                $gRostilj2 = strstr($row2['post_content'], "Ugrađen roštilj",0);
                                                                if ($gRostilj2) {
                                                                echo '<lookup_item code="garden">166</lookup_item>',"\n";
                                                                }

                                                                  //electronics
                                                                      if ($KablovskaRow2["name"]) {
                                                                      echo '<lookup_item code="electronics">167</lookup_item>',"\n"; 
                                                                      }

                                                                          if ($SatelitRow2['name'] ) {
                                                                               echo '<lookup_item code="electronics">168</lookup_item>',"\n";
                                                                              }

                                                                              //alarm
                                                                              if ( $AlarmRow2['name'] ) {
                                                                                  echo '<lookup_item code="electronics">171</lookup_item>',"\n";   
                                                                                  }

                                                                                     //protuprovalna vrata 
                                                                                         // echo '<lookup_item code="electronics"/>',"\n";


                                                                                              if ($cajnaKuhinjaRow["name"]){
                                                                                                  echo '<lookup_item code="electronics">367</lookup_item>',"\n"; 
                                                                                                }
                                                                                          

                              echo '</lookup_list>',"\n";// KRAJ LOOPa




                                                      
                                                           




 echo '</ad_item>',"\n"; //end nekretnine
}// kraj loop najam stanova





//
//
//
//                   KUĆE PRODAJA
//                                                                                 
//
//   


 $container4 = mysqli_query($link, $Contextz_Q->queryKuceProdaja);
 while($row4 = mysqli_fetch_assoc($container4)){
 $tekst4 = $row4["post_content"];


                                               //polja - detalji
                                             $Qdetails4 = "SELECT meta_value FROM wp_postmeta
                                             where wp_postmeta.post_id = ".$row4["ID"]."
                                             and wp_postmeta.meta_key = 'REAL_HOMES_property_price'
                                             and wp_postmeta.meta_value >= 0";
                                             $cijena4 = mysqli_query($link, $Qdetails4);
                                             $cijenaRow4 = mysqli_fetch_assoc($cijena4);
                                            



                                            //naslovna slika
                                            $QslikeFe4 = "select DISTINCT  wp_posts.guid
                                            from wp_posts
                                            INNER JOIN wp_postmeta ON wp_postmeta.meta_value = wp_posts.ID
                                            WHERE wp_posts.post_type = 'attachment'
                                            AND wp_postmeta.meta_key = '_thumbnail_id'
                                            AND wp_postmeta.post_id = ".$row4["ID"];
                                            $slika4 = mysqli_query($link, $QslikeFe4);
                                            $slikeRow4 = mysqli_fetch_assoc($slika4);


                             


                                              //lokacija WP
                                             $QlokacijaZupanija4 = "SELECT wp_terms.name
                                                            from wp_terms
                                                            RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                            LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                                            JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                                            WHERE wp_posts.ID = ".$row4["ID"].
                                                            " AND wp_term_taxonomy.taxonomy = 'property-city'
                                                            GROUP BY wp_term_taxonomy.parent";
                                                            $zupanija4 = mysqli_query($link, $QlokacijaZupanija4);
                                                            $zupanijaRow4 = mysqli_fetch_assoc($zupanija4);
  

                                      


                                               $QTbl_Lokacija4 = "SELECT * from zupanije
                                                                 where zupanije.nazivZupanije = '".$zupanijaRow4["name"]."'";        
                                                                 $zupanija_njuskaloId4 = mysqli_query($link, $QTbl_Lokacija4);
                                                                 $njuskaloZupRow4 = mysqli_fetch_assoc($zupanija_njuskaloId4);

                                                                          if($njuskaloZupRow4["id"] > 0)
                                                                          {
                                                                                $QTbl_Lokacija4_ = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaloZupRow4["id"];    
                                                                                $grad_njuskaloId4 = mysqli_query($link, $QTbl_Lokacija4_);
                                                                                $nuskaloGradRow4 = mysqli_fetch_assoc($grad_njuskaloId4);
                                                                          }else{
                                                                            $nuskaloGradRow4 = null;
                                                                          }
                                            
                                          
                                                                         // $nuskaloGradRow4

                                                 $QTbl_Lokacija4 = "SELECT * FROM kvartovi WHERE id = ".$nuskaloGradRow["id"];

                                                        ///karta i google zapisi
                                                                 $QMap4 = "SELECT * FROM wp_postmeta where wp_postmeta.post_id = ".$row4["ID"].
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                                                                 " and wp_postmeta.meta_value >= 0";
                                                                 $map4 = mysqli_query($link, $QMap4);
                                                                 $gMapRow4 = mysqli_fetch_assoc($map4);
                                            

                                                                  if(!is_null($gMapRow4["meta_value"]) || $gMapRow4["meta_value"] != ''){
                                                                      $rest4 = explode(",", $gMapRow4["meta_value"]);
                                                                      $Lon4 = $rest4[1];
                                                                      $Lat4 = $rest4[0];
                                                                  }else{
                                                                    $Lat4 = 0;
                                                                    $Lon4 = 0;
                                                                  }


                                                                 

                                                            $QbrojSoba4 = "SELECT meta_value FROM wp_postmeta where 
                                                                 wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $brSoba4 = mysqli_query($link, $QbrojSoba4);
                                                                  $sobeRow4 = mysqli_fetch_assoc($brSoba4);

                                                             

                              
                              

                                                                 $QSize4 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $size_4 = mysqli_query($link, $QSize4);
                                                                 $sizeRow4 = mysqli_fetch_assoc($size_4); 
                                                                 $size4 = $sizeRow4["meta_value"];


                                                                 $QSizeLot4 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_lot_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $sizeL_4 = mysqli_query($link, $QSizeLot4);
                                                                 $sizeRowL4 = mysqli_fetch_assoc($sizeL_4); 
                                                                 $sizeL4 = $sizeRowL4["meta_value"];


                                

                                                                  $QYearBuild4 = "SELECT meta_value FROM wp_postmeta
                                                                   where wp_postmeta.post_id = ".$row4["ID"].
                                                                   " and wp_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                                                                   and wp_postmeta.meta_value >= 0";
                                                                   $yearB4 = mysqli_query($link, $QYearBuild4);
                                                                   $year4 = mysqli_fetch_assoc($yearB4);



                                                                     $Grijanje4 = "SELECT  wp_terms.name
                                                                               from wp_term_relationships
                                                                               LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                               LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                               LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                               WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                               AND post_status='publish'
                                                                               AND wp_posts.ID = ".$row4["ID"]."
                                                                                AND wp_terms.name = 'Plinsko etažno'
                                                                                OR wp_terms.name = 'Radijatori na struju'
                                                                                OR wp_terms.name = 'Toplana'";
                                                                       $grijanjeTip4 = mysqli_query($link, $Grijanje4);
                                                                       $GrijanjeRow4 = mysqli_fetch_assoc($grijanjeTip4); 


                                                                            $QParking4 = "SELECT wp_terms.name from wp_term_relationships 
                                                                   LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID 
                                                                   LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                                                                   LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                                                                   WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND wp_posts.ID = ".$row4["ID"]. 
                                                                   " AND wp_terms.name = 'Parking' ";
                                                                   $parking4 = mysqli_query($link, $QParking4);
                                                                   $ParkingRow4 = mysqli_fetch_assoc($parking4);



                                                                              $QKlima4 = "SELECT  wp_terms.name
                                                                                         from wp_term_relationships
                                                                                         LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                         LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                         LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                         WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                         AND post_status='publish'
                                                                                         AND wp_posts.ID = ".$row4["ID"]. 
                                                                                          " AND wp_terms.name = 'Klima uređaj' ";
                                                                   $klima4 = mysqli_query($link, $QKlima4);
                                                                   $KlimaRow4 = mysqli_fetch_assoc($klima4);



                                                                                  $QVlList4 = "SELECT  wp_terms.name
                                                                                         from wp_term_relationships
                                                                                         LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                         LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                         LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                         WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                         AND post_status='publish'
                                                                                         AND wp_posts.ID = ".$row4["ID"]. 
                                                                                          " AND wp_terms.name = 'Vlasnički list u posjedu'";
                                                                   $Vlist4 = mysqli_query($link, $QVlList4);
                                                                   $VlistRow4 = mysqli_fetch_assoc($Vlist4);




                                                                     $QGaraza = "SELECT meta_value FROM wp_postmeta
                                                                   where wp_postmeta.post_id = ".$row4["ID"].
                                                                   " and wp_postmeta.meta_key = 'REAL_HOMES_property_garage'
                                                                   and wp_postmeta.meta_value >= 0";
                                                                   $garagaB4 = mysqli_query($link, $QGaraza);
                                                                   $garaga4 = mysqli_fetch_assoc($garagaB4);



                                                                   $QBazen4 = "SELECT  wp_terms.name
                                                                               from wp_term_relationships
                                                                               LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                               LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                               LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                               WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                               AND post_status='publish'
                                                                               AND wp_posts.ID = ".$row4["ID"]. 
                                                                                 " AND wp_terms.name = 'Bazen'";
                                                                                 $Bazen4 = mysqli_query($link, $QBazen4);
                                                                                 $BazenRow4 = mysqli_fetch_assoc($Bazen4);



                                                                                 $QKablovska4 = "SELECT  wp_terms.name
                                                                                                 from wp_term_relationships
                                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                 AND post_status='publish'
                                                                                                 AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                 " AND wp_terms.name = 'Kablovska'";
                                                                                                 $Kablovska4 = mysqli_query($link, $QKablovska4);
                                                                                                 $KablovskaRow4 = mysqli_fetch_assoc($Kablovska4);


                                                                                                
                                                                                 $QSatelit4 = "SELECT  wp_terms.name
                                                                                                 from wp_term_relationships
                                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                 AND post_status='publish'
                                                                                                 AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                 " AND wp_terms.name = 'Satelitska'";
                                                                                                 $satelit4 = mysqli_query($link, $QSatelit4);
                                                                                                 $SatelitRow4 = mysqli_fetch_assoc($satelit4);


                                                                                      $QAlarm4 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                " AND wp_terms.name = 'Alarm'";
                                                                                                $alarm4 = mysqli_query($link, $QAlarm4);
                                                                                                $AlarmRow4 = mysqli_fetch_assoc($alarm4);



                                                                                     $QTelefon4 = "SELECT  wp_terms.name
                                                                                     from wp_term_relationships
                                                                                     LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                     LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                     LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                     WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                     AND post_status='publish'
                                                                                     AND wp_posts.ID = ".$row4["ID"].
                                                                                     " AND wp_terms.name = 'Telefon (upotreba)'";
                                                                                     $telefon_4 = mysqli_query($link, $QTelefon4);
                                                                                     $TelefonRow_4 = mysqli_fetch_assoc($telefon_4);


                                                                                     $QTelefon_L4 = "SELECT  wp_terms.name
                                                                                     from wp_term_relationships
                                                                                     LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                     LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                     LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                     WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                     AND post_status='publish'
                                                                                     AND wp_posts.ID = ".$row4["ID"].
                                                                                     " AND wp_terms.name = 'Telefon'";
                                                                                     $telefon_L4 = mysqli_query($link, $QTelefon_L4);
                                                                                     $TelefonRow_L4 = mysqli_fetch_assoc($telefon_L4);






                                                                                    


 echo '<ad_item class="ad_house">
     <user_id>444900</user_id>
         <original_id>s-'.$row4["ID"].'</original_id>';
         echo  '<category_id>9579</category_id>',"\n";


//         //naslov
             echo '<title> Kuća: ',$row4['post_title'],'</title>';
             //link na stranicu
                echo '<external_url>'.$row4["guid"].'</external_url>', "\n";
                     //tekst oglasa
                       echo '<description_raw>'; 
                           echo '<![CDATA[',$tekst4,']]>';
                       echo '</description_raw>',"\n";

                           echo '<price>',$cijenaRow4['meta_value'],'</price>
                           <currency_id>2</currency_id>',"\n";
    
    
//                             //slike                  
                             echo '<image_list>',"\n";
                                             echo '<image>glavna slika : '. $slikeRow4["guid"].'</image>',"\n";
                                                 //galerija slika
                                                 $Qgalerija4 = "select DISTINCT wp_posts.guid
                                                 from wp_posts
                                                 INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                 WHERE wp_posts.post_type = 'attachment'
                                                 AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                 AND wp_postmeta.post_id = ".$row4["ID"].
                                                 " ORDER BY wp_posts.post_date DESC";
                                                                           $gallery4 = mysqli_query($link, $Qgalerija4);
                                                                           while($galleryRow4= mysqli_fetch_assoc($gallery4)){
                                                                                 echo '<image>'. $galleryRow4["guid"].'</image>',"\n";
                                                                           }    
                             echo '</image_list>',"\n";

                            
//                                                 //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                                 echo '<additional_contact></additional_contact>',"\n";


                                                 //određivanje lokacija
                                                 echo '<level_0_location_id>';
                                                 //zupanija
                                                 echo $njuskaloZupRow4["njuskaloId"].'</level_0_location_id>',"\n";
                                                
//                                                 //grad
                                                 echo '<level_1_location_id>'.$nuskaloGradRow4["njuskaloId"].'</level_1_location_id>',"\n";

//                                                 //kvart
                                                 echo '<level_2_location_id></level_2_location_id>',"\n";


//                                                 //ulica (mikrolokacija po JAKO starom)
//                                                 echo '<street_name>0</street_name>',"\n";


                                                 //Lokacija na google karti
                                                   if ( $Lon4 AND $Lat4 ) {
                                                       echo '<location_x>'.$Lon4.'</location_x>',"\n";
                                                       echo '<location_y>'.$Lat4.'</location_y>',"\n";
                                                   }else{
                                                        echo '<location_x>0</location_x>',"\n";
                                                        echo '<location_y>0</location_y>',"\n";
                                                   }




                             


                                                                                                //vrsta kuće
                                                                                                 $type;
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaStambenoPoslovna);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 1;}; //Stambeno-poslovna
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaSamostojeca);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 2;}; //Samostojeća
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaNiz);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 3;}; //kuća u nizu
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaDvoj);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 4;}; //Samostojeća
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaRoh);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 5;}; //Roh-bau
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryVikendica);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 6;}; //Vikendica
                                                                                                 }



                                                                                                switch ($type){

                                                                                                  case '1':
                                                                                                  $stan = "351";
                                                                                                  break;
                                                                                              
                                                                                                  case '2':
                                                                                                  $stan = "174";
                                                                                                  break;
                                                                                              
                                                                                                  case '3':
                                                                                                  $stan = "176";
                                                                                                  break;
                                                                                              
                                                                                                  case '4':
                                                                                                  $stan = "175";
                                                                                                  break;
                                                                                              
                                                                                                  case '5':
                                                                                                  case '6':
                                                                                                  $stan = "174";
                                                                                                  break;
                                                                                              }
                                                                                              
                                                                                              echo '<house_type_id>'.$stan.'</house_type_id>',"\n";




                                                                                    //broj etaža
                                                                                    if(strstr($row4['post_content'], "Broj etaža :")){
                                                                                      $etaza4 = strstr($row4['post_content'], "Broj etaža :",0);
                                                                                      $etaza4 = substr($etaza4,14,1);
                                                                                      switch ($etaza4){
                                                                                        case "1":
                                                                                        $etaza4 = "177";
                                                                                        break;

                                                                                        case "2":
                                                                                          $etaza4 = "178";
                                                                                          break;

                                                                                          case "3":
                                                                                          $etaza4 = "179";
                                                                                          break;

                                                                                          case "4":
                                                                                          $etaza4 = "180";
                                                                                          break;
                                                                                        }
                                                                                      
                                                                              echo '<floor_count_id>'. $etaza4.'</floor_count_id>',"\n";
                                                                                    }   else{
                                                                                           // echo '<floor_count_id>0</floor_count_id>',"\n";
                                                                                            }


                                                                                echo '<room_count>'.$sobeRow4["meta_value"].'</room_count>',"\n";



                                                                                //površina
                                                                                if($size3 > 0){
                                                                                      echo '<main_area>'.$size4.'</main_area>',"\n";                                                       
                                                                                }
                                                        
                                                                                
                                                                                //površina okućnice
                                                                                echo '<other_area>'.$sizeL4.'</other_area>',"\n";


                                                                            //godina izgradnje 
                                                                            if ($year4['meta_value']){
                                                                              echo '<year_built>'.$year4['meta_value'].'</year_built>',"\n";}


                                                                                  if(strstr($row4['post_content'], "Adaptacija :")){
                                                                                  $adap4 = strstr($row4['post_content'], "Adaptacija :",0);
                                                                                  $adap4 = substr($adap4,12,7);
                                                                                  echo '<year_last_rebuild>',$adap4,'</year_last_rebuild>',"\n";
                                                                        }


                                                                         //novogradnja
                                                                         echo '<new_building>0</new_building>',"\n";



                                                                                                   //grijanje

                                                       echo '<heating_type_id>';
                                                           switch ($GrijanjeRow4["name"])
                                                           {
                                                              case "Plinsko etažno":
                                                              case "Toplana":
                                                              $broj4 = "224";
                                                               break;
                                                         
                                                               case "Radijatori na struju":
                                                               $broj4 = "225";
                                                               break;
                                                               case "":
                                                               $broj4 = "0";
                                                               break;
                                                        
                                                           }
                                                           echo $broj4;
                                                       echo '</heating_type_id>',"\n";

//                                                           //vrt površina
//                                                            echo '<garden_area>0</garden_area>',"\n";

//                                                            //balkon površina
//                                                           echo '<balcony_area>0</balcony_area>',"\n";

//                                                           //terasa površina
//                                                           echo '<terace_area>0</terace_area>',"\n";


                                                                                                         
                                                              echo '<parking_spot_count>';
                                                      if($ParkingRow4["name"]){
                                                       echo '1';
                                                      }else{echo '0';}
                                                       echo '</parking_spot_count>'."\n";


                                                         //oprema prijevoz
                                                         echo '<furnish_level_id></furnish_level_id>',"\n";
                                                         echo '<bus_proximity></bus_proximity>';
                                                         echo '<tram_proximity></tram_proximity>';

//                               //LOOKUP LISTA
                               echo '<lookup_list>';

                                                               //telefon
                                                                 if($TelefonRow_4["name"] !== null || $TelefonRow_L4["name"] !== null){
                                                                       echo '<lookup_item code="installations">150</lookup_item>',"\n";
                                                                 }

                                                                 //grijanje
                                                             if ($GrijanjeRow2["name"] == "Toplana"){ 
                                                                   echo '<lookup_item code="heating">229</lookup_item>',"\n";   
                                                                 }

                                                             if ($KlimaRow4["name"]) {
                                                                 echo '<lookup_item code="heating">154</lookup_item>',"\n";
                                                                 }


                                                                
                                                               //Vlasnički list
                                                                if($VlistRow4["name"]){
                                                                    echo '<lookup_item code="permits">161</lookup_item>',"\n"; 
                                                                }else{
                                                                              //vlista alternativa 
                                                                                $gVDozvola4 = strstr($row4['post_content'], "Vlasnički list:",0);
                                                                                $gVDozvola4 = substr($gVDozvola4,14,4);
                                                                                if($gVDozvola4){
                                                                                    echo '<lookup_item code="permits">161</lookup_item>',"\n";           
                                                                                }          
                                                                }

                                                         

                                                               //građevinska 
                                                                  if(strstr($row4['post_content'], "Građevinska dozvola:")){
                                                                     $gDozvola4 = strstr($row4['post_content'], "Građevinska dozvola:",0);
                                                                     $gDozvola4 = substr($gDozvola4,21,4);
                                                                     if($gDozvola4){
                                                                         echo '<lookup_item code="permits">159</lookup_item>',"\n";           
                                                                     }  
                                                              }

                                                                       //uporabna 
                                                                  if(strstr($row4['post_content'], "Uporabna dozvola:")){
                                                                     $gUDozvola4 = strstr($row4['post_content'], "Uporabna dozvola:",0);
                                                                     $gUDozvola4 = substr($gUDozvola4,17,4);
                                                                     if($gUDozvola4){
                                                                         echo '<lookup_item code="permits">160</lookup_item>',"\n";           
                                                                     }  
                                                              }



                                                                  //parking
                                                                  if ($garaga4['meta_value'] ) {
                                                                  echo '<lookup_item code="parking">162</lookup_item>',"\n";   
                                                                  }






                                                                  //bazen                                                      
                                                              if ($BazenRow4["name"]) {
                                                              echo '<lookup_item code="garden">164</lookup_item>',"\n";   
                                                              }


                                                                  // if ( $podaci['vrtnaKucica'] ) {
                                                                  //   echo '<lookup_item code="garden">165</lookup_item>',"\n";   
                                                                  //   }


                                                                  //roštilj    
                                                                 $gRostilj4 = strstr($row4['post_content'], "Ugrađen roštilj",0);
                                                                 if ($gRostilj4) {
                                                                 echo '<lookup_item code="garden">166</lookup_item>',"\n";
                                                                 }

                                                                  //electronics
                                                                      if ($KablovskaRow4["name"]) {
                                                                      echo '<lookup_item code="electronics">167</lookup_item>',"\n"; 
                                                                      }

                                                                           if ($SatelitRow4['name'] ) {
                                                                                echo '<lookup_item code="electronics">168</lookup_item>',"\n";
                                                                               }


                                                              

                                                                               //alarm
                                                                               if ( $AlarmRow4['name'] ) {
                                                                                   echo '<lookup_item code="electronics">171</lookup_item>',"\n";   
                                                                                   }


                                                                                          

                               echo '</lookup_list>',"\n";// KRAJ LOOPa


  echo '</ad_item>',"\n"; //end nekretnine
 }// kraj loop kuće prodaja



//                                                                                 
//                                                                                 
//                                                                                 
//                   KUĆE NAJAM                                                    
//                                                                                 
//                                                                                 
//   

 $container5 = mysqli_query($link, $Contextz_Q->queryKuceNajam);
 while($row5 = mysqli_fetch_assoc($container4)){
 $tekst5 = $row5["post_content"];


                                               //polja - detalji
                                             $Qdetails5 = "SELECT meta_value FROM wp_postmeta
                                             where wp_postmeta.post_id = ".$row5["ID"]."
                                             and wp_postmeta.meta_key = 'REAL_HOMES_property_price'
                                             and wp_postmeta.meta_value >= 0";
                                             $cijena5 = mysqli_query($link, $Qdetails5);
                                             $cijenaRow5 = mysqli_fetch_assoc($cijena5);
                                            



                                            //naslovna slika
                                            $QslikeFe5 = "select DISTINCT  wp_posts.guid
                                            from wp_posts
                                            INNER JOIN wp_postmeta ON wp_postmeta.meta_value = wp_posts.ID
                                            WHERE wp_posts.post_type = 'attachment'
                                            AND wp_postmeta.meta_key = '_thumbnail_id'
                                            AND wp_postmeta.post_id = ".$row5["ID"];
                                            $slika5 = mysqli_query($link, $QslikeFe5);
                                            $slikeRow5 = mysqli_fetch_assoc($slika5);


                             


                                              //lokacija WP
                                             $QlokacijaZupanija5 = "SELECT wp_terms.name
                                                            from wp_terms
                                                            RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                            LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                                            JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                                            WHERE wp_posts.ID = ".$row5["ID"].
                                                            " AND wp_term_taxonomy.taxonomy = 'property-city'
                                                            GROUP BY wp_term_taxonomy.parent";
                                                            $zupanija5 = mysqli_query($link, $QlokacijaZupanija5);
                                                            $zupanijaRow5 = mysqli_fetch_assoc($zupanija5);
  

                                      


                                               $QTbl_Lokacija5 = "SELECT * from zupanije
                                                                 where zupanije.nazivZupanije = '".$zupanijaRow5["name"]."'";        
                                                                 $zupanija_njuskaloId5 = mysqli_query($link, $QTbl_Lokacija5);
                                                                 $njuskaloZupRow5 = mysqli_fetch_assoc($zupanija_njuskaloId5);

                                                                          if($njuskaloZupRow5["id"] > 0)
                                                                          {
                                                                                $QTbl_Lokacija5_ = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaloZupRow5["id"];    
                                                                                $grad_njuskaloId5 = mysqli_query($link, $QTbl_Lokacija5_);
                                                                                $nuskaloGradRow5 = mysqli_fetch_assoc($grad_njuskaloId5);
                                                                          }else{
                                                                            $nuskaloGradRow5 = null;
                                                                          }
                                            
                                          
                                                                         // $nuskaloGradRow4

                                                 $QTbl_Lokacija5 = "SELECT * FROM kvartovi WHERE id = ".$nuskaloGradRo5["id"];

                                                        ///karta i google zapisi
                                                                 $QMap5 = "SELECT * FROM wp_postmeta where wp_postmeta.post_id = ".$row5["ID"].
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_location'". 
                                                                 " and wp_postmeta.meta_value >= 0";
                                                                 $map5 = mysqli_query($link, $QMap5);
                                                                 $gMapRow5 = mysqli_fetch_assoc($map5);
                                            

                                                                  if(!is_null($gMapRow5["meta_value"]) || $gMapRow5["meta_value"] != ''){
                                                                      $rest5 = explode(",", $gMapRow5["meta_value"]);
                                                                      $Lon5 = $rest5[1];
                                                                      $Lat5 = $rest5[0];
                                                                  }else{
                                                                    $Lat5 = 0;
                                                                    $Lon5 = 0;
                                                                  }


                                                                 

                                                            $QbrojSoba4 = "SELECT meta_value FROM wp_postmeta where 
                                                                 wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                                                                  and wp_postmeta.meta_value >= 0";
                                                                  $brSoba4 = mysqli_query($link, $QbrojSoba4);
                                                                  $sobeRow4 = mysqli_fetch_assoc($brSoba4);

                                                             

                              
                              

                                                                 $QSize4 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $size_4 = mysqli_query($link, $QSize4);
                                                                 $sizeRow4 = mysqli_fetch_assoc($size_4); 
                                                                 $size4 = $sizeRow4["meta_value"];


                                                                 $QSizeLot4 = "SELECT meta_value FROM wp_postmeta
                                                                 where wp_postmeta.post_id = ".$row4["ID"]. 
                                                                 " and wp_postmeta.meta_key = 'REAL_HOMES_property_lot_size'
                                                                 and wp_postmeta.meta_value >= 0";
                                                                 $sizeL_4 = mysqli_query($link, $QSizeLot4);
                                                                 $sizeRowL4 = mysqli_fetch_assoc($sizeL_4); 
                                                                 $sizeL4 = $sizeRowL4["meta_value"];


                                

                                                                  $QYearBuild4 = "SELECT meta_value FROM wp_postmeta
                                                                   where wp_postmeta.post_id = ".$row4["ID"].
                                                                   " and wp_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                                                                   and wp_postmeta.meta_value >= 0";
                                                                   $yearB4 = mysqli_query($link, $QYearBuild4);
                                                                   $year4 = mysqli_fetch_assoc($yearB4);



                                                                     $Grijanje4 = "SELECT  wp_terms.name
                                                                               from wp_term_relationships
                                                                               LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                               LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                               LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                               WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                               AND post_status='publish'
                                                                               AND wp_posts.ID = ".$row4["ID"]."
                                                                                AND wp_terms.name = 'Plinsko etažno'
                                                                                OR wp_terms.name = 'Radijatori na struju'
                                                                                OR wp_terms.name = 'Toplana'";
                                                                       $grijanjeTip4 = mysqli_query($link, $Grijanje4);
                                                                       $GrijanjeRow4 = mysqli_fetch_assoc($grijanjeTip4); 


                                                                            $QParking4 = "SELECT wp_terms.name from wp_term_relationships 
                                                                   LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID 
                                                                   LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                                                                   LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
                                                                   WHERE wp_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND wp_posts.ID = ".$row4["ID"]. 
                                                                   " AND wp_terms.name = 'Parking' ";
                                                                   $parking4 = mysqli_query($link, $QParking4);
                                                                   $ParkingRow4 = mysqli_fetch_assoc($parking4);



                                                                              $QKlima4 = "SELECT  wp_terms.name
                                                                                         from wp_term_relationships
                                                                                         LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                         LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                         LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                         WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                         AND post_status='publish'
                                                                                         AND wp_posts.ID = ".$row4["ID"]. 
                                                                                          " AND wp_terms.name = 'Klima uređaj' ";
                                                                   $klima4 = mysqli_query($link, $QKlima4);
                                                                   $KlimaRow4 = mysqli_fetch_assoc($klima4);



                                                                                  $QVlList4 = "SELECT  wp_terms.name
                                                                                         from wp_term_relationships
                                                                                         LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                         LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                         LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                         WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                         AND post_status='publish'
                                                                                         AND wp_posts.ID = ".$row4["ID"]. 
                                                                                          " AND wp_terms.name = 'Vlasnički list u posjedu'";
                                                                   $Vlist4 = mysqli_query($link, $QVlList4);
                                                                   $VlistRow4 = mysqli_fetch_assoc($Vlist4);




                                                                     $QGaraza = "SELECT meta_value FROM wp_postmeta
                                                                   where wp_postmeta.post_id = ".$row4["ID"].
                                                                   " and wp_postmeta.meta_key = 'REAL_HOMES_property_garage'
                                                                   and wp_postmeta.meta_value >= 0";
                                                                   $garagaB4 = mysqli_query($link, $QGaraza);
                                                                   $garaga4 = mysqli_fetch_assoc($garagaB4);



                                                                   $QBazen4 = "SELECT  wp_terms.name
                                                                               from wp_term_relationships
                                                                               LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                               LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                               LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                               WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                               AND post_status='publish'
                                                                               AND wp_posts.ID = ".$row4["ID"]. 
                                                                                 " AND wp_terms.name = 'Bazen'";
                                                                                 $Bazen4 = mysqli_query($link, $QBazen4);
                                                                                 $BazenRow4 = mysqli_fetch_assoc($Bazen4);



                                                                                 $QKablovska4 = "SELECT  wp_terms.name
                                                                                                 from wp_term_relationships
                                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                 AND post_status='publish'
                                                                                                 AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                 " AND wp_terms.name = 'Kablovska'";
                                                                                                 $Kablovska4 = mysqli_query($link, $QKablovska4);
                                                                                                 $KablovskaRow4 = mysqli_fetch_assoc($Kablovska4);


                                                                                                
                                                                                 $QSatelit4 = "SELECT  wp_terms.name
                                                                                                 from wp_term_relationships
                                                                                                 LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                 LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                 LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                 WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                 AND post_status='publish'
                                                                                                 AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                 " AND wp_terms.name = 'Satelitska'";
                                                                                                 $satelit4 = mysqli_query($link, $QSatelit4);
                                                                                                 $SatelitRow4 = mysqli_fetch_assoc($satelit4);


                                                                                      $QAlarm4 = "SELECT  wp_terms.name
                                                                                                from wp_term_relationships
                                                                                                LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                                LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                                LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                                WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                                AND post_status='publish'
                                                                                                AND wp_posts.ID = ".$row4["ID"]. 
                                                                                                " AND wp_terms.name = 'Alarm'";
                                                                                                $alarm4 = mysqli_query($link, $QAlarm4);
                                                                                                $AlarmRow4 = mysqli_fetch_assoc($alarm4);



                                                                                     $QTelefon4 = "SELECT  wp_terms.name
                                                                                     from wp_term_relationships
                                                                                     LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                     LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                     LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                     WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                     AND post_status='publish'
                                                                                     AND wp_posts.ID = ".$row4["ID"].
                                                                                     " AND wp_terms.name = 'Telefon (upotreba)'";
                                                                                     $telefon_4 = mysqli_query($link, $QTelefon4);
                                                                                     $TelefonRow_4 = mysqli_fetch_assoc($telefon_4);


                                                                                     $QTelefon_L4 = "SELECT  wp_terms.name
                                                                                     from wp_term_relationships
                                                                                     LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
                                                                                     LEFT JOIN wp_terms ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
                                                                                     LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
                                                                                     WHERE wp_term_taxonomy.taxonomy = 'property-feature'
                                                                                     AND post_status='publish'
                                                                                     AND wp_posts.ID = ".$row4["ID"].
                                                                                     " AND wp_terms.name = 'Telefon'";
                                                                                     $telefon_L4 = mysqli_query($link, $QTelefon_L4);
                                                                                     $TelefonRow_L4 = mysqli_fetch_assoc($telefon_L4);






                                                                                    


 echo '<ad_item class="ad_house_lease">
     <user_id>444900</user_id>
         <original_id>k-'.$row5["ID"].'</original_id>';
         echo  '<category_id>10919</category_id>',"\n";


//         //naslov
             echo '<title> Kuća: '.$row5['post_title'],'</title>';
             //link na stranicu
                echo '<external_url>'.$row5["guid"].'</external_url>', "\n";
                     //tekst oglasa
                       echo '<description_raw>'; 
                           echo '<![CDATA[',$tekst5,']]>';
                       echo '</description_raw>',"\n";

                           echo '<price>',$cijenaRow5['meta_value'],'</price>
                           <currency_id>2</currency_id>',"\n";
    
    
//                             //slike                  
                             echo '<image_list>',"\n";
                                             echo '<image>glavna slika : '. $slikeRow5["guid"].'</image>',"\n";
                                                 //galerija slika
                                                 $Qgalerija5 = "select DISTINCT wp_posts.guid
                                                 from wp_posts
                                                 INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                 WHERE wp_posts.post_type = 'attachment'
                                                 AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                 AND wp_postmeta.post_id = ".$row5["ID"].
                                                 " ORDER BY wp_posts.post_date DESC";
                                                                           $gallery5 = mysqli_query($link, $Qgalerija5);
                                                                           while($galleryRow4= mysqli_fetch_assoc($gallery5)){
                                                                                 echo '<image>'. $galleryRow5["guid"].'</image>',"\n";
                                                                           }    
                             echo '</image_list>',"\n";

                            
//                                                 //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                                 echo '<additional_contact></additional_contact>',"\n";


                                                 //određivanje lokacija
                                                 echo '<level_0_location_id>';
                                                 //zupanija
                                                 echo $njuskaloZupRow5["njuskaloId"].'</level_0_location_id>',"\n";
                                                
//                                                 //grad
                                                 echo '<level_1_location_id>'.$nuskaloGradRow5["njuskaloId"].'</level_1_location_id>',"\n";

//                                                 //kvart
                                                 echo '<level_2_location_id></level_2_location_id>',"\n";


//                                                 //ulica (mikrolokacija po JAKO starom)
//                                                 echo '<street_name>0</street_name>',"\n";


                                                 //Lokacija na google karti
                                                   if ( $Lon5 AND $Lat5 ) {
                                                       echo '<location_x>'.$Lon5.'</location_x>',"\n";
                                                       echo '<location_y>'.$Lat5.'</location_y>',"\n";
                                                   }else{
                                                        echo '<location_x>0</location_x>',"\n";
                                                        echo '<location_y>0</location_y>',"\n";
                                                   }




                             


                                                                                                //vrsta kuće
                                                                                                 $type;
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaStambenoPoslovna);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 1;}; //Stambeno-poslovna
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaSamostojeca);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 2;}; //Samostojeća
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaNiz);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 3;}; //kuća u nizu
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaDvoj);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 4;}; //Samostojeća
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryKucaRoh);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 5;}; //Roh-bau
                                                                                                 }
                                                                                                 $QStanbenoPoslovna = mysqli_query($link, $Contextz_Q->queryVikendica);
                                                                                                 while($vrKuca = mysqli_fetch_assoc($QStanbenoPoslovna)){
                                                                                                 if($vrKuca["ID"]){$type = 6;}; //Vikendica
                                                                                                 }



                                                                                                switch ($type){

                                                                                                  case '1':
                                                                                                  $stan = "351";
                                                                                                  break;
                                                                                              
                                                                                                  case '2':
                                                                                                  $stan = "174";
                                                                                                  break;
                                                                                              
                                                                                                  case '3':
                                                                                                  $stan = "176";
                                                                                                  break;
                                                                                              
                                                                                                  case '4':
                                                                                                  $stan = "175";
                                                                                                  break;
                                                                                              
                                                                                                  case '5':
                                                                                                  case '6':
                                                                                                  $stan = "174";
                                                                                                  break;
                                                                                              }
                                                                                              
                                                                                              echo '<house_type_id>'.$stan.'</house_type_id>',"\n";




                                                                                    //broj etaža
                                                                                    if(strstr($row5['post_content'], "Broj etaža :")){
                                                                                      $etaza5 = strstr($row4['post_content'], "Broj etaža :",0);
                                                                                      $etaza5 = substr($etaza5,14,1);
                                                                                      switch ($etaza5){
                                                                                        case "1":
                                                                                        $etaza5 = "177";
                                                                                        break;

                                                                                        case "2":
                                                                                          $etaza5 = "178";
                                                                                          break;

                                                                                          case "3":
                                                                                          $etaza5 = "179";
                                                                                          break;

                                                                                          case "4":
                                                                                          $etaza5 = "180";
                                                                                          break;
                                                                                        }
                                                                                      
                                                                              echo '<floor_count_id>'. $etaza5.'</floor_count_id>',"\n";
                                                                                    }   else{
                                                                                           // echo '<floor_count_id>0</floor_count_id>',"\n";
                                                                                            }


                                                                                echo '<room_count>'.$sobeRow5["meta_value"].'</room_count>',"\n";



                                                                            

  echo '</ad_item>',"\n"; //end nekretnine
 }// kraj loop kuće najam





//                                      
//                                      
//                                      
//           ZEMLJIŠTA PRODAJA          
//                                      
//                                      
//                                      




echo '</ad_list>';



//rješene su samo Vlasnički list i bazen, ostalo će trebat pazit kako se unaša.

?>

