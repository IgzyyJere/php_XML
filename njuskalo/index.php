<?php
header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="utf-8"?>';

$link = new mysqli("localhost", "root", "", "nekreninetestwp");
mysqli_set_charset($link,"utf8");

//session_start ();

echo '<ad_list>';
  


                                                            
 $queryOglasi1 ="
 select wp_posts.ID, wp_posts.post_title, wp_posts.post_status ,wp_posts.guid ,wp_posts.post_type, wp_posts.post_date, wp_term_taxonomy.term_id, 
             wp_term_taxonomy.taxonomy, wp_term_taxonomy.description, wp_terms.name, wp_posts.post_content
             from wp_posts
             LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
             LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
             LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id)
             WHERE wp_posts.post_type = 'property'
             AND wp_posts.post_status = 'publish'
             AND wp_terms.name IS NOT NULL
             ORDER BY post_date DESC";



$container = mysqli_query($link, $queryOglasi1);
while($row = mysqli_fetch_assoc($container)){
$tekst = $row["post_content"];


                                            //kvart
                                            // $Qkvart = "SELECT wp_term_taxonomy.parent, wp_terms.name, wp_terms.term_id, wp_posts.ID
                                            // from wp_terms
                                            // RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                            // LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                            // JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                            // WHERE wp_posts.ID = ".$row["ID"]."
                                            // AND wp_term_taxonomy.taxonomy = 'property-city'
                                            // GROUP BY wp_term_taxonomy.parent";
                                            // $zupanija = mysqli_query($link, $Qkvart);
                                            // $zupanijaRow = mysqli_fetch_assoc($zupanija);


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
                                            $QgalCount = "select DISTINCT  count(wp_posts.guid)
                                              from wp_posts
                                              INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                              WHERE wp_posts.post_type = 'attachment'
                                              AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                              AND wp_postmeta.post_id = ".$row["ID"].
                                              " ORDER BY wp_posts.post_date DESC";
                                              $gall = mysqli_query($link, $QgalCount);
                                              $gallRow = mysqli_fetch_assoc($gall);
                                              $picCount = $gallRow["count(wp_posts.guid)"];


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
                                                                                 AND wp_posts.ID = ".$row["ID"];
                                                                                 $liftT = mysqli_query($link, $QFeaturesT1);
                                                                                 $liftRow = mysqli_fetch_assoc($liftT);



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
                                                $Qgalerija = "select DISTINCT  wp_posts.guid
                                                from wp_posts
                                                INNER JOIN wp_postmeta ON (wp_postmeta.meta_value = wp_posts.ID)
                                                WHERE wp_posts.post_type = 'attachment'
                                                AND wp_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                AND wp_postmeta.post_id = ".$row["ID"].
                                                " ORDER BY wp_posts.post_date DESC";
                                                
                                                                for ($i=1; $i <= $picCount; $i++) {
                                                                $gallery = mysqli_query($link, $Qgalerija);
                                                                $galleryRow = mysqli_fetch_assoc($gallery);
                                                                echo '<image>'.$picCount. $galleryRow["guid"].'</image>',"\n";
                                                                 echo '<i>'.$picCount.'</i>';
                                                                if ( $i == 9 ) { break;}
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

                                                //kvart
                                                echo '<level_2_location_id>N</level_2_location_id>',"\n";


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
                                                         
                                                           if($liftRow["name"] == "Teretni Lift"){
                                                               echo '<elevator>1</elevator>',"\n";
                                                             }else{
                                                                 echo '<elevator>0</elevator>',"\n";
                                                           }


                                                          //površina
                                                          if($size > 0){
                                                                echo '<main_area>'.$size.'</main_area>',"\n";
                                                          }else{
                                                              echo '<main_area>0</main_area>',"\n";
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
                                                    
                                           
                                                        //telefon
                                                            echo '<lookup_item code="installations">223</lookup_item>',"\n";
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
                                                                              echo'KKKKKKKKKK'.$gVDozvola;
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
    if ( $podaci['bazen'] ) {

     echo '<lookup_item code="garden">164</lookup_item>',"\n";
        
    }


                                                          

                                                                 
     
     
        
    
    



        echo '</ad_item>',"\n"; //end nekretnine
                                           // mysqli_free_result($row);
                                            // mysqli_free_result($slikeRow);
                                            // mysqli_free_result($gallRow);
                                            // mysqli_free_result($zupanijaRow);
                                            // mysqli_free_result($cijenaRow);
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
                                          mysqli_free_result($BazenRow);

}// KRAJ LOOPa
echo '</ad_list>';



//rješene su samo Vlasnički list i bazen, ostalo će trebat pazit kako se unaša.

?>

