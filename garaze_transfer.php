<?php

/** create XML file */
$mysqli = new mysqli("localhost", "root", "", "nekretninedb");
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


function mapa($ulicaNaziva_, $broj_, $grad_)
{
        $mapa = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=";
        $ulica_naziv = $ulicaNaziva_;
        if($broj_ == ""){
          $brojulica='';
        }else{
          $brojulica = $broj_;
        }

        $grad =  $grad_;
        $drzava = "Croatia";
        $part = "()&amp;ie=UTF8&amp;t=&amp;z=12&amp;iwloc=B&amp;output=embed";
        $mapa_emb = $mapa.$ulica_naziv."%20".$brojulica."%20".$grad."%2C%20".$drzava.$part;

        if(isset($ulicaNaziva_) && trim($ulicaNaziva_) != ''){
            return $mapa_emb;
              }elseif(!isset($broj_) || trim($broj_) == '' || is_null($broj_) && is_null($grad_) || trim($grad_) == '' || !isset($grad_)){
                  return '';
                }elseif (!isset($ulicaNaziva_) || trim($ulicaNaziva_) === '') {
                  return '';
                }else{
              return $mapa_emb;
              }
}



function mapaLtd($lat_, $lon_)
{

        $mapa = "https://maps.google.com/maps?q=";
        $lat = $lat_;
        $lon = $lon_;
        $part = "&hl=es;z=1&amp;output=embed";
        $mapa_emb = $mapa.$lat.",".$lon.$part;
        if(!isset($lat) || is_null($lat) || trim($lat) == '' && !isset($lon)  || is_null($lon) || trim($lat) == ''){
          return ''; //ako je prazno
      }
        elseif ($lat < 1 && $lon < 1){
        return ''; //ako je prazno
     }
      else{
        return $mapa_emb; //ako je puno
      }
}


// $query = "SELECT* FROM grupe";

$query = "
SELECT vivoostalo.id, grupe.naziv AS 'vrsta', grupe.vrsta AS 'status', vivoostalo.regija, regije.naziv, vivoostalo.zupanija, zupanije.nazivZupanije ,vivoostalo.mikrolokacija, vivoostalo.povrsina,
vivoostalo.cijena,vivoostalo.mjesto, vivoostalo.adresa, vivoostalo.imeIPrezime, vivoostalo.mobitel,
vivoostalo.minCijena, vivoostalo.maxCijena, vivoostalo.email, vivoostalo.napomena,
vivoostalo.vrstaPonude, vivoostalo.lat, vivoostalo.lon, vivoostalo.agent, vivoostalo.mjesto  AS 'naslov',
vivoostalo.tlocrtPDF, vivoostalo.moreUdaljenost, vivoostalo.morePogled, texttransfer.tekst, sliketransfer.slk1, sliketransfer.slk2,
sliketransfer.slk3, sliketransfer.slk4, sliketransfer.slk5, sliketransfer.slk6, sliketransfer.slk7

FROM vivoostalo LEFT JOIN grupe ON vivoostalo.grupa = grupe.id
LEFT JOIN texttransfer ON vivoostalo.id = texttransfer.spojenoNa
LEFT JOIN regije ON vivoostalo.regija = regije.id
LEFT JOIN zupanije ON vivoostalo.zupanija = zupanije.id
LEFT JOIN sliketransfer ON sliketransfer.ID_nekrenina = vivoostalo.id
where vivoostalo.aktivno = 1;";



$nekrsArray = array();

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {

       array_push($nekrsArray, $row);
    }

    if(count($nekrsArray)){

         createXMLfile($nekrsArray);

     }

    /* free result set */
    $result->free();
}





/*counter*/
$counquery = "SELECT vivoostalo.id from vivoostalo";
$num_rows = $mysqli->query($counquery);
$num_rows = count($nekrsArray);

$str1= $num_rows;
$str2="Broj koji je prebaćen ";
//echo "<h4>".$str1 . " " . $str2."</h4>";

/* close connection */
$mysqli->close();


