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


$query = "
SELECT vivoturizam.id, grupe.naziv as 'vrsta', grupe.vrsta AS 'status',  zupanije.nazivZupanije, vivoturizam.mikrolokacija, vivoturizam.mjesto as 'naslov',
vivoturizam.naslovoglasa, vivoturizam.adresa,
vivoturizam.cijena, vivoturizam.mjesto as 'grad', vivoturizam.adresa, vivoturizam.cvrstiObjektm2,
vivoturizam.napomena, vivoturizam.grijanje, vivoturizam.klima, vivoturizam.kabel, vivoturizam.telefon, vivoturizam.internet, kvartovi.naziv AS 'kvart',
vivoturizam.satelit, vivoturizam.lat, vivoturizam.lon, vivoturizam.agent, vivoturizam.udaljenostMore, vivoturizam.pogledMore,
vivoturizam.udaljenostCentar, vivoturizam.udaljenostAerodrom, vivoturizam.udaljenostAutobus, vivoturizam.udaljenostPlaza, vivoturizam.udaljenostMarina , vivoturizam.udaljenostTrajekt,
vivoturizam.udaljenostTrgovina ,vivoturizam.udaljenostRestoran ,vivoturizam.udaljenostAmbulanta ,vivoturizam.udaljenostLjekarna, vivoturizam.udaljenostPrometnica,
vivoturizam.pogledZelenilo, vivoturizam.udaljenostParkiralista, vivoturizam.dostupnostAutomobilom, vivoturizam.zemljistem2, vivoturizam.pogledPlanine,
vivoturizam.parkirnaMjestabroj, vivoturizam.garaznaMjestaBroj, vivoturizam.godinaIzgradnjeValue, tekstTransferTurizam.tekst,
sliketransferTurizam.slk1, sliketransferTurizam.slk2, sliketransferTurizam.slk3, sliketransferTurizam.slk4, sliketransferTurizam.slk5, sliketransferTurizam.slk6,
sliketransferTurizam.slk7

FROM vivoturizam LEFT JOIN grupe ON vivoturizam.grupa = grupe.id
LEFT JOIN regije ON vivoturizam.regija = regije.id
LEFT JOIN zupanije ON vivoturizam.zupanija = zupanije.id
LEFT JOIN kvartovi ON kvartovi.id = vivoturizam.kvart
LEFT JOIN tekstTransferTurizam ON tekstTransferTurizam.spojenoNa = vivoturizam.id
LEFT JOIN sliketransferTurizam ON sliketransferTurizam.ID_nekrenina = vivoturizam.id
where vivoturizam.aktivno = 1
order by vivoturizam.id asc;";
//where vivoturizam.aktivno = 1 AND vivozemljista.id > 320 AND vivozemljista.id < 450;";



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
$counquery = "SELECT vivoturizam.id from vivoturizam";
$num_rows = $mysqli->query($counquery);
$num_rows = count($nekrsArray);

$str1= $num_rows;
$str2="Broj koji je prebaćen ";
//echo "<h4>".$str1 . " " . $str2."</h4>";



/* close connection */
$mysqli->close();

