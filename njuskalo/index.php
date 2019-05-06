<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';

include 'defini_fields.php';
$Contextz_Q = new QueryMain_Context();
$link = new mysqli("localhost", $Contextz_Q->user, $Contextz_Q->passW, $Contextz_Q->db);
mysqli_set_charset($link,"utf8");
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

$iframe='<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2780.3923760217453!2d15.977854915868244!3d45.82342617910676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d70564567d8f%3A0x590a4443e8f65193!2zTWVkdmXFocSNYWsgdWwuLCAxMDAwMCwgWmFncmVi!5e0!3m2!1shr!2shr!4v1554149357723!5m2!1shr!2shr" width="600" height="450" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
$patternIframe = "#<iframe[^>]+>.*?</iframe>#is";



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
                $WPLOKACIJARow= mysqli_fetch_assoc($WPLokacija);
                $zupanijaname = $WPLOKACIJARow["name"];

        }


    $QZupanije1 = "SELECT * FROM zupanije WHERE nazivZupanije = '" . $zupanijaname . "'";
    $zupanija = mysqli_query($link, $QZupanije1);
    $njuskaZupanija = mysqli_fetch_assoc($zupanija);



  $QNjuskaloKvart_Lost = "SELECT  DISTINCT * from kvartovi WHERE kvartovi.naziv like '".$zupanijaname."%'";
  $kvartNjuskao_lost = mysqli_query($link, $QNjuskaloKvart_Lost);
  $njuskaloKvartRow_Lost = mysqli_fetch_assoc($kvartNjuskao_lost);


  if($njuskaZupanija["id"] > 0) //ako smo našli županiju idemo pogledati gradove
  {
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
  }


            ///karta i google zapisi
                    $QMap = "SELECT * FROM uudqv_postmeta where uudqv_postmeta.post_id = ".$row["ID"].
                    " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_location'".
                    " and uudqv_postmeta.meta_value >= 0";
                    $map = mysqli_query($link, $QMap);
                    $gMapRow = mysqli_fetch_assoc($map);
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
    <user_id>56</user_id>
        <original_id>s-'.$row["ID"].'</original_id>';
        echo '<category_id>9580</category_id>',"\n";

