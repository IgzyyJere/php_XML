<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';

include 'defini_fields.php';
$Contextz_Q = new QueryMain_Context();
$link = new mysqli("localhost", $Contextz_Q->user, $Contextz_Q->passW, $Contextz_Q->db);
mysqli_set_charset($link,"utf8");
echo '<root>';



$container = mysqli_query($link, $Contextz_Q->queryProduct);
//$container2 = mysqli_query($link, $Contextz_Q->pp);


while($row = mysqli_fetch_assoc($container))
{
  $tekst = $row["post_content"];
  //$html = preg_replace('&lt;li&gt;', '', $tekst);
  $tt = htmlentities($tekst, ENT_XML1);

///parent varable
$pp = "SELECT * from wpdg_posts
where post_type like 'product_variation' and post_status like 'publish' and  post_parent = ".$row['ID'];
$cont = mysqli_query($link, $pp);

///id
$pp2= "SELECT * from wpdg_posts
where post_type like 'attachment' 
and post_mime_type like 'image/jpeg' 
and post_status like 'inherit' 
and post_parent = ".$row['ID'];
$cont2 = mysqli_query($link, $pp2);


echo '<row>';
    //naslov
    echo '<title>'.$row['post_title'].'</title>', "\n";
    echo '<description>'.$tt.'</description>', "\n";
    echo '<id>'.$row["ID"].'</id>', "\n";
    echo '<komada>'.$row["meta_value"].'</komada>';

    while($row2 = mysqli_fetch_assoc($cont))
    {
      echo '<pp>'.$row2['post_title'].'</pp>';
      
    }

    while($row3 = mysqli_fetch_assoc($cont2))
    {
    
      echo '<sku>'.$row2['post_name'].'</sku>';
    }




  //link na stranicu
    // echo '<external_url>'.$row["guid"].'</external_url>', "\n";
echo '</row>'; //end proizvod



}// KRAJ LOOPa stanova prodaja

echo '</root>';


?>