function createXMLfile($nekrsArray){

   $filePath = 'prerade/garaze.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('nekretnina');

   for($i=0; $i<count($nekrsArray); $i++){

     $nekrID  =  $nekrsArray[$i]['id'];

    // $nekretninaNaslov = $nekrsArray[$i]['naslovoglasa'];
    $nekretninaNaslov =$nekrsArray[$i]['naslov'];

     $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

     $nekrStatus  =  $nekrsArray[$i]['status'];

     $nekrZupanija =  $nekrsArray[$i]['nazivZupanije'];

     $nekrMikrolokacija =  $nekrsArray[$i]['mikrolokacija'];

     $nekretninaPovrsina  =  $nekrsArray[$i]['povrsina'];

      $nekretninaCijena  =  $nekrsArray[$i]['cijena'];

      $nekretninaMjesto =   $nekrsArray[$i]['mjesto'];

      $nekretninaAdresa =  $nekrsArray[$i]['adresa'];


      ///karta info
      $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);
  //  mapa("zagreb","", "zagreb");


      $nekretninaAgent  =  $nekrsArray[$i]['imeIPrezime'];

     $nekretninaMobitel  =  $nekrsArray[$i]['mobitel'];

      $nekretninaMinCijena  =  $nekrsArray[$i]['minCijena'];

      $nekretninaMaxCijena  =  $nekrsArray[$i]['maxCijena'];

      $nekretninaEmail  =  $nekrsArray[$i]['email'];

      $nekretninaNap  =  $nekrsArray[$i]['napomena'];


      $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
        $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
          $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
            $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
              $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
                $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
                  $nekretnine_slk7 = $nekrsArray[$i]['slk7'];

      $nekretninaVrstPonude  =  $nekrsArray[$i]['vrstaPonude'];

      $nekretninaLat  =  $nekrsArray[$i]['lat'];

      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $nekretninaAgent_1  =  $nekrsArray[$i]['agent'];

      // $nekretninanjuskaloID  =  $nekrsArray[$i]['njuskalo_id'];

      $nekretninaPdf  =  $nekrsArray[$i]['tlocrtPDF'];

      $nekretninaMoreUdaljenost = $nekrsArray[$i]['moreUdaljenost'];

      $nekretninaMorePogled = $nekrsArray[$i]['morePogled'];

      $nekretninaTekst = $nekrsArray[$i]['tekst'];

      $nekretnina = $dom->createElement('post');



      if(empty($nekretninaMjesto) || $nekretninaMjesto == '' || is_null($nekretninaMjesto)){


               //ako je prioritet da bude županija
                // if($nekrZupanija != '' || is_null($nekrZupanija)){
                //   $naslovM = $nekrZupanija;
                // }
                //
                // else{
                //   $naslovM = $nekrenineKvart;
                // }

                if($nekrenineKvart != ''){
                    $naslovM = $nekrenineKvart;
                }else{
                  if($nekrenineKvart != ''){
                   $naslovM = $nekrenineKvart;
                 }else{
                   $naslovM = $nekrZupanija;
                 }
                }

        }


      else{$naslovM = $nekretninaMjesto;}




    // $nekretnina->setAttribute('id', "garag".$nekrID);
     $IDNk = $dom-> createElement('id', $nekretninaNaslov . " - ".$nekrID . ", " .$nekrVrsta);
     $nekretnina->appendChild($IDNk);


     $naslov  = $dom->createElement('naslov', $nekretninaNaslov . " - ".$nekrID . ", " .$nekrVrsta);
     $nekretnina->appendChild($naslov);




     // echo'<br/> karta ID :'.$naslovM . " - ".$nekrID .", ". $nekrVrsta;
     //
     //  echo'<br/> <iframe
     //  src="'.$GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon).'"
     //  width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
     //  </iframe> <br/>';
     //  echo $nekretninaLat ."----, ---". $nekretninaLon;
     //
     //
     // echo'<br/> --- <h3>po adresi</h3> ';
     //  echo'<br/> <iframe
     //  src="'.$GoogleKarta = mapa($nekretninaAdresa, "",   $nekretninaAdresa).'"
     //  width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
     //  </iframe> <br/>';
     // echo   $nekretninaAdresa;
     // echo '<hr/>';






     $name  = $dom->createElement('vrsta', $nekrVrsta);
     $nekretnina->appendChild($name);

     $status  = $dom->createElement('status',  $nekrStatus);
     $nekretnina->appendChild($status);

     $zupanija = $dom->createElement('nazivZupanije', $nekrZupanija);
     $nekretnina->appendChild($zupanija);

     $mikrolokacija = $dom->createElement('mikrolokacija', $nekrMikrolokacija);
     $nekretnina->appendChild($mikrolokacija);

     $povrsina  = $dom->createElement('povrsina', $nekretninaPovrsina);
     $nekretnina->appendChild($povrsina);


     $cijena  = $dom->createElement('cijena', $nekretninaCijena );
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('mjesto', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);

     $adresa = $dom->createElement('adresa', $nekretninaAdresa);
     $nekretnina->appendChild($adresa);

     $agent = $dom->createElement('imeIPrezime', $nekretninaAgent);
     $nekretnina->appendChild($agent);


     $mobitel = $dom->createElement('mobitel', $nekretninaMobitel);
     $nekretnina->appendChild($mobitel);


     $minCijena = $dom->createElement('minCijena', $nekretninaMinCijena);
     $nekretnina->appendChild($minCijena);

     $maxCijena = $dom->createElement('maxCijena', $nekretninaMaxCijena);
     $nekretnina->appendChild($maxCijena);

     $mail = $dom->createElement('email', $nekretninaEmail);
     $nekretnina->appendChild($mail);

     $napomena = $dom->createElement('napomena', $nekretninaNap);
     $nekretnina->appendChild($napomena);

     // $slike = $dom->createElement('slike', $nekretninaSlike);
     // $nekretnina->appendChild($slike);

     $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);



           if($nekretnine_slk1 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
            $nekretnine_slk1 = 'http://www.nekretnine-tomislav.hr/t/t_tomislav.jpg';
           }else{
             $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
           }
             $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
           $nekretnina-> appendChild($slike1);


           if($nekretnine_slk2 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk2 = '';
           }else{
               $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
             }
             $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
           $nekretnina -> appendChild($slike2);


           if($nekretnine_slk3 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk3 = '';
           }else{
             $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
             }
           $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
           $nekretnina -> appendChild($slike3);


             if($nekretnine_slk4 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
                 $nekretnine_slk4 = '';
             }else{
                 $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
             }
           $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
           $nekretnina -> appendChild($slike4);



           if($nekretnine_slk5 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk5 = '';
           }else{
             $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
           }
           $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
           $nekretnina -> appendChild($slike5);


           if($nekretnine_slk6 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk6 = '';
           }else{
               $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
           }
           $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
           $nekretnina -> appendChild($slike6);


           if($nekretnine_slk7 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk7 = '';
           }else{
             $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
           }
           $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
           $nekretnina -> appendChild($slike7);






     $vrstPonude = $dom->createElement('vrstaPonude', $nekretninaVrstPonude);
     $nekretnina->appendChild($vrstPonude);

     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);


     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', htmlEntities($GoogleKorKarta)); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);




     //$GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);


     $agent_1 = $dom->createElement('agent', $nekretninaAgent_1);
     $nekretnina->appendChild($agent_1);

     // $njuskalo = $dom->createElement('njuskalo_id', $nekretninanjuskaloID);
     // $nekretnina->appendChild($njuskalo);

     $pdf_ = $dom->createElement('tlocrtPDF', $nekretninaPdf);
     $nekretnina->appendChild($pdf_);

     $moreUda = $dom->createElement('moreUdaljenost', $nekretninaMoreUdaljenost);
     $nekretnina->appendChild($moreUda);

     $morePogled = $dom->createElement('morePogled', $nekretninaMorePogled);
     $nekretnina->appendChild($morePogled);

     $tekst = $dom->createElement('tekst', $nekretninaTekst);
     $nekretnina->appendChild($tekst);




     $root->appendChild($nekretnina);

   }

   $dom->appendChild($root);

   $dom->save($filePath);
   //echo'<h1>Uspjeh</h1>';

 }



 ?>

  <!--?print $karta?-->


  

 <!DOCTYPE html>
<html lang="hr">
<head>
  <title>PHP XML app</title>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>
<body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="">Garaže <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">Naslovna</a>
      </li>

      
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
     
    </ul>

  </div>
</nav>



<div class="container">

<div class="jumbotron">
  <h1 class="display-4">Garaže</h1>
  <p class="lead">Uspjeh , rješene garaže</p>
  <hr class="my-4">
  <?php print '<h1>'.$str1. " " .$str2.'</h1>'; ?>
 
</div>



</div>








</body>
</html>
