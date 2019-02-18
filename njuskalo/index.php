<?php
 
$mysqli = new mysqli("localhost", "root", "", "nekreninetestwp");
mysqli_set_charset($mysqli,"utf8");

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
  <h1 class="display-4">Nekretnine n</h1>

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



<div class="row justify-content-start">
  <div class="col-10">
<?php
try {
echo '<table class="table">
<thead">
<tr>
<th>ID</th>
<th>title</th>
<th>status</th>
<th>link</th>
<th>slika</th>
<th>tip</th>
<th>datum objave</th>


</tr></thead><tbody>';
$count = 0;
$query ="
select wp_posts.ID, wp_posts.post_title, wp_posts.post_status ,wp_posts.guid ,wp_posts.post_type, wp_posts.post_date, wp_term_taxonomy.term_id, 
            wp_term_taxonomy.taxonomy, wp_term_taxonomy.description, wp_terms.name
            from wp_posts
            LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
            LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
            LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id)
            AND wp_term_taxonomy.term_id = 2
            WHERE wp_posts.post_type = 'property'
            AND wp_posts.post_status = 'publish'
            AND wp_terms.name IS NOT NULL
            ORDER BY post_date DESC";



   $query1 ="
	 select DISTINCT wp_posts.ID, wp_posts.guid, wp_posts.post_parent   
          from wp_posts
          LEFT JOIN wp_postmeta ON (wp_postmeta.post_id = wp_posts.post_parent)
          WHERE wp_posts.post_type = 'attachment'
          AND wp_postmeta.meta_key = '_thumbnail_id'
          ORDER BY wp_posts.post_date DESC"; 
  if($slika = mysqli_query($mysqli, $query1)){
    while($rowPic = mysqli_fetch_assoc($slika)){
        $ID = $rowPic["post_parent"];
        $PIC = $rowPic["guid"];
    }
  }

    
    
$resulTitle = $mysqli ->query($query);
if($resulTitle ->num_rows){
                          while($row = $resulTitle -> fetch_assoc()){
                  echo'
                  <tr>
                  <td scope="row">'.$row["ID"].'</td>
                  <td scope="row">'.$row["post_title"].'</td>
                  <td> '.$row["post_status"].'</td>
                  <td scope="row"><a href="'.$row["guid"].'" target="_blank">'.$row["guid"].'</a></td>';
                  if($row["ID"] == $ID){  
                    echo'<td><img src="'.$PIC.'"></td>';
                  }else{  
                    //echo '<td>N</td>';
                    echo '<td>'.$ID.'</td>';
                  };
                  echo'
                  <td> '.$row["post_type"].'</td>
                  <td> '.$row["post_date"].'</td>
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