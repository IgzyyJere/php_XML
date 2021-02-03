<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';

include 'defini_fields.php';
$Contextz_Q = new QueryMain_Context();
$link = new mysqli("localhost", $Contextz_Q->user, $Contextz_Q->passW, $Contextz_Q->db);
mysqli_set_charset($link,"utf8");





echo '<root>';

//main query
$container = mysqli_query($link, $Contextz_Q->queryProduct);


//main
while($row = mysqli_fetch_assoc($container))
{

  //filtriranje texta cipele
  $tekst_content = $row["post_content"];
  $opis_content = htmlentities($tekst_content, ENT_XML1);

  ///parent varable
  $parentQueryVariable = "SELECT * from loxah_posts
  where post_type like 'product_variation' and post_status like 'publish' and post_parent = ".$row['ID'];
  $variables_container = mysqli_query($link, $parentQueryVariable);

  ///SKU
  $parentQuerySKU = "SELECT * FROM loxah_postmeta WHERE meta_key like '%sku' and post_id = ".$row['ID'];
  $sku_container = mysqli_query($link, $parentQuerySKU);


  //image fix
  $imageFixQ =  "SELECT * FROM loxah_postmeta WHERE meta_key like '_thumbnail_id' and post_id = ".$row['ID'];
  $imageFixquery = mysqli_query($link, $imageFixQ);

  echo '<row>';
          //naslov
          echo '<title>'.$row['post_title'].'</title>', "\n";
          //echo '<description>'.$opis_content.'</description>', "\n";
          echo '<description><![CDATA['.$opis_content.']]></description>', "\n"; 

            while($row_sku = mysqli_fetch_assoc($sku_container))
            {
              echo '<id>'.$row_sku['meta_value'].'</id>';

                       //image
                       $kk = $row_sku['meta_value'];
                       $imageQuery = "SELECT * FROM loxah_posts where post_name like '$kk' and post_type like 'attachment'";
                       $image_container = mysqli_query($link, $imageQuery);
                       $image = mysqli_fetch_assoc($image_container);
                       if($image != null){
                        echo '<image>'.$image['guid'].'</image>';
                       }
                       else{
                        while($row_sku2 = mysqli_fetch_assoc($imageFixquery)){
                          $kk2 = $row_sku2['meta_value'];
                          $imageQuery2 = "SELECT * FROM loxah_posts where id = '$kk2' and post_type like 'attachment'";
                          $image_container2 = mysqli_query($link, $imageQuery2);
                          $image2 = mysqli_fetch_assoc($image_container2);
                          echo '<image>'.$image2['guid'].'</image>';
                        }
                      
                       }
                   
            }

                

          //echo '<stock>'.$row["meta_value"].'</stock>'; nema ukupno samo pojedinčano po brojevima
          echo '<id_control>'.$row["ID"].'</id_control>';
         
                echo'<variants>';
             


                    while($row_variables = mysqli_fetch_assoc($variables_container))
                    {
                      echo '<variant>';
                        $filterBroj = preg_replace('/[^0-9]/', '', $row_variables['post_title']);
                        echo '<variant_title>'.$filterBroj.'</variant_title>', "\n"; //broj cipele
                        echo '<variant_title_id>'.$row_variables['ID'].'</variant_title_id>', "\n"; //id broja cipele

                                //stock broja cipele
                                $stockByNumQuery= "SELECT * FROM loxah_postmeta where meta_key like '_stock' and post_id = ".$row_variables['ID'];
                                $stock_variabales = mysqli_query($link, $stockByNumQuery);
                                while($row_stockVariables = mysqli_fetch_assoc($stock_variabales)){
                                  echo '<variant_stock>'.$row_stockVariables['meta_value'].'</variant_stock>', "\n";
                                }
                    


                      $saleActionPriceQuery = "SELECT * FROM loxah_postmeta where meta_key LIKE '_sale_price' and post_id = " .$row_variables['ID'];
                      $sale_price_action = mysqli_query($link, $saleActionPriceQuery);
                      $dataPrice_action = mysqli_fetch_assoc($sale_price_action);
                      echo '<discounted_price>'.$dataPrice_action['meta_value'].'</discounted_price>', "\n";
      
      
                      $salePriceQuery = "SELECT * FROM loxah_postmeta where meta_key LIKE '_regular_price' and post_id = " .$row_variables['ID'];
                      $sale_price = mysqli_query($link, $salePriceQuery);
                      $dataPrice = mysqli_fetch_assoc($sale_price);
                      echo '<base_price>'.$dataPrice['meta_value'].'</base_price>', "\n";
         
                      echo '</variant>';            
                     }
          echo'</variants>';
echo '</row>'; //end proizvod
}// KRAJ LOOPa stanova prodaja

echo '</root>';


?>