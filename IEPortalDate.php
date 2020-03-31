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
 $postName = $_POST["postname"];
 $datumOd = "yyyy-mm-dd";
 $datumDo = "yyyy-mm-dd";
 $nameDoc = "Izvještaj ".$postName; 
 $nameDoc = $nameDoc." -".date("d-m-yy");
 $path = "report/".$nameDoc.".txt";
 //$path = "report/portal_byDate_test.txt";
 $file = fopen($path,"w");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["d1"] !='') {
    $datumOd = $_POST["d1"];
    $datumDo = $_POST["d2"];
    $categoryId = $_POST["id"];
    $postName = $_POST["postname"];
    $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status ,kgrdr_posts.guid ,kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
    kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name, kgrdr_posts.ID
    from kgrdr_posts
    LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
    LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
    LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
    WHERE kgrdr_posts.post_type = 'post'
    AND kgrdr_term_taxonomy.taxonomy = 'category'
    AND kgrdr_term_taxonomy.term_id = ".$categoryId."
    AND kgrdr_posts.post_date >  '".$datumOd."' 
    AND kgrdr_posts.post_date < '".$datumDo."'
    AND kgrdr_posts.post_status = 'publish'
    ORDER BY post_date DESC";
   // PrintToDocument("PrintByDate_".$postName, $postId, $datumOd, $datumDo,1, $mysqli);
      
}
 
//get from
else{
$categoryId = $_GET["id"];
$postName = $_GET["name"];
$stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status, kgrdr_posts.guid, kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
    kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name, kgrdr_posts.ID
    from kgrdr_posts
    LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
    LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
    LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
    WHERE kgrdr_posts.post_type = 'post'
    AND kgrdr_term_taxonomy.taxonomy = 'category'
    AND kgrdr_term_taxonomy.term_id = ".$categoryId."
    AND kgrdr_posts.post_date >  '2016-1-1' 
    AND kgrdr_posts.post_date < '2020-1-1'
    AND kgrdr_posts.post_status = 'publish'
    ORDER BY post_date DESC";
      // PrintToDocument("PrintByDate_".$postName, $postId, $datumOd, $datumDo,0);
}



    function postNumber($categoryId, $mysqli, $d1, $d2){
               $link = mysqli_connect("localhost", "root", "", "portal");
              $countPost_num = "SELECT
              COUNT(kgrdr_term_relationships.object_id) AS num_posts
              FROM kgrdr_term_taxonomy
              JOIN kgrdr_terms ON kgrdr_term_taxonomy.term_id = kgrdr_terms.term_id
              JOIN kgrdr_term_relationships ON kgrdr_term_taxonomy.term_taxonomy_id = kgrdr_term_relationships.term_taxonomy_id
              JOIN kgrdr_posts ON (kgrdr_term_relationships.object_id = kgrdr_posts.id AND kgrdr_term_taxonomy.taxonomy='category' AND post_type='post' AND post_status='publish')
               where  kgrdr_term_taxonomy.term_id = ".$categoryId."
               AND kgrdr_posts.post_date >  '".$d1."' 
               AND kgrdr_posts.post_date < '".$d2."'
              GROUP BY kgrdr_terms.term_id";
                  if($resultNumRow = mysqli_query($link, $countPost_num)){
                      $row = mysqli_fetch_assoc($resultNumRow);
                      $c = $row["num_posts"];
                  }
                  return $c; 
            }


    function PrintToDocument($nameDoc, $categoryId, $datumOd, $datumDo, $optionDate, $mysqli){
      $link = $mysqli;
      if($optionDate == 1){
                    $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status ,kgrdr_posts.guid ,kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
                    kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
                    from kgrdr_posts
                    LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
                    LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
                    LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
                    WHERE kgrdr_posts.post_type = 'post'
                    AND kgrdr_term_taxonomy.taxonomy = 'category'
                    AND kgrdr_term_taxonomy.term_id = ".$categoryId."
                    AND kgrdr_posts.post_date >  '".$datumOd."' 
                    AND kgrdr_posts.post_date < '".$datumDo."'
                    AND kgrdr_posts.post_status = 'publish'
                    ORDER BY post_date DESC";
      }
                  //ako nema datuma, from beginnig of the timestamp
                  else{
                    $datumOd = "";
                    $datumDo = "";
                      $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status, kgrdr_posts.guid, kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
                      kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
                      from kgrdr_posts
                      LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
                      LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
                      LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
                      WHERE kgrdr_posts.post_type = 'post'
                      AND kgrdr_term_taxonomy.taxonomy = 'category'
                      AND kgrdr_term_taxonomy.term_id = ".$categoryId."
                      AND kgrdr_posts.post_date >  '2016-1-1' 
                      AND kgrdr_posts.post_date < '2020-1-1'
                      AND kgrdr_posts.post_status = 'publish'
                      ORDER BY post_date DESC";
                    }
               

                  $nameDoc = $nameDoc."-".date("d-m-yy");
                  $path = "report/".$nameDoc.".txt";
                  $file = fopen($path,"w");
                  $empty = "\n   ";

               if($rezContainer = mysqli_query($link, $stringQ)){
                    $zapis = mysqli_fetch_assoc($rezContainer);
                    $naslov = $zapis["name"];
                     //echo $naslov;
                    fwrite($file,"Naslov kategorije : ".$naslov."\r\n\r");
               }
               

                $resulTitle = $link ->query($stringQ);
                if($resulTitle ->num_rows > 0){
                  while($row = $resulTitle -> fetch_assoc()){
                    $titl = $row["post_title"];
                    $linkU = $row["guid"];
                    $date = $row["post_date"];
                   
                    //ipis u dokument
                    fwrite($file,"\r\n\r"."\r\n\r".$titl.$empty."link : ".$linkU.$empty."Datum objave :".$date);
                    fwrite($file,"\r\n\r".$row["name"]);
                  }
                }
                fwrite($file,"\r\n\r"."\r\n\r"."broj postova u kategoriji : ");
                //zatvori me 
                fclose($file);
             
            }


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title> <?=$postName?> </title>
  </head>



