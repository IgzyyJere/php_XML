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

//Glavni query
$postId = $_GET["id"];
$postName = $_GET["name"];
$count = 0;
if($_GET["id"]){
        $stringQ = "select kgrdr_posts.post_title, kgrdr_posts.post_status ,kgrdr_posts.guid ,kgrdr_posts.post_type, kgrdr_posts.post_date, kgrdr_term_taxonomy.term_id, 
        kgrdr_term_taxonomy.taxonomy, kgrdr_term_taxonomy.description, kgrdr_terms.name
        from kgrdr_posts
        LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
        LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
        LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
        WHERE kgrdr_posts.post_type = 'post'
        AND kgrdr_term_taxonomy.taxonomy = 'category'
        AND kgrdr_term_taxonomy.term_id = ".$_GET["id"]."
        AND kgrdr_posts.post_status = 'publish'
        ORDER BY post_date DESC";
        $postId = $_GET["id"];


            function postNumber($post_id){
              $link = mysqli_connect("localhost", "root", "", "portal");
              // $specQuery = "SELECT kgrdr_terms.name,
              //               COUNT(kgrdr_term_relationships.object_id) AS num_posts,
              //             FROM kgrdr_term_taxonomy
              //             JOIN kgrdr_terms ON kgrdr_term_taxonomy.term_id = kgrdr_terms.term_id
              //             JOIN kgrdr_term_relationships ON kgrdr_term_taxonomy.term_taxonomy_id = kgrdr_term_relationships.term_taxonomy_id
              //             JOIN kgrdr_posts ON (kgrdr_term_relationships.object_id = kgrdr_posts.id AND kgrdr_term_taxonomy.taxonomy='category' AND post_type='post' AND post_status='publish')
              //             WHERE kgrdr_term_taxonomy.term_id = ".$post_id.
              //             "GROUP BY kgrdr_terms.term_id
              //             ORDER BY name ASC";
              $countPost_num = "SELECT
              COUNT(kgrdr_term_relationships.object_id) AS num_posts
              FROM kgrdr_term_taxonomy
              JOIN kgrdr_terms ON kgrdr_term_taxonomy.term_id = kgrdr_terms.term_id
              JOIN kgrdr_term_relationships ON kgrdr_term_taxonomy.term_taxonomy_id = kgrdr_term_relationships.term_taxonomy_id
              JOIN kgrdr_posts ON (kgrdr_term_relationships.object_id = kgrdr_posts.id AND kgrdr_term_taxonomy.taxonomy='category' AND post_type='post' AND post_status='publish')
 			      	where  kgrdr_term_taxonomy.term_id = ".$post_id."
              GROUP BY kgrdr_terms.term_id";
                  if($resultNumRow = mysqli_query($link, $countPost_num)){
                      $row = mysqli_fetch_assoc($resultNumRow);
                      $c = $row["num_posts"];
                  }
                  return $c; 
            }



            function PrintToDocument($nameDoc, $post_id){
                  $link = mysqli_connect("localhost", "root", "", "portal");
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

                  $nameDoc = $nameDoc."-".date("d-m-yy");
                  $path = "report/".$nameDoc.".txt";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title> <?=$postName?> </title>
  </head>


  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Početna stranica</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="portal.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>


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
          echo'<p><a class="btn btn-info" href="./IEPortalDate.php?id='.$postId.'&name='.$postName.'"' .'role="button">Pretraži pod datumu istu kategoriju!</a></p>';
          echo '<p>ID kategorije je : '.$postId."</p>";
          echo '<p>Ime kategorije je : '.$postName."</p>";
          echo '<p>Broj postova u kategoriji : '.postNumber($postId)."</p>";
          ?>
</p>
<div class="form-group">
<div class="checkbox">
  <label><input type="checkbox" value="true" onclick="GetReport();">Želim ispis (ne koristi)</label>
</div>
</div>

</div>


<div class="container-fluid">
<h3>Postovi</h3>

<div class="row">
<div class="col-12">
<?php
PrintToDocument("Test", $postId);
try {
echo '<table class="table">
<thead class="thead-dark">
<tr>
<th>Ime posta (Title)</th>
<th>Status</th>
<th>Link</th>
<th>Tip</th>
<th>Datum objave</th>
<th>Id kategorije</th>
<th>Ime kategorije</th>
</tr></thead><tbody>';

$resulTitle = $mysqli ->query($stringQ);
if($resulTitle ->num_rows > 0){
  while($row = $resulTitle -> fetch_assoc()){
echo'
<tr>
    <td scope="row">'.$row["post_title"].'</td>
    <td> '.$row["post_status"].'</td>
    <td scope="row"><a href="'.$row["guid"].'" target="_blank">Link</a></td>
    <td> '.$row["post_type"].'</td>
    <td> '.$row["post_date"].'</td>
    <td> '.$row["term_id"].'</td>
    <td> '.$row["name"].'</td>
</tr>';
//fwrite($file,"\r\n\r".$row["name"]);

  }
    //fwrite($file,"\r\n\r"."\r\n\r"."broj postova u kategroji : ".postNumber($postId));
}
echo'
</tbody>
</table>';

} 
    
    catch (Exception $e) {
    echo 'Poruka '. $e -> getMessage();
    }
    mysqli_free_result($resulTitle);
  
?>
</div>
</div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
  </body>

    <script>
  function GetReport(){
  window.location = "portalFun.php?report=1";
  }

  </script>
</html>

