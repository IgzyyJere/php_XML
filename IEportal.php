<?php
 
$mysqli = new mysqli("localhost", "root", "", "svijet");
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
$postId = $_GET["id"];
if($_GET["id"]){
            $stringQ = "SELECT 
            kgrdr_posts.post_title, 
            kgrdr_posts.post_status,
            kgrdr_posts.guid,
            kgrdr_posts.post_type, 
            kgrdr_posts.post_date,
            kgrdr_term_taxonomy.term_id, 
            kgrdr_term_taxonomy.taxonomy, 
            kgrdr_term_taxonomy.description, 
            kgrdr_terms.name,
            kgrdr_postmeta.meta_value
            FROM kgrdr_posts
               JOIN kgrdr_term_relationships ON kgrdr_posts.ID = kgrdr_term_relationships.object_id
               JOIN kgrdr_term_taxonomy ON kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id
               JOIN kgrdr_terms ON kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id
               LEFT JOIN kgrdr_postmeta on kgrdr_postmeta.post_id = kgrdr_posts.ID
            WHERE kgrdr_posts.post_type = 'post'
            AND kgrdr_term_taxonomy.taxonomy = 'category'
            AND kgrdr_term_taxonomy.term_id = ".$_GET["id"]."
            AND kgrdr_posts.post_status = 'publish'
            AND kgrdr_postmeta.meta_key  = 'post_views_count'
            ORDER BY post_date DESC";
            $postId = $_GET["id"];
          
}

else{
die();
}


$path = "report/portal.txt"; //ubaciti da se vidi na webu
$file = fopen($path,"w");

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viekgrdrort" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Svijet Sigurnosti app</title>
  </head>
  <body>


<div class="container">

<div class="jumbotron">
  <h1 class="display-4">Portal</h1>

  <hr class="my-4">
  
  <p class="lead">
      <?php
                                if (!$mysqli) {
                                die("Connection failed: " . mysqli_connect_error());
                                            echo'  <p><a class="btn btn-lg btn-danger" href="#" role="button">Nema konekcije</a></p>';
                                }

                                else {

                                        echo'  <p><a class="btn btn-lg btn-success" href="#" role="button">konekcija s serverom uspostavljena</a></p>';
                                        mysqli_set_charset($mysqli, 'utf8');
                                }
       ?>

    
<?php
 echo'<p><a class="btn btn-lg btn-success" href="./IEPortalDate.php?id='.$postId.'"' .'role="button">Idi na petraživanje po datumu!</a></p>';
 echo '<p>ID kategorije je : '.$postId."</p>";
?>

  </p>
</div>


<div class="container-fluid">

<h3>Postovi</h3>

<div class="row">
  <div class="col-12">
<?php
try {


  //naslov
if($rezContainer = mysqli_query($mysqli, $stringQ)){
  $zapis = mysqli_fetch_assoc($rezContainer);
  $naslov = $zapis["name"];
  //echo $naslov;
  fwrite($file,"Naslov kategorije : ".$naslov."\r\n\r");
}


$count = 0;



echo '<table class="table">
<thead">
<tr>
<th>Naslov</th>
<th>Status</th>
<th>link</th>
<th>tip</th>
<th>datum objave</th>
<th>id kategorije</th>
<th>ime kategorije</th>
<th>broj pregleda</th>

</tr></thead><tbody>';
$resulTitle = $mysqli ->query($stringQ);
if($resulTitle ->num_rows > 0){
  while($row = $resulTitle -> fetch_assoc()){
    $count++;

//pregled:
$view_org = $row["meta_value"];
if($view_org < 100){
  $view_org = $view_org * 2;
}
if($view_org > 100 && $view_org < 400){
   $view_org = $view_org + 25;
}

if($view_org > 400 && $view_org < 1000){
   $view_org = $view_org + 300;
}

if($view_org > 1000 ){
   $view_org = $view_org + 21;
}




echo'
<tr>
<td scope="row">'.$row["post_title"].'</td>
<td> '.$row["post_status"].'</td>
<td scope="row"><a href="'.$row["guid"].'" target="_blank">'.$row["guid"].'</a></td>
<td> '.$row["post_type"].'</td>
<td> '.$row["post_date"].'</td>
<td> '.$row["term_id"].'</td>
<td> '.$row["name"].'</td>
<td> '.$view_org.'</td>
</tr>';
$empty = "\n   ";
$titl = $row["post_title"];
$linkU = $row["guid"];
$date = $row["post_date"];

fwrite($file,"\r\n\r"."\r\n\r".$titl.$empty."link : ".$linkU.$empty."Datum objave :".$date);

//fwrite($file,"\r\n\r".$row["name"]);

  }
  fwrite($file,"\r\n\r"."\r\n\r"."broj postova u kategroji : ".$count);
}


echo'
</tbody>
</table>';

  } catch (Exception $e) {
  echo 'Poruka '. $e -> getMessage();
  }
    mysqli_free_result($resulTitle);
    


 

//zatvori me ako sma gotov
fclose($file);

?>
</div>
</div>
</div>






 
   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFkgrdri1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>