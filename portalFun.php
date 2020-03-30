<?php
$mysqli = new mysqli("localhost", "root", "", "portal");

mysqli_set_charset($mysqli,'utf-8');
/* check connection */
if ($mysqli->connect_errno) {
   echo "Connect failed ".$mysqli->connect_error;
   exit();
}

function encode_to_utf8_if_needed($string)
{
    $encoding = mb_detect_encoding($string, 'UTF-8, ISO-8859-9, ISO-8859-1');
    if ($encoding != 'UTF-8') {
        $string = mb_convert_encoding($string, 'UTF-8', $encoding);
    }
    return $string;
}

 function PrintToDocument($nameDoc, $post_id){
                  $link = mysqli_connect("localhost", "root", "", "portal");
                  mysqli_set_charset( $link ,'utf-8');
                  $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status ,kgrdr_posts.guid ,kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
                  kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
                  from kgrdr_posts
                  LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
                  LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
                  LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
                  WHERE kgrdr_posts.post_type = 'post'
                  AND kgrdr_term_taxonomy.taxonomy = 'category'
                  AND kgrdr_term_taxonomy.term_id = ".$post_id."
                  AND kgrdr_posts.post_status = 'publish'
                  ORDER BY post_date DESC";

                  $path = "report/portal_teyt.txt";
                  //  $path = "report/".$nameDoc."txt";
                  $file = fopen($path,"w");
                  $empty = "\n   ";

               if($rezContainer = mysqli_query($link, $stringQ)){
                    $zapis = mysqli_fetch_assoc($rezContainer);
                    $naslov = $zapis["name"];
               }

                $resulTitle = $link ->query($stringQ);
                if($resulTitle ->num_rows > 0){
                  while($row = $resulTitle -> fetch_assoc()){
                    $titl = $row["post_title"];
                    $linkU = $row["guid"];
                    $date = $row["post_date"];
                    //echo $naslov;
                    fwrite($file,"Naslov kategorije : ".$naslov."\r\n\r");
                    //ipis u dokument
                    fwrite($file,"\r\n\r"."\r\n\r".$titl.$empty."link : ".$linkU.$empty."Datum objave :".$date);
                  }
                }
                fwrite($file,"\r\n\r"."\r\n\r"."broj postova u kategroji : ".postNumber($post_id));
                //zatvori me 
                fclose($file);
            }


            //Glavni query
$operacijaReport = $_GET["report"];
// $postId = $_GET["id"];
// $postName = $_GET["name"];


if($_GET["report"]){
    if($_GET["report"] == "1"){
         PrintToDocument("Test", 6);
    }
}


else{
  die();
}

// $path = "report/portal.txt";
// $file = fopen($path,"w");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title> <?=$postName?> </title>
  </head>





 
</html>