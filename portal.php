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
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Svijet sigurnosti portal report</title>
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
    <h1 class="display-4">Portal</h1>
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
    </p>
  </div>

<div class="row justify-content-start">
    <div class="col-10">
<?php
              try {
              echo '<table class="table">
              <thead class="thead-dark">
              <tr>
              <th>ID - kategorije</th>
              <th>Ime kategorije</th>
              <th>Link kategorije</th>
              </tr></thead><tbody>';

              $count = 0;
              $query ="
              SELECT kgrdr_terms.term_id, kgrdr_terms.name 
              FROM kgrdr_terms
              INNER JOIN kgrdr_term_taxonomy ON (kgrdr_terms.term_id = kgrdr_term_taxonomy.term_id) 
              WHERE kgrdr_term_taxonomy.taxonomy IN ('category') 
              ORDER BY kgrdr_terms.name ASC";

              $resulTitle = $mysqli ->query($query);
              if($resulTitle ->num_rows){
                      while($row = $resulTitle -> fetch_assoc()){
              echo'
              <tr>
              <td>'.$row["term_id"].'</td>
              <td> '.$row["name"].'</td>
              <td scope="row"><a href="./IEportal.php?id='.$row["term_id"].'&date=0&name='.$row["name"].'" target="_blank">'.$row["term_id"].'</a></td>
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