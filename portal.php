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



// if($_GET["id"]){
   

// $stringQ = "select wp_posts.post_title, wp_posts.post_status ,wp_posts.guid ,wp_posts.post_type, wp_posts.post_date, wp_term_taxonomy.term_id, 
// wp_term_taxonomy.taxonomy, wp_term_taxonomy.description, wp_terms.name
// from wp_posts
// LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
// LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
// LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id)
// WHERE wp_posts.post_type = 'post'
// AND wp_term_taxonomy.taxonomy = 'category'
// AND wp_term_taxonomy.term_id = ".$_GET["id"]."
// AND wp_posts.post_status = 'publish'
// ORDER BY post_date DESC";

// }



$path = "file.txt";
 
$file = fopen($path,"w");
 
echo fwrite($file,"ccccc");
 

//zatvori me ako sma gotov
fclose($file);
 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
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
                                }?>




  </p>
</div>


<div class="container">

<h3>Kategorije</h3>


<div class="row justify-content-start">
  <div class="col-10">
<?php
try {
echo '<table class="table">
<thead">
<tr>
<th>ID</th>
<th>Ime kategorije</th>
</tr></thead><tbody>';
$count = 0;
$query ="
SELECT wp_terms.term_id, wp_terms.name 
FROM wp_terms
INNER JOIN wp_term_taxonomy ON (wp_terms.term_id = wp_term_taxonomy.term_id) 
WHERE wp_term_taxonomy.taxonomy IN ('category') 
ORDER BY wp_terms.name ASC";

$resulTitle = $mysqli ->query($query);
if($resulTitle ->num_rows){
        while($row = $resulTitle -> fetch_assoc()){
echo'
<tr>
<td scope="row"><a href="./IEportal.php?id='.$row["term_id"].'&date=0"> '.$row["term_id"].'</a></td>
<td> '.$row["name"].'</td>
</tr>';

  }
}


echo'
</tbody>
</table>';


  } catch (Exception $e) {
  echo 'Poruka '. $e -> getMessage();
  }
    mysqli_free_result($resulTitle);
?>
</div>
</div>
</div>






 
   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>