<body>
<div class="container">
<div class="jumbotron">
<h1 class="display-4">Portal i ispis postova kategorije <?=$postName?></h1>
  <hr class="my-4">
  <p class="lead">
      <?php
              if (!$mysqli) {
                  die("Connection failed: " . mysqli_connect_error());
                              echo'<span class="badge badge-danger">Nema konekcije</span>';
                  }

                  else {
                          echo'<span class="badge badge-success">Konekcija s serverom uspostavljena</span>';
                          mysqli_set_charset($mysqli, 'utf8');
                  }
       ?>
         <?php
          echo '<p>ID kategorije je : '.$categoryId."</p>";
          echo '<p>Ime kategorije je : '.$postName."</p>";
          echo '<p>Broj postova u kategoriji : '.postNumber($categoryId, $mysqli, $datumOd, $datumDo)."</p>";
          ?>
        <!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        datum od <input type="text" name="d1"><br>
        datum do <input type="text" name="d2"><br>
        <input type="text" name="id" value="<?php echo $categoryId ?>" />
        <input type="submit" name="submit" value="Submit">  
       </form> -->

  </p>
</div>


<div class="container-fluid">

<div class="row">
<div class="col-md-8" style="background-color:#E9ECEF; padding-top:20px; paddding-bottom:20px; margin-bottom:50px;">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Datum od</label>
    <div class="col-sm-5">
       <input type="text" class="form-control" name="d1" value="<?=$datumOd?>"><br>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Datum do</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="d2" value="<?=$datumDo?>">
    </div>
  </div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Kategroija ID</label>
    <div class="col-sm-5">
       <input type="text" class="form-control" name="id" value="<?php echo $categoryId ?>"><br>
       <input type="text" hidden name="postname" value="<?=$postName?> ">
    </div>
        <div class="col-sm-5">
        <input type="submit" name="submit" class="btn-default" value="Submit">  
    
    </div>
  </div>
</form>
</div>
</div>

<h3>Postovi by date</h3>
<div class="row">
  <div class="col-12">
<?php

   //naslov
 if($rezContainer = mysqli_query($mysqli, $stringQ)){
   $zapis = mysqli_fetch_assoc($rezContainer);
  $naslov = $zapis["name"];
   //echo $naslov;
  fwrite($file,"Naslov kategorije : ".$naslov." Za razdoblje ".$datumOd." - ".$datumDo." \r\n\r");
 }
  echo '<table class="table">
  <thead class="thead-dark">
  <tr>
  <th>Naslov posta (Title)</th>
  <th>Status</th>
  <th>Link</th>
  <th>Tip</th>
  <th>Datum objave</th>
  <th>Id Posta</th>
  <th>Ime Kate</th>
  <th>Broj pregleda</th>
  </tr></thead><tbody>';





$resulTitle = $mysqli ->query($stringQ);
if($resulTitle ->num_rows > 0){
      while($row = $resulTitle -> fetch_assoc()){
      //view query
      $QView = "select meta_value
      from kgrdr_postmeta 
      where post_id = ".$row["ID"]." AND meta_key like 'post_views_count' ";

      $resulView = $mysqli ->query($QView);
          while($row_V = $resulView -> fetch_assoc()){ 
                    echo'
                    <tr>
                    <td scope="row">'.$row["post_title"].'</td>
                    <td> '.$row["post_status"].'</td>
                    <td scope="row"><a href="'.$row["guid"].'" target="_blank">Link</a></td>
                    <td> '.$row["post_type"].'</td>
                    <td> '.$row["post_date"].'</td>
                    <td> '.$row["ID"].'</td>
                    <td> '.$row["name"].'</td>
                    <td>'.$row_V["meta_value"].'</td>';
                   
                    echo'</tr>';
                    $empty = "\n   ";
                    $titl = $row["post_title"];
                    $linkU = $row["guid"];
                    $date = $row["post_date"];
                    fwrite($file,"\r\n\r"."\r\n\r".$titl.$empty."link : ".$linkU.$empty."Datum objave :".$date." Broj pregleda :". $row_V["meta_value"]);
                    //fwrite($file,"\r\n\r".$row["name"]);
                     }
            }
          fwrite($file,"\r\n\r"."\r\n\r"."broj postova u kategroji : ".postNumber($categoryId, $mysqli, $datumOd, $datumDo));
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
  </body>

<script>
portal = new {
  from: 0,
  unitl: 0
}
</script>
</html>