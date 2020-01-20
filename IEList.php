<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pregled unosa u xml </title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>



    </head>
    <body>
                            <?php
                            // spajamo se na net
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                           // $dbname = "ss";
                            $dbname = "nekretnine";
                            $conn = mysqli_connect($servername, $username, $password, $dbname);

                        ?>




  <div class="container">

    <!-- Jumbotron -->
        <div class="jumbotron">
          <h1>Pregled sadržaja koji ide u novu bazu</h1>
                                <?php
                                if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                                            echo'  <p><a class="btn btn-lg btn-danger" href="#" role="button">Nema konekcije</a></p>';
                                }

                                else {

                                        echo'  <p><a class="btn btn-lg btn-success" href="#" role="button">konekcija s serverom uspostavljena</a></p>';
                                        mysqli_set_charset($conn, 'utf8');
                                }?>

<!--
ALTER TABLE
   table_name
   CONVERT TO CHARACTER SET utf8mb4
   COLLATE utf8mb4_unicode_ci; -->
                                <div class="progress">
                                  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                </div>

        </div>



<?php
try {


echo '<table class="table">
<thead class="thead-dark">
<tr>
<th>ID</th>
<th>naziv</th>
<th>sadržaj</th>
<th>kategorija</th>
<th>tekst</th>
</tr></thead><tbody>';
$count = 0;
$query = "
SELECT vivoostalo.id, grupe.naziv AS 'vrsta nekretnine', vivoostalo.regija, regije.naziv, vivoostalo.zupanija, zupanije.nazivZupanije ,vivoostalo.mikrolokacija, vivoostalo.povrsina,
vivoostalo.cijena ,vivoostalo.mjesto, vivoostalo.adresa, vivoostalo.imeIPrezime, vivoostalo.mobitel,
vivoostalo.minCijena, vivoostalo.maxCijena, vivoostalo.email, vivoostalo.napomena,
vivoostalo.vrstaPonude, vivoostalo.lat, vivoostalo.lon, vivoostalo.agent, vivoostalo.mjesto  AS 'naslov' , vivoostalo.njuskalo_id,
vivoostalo.tlocrtPDF, vivoostalo.moreUdaljenost, vivoostalo.morePogled, texttransfer.tekst, sliketransfer.slk1, sliketransfer.slk2,
sliketransfer.slk3, sliketransfer.slk4, sliketransfer.slk5, sliketransfer.slk6, sliketransfer.slk7

FROM vivoostalo LEFT JOIN grupe ON vivoostalo.grupa = grupe.id
LEFT JOIN texttransfer ON vivoostalo.id = texttransfer.spojenoNa
LEFT JOIN regije ON vivoostalo.regija = regije.id
LEFT JOIN zupanije ON vivoostalo.zupanija = zupanije.id
LEFT JOIN sliketransfer ON sliketransfer.ID_nekrenina = vivoostalo.id
where vivoostalo.aktivno = 1;";

$resulTitle = $conn ->query($query);

if($resulTitle ->num_rows > 0){
  while($row = $resulTitle -> fetch_assoc()){
$count+1;
//  echo''.$row["naziv"].' , '.$row["detaljnije"].'';
echo'
<tr>
<td scope="row">'.$row["id"].'</td>
<td> '.$row["mikrolokacija"].' </td>
<td><img src="'.$row["slk1"].'" style="width:50px;"/> </td>
<td><img src="'.$row["slk2"].'" style="width:50px;"/> </td>
<td><img src="'.$row["slk3"].'" style="width:50px;"/> </td>
<td><img src="'.$row["slk4"].'" style="width:50px;"/> </td>
<td><img src="'.$row["slk5"].'" style="width:50px;"/> </td>
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
    </body>
</html>
