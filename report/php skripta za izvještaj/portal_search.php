<?php
$mysqli = new mysqli("localhost", "webzyco1_userSvijet", "OdKUDUtp~8]Y", "webzyco1_svijetS");
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

 $stringQ = "SELECT post_title, post_content, post_date, guid , date_format(post_date, '%d-%m-%Y') as datum,  kgrdr_terms.name as kategorija_name
  FROM kgrdr_posts 
  LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
  LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
  LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id) 
  WHERE post_type like 'post'
  AND post_status like 'publish' 
  AND post_date BETWEEN '2020-01-01' and '2020-12-31' 
  AND kgrdr_term_taxonomy.taxonomy = 'category'
  AND post_title like '%Zagre%'
  AND kgrdr_term_taxonomy.term_id = 1893"; ////ovdje je kategorija id
  //and post_content like '%Zagre%'  ///ako tražiš što post sadržava
 
 $path = "report/ZG_korona_byTitle.txt";
 $file = fopen($path,"w");


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>IZVJEŠTAJ!</title>







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
  </p>
</div>




<?php
try {


//naslov
 if($rezContainer = mysqli_query($mysqli, $stringQ)){
  $zapis = mysqli_fetch_assoc($rezContainer);
  $naslov = $zapis["kategorija_name"];
  echo $naslov;
  fwrite($file,"Naslov kategorije : ".$naslov."\r\n\r");
 }


$count = 0;
echo '<table class="table">
<thead">
<tr>
<th>Ime posta</th>
<th>Sadr탑aj</th>
<th>link</th>
<th>datum objave</th>
<th>Kategorija</th>
</tr></thead><tbody>';
$resulTitle = $mysqli ->query($stringQ);
if($resulTitle ->num_rows > 0){
  while($row = $resulTitle -> fetch_assoc()){
    $count++;
echo'
<tr>
<td scope="row">'.$row["post_title"].'</td>
<td> '.strip_tags($row["post_content"]).'</td>
<td scope="row"><a href="'.$row["guid"].'" target="_blank">'.$row["guid"].'</a></td>
<td> '.$row["datum"].'</td>
<td> '.$row["kategorija_name"].'</td>
</tr>';
$empty = "\n   ";
$titl = $row["post_title"];
$linkU = $row["guid"];
$date = $row["datum"];
$kategory = $row["kategorija_name"];

fwrite($file,"\r\n\r"."\r\n\r".$titl.$empty."link : ".$linkU.$empty.$empty."  Datum objave :".$date);

//fwrite($file,"\r\n\r".$row["name"]);

  }
  fwrite($file,"\r\n\r"."\r\n\r"."broj postova u razdoblju od 01.1.2020 do 1.01.2020 : ".$count);
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




<?php   

$resulTitle = $mysqli ->query($stringQ);
if($resulTitle ->num_rows > 0){
  while($row = $resulTitle -> fetch_assoc()){
  }
}
?>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>