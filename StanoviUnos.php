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




// $query = "SELECT* FROM grupe";

$query = "
SELECT vivostanovi.id, grupe.naziv as 'vrsta', grupe.vrsta AS 'status',  zupanije.nazivZupanije, vivostanovi.mikrolokacija, vivostanovi.mjesto as 'naslov', vivostanovi.mjesto, vivostanovi.ukupnaPovrsina,
vivostanovi.cijena, vivostanovi.katValue as 'stan na katu', vivostanovi.ukupnoKat as 'ukupno katova', vivostanovi.brojEtaza, vivostanovi.grijanje,
vivostanovi.godinaIzgradnjeValue as 'godina izgradnje', vivostanovi.balkonValue, vivostanovi.loggiaValue, vivostanovi.vrtValue as 'vrt', vivostanovi.terasaValue, vivostanovi.lift, vivostanovi.stolarija,
vivostanovi.alarm, vivostanovi.protupozar, vivostanovi.protuprovala, vivostanovi.parket, vivostanovi.laminat, vivostanovi.klima, vivostanovi.kabel, vivostanovi.satelit, vivostanovi.internet, vivostanovi.rostilj,
vivostanovi.bazen

from vivostanovi LEFT JOIN grupe ON vivostanovi.grupa = grupe.id
LEFT JOIN regije ON vivostanovi.regija = regije.id
LEFT JOIN zupanije ON vivostanovi.zupanija = zupanije.id
LEFT JOIN kvartovi ON kvartovi.id = vivostanovi.kvart
where vivostanovi.aktivno = 1;";



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

/* close connection */
$mysqli->close();

function createXMLfile($nekrsArray){

   $filePath = 'nekretnine_stanovi_1.xml';

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

      $nekretninaAgent  =  $nekrsArray[$i]['imeIPrezime'];

     $nekretninaMobitel  =  $nekrsArray[$i]['mobitel'];

      $nekretninaMinCijena  =  $nekrsArray[$i]['minCijena'];

      $nekretninaMaxCijena  =  $nekrsArray[$i]['maxCijena'];

      $nekretninaEmail  =  $nekrsArray[$i]['email'];

      $nekretninaNap  =  $nekrsArray[$i]['napomena'];

      //$nekretninaSlike  =  $nekrsArray[$i]['slike'];
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




    // $nekretnina->setAttribute('id', "garag".$nekrID);
     $IDNk = $dom-> createElement('id', $nekretninaNaslov . " - ".$nekrID . ", " .$nekrVrsta);
     $nekretnina->appendChild($IDNk);


     $naslov  = $dom->createElement('naslov', $nekretninaNaslov . " - ".$nekrID . ", " .$nekrVrsta);
     $nekretnina->appendChild($naslov);

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


      $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
      $nekretnina-> appendChild($slike1);


      $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
      $nekretnina -> appendChild($slike2);


      $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
      $nekretnina -> appendChild($slike3);


      $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
      $nekretnina -> appendChild($slike4);

      $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
      $nekretnina -> appendChild($slike5);

      $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
      $nekretnina -> appendChild($slike6);

      $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
      $nekretnina -> appendChild($slike7);


     $vrstPonude = $dom->createElement('vrstaPonude', $nekretninaVrstPonude);
     $nekretnina->appendChild($vrstPonude);

     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);

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
   echo'<h1>Uspjeh</h1>';

 }



 ?>
