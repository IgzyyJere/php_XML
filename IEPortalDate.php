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

$path = "report/portal_byDate.txt";
$file = fopen($path,"w");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["d1"] !='') {
    $datumOd = $_POST["d1"];
    $datumDo = $_POST["d2"];
    $postId = $_POST["id"];
    
    $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status ,kgrdr_posts.guid ,kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
    kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
    from kgrdr_posts
    LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
    LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
    LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
    WHERE kgrdr_posts.post_type = 'post'
    AND kgrdr_term_taxonomy.taxonomy = 'category'
    AND kgrdr_term_taxonomy.term_id = ".$postId."
    AND kgrdr_posts.post_date >  '".$datumOd."' 
    AND kgrdr_posts.post_date < '".$datumDo."'
    AND kgrdr_posts.post_status = 'publish'
    ORDER BY post_date DESC";
}

//get from
else{
$postId = $_GET["id"];
$stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status, kgrdr_posts.guid, kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
    kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
    from kgrdr_posts
    LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
    LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
    LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
    WHERE kgrdr_posts.post_type = 'post'
    AND kgrdr_term_taxonomy.taxonomy = 'category'
    AND kgrdr_term_taxonomy.term_id = ".$postId."
    AND kgrdr_posts.post_date >  '2016-1-1' 
    AND kgrdr_posts.post_date < '2020-1-1'
    AND kgrdr_posts.post_status = 'publish'
    ORDER BY post_date DESC";
}


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
                                } else {

                                        echo'  <p><a class="btn btn-lg btn-success" href="#" role="button">konekcija s serverom uspostavljena</a></p>';
                                        mysqli_set_charset($mysqli, 'utf8');
                                }
       ?>


        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        datum od <input type="text" name="d1"><br>
        datum do <input type="text" name="d2"><br>
        <input type="text" name="id" value="<?php echo $postId ?>" />
        <input type="submit" name="submit" value="Submit">  
       </form>

  </p>
</div>


<div class="container-fluid">

<h3>Postovi by date</h3>


<div class="row">
  <div class="col-12">
<?php
$count = 0;
  //naslov
if($rezContainer = mysqli_query($mysqli, $stringQ)){
  $zapis = mysqli_fetch_assoc($rezContainer);
  $naslov = $zapis["name"];
  //echo $naslov;
  fwrite($file,"Naslov kategorije : ".$naslov."\r\n\r");
}




              echo '<table class="table">
              <thead">
              <tr>
              <th>title</th>
              <th>status</th>
              <th>link</th>
              <th>tip</th>
              <th>datum objave</th>
              <th>id kategorije</th>
              <th>ime kategorije</th>

              </tr></thead><tbody>';

                                                      $resulTitle = $mysqli ->query($stringQ);
                                                      if($resulTitle ->num_rows > 0){
                                                        while($row = $resulTitle -> fetch_assoc()){
                                                            $count++;
                                                      echo'
                                                      <tr>
                                                      <td scope="row">'.$row["post_title"].'</td>
                                                      <td> '.$row["post_status"].'</td>
                                                      <td scope="row"><a href="'.$row["guid"].'" target="_blank">'.$row["guid"].'</a></td>
                                                      <td> '.$row["post_type"].'</td>
                                                      <td> '.$row["post_date"].'</td>
                                                      <td> '.$row["term_id"].'</td>
                                                      <td> '.$row["name"].'</td>
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

                                                          mysqli_free_result($resulTitle);
        echo'
        </tbody>
        </table>';
   


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

<script>
portal = new {
  from: 0,
  unitl: 0
}





</script>



</html>