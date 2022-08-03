<?php

include 'defini_fields.php';
$Contextz_Q = new QueryMain_Context();
$link = new mysqli("localhost", $Contextz_Q->user, $Contextz_Q->passW, $Contextz_Q->db);
mysqli_set_charset($link,"utf8");

$xmlString = '<root>';

//main query
$container = mysqli_query($link, $Contextz_Q->queryProduct);

//main
while($row = mysqli_fetch_assoc($container))
{

  ///kategorija
  $ID = $row['ID'];
  $querycategory1 = "select loxah_terms.name, loxah_terms.term_id, loxah_terms.term_group from loxah_terms 
  left join loxah_term_relationships on loxah_term_relationships.term_taxonomy_id = loxah_terms.term_id  
  left join loxah_posts on loxah_posts.ID = loxah_term_relationships.object_id 
  left join loxah_term_taxonomy on loxah_term_taxonomy.term_taxonomy_id = loxah_term_relationships.term_taxonomy_id
  where loxah_term_taxonomy.taxonomy like 'product_cat'
  and loxah_posts.ID = '$ID'  
  order by loxah_terms.name ASC LIMIT 1 ";
  $category_container1 = mysqli_query($link, $querycategory1);
  $category_asc = mysqli_fetch_assoc($category_container1);



  $querycategory2 = "select loxah_terms.name, loxah_terms.term_id, loxah_terms.term_group from loxah_terms 
  left join loxah_term_relationships on loxah_term_relationships.term_taxonomy_id = loxah_terms.term_id  
  left join loxah_posts on loxah_posts.ID = loxah_term_relationships.object_id 
  left join loxah_term_taxonomy on loxah_term_taxonomy.term_taxonomy_id = loxah_term_relationships.term_taxonomy_id
  where loxah_term_taxonomy.taxonomy like 'product_cat'
  and loxah_posts.ID = '$ID'  
  order by loxah_terms.name DESC LIMIT 1 ";
  $category_container2 = mysqli_query($link, $querycategory2);
  $category_desc = mysqli_fetch_assoc($category_container2);


  $querycategory3 = "select loxah_terms.name, loxah_terms.term_id, loxah_terms.term_group from loxah_terms 
  left join loxah_term_relationships on loxah_term_relationships.term_taxonomy_id = loxah_terms.term_id  
  left join loxah_posts on loxah_posts.ID = loxah_term_relationships.object_id 
  left join loxah_term_taxonomy on loxah_term_taxonomy.term_taxonomy_id = loxah_term_relationships.term_taxonomy_id
  where loxah_term_taxonomy.taxonomy like 'product_cat'
  and loxah_posts.ID = '$ID'  
  and loxah_terms.name like '%Tenisice%' ";
  $category_container3 = mysqli_query($link, $querycategory3);
  $category_asc_Tenis = mysqli_fetch_assoc($category_container3);



  $querycategory4 = "select loxah_terms.name, loxah_terms.term_id, loxah_terms.term_group from loxah_terms 
  left join loxah_term_relationships on loxah_term_relationships.term_taxonomy_id = loxah_terms.term_id  
  left join loxah_posts on loxah_posts.ID = loxah_term_relationships.object_id 
  left join loxah_term_taxonomy on loxah_term_taxonomy.term_taxonomy_id = loxah_term_relationships.term_taxonomy_id
  where loxah_term_taxonomy.taxonomy like 'product_cat'
  and loxah_posts.ID = '$ID'  
  and loxah_terms.name like '%Cipele%' ";
  $category_container4 = mysqli_query($link, $querycategory4);
  $category_asc_Cipe = mysqli_fetch_assoc($category_container4);


 


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


  $xmlString .= '<row>';
          //naslov
          $xmlString .= '<title>'.$row['post_title'].'</title>';
          //$xmlString .= '<description>'.$opis_content.'</description>', "\n";
          $xmlString .= '<description><![CDATA['.$opis_content.']]></description>'; 

            while($row_sku = mysqli_fetch_assoc($sku_container))
            {
              $xmlString .= '<id>'.$row_sku['meta_value'].'</id>';

                       //image
                       $kk = $row_sku['meta_value'];
                       $imageQuery = "SELECT * FROM loxah_posts where post_name like '$kk' and post_type like 'attachment'";
                       $image_container = mysqli_query($link, $imageQuery);
                       $image = mysqli_fetch_assoc($image_container);
                       if($image != null){
                        $xmlString .= '<image>'.$image['guid'].'</image>';
                       }
                       else{
                        while($row_sku2 = mysqli_fetch_assoc($imageFixquery)){
                          $kk2 = $row_sku2['meta_value'];
                          $imageQuery2 = "SELECT * FROM loxah_posts where id = '$kk2' and post_type like 'attachment'";
                          $image_container2 = mysqli_query($link, $imageQuery2);
                          $image2 = mysqli_fetch_assoc($image_container2);
                          $xmlString .= '<image>'.$image2['guid'].'</image>';
                        }
                      
                       }
                   
            }

                

          //$xmlString .= '<stock>'.$row["meta_value"].'</stock>'; nema ukupno samo pojedinčano po brojevima
          $xmlString .= '<id_control>'.$row["ID"].'</id_control>';
         
                $xmlString .='<variants>';
             
                if(strcmp($category_asc['name'], "Akcija i popusti") !== 0 && strcmp($category_asc['name'], "Outlet") !== 0 && strcmp($category_asc['name'], "Nova kolekcija") !== 0 && strcmp($category_asc['name'], "Veliki brojevi") !== 0){
                  $xmlString .='<kategorija>'.$category_asc['name'].'</kategorija>';
                }
                elseif(strcmp($category_desc['name'], "Akcija i popusti") !== 0 && strcmp($category_desc['name'], "Outlet") !== 0 && strcmp($category_desc['name'], "Nova kolekcija") !== 0 && strcmp($category_desc['name'], "Veliki brojevi") !== 0){
                  $xmlString .='<kategorija>'.$category_desc['name'].'</kategorija>';
                }
                else{
                   if(strcmp($category_asc_Tenis['name'], "Tenisice")){
                    $xmlString .='<kategorija>'.$category_asc_Tenis['name'].'</kategorija>';
                  }
                  else{
                    $xmlString .='<kategorija>'.$category_asc_Cipe['name'].'</kategorija>';
                  }
                
                  
                }

              

                    while($row_variables = mysqli_fetch_assoc($variables_container))
                    {
                      $xmlString .= '<variant>';
                        $filterBroj = preg_replace('/[^0-9]/', '', $row_variables['post_title']);
                        $xmlString .= '<variant_title>'.$filterBroj.'</variant_title>'; //broj cipele
                        $xmlString .= '<variant_title_id>'.$row_variables['ID'].'</variant_title_id>'; //id broja cipele

                                //stock broja cipele
                                $stockByNumQuery= "SELECT * FROM loxah_postmeta where meta_key like '_stock' and post_id = ".$row_variables['ID'];
                                $stock_variabales = mysqli_query($link, $stockByNumQuery);
                                while($row_stockVariables = mysqli_fetch_assoc($stock_variabales)){
                                  $xmlString .= '<variant_stock>'.$row_stockVariables['meta_value'].'</variant_stock>';
                                }
                    


                      $saleActionPriceQuery = "SELECT * FROM loxah_postmeta where meta_key LIKE '_sale_price' and post_id = " .$row_variables['ID'];
                      $sale_price_action = mysqli_query($link, $saleActionPriceQuery);
                      $dataPrice_action = mysqli_fetch_assoc($sale_price_action);
                      $xmlString .= '<discounted_price>'.$dataPrice_action['meta_value'].'</discounted_price>';
      
      
                      $salePriceQuery = "SELECT * FROM loxah_postmeta where meta_key LIKE '_regular_price' and post_id = " .$row_variables['ID'];
                      $sale_price = mysqli_query($link, $salePriceQuery);
                      $dataPrice = mysqli_fetch_assoc($sale_price);
                      $xmlString .= '<base_price>'.$dataPrice['meta_value'].'</base_price>';
         
                      $xmlString .= '</variant>';            
                     }
          $xmlString .='</variants>';
$xmlString .= '</row>'; //end proizvod
}// KRAJ LOOPa stanova prodaja
$xmlString .= '</root>';


$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
$dom->loadXML($xmlString);

$dom->formatOutput = TRUE;
//Save XML as a file
$dom->save('xmlData/kupiMe.xml');



echo '<!DOCTYPE html>
<html>
<head>
<title>Kupi me</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>
 $(document).ready(function(){
 
 //$("#alert").show();
 setTimeout(function() { $("#alert").hide(); }, 5000);
 
 
    setInterval(function(){ reload_page(); },600000);
 });

 function reload_page()
 {
    window.location.reload(true);
    // $("#alert").hide();
 }
 
 
</script>

</head>
<body>


<div class="container" style="margin-top:100px">


<div class="jumbotron">
  <h1 class="display-4">Kupi me hr</h1>
  <hr class="my-4">
  <p>Imaj tvoren URL da bi se skripta mogla sama ažurirati ili ručno klikni na osviježi!!, prevremeno ;)</p>
  <a class="btn btn-primary btn-lg" href="javascript:void(0);" role="button" onclick="reload_page();">Osviježi</a>
  <br/>
  <div class="alert alert-primary" role="alert" id="alert">
 XML je kreiran!!
</div>
</div>


</div>

</body>
</html>';

?>