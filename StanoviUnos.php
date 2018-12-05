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
SELECT vivostanovi.id, grupe.naziv as 'vrsta', grupe.vrsta AS 'status',  zupanije.nazivZupanije, vivostanovi.mikrolokacija as 'kvart', vivostanovi.mjesto as 'grad', vivostanovi.mjesto as 'naslov',
vivostanovi.ukupnaPovrsina,
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

   $filePath = 'nekretnine_apartmani.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('apartman');

   for($i=0; $i<count($nekrsArray); $i++){

     $nekrID  =  $nekrsArray[$i]['id'];

     $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

     $nekrStatus  =  $nekrsArray[$i]['status'];

     $nekrNaslov  =  $nekrsArray[$i]['naslov'];

     $nekrZupanija =  $nekrsArray[$i]['nazivZupanije'];

      $nekretninaPovrsina  =  $nekrsArray[$i]['ukupnaPovrsina'];

      $nekretninaMjesto =   $nekrsArray[$i]['grad']; // grad

      $nekrenineKvart = $nekrsArray[$i]['kvart']; //kvart

      $nekretninaCijena  =  $nekrsArray[$i]['cijena'];

      $nekretninaKat  =  $nekrsArray[$i]['stan na katu'];

      $nekretninaUkupnoKat  =  $nekrsArray[$i]['ukupno katova'];

      $nekretninaEtaza  =  $nekrsArray[$i]['brojEtaza'];

      $nekretninaGrijanje = $nekrsArray[$i]['grijanje'];

      $godinaIzgradnjeValue = $nekrsArray[$i]['godinaIzgradnjeValue'];


      $nekretninaTelefon = $nekrsArray[$i]['telefon'];

      $nekretninaKlima = $nekrsArray[$i]['klima'];



      $nekretninaInternet = $nekrsArray[$i]['internet'];

      $nekretninaSatelitska = $nekrsArray[$i]['satelit'];

      // $nekreninaUdaljenostCentar = $nekrsArray[$i]['udaljenostCentar'];
      //
      // $nekreninaUdaljenostAerodrom = $nekrsArray[$i]['udaljenostAerodrom'];
      //
      // $udaljenostBus =  $nekrsArray[$i]['udaljenostAutobus'];
      //
      // $udaljenostMarina =  $nekrsArray[$i]['udaljenostMarina'];
      //
      // $udaljenostPlaza = $nekrsArray[$i]['udaljenostPlaza'];
      //
      // $udaljenostTrajekt = $nekrsArray[$i]['udaljenostTrajekt'];
      //
      // $udaljenostTrgovina = $nekrsArray[$i]['udaljenostTrgovina'];

      // $udaljenostRestoran = $nekrsArray[$i]['udaljenostRestoran'];
      //
      // $udaljenostAmbulanta =  $nekrsArray[$i]['udaljenostAmbulanta'];
      //
      // $udaljenostLjekarna = $nekrsArray[$i]['udaljenostLjekarna'];
      //
      // $udaljenostPrometnica = $nekrsArray[$i]['udaljenostPrometnica'];
      //
      // $udaljenostParkiralista = $nekrsArray[$i]['udaljenostParkiralista'];
      //
      // $dostupnostAutomobilom = $nekrsArray[$i]['dostupnostAutomobilom'];
      //
      // $parkirnaMjestabroj = $nekrsArray[$i]['parkirnaMjestabroj'];

      // $garaznaMjestaBroj = $nekrsArray[$i]['garaznaMjestaBroj'];
      //
      // $pogledZelenilo =  $nekrsArray[$i]['pogledZelenilo'];
      //
      // $pogledPlanine = $nekrsArray[$i]['pogledPlanine'];

      // $nekrMikrolokacija  = $nekrsArray[$i]['mikrolokacija'];
      //

      //
      // $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);
      //
      // $nekretninaNap  =  $nekrsArray[$i]['napomena'];
      // $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
      // $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      // $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      // $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      // $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      // $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      // $nekretnine_slk7 = $nekrsArray[$i]['slk7'];
      //
      // $nekretninaLat  =  $nekrsArray[$i]['lat'];
      // $nekretninaLon  =  $nekrsArray[$i]['lon'];
      //
      // $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);

      // $nekretninaMoreUdaljenost = $nekrsArray[$i]['udaljenostMore'];
      //
      // $nekretninaMorePogled = $nekrsArray[$i]['pogledMore'];

      $nekretninaTekst = $nekrsArray[$i]['tekst'];
      $nekretninaTekst = strip_tags($nekretninaTekst);

      $nekretnina = $dom->createElement('post');




     if($nekrNaslov == "" || $nekrNaslov == 0){
       $naslovM = $nekretninaMjesto;
     } else{
       $naslovM = $nekrNaslov;
     }

     $IDNk = $dom-> createElement('id', $naslovM . " - ".$nekrID . ", stan");
     $nekretnina->appendChild($IDNk);

     $naslov  = $dom->createElement('naslov', $naslovM . " - ".$nekrID . ", stan");
     $nekretnina->appendChild($naslov);


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


     $cijena  = $dom->createElement('cijena', $nekretninaCijena );
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('grad', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);

     $kat  = $dom->createElement('kat', $nekretninaKat);
     $nekretnina ->appendChild($kat);

     $Broj_kat  = $dom->createElement('broj_kat', $nekretninaUkupnoKat);
     $nekretnina ->appendChild($Broj_kat);

     $Broj_etaza  = $dom->createElement('broj_etaza', $nekretninaEtaza);
     $nekretnina ->appendChild($Broj_etaza);

     $godinaIzgradnje = $dom ->createElement('GodinaGradnje', $godinaIzgradnjeValue);
     $nekretnina -> appendChild($godinaIzgradnje);


     //nekretnine features
     //ima nema grijanje
     if($nekretninaGrijanje == '0'){
         $nekretninaGrijanje = '';
     }else{
         $nekretninaGrijanje = 'Grijanje';
     }

     $grijanje = $dom -> createElement('Grijanje_ima', $nekretninaGrijanje);
     $nekretnina -> appendChild($grijanje);





     //nekrenine telefon
    if($nekretninaTelefon == 0){
      $nekretninaTelefon = '';
    }else{
      $nekretninaTelefon = 'Telefon';
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
       $nekretninaInternet = 'Internet';
     }

     $internet = $dom -> createElement('Ima_internet', $nekretninaInternet);
     $nekretnina -> appendChild($internet);


     //nekrenine satelitska
    if($nekretninaSatelitska == '0'){
          $nekretninaSatelitska = '';
    }else{
          $nekretninaSatelitska = 'Satelitska';
    }

     $satelitska = $dom -> createElement('Instalirana_satelitska', $nekretninaSatelitska);
     $nekretnina -> appendChild($satelitska);





   // udaljenosti

     // $UdaljenostCentar = $dom -> createElement('UdaljenostCentra', $nekreninaUdaljenostCentar);
     // $nekretnina -> appendChild( $UdaljenostCentar);
     //
     // $UdaljenostAerodrom = $dom -> createElement('UdaljenostAerodroma', $nekreninaUdaljenostAerodrom);
     // $nekretnina -> appendChild($UdaljenostAerodrom);
     //
     //
     // $udaljenostAutobus = $dom -> createElement('AutobusnaStanicaUdaljenost', $udaljenostBus);
     // $nekretnina -> appendChild($udaljenostAutobus);
     //
     // $udaljenostDoPlaze = $dom->createElement('PlazaUdaljenost', $udaljenostPlaza);
     // $nekretnina->appendChild($udaljenostDoPlaze);
     //
     //
     // $moreUda = $dom->createElement('UdaljenostMore', $nekretninaMoreUdaljenost);
     // $nekretnina->appendChild($moreUda);
     //
     //
     // $marinaUda = $dom->createElement('UdaljenostMarina', $udaljenostMarina);
     // $nekretnina->appendChild($marinaUda);


     // $marinaTr = $dom->createElement('UdaljenostTrajekta', $udaljenostTrajekt);
     // $nekretnina->appendChild($marinaTr);
     //
     // $trgovinaUda = $dom->createElement('UdaljenostTrgovina', $udaljenostTrgovina);
     // $nekretnina->appendChild($trgovinaUda);
     //
     //
     // $restoranUda = $dom->createElement('UdaljenostRestoran', $udaljenostRestoran);
     // $nekretnina->appendChild($restoranUda);
     //
     // $doktorUda = $dom->createElement('UdaljenostAmbulanta', $udaljenostAmbulanta);
     // $nekretnina->appendChild($doktorUda);
     //
     // $ljekarnaUda = $dom->createElement('UdaljenostLjekarna', $udaljenostLjekarna);
     // $nekretnina->appendChild($ljekarnaUda);
     //
     // $prometnicaUda = $dom->createElement('UdaljenostPrometnica', $udaljenostPrometnica);
     // $nekretnina->appendChild($prometnicaUda);
     //
     // $pogledZeleno = $dom->createElement('PogledZelenilo', $pogledZelenilo);
     // $nekretnina->appendChild($pogledZeleno);
     //
     // $pogledPlanina = $dom->createElement('PogledPlanine', $pogledPlanine);
     // $nekretnina->appendChild($pogledPlanina);
     //
     // $parkingUda = $dom->createElement('ParkingUdaljenost', $udaljenostParkiralista);
     // $nekretnina->appendChild($parkingUda);
     //
     // $dostupnostAuto = $dom->createElement('DostupnostAuto', $dostupnostAutomobilom);
     // $nekretnina->appendChild($dostupnostAuto);
     //
     // $parkingMjestaBroj = $dom->createElement('Broj_parkingMjesta', $parkirnaMjestabroj);
     // $nekretnina->appendChild($parkingMjestaBroj);
     //
     // $garaznaMjestaBroj = $dom->createElement('Broj_garaznihMjesta', $garaznaMjestaBroj);
     // $nekretnina->appendChild($garaznaMjestaBroj);





      //slike
     //  if($nekretnine_slk1 == 'http://nekretnine-tomislav.hr/slike/'){
     //   $nekretnine_slk1 = '';
     //  }else{
     //    $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
     //  }
     //    $slike1 = $dom-> createElement('slk1', $nekretnine_slk1);
     //  $nekretnina-> appendChild($slike1);
     //
     //
     //  if($nekretnine_slk2 == 'http://nekretnine-tomislav.hr/slike/'){
     //    $nekretnine_slk2 = '';
     //  }else{
     //      $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
     //    }
     //    $slike2 = $dom-> createElement('slk2', $nekretnine_slk2);
     //  $nekretnina -> appendChild($slike2);
     //
     //
     //  if($nekretnine_slk3 == 'http://nekretnine-tomislav.hr/slike/'){
     //    $nekretnine_slk3 = '';
     //  }else{
     //    $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
     //    }
     //  $slike3 = $dom-> createElement('slk3', $nekretnine_slk3);
     //  $nekretnina -> appendChild($slike3);
     //
     //
     //    if($nekretnine_slk4 == 'http://nekretnine-tomislav.hr/slike/'){
     //        $nekretnine_slk4 = '';
     //    }else{
     //        $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
     //    }
     //  $slike4 = $dom -> createElement('slk4', $nekretnine_slk4);
     //  $nekretnina -> appendChild($slike4);
     //
     //
     //
     //  if($nekretnine_slk5 == 'http://nekretnine-tomislav.hr/slike/'){
     //    $nekretnine_slk5 = '';
     //  }else{
     //    $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
     //  }
     //  $slike5 = $dom -> createElement('slk5', $nekretnine_slk5);
     //  $nekretnina -> appendChild($slike5);
     //
     //
     //  if($nekretnine_slk6 == 'http://nekretnine-tomislav.hr/slike/'){
     //    $nekretnine_slk6 = '';
     //  }else{
     //      $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
     //  }
     //  $slike6 = $dom -> createElement('slk6',  $nekretnine_slk6);
     //  $nekretnina -> appendChild($slike6);
     //
     //
     //  if($nekretnine_slk7 == 'http://nekretnine-tomislav.hr/slike/'){
     //    $nekretnine_slk7 = '';
     //  }else{
     //    $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
     //  }
     //  $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
     //  $nekretnina -> appendChild($slike7);
     //
     //
     // $Lat = $dom->createElement('lat', $nekretninaLat);
     // $nekretnina->appendChild($Lat);
     //
     // $Lon = $dom->createElement('lon', $nekretninaLon);
     // $nekretnina->appendChild($Lon);


     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', $GoogleKorKarta); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);






     //nekrenine pogled na more
    // if($nekretninaMorePogled == 0){
    //   $nekretninaMorePogled = "";
    // }else{
    //   $nekretninaMorePogled = "Pogled na more";
    // }

     // $morePogled = $dom->createElement('morePogled', $nekretninaMorePogled);
     // $nekretnina->appendChild($morePogled);

     $tekst = $dom->createElement('tekst', $nekretninaTekst);
     $nekretnina->appendChild($tekst);


     $root->appendChild($nekretnina);

   }

   $dom->appendChild($root);

   $dom->save($filePath);
   echo'<h1>Uspjeh , rješeni stanovi</h1>';

 }



 ?>