function createXMLfile($nekrsArray){

   $filePath = 'prerade/nekretnine_apartmani.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('apartman');

   for($i=0; $i<count($nekrsArray); $i++){

     $nekrID  =  $nekrsArray[$i]['id'];

     $nekrNaslov  =  $nekrsArray[$i]['naslov'];

     $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

     $nekrStatus  =  $nekrsArray[$i]['status'];

      $nekrZupanija =  $nekrsArray[$i]['nazivZupanije'];

      $nekretninaPovrsina  =  $nekrsArray[$i]['cvrstiObjektm2'];

      $nekretninaZemljiste  =  $nekrsArray[$i]['zemljistem2'];

      $nekretninaCijena  =  $nekrsArray[$i]['cijena'];

      $nekretninaMjesto =   $nekrsArray[$i]['grad']; // grad

      $nekrenineKvart = $nekrsArray[$i]['kvart']; //kvart

      $nekretninaTelefon = $nekrsArray[$i]['telefon'];

      $nekretninaKlima = $nekrsArray[$i]['klima'];

      $nekretninaGrijanje = $nekrsArray[$i]['grijanje'];

      $nekretninaInternet = $nekrsArray[$i]['internet'];

      $nekretninaSatelitska = $nekrsArray[$i]['satelit'];

      $nekreninaUdaljenostCentar = $nekrsArray[$i]['udaljenostCentar'];

      $nekreninaUdaljenostAerodrom = $nekrsArray[$i]['udaljenostAerodrom'];

      $udaljenostBus =  $nekrsArray[$i]['udaljenostAutobus'];

      $udaljenostMarina =  $nekrsArray[$i]['udaljenostMarina'];

      $udaljenostPlaza = $nekrsArray[$i]['udaljenostPlaza'];

      $udaljenostTrajekt = $nekrsArray[$i]['udaljenostTrajekt'];

      $udaljenostTrgovina = $nekrsArray[$i]['udaljenostTrgovina'];

      $udaljenostRestoran = $nekrsArray[$i]['udaljenostRestoran'];

      $udaljenostAmbulanta =  $nekrsArray[$i]['udaljenostAmbulanta'];

      $udaljenostLjekarna = $nekrsArray[$i]['udaljenostLjekarna'];

      $udaljenostPrometnica = $nekrsArray[$i]['udaljenostPrometnica'];

      $udaljenostParkiralista = $nekrsArray[$i]['udaljenostParkiralista'];

      $dostupnostAutomobilom = $nekrsArray[$i]['dostupnostAutomobilom'];

      $parkirnaMjestabroj = $nekrsArray[$i]['parkirnaMjestabroj'];

      $garaznaMjestaBroj = $nekrsArray[$i]['garaznaMjestaBroj'];

      $pogledZelenilo =  $nekrsArray[$i]['pogledZelenilo'];

      $pogledPlanine = $nekrsArray[$i]['pogledPlanine'];

      $nekrMikrolokacija  = $nekrsArray[$i]['mikrolokacija'];

          $nekretninaAdresa = $nekrsArray[$i]['adresa'];

      $godinaIzgradnjeValue = $nekrsArray[$i]['godinaIzgradnjeValue'];

    $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);

      $nekretninaNap  =  $nekrsArray[$i]['napomena'];
      $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
      $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      $nekretnine_slk7 = $nekrsArray[$i]['slk7'];

      $nekretninaLat  =  $nekrsArray[$i]['lat'];
      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);

      $nekretninaMoreUdaljenost = $nekrsArray[$i]['udaljenostMore'];

      $nekretninaMorePogled = $nekrsArray[$i]['pogledMore'];

      $nekretninaTekst = $nekrsArray[$i]['tekst'];
      $nekretninaTekst = strip_tags($nekretninaTekst);






      $nekretnina = $dom->createElement('post');





     $nekretnina = $dom->createElement('post');

    // if(trim($nekrNaslov) == "" || is_numeric($nekrNaslov) == 0 || is_null($nekrNaslov)){
    //   if(is_numeric($nekretninaMjesto) == 0 || is_null($nekretninaMjesto)){
    //     if(trim($nekrZupanija) != ""){
    //       $naslovM = $nekrZupanija;
    //       }
    //     }
    //     else{
    //          $naslovM = $nekrenineKvart;
    //       }
    //
    // }
    //
    // else{
    // $naslovM = $nekrenineKvart;
    // }
    //
    // $naslovM = "";




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







    $IDNk = $dom-> createElement('id', $naslovM . " - ".$nekrID .", ". $nekrVrsta);
    $nekretnina->appendChild($IDNk);

    $naslov  = $dom->createElement('naslov', $naslovM . " - ".$nekrID . ", ".$nekrVrsta);
    $nekretnina->appendChild($naslov);

    $naslovM = ''; //prazni varijablu


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

     $kvart = $dom->createElement('kvart', $nekrenineKvart);
     $nekretnina -> appendChild($kvart);

     $povrsina  = $dom->createElement('povrsina', $nekretninaPovrsina);
     $nekretnina->appendChild($povrsina);

     $povrsinazemlja = $dom->createElement('povrsinaZemlje', $nekretninaZemljiste);
     $nekretnina->appendChild($povrsinazemlja);

     $cijena  = $dom->createElement('cijena', $nekretninaCijena );
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('grad', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);





     // // nekrenine telefon
     if($nekretninaTelefon == 0){
       $nekretninaTelefon = '';
     }else{
       $nekretninaTelefon = 'Telefon (upotreba)';
     }

     $tel = $dom -> createElement('Telefon', $nekretninaTelefon);
     $nekretnina -> appendChild($tel);


     //nekrenine klima
    if($nekretninaKlima == 0){
      $nekretninaKlima = '';
    }else{
      $nekretninaKlima = 'Klima uređaj';
    }

    $klima = $dom -> createElement('Klima', $nekretninaKlima);
    $nekretnina -> appendChild($klima);


      //nekrenine internet
     if($nekretninaInternet == 0){
       $nekretninaInternet = '';
     }else{
       $nekretninaInternet = 'Internet (wi-fi ili lan)';
     }

     $internet = $dom -> createElement('Ima_internet', $nekretninaInternet);
     $nekretnina -> appendChild($internet);


     //nekrenine satelitska
    if($nekretninaSatelitska == '0'){
          $nekretninaSatelitska = '';
    }else{
          $nekretninaSatelitska = 'Satelitska televizija';
    }

     $satelitska = $dom -> createElement('Instalirana_satelitska', $nekretninaSatelitska);
     $nekretnina -> appendChild($satelitska);


     //ima nema grijanje
     if($nekretninaGrijanje == '0'){
         $nekretninaGrijanje = '';
     }else{
         $nekretninaGrijanje = 'Grijanje (centralno ili klima)';
     }

     $grijanje = $dom -> createElement('Grijanje_ima', $nekretninaGrijanje);
     $nekretnina -> appendChild($grijanje);


   // udaljenosti

     $UdaljenostCentar = $dom -> createElement('UdaljenostCentra', $nekreninaUdaljenostCentar);
     $nekretnina -> appendChild( $UdaljenostCentar);

     $UdaljenostAerodrom = $dom -> createElement('UdaljenostAerodroma', $nekreninaUdaljenostAerodrom);
     $nekretnina -> appendChild($UdaljenostAerodrom);


     $udaljenostAutobus = $dom -> createElement('AutobusnaStanicaUdaljenost', $udaljenostBus);
     $nekretnina -> appendChild($udaljenostAutobus);

     $udaljenostDoPlaze = $dom->createElement('PlazaUdaljenost', $udaljenostPlaza);
     $nekretnina->appendChild($udaljenostDoPlaze);


     $moreUda = $dom->createElement('UdaljenostMore', $nekretninaMoreUdaljenost);
     $nekretnina->appendChild($moreUda);


     $marinaUda = $dom->createElement('UdaljenostMarina', $udaljenostMarina);
     $nekretnina->appendChild($marinaUda);


     $marinaTr = $dom->createElement('UdaljenostTrajekta', $udaljenostTrajekt);
     $nekretnina->appendChild($marinaTr);

     $trgovinaUda = $dom->createElement('UdaljenostTrgovina', $udaljenostTrgovina);
     $nekretnina->appendChild($trgovinaUda);


     $restoranUda = $dom->createElement('UdaljenostRestoran', $udaljenostRestoran);
     $nekretnina->appendChild($restoranUda);

     $doktorUda = $dom->createElement('UdaljenostAmbulanta', $udaljenostAmbulanta);
     $nekretnina->appendChild($doktorUda);

     $ljekarnaUda = $dom->createElement('UdaljenostLjekarna', $udaljenostLjekarna);
     $nekretnina->appendChild($ljekarnaUda);

     $prometnicaUda = $dom->createElement('UdaljenostPrometnica', $udaljenostPrometnica);
     $nekretnina->appendChild($prometnicaUda);


     //pogled na zelenilo
    if($pogledZelenilo == '0'){
           $pogledZelenilo = '';
    }else{
           $pogledZelenilo = 'Pogled na zeleno (šuma, livada, uređeni park)';
    }

     $pogledZeleno = $dom -> createElement('PogledZelenilo', $pogledZelenilo);
     $nekretnina -> appendChild($pogledZeleno);



     //pogled na planine
    if($pogledPlanine == '0'){
           $pogledPlanine = '';
    }else{
           $pogledPlanine = 'Pogled na planine';
    }

     $pogledPlanina = $dom -> createElement('PogledPlanine', $pogledPlanine);
     $nekretnina -> appendChild($pogledPlanina);



     // $pogledPlanina = $dom->createElement('PogledPlanine', $pogledPlanine);
     // $nekretnina->appendChild($pogledPlanina);

     $parkingUda = $dom->createElement('ParkingUdaljenost', $udaljenostParkiralista);
     $nekretnina->appendChild($parkingUda);

     $dostupnostAuto = $dom->createElement('DostupnostAuto', $dostupnostAutomobilom);
     $nekretnina->appendChild($dostupnostAuto);

     $parkingMjestaBroj = $dom->createElement('Broj_parkingMjesta', $parkirnaMjestabroj);
     $nekretnina->appendChild($parkingMjestaBroj);

     $garaznaMjestaBroj = $dom->createElement('Broj_garaznihMjesta', $garaznaMjestaBroj);
     $nekretnina->appendChild($garaznaMjestaBroj);





           //slike
           if($nekretnine_slk1 == 'http://nekretnine-tomislav.hr/slike/'){
            $nekretnine_slk1 = 'http://www.nekretnine-tomislav.hr/t/t_tomislav.jpg';
           }else{
             $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
           }
             $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
           $nekretnina-> appendChild($slike1);


           if($nekretnine_slk2 == 'http://nekretnine-tomislav.hr/slike/'){
             $nekretnine_slk2 = '';
           }else{
               $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
             }
             $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
           $nekretnina -> appendChild($slike2);


           if($nekretnine_slk3 == 'http://nekretnine-tomislav.hr/slike/'){
             $nekretnine_slk3 = '';
           }else{
             $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
             }
           $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
           $nekretnina -> appendChild($slike3);


             if($nekretnine_slk4 == 'http://nekretnine-tomislav.hr/slike/'){
                 $nekretnine_slk4 = '';
             }else{
                 $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
             }
           $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
           $nekretnina -> appendChild($slike4);



           if($nekretnine_slk5 == 'http://nekretnine-tomislav.hr/slike/'){
             $nekretnine_slk5 = '';
           }else{
             $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
           }
           $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
           $nekretnina -> appendChild($slike5);


           if($nekretnine_slk6 == 'http://nekretnine-tomislav.hr/slike/'){
             $nekretnine_slk6 = '';
           }else{
               $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
           }
           $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
           $nekretnina -> appendChild($slike6);


           if(trim($nekretnine_slk7) == 'http://nekretnine-tomislav.hr/slike/'){
             $nekretnine_slk7 = '';
           }else{
             $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
           }
           $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
           $nekretnina -> appendChild($slike7);


           // if($nekretnine_slk8 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
           //   $nekretnine_slk8 = '';
           // }else{
           //   $slike8 = $dom -> createElement('slk8',  $nekretnine_slk8);
           // }
           // $slike8 = $dom -> createElement('slk8',  $nekretnine_slk8);
           // $nekretnina -> appendChild($slike8);
           //
           //
           // if($nekretnine_slk9 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
           //   $nekretnine_slk9 = '';
           // }else{
           //   $slike9 = $dom -> createElement('slk9',  $nekretnine_slk9);
           // }
           // $slike9 = $dom -> createElement('slk9',  $nekretnine_slk9);
           // $nekretnina -> appendChild($slike9);


     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);


     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', htmlEntities($GoogleKorKarta)); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);

     $godinaIzgradnje = $dom ->createElement('GodinaGradnje', $godinaIzgradnjeValue); //$GoogleKarta
     $nekretnina -> appendChild($godinaIzgradnje);




     //nekrenine pogled na more
    if($nekretninaMorePogled == 0){
      $nekretninaMorePogled = "";
    }else{
      $nekretninaMorePogled = "Pogled na more (plaža)";
    }

     $morePogled = $dom->createElement('morePogled', $nekretninaMorePogled);
     $nekretnina->appendChild($morePogled);



     $tekst = $dom->createElement('tekst', $nekretninaTekst);
     $nekretnina->appendChild($tekst);


     $root->appendChild($nekretnina);

   }

   $dom->appendChild($root);

   $dom->save($filePath);
    //  echo'<h1>Uspjeh , rješen turizam</h1>';
    $poruka = 'Uspjeh , rješen turizam';


    //echo "<h4>".$str1 . " " . $str2."</h4>";
    
 }
 ?>




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
        <a class="nav-link" href="">Apartmani <span class="sr-only">(current)</span></a>
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
  <h1 class="display-4">Apartmani</h1>
  <p class="lead">Uspjeh , rješen turizam</p>
  <hr class="my-4">
  <?php print '<h1>'.$str1. " " .$str2.'</h1>'; ?>
 
</div>



</div>








</body>
</html>