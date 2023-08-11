<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GrabbXml</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>




    </head>
    <body>



  <div class="container">

    <!-- Jumbotron -->
        <div class="jumbotron">
          <h1>Pregled sadržaja koji ide u novu bazu</h1>
          <br/>
          <a href="index.php?runScript=1"><button type="button" class="btn btn-primary">Run</button></a>

          <?php
          if(isset($_GET['runScript'])){
            $xml = file_get_contents("https://xml.andapresent.com/export/prices/71BVV1GVH11HKMLM979UZDYHN6IGBUF82KDIWJWSTPFPD2815MPD5RH7V1YBISVR"); // your file is in the string "$xml" now.
            file_put_contents("download/cjene.xml", $xml); // now your xml file is saved.
            echo '
            <div class="alert alert-primary" role="alert">
              skinuta!
            </div>';
          }

          ?>



<!--
ALTER TABLE
   table_name
   CONVERT TO CHARACTER SET utf8mb4
   COLLATE utf8mb4_unicode_ci; -->


        </div>






      </div>
    </body>
</html>