//naslov
  echo '<title>'.$row['post_title'].'</title>';
  //link na stranicu
      echo '<external_url>'.$row["guid"].'</external_url>', "\n";
          //tekst oglasa
           $html = preg_replace('#<iframe[^>]+>.*?</iframe>#is', '', $tekst);
            echo '<description_raw>';
                echo '<![CDATA[',$html,']]>';
            echo '</description_raw>',"\n";

             if($cijenaRow < 1){$cijenaRow = 10000;}
             echo '<price>'.$cijenaRow['meta_value'].'</price>


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

                                      //određivanje lokacija
                                      echo '<level_0_location_id>';
                                      //zupanija
                                      echo $njuskaZupanija["njuskaloId"].'</level_0_location_id>',"\n";

                                      //grad
                                      echo '<level_1_location_id>'.$nuskaloGradRow["njuskaloId"].'</level_1_location_id>',"\n";

                                    if($njuskaloKvartRow_Lost["njuskaloId"] = 0 || is_null($njuskaloKvartRow_Lost["njuskaloId"])){
                                  echo '<level_2_location_id>'.$njuskaloKvartRow["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                    }

                                else{
                                      if($WPLOKACIJARow["name"] = "Grad   Zagreb") {
                                        echo '<level_2_location_id>2656</level_2_location_id>',"\n";
                                        }else{
                                        echo '<level_2_location_id>'.$njuskaloKvartRow_Lost["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                       }

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


                                        echo '<flat_type_id>182</flat_type_id>',"\n";


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


                                                        default:
                                                          $etaza = "184";
                                                        break;

                                                      }

                                            echo '<floor_count_id>'. $etaza.'</floor_count_id>',"\n";
                                          }   else{
                                            echo '<floor_count_id>184</floor_count_id>',"\n";
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

                                                      default:
                                                       $sobe= "188";
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

                                                            default:
                                                            $broj = "192";
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

}// KRAJ LOOPa stanova prodaja



//////
//////  STANOVI NAJAM
//////

$container2 = mysqli_query($link, $Contextz_Q->queryOglasi2);
while($row2 = mysqli_fetch_assoc($container2)){
$tekst2 = $row2["post_content"];


//polja - detalji
$Qdetails2 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row2["ID"]."
and uudqv_postmeta.meta_key = 'REAL_HOMES_property_price'
and uudqv_postmeta.meta_value >= 0";
$cijena2 = mysqli_query($link, $Qdetails2);
$cijenaRow2 = mysqli_fetch_assoc($cijena2);




//naslovna slika
$QslikeFe2 = "select DISTINCT  uudqv_posts.guid
from uudqv_posts
INNER JOIN uudqv_postmeta ON uudqv_postmeta.meta_value = uudqv_posts.ID
WHERE uudqv_posts.post_type = 'attachment'
AND uudqv_postmeta.meta_key = '_thumbnail_id'
AND uudqv_postmeta.post_id = ".$row2["ID"];
$slika2 = mysqli_query($link, $QslikeFe2);
$slikeRow2 = mysqli_fetch_assoc($slika2);





//lokacija uudqv
$CityWP2 = "SELECT uudqv_terms.name
from uudqv_terms
RIGHT JOIN uudqv_term_taxonomy on uudqv_terms.term_id = uudqv_term_taxonomy.term_id
LEFT JOIN uudqv_term_relationships ON uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id
JOIN uudqv_posts on uudqv_posts.ID = uudqv_term_relationships.object_id
WHERE uudqv_posts.ID = ".$row2["ID"].
" AND uudqv_term_taxonomy.taxonomy = 'property-city'
GROUP BY uudqv_term_taxonomy.parent";
$WPLokacija2 = mysqli_query($link, $CityWP2);
$WPLokacijaRow2 = mysqli_fetch_assoc($WPLokacija2);
$zupanijaname2 = $WPLOKACIJARow2["name"];



    $QZupanije2 = "SELECT * FROM zupanije WHERE zupanije.nazivZupanije = '".$zupanijaname2."'";   //source iz baze wp-a kroz city name, upit na zupanije
    $zupanija2 = mysqli_query($link, $QZupanije2);
    $njuskaZupanija2 = mysqli_fetch_assoc($zupanija2);

    $QNjuskaloKvart_Lost2 = "SELECT  DISTINCT * from kvartovi WHERE kvartovi.naziv like '".$zupanijaname2."%'";
    $kvartNjuskao_lost2 = mysqli_query($link, $QNjuskaloKvart_Lost2);
    $njuskaloKvartRow_Lost2 = mysqli_fetch_assoc($kvartNjuskao_lost2);


  if($njuskaZupanija2["id"] > 0) //ako smo našli županiju idemo pogledati gradove
  {
        $QGradovi2 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaZupanija2["id"];
        $grad_njuskaloId2 = mysqli_query($link, $QGradovi2);
        $nuskaloGradRow2 = mysqli_fetch_assoc($grad_njuskaloId2);

        //ako ima grad tada idemo tražit i kvart
        $QNjuskalo_Kvart2 = "SELECT * from kvartovi WHERE kvartovi.grad = ".$nuskaloGradRow2["id"];
        $kvart_njuskaloId2 = mysqli_query($link,  $QNjuskalo_Kvart2);
        $njuskaloKvartRow2 = mysqli_fetch_assoc($kvart_njuskaloId2);

        if($njuskaloKvartRow2["njuskaloId"] < 1){
            $njuskaloKvartRow2["njuskaloId"] = $njuskaloKvartRow_Lost2["njuskaloId"];
            $njuskaloKvartRow2["naziv"] = $njuskaloKvartRow_Lost2["naziv"];
        }
  }




///karta i google zapisi
$QMap2 = "SELECT * FROM uudqv_postmeta where uudqv_postmeta.post_id = ".$row2["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_location'".
" and uudqv_postmeta.meta_value >= 0";
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




$QbrojSoba2 = "SELECT meta_value FROM uudqv_postmeta where
  uudqv_postmeta.post_id = ".$row2["ID"].
  " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
  and uudqv_postmeta.meta_value >= 0";
  $brSoba2 = mysqli_query($link, $QbrojSoba2);
  $sobeRow2 = mysqli_fetch_assoc($brSoba2);






  $QSize2 = "SELECT meta_value FROM uudqv_postmeta
  where uudqv_postmeta.post_id = ".$row2["ID"].
  " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_size'
  and uudqv_postmeta.meta_value >= 0";
  $size_2 = mysqli_query($link, $QSize2);
  $sizeRow2 = mysqli_fetch_assoc($size_2);
  $size2 = $sizeRow2["meta_value"];




  $QYearBuild2 = "SELECT meta_value FROM uudqv_postmeta
  where uudqv_postmeta.post_id = ".$row2["ID"].
  " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_year_built'
  and uudqv_postmeta.meta_value >= 0";
  $yearB2 = mysqli_query($link, $QYearBuild2);
  $year2 = mysqli_fetch_assoc($yearB2);



    $Grijanje2 = "SELECT  uudqv_terms.name
              from uudqv_term_relationships
              LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
              LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
              LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
              WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
              AND post_status='publish'
              AND uudqv_posts.ID = ".$row2["ID"]."
                AND uudqv_terms.name = 'Plinsko etažno'
              OR uudqv_terms.name = 'Radijatori na struju'
              OR uudqv_terms.name = 'Toplana'";
      $grijanjeTip2 = mysqli_query($link, $Grijanje2);
      $GrijanjeRow2 = mysqli_fetch_assoc($grijanjeTip2);


            $QParking2 = "SELECT uudqv_terms.name from uudqv_term_relationships
  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND uudqv_posts.ID = ".$row2["ID"].
  " AND uudqv_terms.name = 'Parking' ";
  $parking2 = mysqli_query($link, $QParking2);
  $ParkingRow2 = mysqli_fetch_assoc($parking2);



              $QKlima2 = "SELECT  uudqv_terms.name
                        from uudqv_term_relationships
                        LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                        LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                        LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                        WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                        AND post_status='publish'
                        AND uudqv_posts.ID = ".$row2["ID"].
                          " AND uudqv_terms.name = 'Klima uređaj' ";
  $klima2 = mysqli_query($link, $QKlima2);
  $KlimaRow2 = mysqli_fetch_assoc($klima2);



                  $QVlList2 = "SELECT  uudqv_terms.name
                        from uudqv_term_relationships
                        LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                        LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                        LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                        WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                        AND post_status='publish'
                        AND uudqv_posts.ID = ".$row2["ID"].
                          " AND uudqv_terms.name = 'Vlasnički list u posjedu'";
  $Vlist2 = mysqli_query($link, $QVlList2);
  $VlistRow2 = mysqli_fetch_assoc($Vlist2);



  $QBazen2 = "SELECT  uudqv_terms.name
              from uudqv_term_relationships
              LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
              LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
              LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
              WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
              AND post_status='publish'
              AND uudqv_posts.ID = ".$row2["ID"].
                " AND uudqv_terms.name = 'Bazen'";
                $Bazen2 = mysqli_query($link, $QBazen2);
                $BazenRow2 = mysqli_fetch_assoc($Bazen2);



                $QKablovska2 = "SELECT  uudqv_terms.name
                                from uudqv_term_relationships
                                LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                AND post_status='publish'
                                AND uudqv_posts.ID = ".$row2["ID"].
                                " AND uudqv_terms.name = 'Kablovska'";
                                $Kablovska2 = mysqli_query($link, $QKablovska2);
                                $KablovskaRow2 = mysqli_fetch_assoc($Kablovska2);



                $QSatelit2 = "SELECT  uudqv_terms.name
                                from uudqv_term_relationships
                                LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                AND post_status='publish'
                                AND uudqv_posts.ID = ".$row2["ID"].
                                " AND uudqv_terms.name = 'Satelitska'";
                                $satelit2 = mysqli_query($link, $QSatelit2);
                                $SatelitRow2 = mysqli_fetch_assoc($satelit2);


                      $QAlarm2 = "SELECT  uudqv_terms.name
                                from uudqv_term_relationships
                                LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                AND post_status='publish'
                                AND uudqv_posts.ID = ".$row2["ID"].
                                " AND uudqv_terms.name = 'Alarm'";
                                $alarm2 = mysqli_query($link, $QAlarm2);
                                $AlarmRow2 = mysqli_fetch_assoc($alarm2);



                    $QTelefon2 = "SELECT  uudqv_terms.name
                    from uudqv_term_relationships
                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                    AND post_status='publish'
                    AND uudqv_posts.ID = ".$row2["ID"].
                    " AND uudqv_terms.name = 'Telefon (upotreba)'";
                    $telefon_2 = mysqli_query($link, $QTelefon2);
                    $TelefonRow_2 = mysqli_fetch_assoc($telefon_2);


                    $QTelefon_L2 = "SELECT  uudqv_terms.name
                    from uudqv_term_relationships
                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                    AND post_status='publish'
                    AND uudqv_posts.ID = ".$row2["ID"].
                    " AND uudqv_terms.name = 'Telefon'";
                    $telefon_L2 = mysqli_query($link, $QTelefon_L2);
                    $TelefonRow_L2 = mysqli_fetch_assoc($telefon_L2);









                    echo '<ad_item class="ad_flats_lease">
                    <user_id>56</user_id>
                        <original_id>s-'.$row2["ID"].'</original_id>';
                        echo  '<category_id>10920</category_id>',"\n";


                        //naslov
                            echo '<title> Stan: ',$row2['post_title'],'</title>';
                            //link na stranicu
                                echo '<external_url>'.$row2["guid"].'</external_url>', "\n";
                                    //tekst oglasa

                                      $html2 = preg_replace('#<iframe[^>]+>.*?</iframe>#is', '', $tekst2);
                                      echo '<description_raw>';

                                          echo '<![CDATA[',$html2,']]>';
                                      echo '</description_raw>',"\n";

                                       if($cijenaRow2 < 1){$cijenaRow2 = 10000;}
                                          echo '<price>',$cijenaRow2['meta_value'],'</price>
                                          <currency_id>2</currency_id>',"\n";


                                            //slike
                                            echo '<image_list>',"\n";
                                                            echo '<image>'. $slikeRow2["guid"].'</image>',"\n";
                                                                //galerija slika
                                                                $Qgalerija2 = "select DISTINCT uudqv_posts.guid
                                                                from uudqv_posts
                                                                INNER JOIN uudqv_postmeta ON (uudqv_postmeta.meta_value = uudqv_posts.ID)
                                                                WHERE uudqv_posts.post_type = 'attachment'
                                                                AND uudqv_postmeta.meta_key = 'REAL_HOMES_property_images'
                                                                AND uudqv_postmeta.post_id = ".$row2["ID"].
                                                                " ORDER BY uudqv_posts.post_date DESC";
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
                                                              echo $njuskaZupanija2["njuskaloId"].'</level_0_location_id>',"\n";

                                                              //grad
                                                              echo '<level_1_location_id>'.$nuskaloGradRow2["njuskaloId"].'</level_1_location_id>',"\n";

                                                     //ovaj uvjet jebe dobijam 1
                                                      if($njuskaloKvartRow_Lost2["njuskaloId"] = 0 || is_null($njuskaloKvartRow_Lost2["njuskaloId"])){
                                                          echo '<level_2_location_id>'.$njuskaloKvartRow2["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                                        }

                                                else{
                                                     if($WPLOKACIJARow2["name"] = "Grad   Zagreb"){
                                                       echo '<level_2_location_id>2656</level_2_location_id>',"\n";
                                                      }
                                                        else{echo '<level_2_location_id>'.$njuskaloKvartRow_Lost2["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                                    }
                                                  }

                                                                //ulica (mikrolokacija po JAKO starom)
                                                                echo '<street_name>0</street_name>',"\n";


                                                                //Lokacija na google karti
                                                                  if ( $Lon2 AND $Lat2 ) {
                                                                      echo '<location_x>'.$Lon2.'</location_x>',"\n";
                                                                      echo '<location_y>'.$Lat2.'</location_y>',"\n";
                                                                  }else{
                                                                       echo '<location_x>'.$njuskaloKvartRow_Lost2["lng"].'</location_x>',"\n";
                                                                        echo '<location_y>'.$njuskaloKvartRow_Lost2["lat"].'</location_y>',"\n";
                                                                  }


                                                                  echo '<flat_type_id>182</flat_type_id>',"\n";


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

                                                                                  default:
                                                                                   $etaza2 = "184";
                                                                                   break;

                                                                                }

                                                                      echo '<floor_count_id>'. $etaza2.'</floor_count_id>',"\n";
                                                                            }   else{
                                                                                    echo '<floor_count_id>184</floor_count_id>',"\n";
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

                                                                                default:
                                                                                $sobe2 = "188";
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

                                                                                      default:
                                                                                      $sobe2 = "218";
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
                                                                            echo '<garden_area></garden_area>',"\n";

                                                                            //balkon površina
                                                                          echo '<balcony_area></balcony_area>',"\n";

                                                                          //terasa površina
                                                                          echo '<terace_area></terace_area>',"\n";



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



                 mysqli_free_result($kvartNjuskao_lost2);
                                              mysqli_free_result($zupanija2);






                  echo '</ad_item>',"\n"; //end nekretnine
                }// kraj loop najam stanova







//////
//////  POSLOVNI NAJAM
//////

$container3 = mysqli_query($link, $Contextz_Q->queryOglasi3);
while($row3 = mysqli_fetch_assoc($container3)){
$tekst3 = $row3["post_content"];


  //polja - detalji
$Qdetails3 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row3["ID"]."
and uudqv_postmeta.meta_key = 'REAL_HOMES_property_price'
and uudqv_postmeta.meta_value >= 0";
$cijena3 = mysqli_query($link, $Qdetails3);
$cijenaRow3 = mysqli_fetch_assoc($cijena3);




//naslovna slika
$QslikeFe3 = "select DISTINCT  uudqv_posts.guid
from uudqv_posts
INNER JOIN uudqv_postmeta ON uudqv_postmeta.meta_value = uudqv_posts.ID
WHERE uudqv_posts.post_type = 'attachment'
AND uudqv_postmeta.meta_key = '_thumbnail_id'
AND uudqv_postmeta.post_id = ".$row3["ID"];
$slika3 = mysqli_query($link, $QslikeFe3);
$slikeRow3 = mysqli_fetch_assoc($slika3);





  //lokacija uudqv
  $CityWP3 = "SELECT uudqv_terms.name
                from uudqv_terms
                RIGHT JOIN uudqv_term_taxonomy on uudqv_terms.term_id = uudqv_term_taxonomy.term_id
                LEFT JOIN uudqv_term_relationships ON uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id
                JOIN uudqv_posts on uudqv_posts.ID = uudqv_term_relationships.object_id
                WHERE uudqv_posts.ID = ".$row3["ID"].
                " AND uudqv_term_taxonomy.taxonomy = 'property-city'
                GROUP BY uudqv_term_taxonomy.parent";
                $WPLokacija3 = mysqli_query($link, $CityWP3);
                $WPLokacijaRow3 = mysqli_fetch_assoc($WPLokacija3);
                $zup3= $WPLOKACIJARow3["name"];

    $QZupanije3 = "SELECT * FROM zupanije WHERE zupanije.nazivZupanije = '".$zup3."'";   //source iz baze wp-a kroz city name, upit na zupanije
    $zupanija3 = mysqli_query($link, $QZupanije3);
    $njuskaZupanija3 = mysqli_fetch_assoc($zupanija3);

    $QNjuskaloKvart_Lost3 = "SELECT  DISTINCT * from kvartovi WHERE kvartovi.naziv like '".$zup3."%'";
    $kvartNjuskao_lost3 = mysqli_query($link, $QNjuskaloKvart_Lost3);
    $njuskaloKvartRow_Lost3 = mysqli_fetch_assoc($kvartNjuskao_lost3);


  if($njuskaZupanija3["id"] > 0) //ako smo našli županiju idemo pogledati gradove
  {
        $QGradovi3 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaZupanija3["id"];
        $grad_njuskaloId3 = mysqli_query($link, $QGradovi3);
        $nuskaloGradRow3 = mysqli_fetch_assoc($grad_njuskaloId3);

        //ako ima grad tada idemo tražit i kvart
        $QNjuskalo_Kvart3 = "SELECT * from kvartovi WHERE kvartovi.grad = ".$nuskaloGradRow3["id"];
        $kvart_njuskaloId3 = mysqli_query($link,  $QNjuskalo_Kvart3);
        $njuskaloKvartRow3 = mysqli_fetch_assoc($kvart_njuskaloId3);

        if($njuskaloKvartRow3["njuskaloId"] < 1){
            $njuskaloKvartRow3["njuskaloId"] = $njuskaloKvartRow_Lost3["njuskaloId"];
            $njuskaloKvartRow3["naziv"] = $njuskaloKvartRow_Lost3["naziv"];
        }
  }







            ///karta i google zapisi
                    $QMap3 = "SELECT * FROM uudqv_postmeta where uudqv_postmeta.post_id = ".$row3["ID"].
                    " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_location'".
                    " and uudqv_postmeta.meta_value >= 0";
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




                $QbrojSoba3 = "SELECT meta_value FROM uudqv_postmeta where
                      uudqv_postmeta.post_id = ".$row3["ID"].
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
                      and uudqv_postmeta.meta_value >= 0";
                      $brSoba3 = mysqli_query($link, $QbrojSoba3);
                      $sobeRow3 = mysqli_fetch_assoc($brSoba3);






                      $QSize3 = "SELECT meta_value FROM uudqv_postmeta
                      where uudqv_postmeta.post_id = ".$row3["ID"].
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_size'
                      and uudqv_postmeta.meta_value >= 0";
                      $size_3 = mysqli_query($link, $QSize3);
                      $sizeRow3 = mysqli_fetch_assoc($size_3);
                      $size3 = $sizeRow3["meta_value"];




                      $QYearBuild3 = "SELECT meta_value FROM uudqv_postmeta
                      where uudqv_postmeta.post_id = ".$row3["ID"].
                      " and uudqv_postmeta.meta_key = 'REAL_HOMES_property_year_built'
                      and uudqv_postmeta.meta_value >= 0";
                      $yearB3 = mysqli_query($link, $QYearBuild3);
                      $year3 = mysqli_fetch_assoc($yearB3);



                        $Grijanje3 = "SELECT  uudqv_terms.name
                                  from uudqv_term_relationships
                                  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row3["ID"]."
                                    AND uudqv_terms.name = 'Plinsko etažno'
                                  OR uudqv_terms.name = 'Radijatori na struju'
                                  OR uudqv_terms.name = 'Toplana'";
                          $grijanjeTip3 = mysqli_query($link, $Grijanje3);
                          $GrijanjeRow3 = mysqli_fetch_assoc($grijanjeTip3);


                                $QParking3 = "SELECT uudqv_terms.name from uudqv_term_relationships
                      LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                      LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                      LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                      WHERE uudqv_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND uudqv_posts.ID = ".$row3["ID"].
                      " AND uudqv_terms.name = 'Parking' ";
                      $parking3 = mysqli_query($link, $QParking3);
                      $ParkingRow3 = mysqli_fetch_assoc($parking3);



                                  $QKlima3 = "SELECT  uudqv_terms.name
                                            from uudqv_term_relationships
                                            LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                            LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                            WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row3["ID"].
                                              " AND uudqv_terms.name = 'Klima uređaj' ";
                      $klima3 = mysqli_query($link, $QKlima3);
                      $KlimaRow3 = mysqli_fetch_assoc($klima3);



                                      $QVlList3 = "SELECT  uudqv_terms.name
                                            from uudqv_term_relationships
                                            LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                            LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                            LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                            WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                            AND post_status='publish'
                                            AND uudqv_posts.ID = ".$row3["ID"].
                                              " AND uudqv_terms.name = 'Vlasnički list u posjedu'";
                      $Vlist3 = mysqli_query($link, $QVlList3);
                      $VlistRow3 = mysqli_fetch_assoc($Vlist3);



                      $QBazen3 = "SELECT  uudqv_terms.name
                                  from uudqv_term_relationships
                                  LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                  LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                  LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                  WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                  AND post_status='publish'
                                  AND uudqv_posts.ID = ".$row3["ID"].
                                    " AND uudqv_terms.name = 'Bazen'";
                                    $Bazen3 = mysqli_query($link, $QBazen3);
                                    $BazenRow3 = mysqli_fetch_assoc($Bazen3);



                                    $QKablovska3 = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row3["ID"].
                                                    " AND uudqv_terms.name = 'Kablovska'";
                                                    $Kablovska3 = mysqli_query($link, $QKablovska3);
                                                    $KablovskaRow3 = mysqli_fetch_assoc($Kablovska3);



                                    $QSatelit3 = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row3["ID"].
                                                    " AND uudqv_terms.name = 'Satelitska'";
                                                    $satelit3 = mysqli_query($link, $QSatelit3);
                                                    $SatelitRow3 = mysqli_fetch_assoc($satelit3);


                                          $QAlarm3 = "SELECT  uudqv_terms.name
                                                    from uudqv_term_relationships
                                                    LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                                    LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                                    LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                                    WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                                    AND post_status='publish'
                                                    AND uudqv_posts.ID = ".$row3["ID"].
                                                    " AND uudqv_terms.name = 'Alarm'";
                                                    $alarm3 = mysqli_query($link, $QAlarm3);
                                                    $AlarmRow3 = mysqli_fetch_assoc($alarm3);



                                        $QTelefon3 = "SELECT  uudqv_terms.name
                                        from uudqv_term_relationships
                                        LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                        LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                        LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                        WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                        AND post_status='publish'
                                        AND uudqv_posts.ID = ".$row3["ID"].
                                        " AND uudqv_terms.name = 'Telefon (upotreba)'";
                                        $telefon_3 = mysqli_query($link, $QTelefon3);
                                        $TelefonRow_3 = mysqli_fetch_assoc($telefon_3);


                                        $QTelefon_L3 = "SELECT  uudqv_terms.name
                                        from uudqv_term_relationships
                                        LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                        LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                        LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                        WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                        AND post_status='publish'
                                        AND uudqv_posts.ID = ".$row3["ID"].
                                        " AND uudqv_terms.name = 'Telefon'";
                                        $telefon_L3 = mysqli_query($link, $QTelefon_L3);
                                        $TelefonRow_L3 = mysqli_fetch_assoc($telefon_L3);


                                        $QKuhinja = "SELECT  uudqv_terms.name
                                        from uudqv_term_relationships
                                        LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
                                        LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
                                        LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
                                        WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
                                        AND post_status='publish'
                                        AND uudqv_posts.ID = ".$row3["ID"].
                                        " AND uudqv_terms.name = 'Čajna kuhinja'";
                                        $cajna_kuhinja = mysqli_query($link, $QKuhinja);
                                        $cajnaKuhinjaRow = mysqli_fetch_assoc($cajna_kuhinja);






echo '<ad_item class="ad_business_space">
<user_id>56</user_id>
<original_id>s-'.$row3["ID"].'</original_id>';
echo  '<category_id>9585</category_id>',"\n";


//naslov
echo '<title> Poslovni prostor: ',$row3['post_title'],'</title>';
//link na stranicu
echo '<external_url>'.$row3["guid"].'</external_url>', "\n";
//tekst oglasa
$html3 = preg_replace('#<iframe[^>]+>.*?</iframe>#is', '', $tekst3);
echo '<description_raw>';
echo '<![CDATA[',$html3,']]>';
echo '</description_raw>',"\n";

 if($cijenaRow3 < 1){$cijenaRow3 = 10000;}
echo '<price>',$cijenaRow3['meta_value'],'</price>
<currency_id>2</currency_id>',"\n";


//slike
echo '<image_list>',"\n";
            echo '<image>'. $slikeRow3["guid"].'</image>',"\n";
                //galerija slika
                $Qgalerija3 = "select DISTINCT uudqv_posts.guid
                from uudqv_posts
                INNER JOIN uudqv_postmeta ON (uudqv_postmeta.meta_value = uudqv_posts.ID)
                WHERE uudqv_posts.post_type = 'attachment'
                AND uudqv_postmeta.meta_key = 'REAL_HOMES_property_images'
                AND uudqv_postmeta.post_id = ".$row3["ID"].
                " ORDER BY uudqv_posts.post_date DESC";
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
            echo $njuskaZupanija3["njuskaloId"].'</level_0_location_id>',"\n";

            //grad
            echo '<level_1_location_id>'.$nuskaloGradRow3["njuskaloId"].'</level_1_location_id>',"\n";

           //ovaj uvjet jebe dobijam 1
                                             if($njuskaloKvartRow_Lost3["njuskaloId"] = 0 || is_null($njuskaloKvartRow_Lost3["njuskaloId"])){
                                                 echo '<level_3_location_id>'.$njuskaloKvartRow3["njuskaloId"].'</level_3_location_id>',"\n"; //zamjenski
                                               }

                                                else{
                                                     if($WPLOKACIJARow3["name"] = "Grad   Zagreb") {
                                                       echo '<level_3_location_id>3656</level_3_location_id>',"\n";}

                                                       else{
                                                         echo '<level_3_location_id>'.$njuskaloKvartRow_Lost3["njuskaloId"].'</level_3_location_id>',"\n"; //zamjenski
                                                   }
                                                }



                //ulica (mikrolokacija po JAKO starom)
                echo '<street_name>0</street_name>',"\n";


                //Lokacija na google karti
                  if ( $Lon3 AND $Lat3 ) {
                      echo '<location_x>'.$Lon3.'</location_x>',"\n";
                      echo '<location_y>'.$Lat3.'</location_y>',"\n";
                  }else{
                      echo '<location_x>'.$njuskaloKvartRow_Lost3["lng"].'</location_x>',"\n";
                      echo '<location_y>'.$njuskaloKvartRow_Lost3["lat"].'</location_y>',"\n";
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

                                                                  default:
                                                                  $stan="1";
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
                            if ($year3['meta_value']){
                                echo '<year_built>'.$year2['meta_value'].'</year_built>',"\n";}


                                    if(strstr($row3['post_content'], "Adaptacija :")){
                                    $adap3 = strstr($row3['post_content'], "Adaptacija :",0);
                                    $adap3 = substr($adap3,12,7);
                                    echo '<year_last_rebuild>',$adap3,'</year_last_rebuild>',"\n";
                          }

                          //novogradnja
                            echo '<new_building>0</new_building>',"\n";

                                        //grijanje

                      echo '<heating_type_id>';
                          switch ($GrijanjeRow3["name"])
                          {

                              case "Plinsko etažno":
                              case "Toplana":
                              $broj3 = "224";
                              break;

                              case "Radijatori na struju":
                              $broj3 = "225";
                              break;

                              case "":
                              $broj3 = "0";
                              break;

                          }

                          echo $broj3;

                      echo '</heating_type_id>',"\n";
                              echo '<parking_spot_count>';

                      if($ParkingRow3["name"]){
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
                                if($TelefonRow_3["name"] !== null || $TelefonRow_L3["name"] !== null){
                                      echo '<lookup_item code="installations">223</lookup_item>',"\n";
                                }else{echo '<lookup_item code="installations">0</lookup_item>',"\n";}

                                //grijanje
                            if ($GrijanjeRow3["name"] == "Toplana"){
                                  echo '<lookup_item code="heating">229</lookup_item>',"\n";
                                }

                            if ($KlimaRow3["name"]) {
                                echo '<lookup_item code="heating">231</lookup_item>',"\n";
                                }



                              //Vlasnički list
                              if($VlistRow3["name"]){
                                  echo '<lookup_item code="permits">232</lookup_item>',"\n";
                              }else{
                                            //vlista alternativa
                                              $gVDozvola3 = strstr($row3['post_content'], "Vlasnički list:",0);
                                              $gVDozvola3 = substr($gVDozvola3,14,4);
                                              if($gVDozvola3){
                                                  echo '<lookup_item code="permits">232</lookup_item>',"\n";
                                              }
                              }


                                      //građevinska
                                if(strstr($row3['post_content'], "Građevinska dozvola:")){
                                    $gDozvola3 = strstr($row3['post_content'], "Građevinska dozvola:",0);
                                    $gDozvola3 = substr($gDozvola3,31,4);
                                    if($gDozvola3){
                                        echo '<lookup_item code="permits">333</lookup_item>',"\n";
                                    }
                            }

                                      //uporabna
                                if(strstr($row3['post_content'], "Uporabna dozvola:")){
                                    $gUDozvola3 = strstr($row3['post_content'], "Uporabna dozvola:",0);
                                    $gUDozvola3 = substr($gUDozvola3,17,4);
                                    if($gUDozvola3){
                                        echo '<lookup_item code="permits">334</lookup_item>',"\n";
                                    }
                            }


                            //bazen
                              if ($BazenRow3["name"]) {
                              echo '<lookup_item code="garden">164</lookup_item>',"\n";
                              }


                               //roštilj
                                $gRostilj3 = strstr($row3['post_content'], "Ugrađen roštilj",0);
                                if ($gRostilj3) {
                                echo '<lookup_item code="garden">166</lookup_item>',"\n";
                                }

                                  //electronics
                                      if ($KablovskaRow3["name"]) {
                                      echo '<lookup_item code="electronics">167</lookup_item>',"\n";
                                      }

                                          if ($SatelitRow3['name'] ) {
                                                echo '<lookup_item code="electronics">168</lookup_item>',"\n";
                                              }

                                              //alarm
                                              if ( $AlarmRow3['name'] ) {
                                                  echo '<lookup_item code="electronics">171</lookup_item>',"\n";
                                                  }

                                                      //protuprovalna vrata
                                                          // echo '<lookup_item code="electronics"/>',"\n";


                                                              if ($cajnaKuhinjaRow3["name"]){
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
$Qdetails4 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row4["ID"]."
and uudqv_postmeta.meta_key = 'REAL_HOMES_property_price'
and uudqv_postmeta.meta_value >= 0";
$cijena4 = mysqli_query($link, $Qdetails4);
$cijenaRow4 = mysqli_fetch_assoc($cijena4);




//naslovna slika
$QslikeFe4 = "select DISTINCT  uudqv_posts.guid
from uudqv_posts
INNER JOIN uudqv_postmeta ON uudqv_postmeta.meta_value = uudqv_posts.ID
WHERE uudqv_posts.post_type = 'attachment'
AND uudqv_postmeta.meta_key = '_thumbnail_id'
AND uudqv_postmeta.post_id = ".$row4["ID"];
$slika4 = mysqli_query($link, $QslikeFe4);
$slikeRow4 = mysqli_fetch_assoc($slika4);





//lokacija uudqv
$CityWP4 = "SELECT uudqv_terms.name
from uudqv_terms
RIGHT JOIN uudqv_term_taxonomy on uudqv_terms.term_id = uudqv_term_taxonomy.term_id
LEFT JOIN uudqv_term_relationships ON uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id
JOIN uudqv_posts on uudqv_posts.ID = uudqv_term_relationships.object_id
WHERE uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_term_taxonomy.taxonomy = 'property-city'
GROUP BY uudqv_term_taxonomy.parent";
$WPLokacija4 = mysqli_query($link, $CityWP4);
$WPLokacijaRow4 = mysqli_fetch_assoc($WPLokacija4);
$zupanijaname4 = $WPLOKACIJARow4["name"];

    $QZupanije4 = "SELECT * FROM zupanije WHERE zupanije.nazivZupanije = '".$zupanijaname4."'";   //source iz baze wp-a kroz city name, upit na zupanije
    $zupanija4 = mysqli_query($link, $QZupanije4);
    $njuskaZupanija4 = mysqli_fetch_assoc($zupanija4);


    $QNjuskaloKvart_Lost4 = "SELECT  DISTINCT * from kvartovi WHERE kvartovi.naziv like '".$zupanijaname4."%'";
    $kvartNjuskao_lost4 = mysqli_query($link, $QNjuskaloKvart_Lost4);
    $njuskaloKvartRow_Lost4 = mysqli_fetch_assoc($kvartNjuskao_lost4);


  if($njuskaZupanija4["id"] > 0) //ako smo našli županiju idemo pogledati gradove
  {
        $QGradovi4 = "SELECT * from gradovi WHERE gradovi.zupanija = ".$njuskaZupanija4["id"];
        $grad_njuskaloId4 = mysqli_query($link, $QGradovi4);
        $nuskaloGradRow4 = mysqli_fetch_assoc($grad_njuskaloId4);

        //ako ima grad tada idemo tražit i kvart
        $QNjuskalo_Kvart4 = "SELECT * from kvartovi WHERE kvartovi.grad = ".$nuskaloGradRow4["id"];
        $kvart_njuskaloId4 = mysqli_query($link,  $QNjuskalo_Kvart4);
        $njuskaloKvartRow4 = mysqli_fetch_assoc($kvart_njuskaloId4);

        if($njuskaloKvartRow4["njuskaloId"] < 1){
            $njuskaloKvartRow4["njuskaloId"] = $njuskaloKvartRow_Lost4["njuskaloId"];
            $njuskaloKvartRow4["naziv"] = $njuskaloKvartRow_Lost4["naziv"];
        }
  }



///karta i google zapisi
$QMap4 = "SELECT * FROM uudqv_postmeta where uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_location'".
" and uudqv_postmeta.meta_value >= 0";
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




$QbrojSoba4 = "SELECT meta_value FROM uudqv_postmeta where
uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_bedrooms'
and uudqv_postmeta.meta_value >= 0";
$brSoba4 = mysqli_query($link, $QbrojSoba4);
$sobeRow4 = mysqli_fetch_assoc($brSoba4);






$QSize4 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_size'
and uudqv_postmeta.meta_value >= 0";
$size_4 = mysqli_query($link, $QSize4);
$sizeRow4 = mysqli_fetch_assoc($size_4);
$size4 = $sizeRow4["meta_value"];


$QSizeLot4 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_lot_size'
and uudqv_postmeta.meta_value >= 0";
$sizeL_4 = mysqli_query($link, $QSizeLot4);
$sizeRowL4 = mysqli_fetch_assoc($sizeL_4);
$sizeL4 = $sizeRowL4["meta_value"];




$QYearBuild4 = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_year_built'
and uudqv_postmeta.meta_value >= 0";
$yearB4 = mysqli_query($link, $QYearBuild4);
$year4 = mysqli_fetch_assoc($yearB4);



$Grijanje4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"]."
AND uudqv_terms.name = 'Plinsko etažno'
OR uudqv_terms.name = 'Radijatori na struju'
OR uudqv_terms.name = 'Toplana'";
$grijanjeTip4 = mysqli_query($link, $Grijanje4);
$GrijanjeRow4 = mysqli_fetch_assoc($grijanjeTip4);


$QParking4 = "SELECT uudqv_terms.name from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature' AND post_status='publish' AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Parking' ";
$parking4 = mysqli_query($link, $QParking4);
$ParkingRow4 = mysqli_fetch_assoc($parking4);



$QKlima4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Klima uređaj' ";
$klima4 = mysqli_query($link, $QKlima4);
$KlimaRow4 = mysqli_fetch_assoc($klima4);



$QVlList4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Vlasnički list u posjedu'";
$Vlist4 = mysqli_query($link, $QVlList4);
$VlistRow4 = mysqli_fetch_assoc($Vlist4);




$QGaraza = "SELECT meta_value FROM uudqv_postmeta
where uudqv_postmeta.post_id = ".$row4["ID"].
" and uudqv_postmeta.meta_key = 'REAL_HOMES_property_garage'
and uudqv_postmeta.meta_value >= 0";
$garagaB4 = mysqli_query($link, $QGaraza);
$garaga4 = mysqli_fetch_assoc($garagaB4);



$QBazen4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Bazen'";
$Bazen4 = mysqli_query($link, $QBazen4);
$BazenRow4 = mysqli_fetch_assoc($Bazen4);



$QKablovska4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Kablovska'";
$Kablovska4 = mysqli_query($link, $QKablovska4);
$KablovskaRow4 = mysqli_fetch_assoc($Kablovska4);



$QSatelit4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Satelitska'";
$satelit4 = mysqli_query($link, $QSatelit4);
$SatelitRow4 = mysqli_fetch_assoc($satelit4);


$QAlarm4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Alarm'";
$alarm4 = mysqli_query($link, $QAlarm4);
$AlarmRow4 = mysqli_fetch_assoc($alarm4);



$QTelefon4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Telefon (upotreba)'";
$telefon_4 = mysqli_query($link, $QTelefon4);
$TelefonRow_4 = mysqli_fetch_assoc($telefon_4);


$QTelefon_L4 = "SELECT  uudqv_terms.name
from uudqv_term_relationships
LEFT JOIN uudqv_posts ON uudqv_term_relationships.object_id = uudqv_posts.ID
LEFT JOIN uudqv_terms ON uudqv_terms.term_id = uudqv_term_relationships.term_taxonomy_id
LEFT JOIN uudqv_term_taxonomy ON uudqv_term_taxonomy.term_taxonomy_id = uudqv_term_relationships.term_taxonomy_id
WHERE uudqv_term_taxonomy.taxonomy = 'property-feature'
AND post_status='publish'
AND uudqv_posts.ID = ".$row4["ID"].
" AND uudqv_terms.name = 'Telefon'";
$telefon_L4 = mysqli_query($link, $QTelefon_L4);
$TelefonRow_L4 = mysqli_fetch_assoc($telefon_L4);









echo '<ad_item class="ad_house">
<user_id>56</user_id>
<original_id>s-'.$row4["ID"].'</original_id>';
echo  '<category_id>9579</category_id>',"\n";


//         //naslov
    echo '<title> Kuća: ',$row4['post_title'],'</title>';
    //link na stranicu
        echo '<external_url>'.$row4["guid"].'</external_url>', "\n";

            $html4 =  preg_replace('#<iframe[^>]+>.*?</iframe>#is', '', $tekst4);
              echo '<description_raw>';
                  echo '<![CDATA[',$html4,']]>';
              echo '</description_raw>',"\n";


                  if($cijenaRow4 < 1){$cijenaRow4 = 10000;}
                  echo '<price>',$cijenaRow4['meta_value'],'</price>
                  <currency_id>2</currency_id>',"\n";


//                             //slike
                    echo '<image_list>',"\n";
                                    echo '<image>'. $slikeRow4["guid"].'</image>',"\n";
                                        //galerija slika
                                        $Qgalerija4 = "select DISTINCT uudqv_posts.guid
                                        from uudqv_posts
                                        INNER JOIN uudqv_postmeta ON (uudqv_postmeta.meta_value = uudqv_posts.ID)
                                        WHERE uudqv_posts.post_type = 'attachment'
                                        AND uudqv_postmeta.meta_key = 'REAL_HOMES_property_images'
                                        AND uudqv_postmeta.post_id = ".$row4["ID"].
                                        " ORDER BY uudqv_posts.post_date DESC";
                                                                  $gallery4 = mysqli_query($link, $Qgalerija4);
                                                                  while($galleryRow4= mysqli_fetch_assoc($gallery4)){
                                                                        echo '<image>'. $galleryRow4["guid"].'</image>',"\n";
                                                                  }
                    echo '</image_list>',"\n";


                                     //broj telefona vezan uz nekretninu (može se izvuć broj agenta)
                                        echo '<additional_contact></additional_contact>',"\n";


      //određivanje lokacija
      echo '<level_0_location_id>';
      //zupanija
      echo $njuskaZupanija4["njuskaloId"].'</level_0_location_id>',"\n";

      //grad
      echo '<level_1_location_id>'.$nuskaloGradRow4["njuskaloId"].'</level_1_location_id>',"\n";

                                if($njuskaloKvartRow_Lost4["njuskaloId"] = 0 || is_null($njuskaloKvartRow_Lost4["njuskaloId"])){
                                  $njuskaloKvartRow4["njuskaloId"] = $njuskaloKvartRow_Lost4["njuskaloId"];
                                  echo '<level_2_location_id>'.$njuskaloKvartRow4["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                } else{
                                    if($WPLOKACIJARow4["name"] = "Grad   Zagreb") {
                                      echo '<level_2_location_id>2656</level_2_location_id>',"\n";
                                    }
                                      else{echo '<level_2_location_id>'.$njuskaloKvartRow_Lost4["njuskaloId"].'</level_2_location_id>',"\n"; //zamjenski
                                  }
                                }


//                                                 //ulica (mikrolokacija po JAKO starom)
//                                                 echo '<street_name>0</street_name>',"\n";


                                        //Lokacija na google karti
                                          if ( $Lon4 AND $Lat4 ) {
                                              echo '<location_x>'.$Lon4.'</location_x>',"\n";
                                              echo '<location_y>'.$Lat4.'</location_y>',"\n";
                                          }else{
                                              echo '<location_x>'.$njuskaloKvartRow_Lost4["lng"].'</location_x>',"\n";
                                              echo '<location_y>'.$njuskaloKvartRow_Lost4["lat"].'</location_y>',"\n";
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

                                                                                  default:
                                                                                  $etaza4 = "177";
                                                                                  break;

                                                                                }

                                                                      echo '<floor_count_id>'. $etaza4.'</floor_count_id>',"\n";
                                                                            }else{
                                                                             echo '<floor_count_id>177</floor_count_id>',"\n";
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
                                                                      echo '<year_built>'.$year4['meta_value'].'</year_built>',"\n";
                                                                    }


                                                                          if(strstr($row4['post_content'], "Adaptacija :")){
                                                                          $adap4 = strstr($row4['post_content'], "Adaptacija :",0);
                                                                          $adap4 = substr($adap4,12,7);
                                                                        //  echo '<year_last_rebuild>',$adap4,'</year_last_rebuild>',"\n";
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



























echo '</ad_list>';



//rješene su samo Vlasnički list i bazen, ostalo će trebat pazit kako se unaša.

?>

