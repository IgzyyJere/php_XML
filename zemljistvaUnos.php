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
  $part = "()&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed";
  $mapa_emb = $mapa.$ulica_naziv."%20".$brojulica."%20".$grad."%2C%20".$drzava.$part;

  //echo $mapa_emb;
  return $mapa_emb;


}



function mapaLtd($lat_, $lon_)
{
  $mapa = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=";

  $lat = $lat_;
  $lon = $lon_;


  $part = "&amp;q=+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed";
  $mapa_emb = $mapa.$lat.",".$lon.$part;

//  $mapa_emb = "<iframe width="100%" height="600" src="'".$mapa_emb.";

  //echo $mapa_emb;
 return $mapa_emb;


}




// $query = "SELECT* FROM grupe";

$query = "
SELECT vivozemljista.id, grupe.naziv AS 'vrsta', grupe.vrsta AS 'status', vivozemljista.regija, regije.naziv as 'zemlja', vivozemljista.zupanija, zupanije.nazivZupanije,
vivozemljista.mikrolokacija, vivozemljista.povrsina, vivozemljista.cijena, vivozemljista.mjesto as 'grad', vivozemljista.adresa, vivozemljista.vlasnickiList, vivozemljista.sirina,
vivozemljista.duzina, vivozemljista.napomena, vivozemljista.struja, vivozemljista.voda, vivozemljista.kanalizacija, vivozemljista.plin, vivozemljista.telefon,
vivozemljista.gradevinska, kvartovi.naziv AS 'kvart',  vivozemljista.datoteke, vivozemljista.lat, vivozemljista.lon, vivozemljista.agent, vivozemljista.mjesto  AS 'naslov',
vivozemljista.moreUdaljenost, vivozemljista.morePogled, teksttransferzemlja.tekst, slikezemljista.slk1, slikezemljista.slk2,
slikezemljista.slk3, slikezemljista.slk4, slikezemljista.slk5, slikezemljista.slk6, slikezemljista.slk7
FROM vivozemljista LEFT JOIN grupe ON vivozemljista.grupa = grupe.id
LEFT JOIN regije ON vivozemljista.regija = regije.id
LEFT JOIN zupanije ON vivozemljista.zupanija = zupanije.id
LEFT JOIN kvartovi ON kvartovi.id = vivozemljista.kvart
LEFT JOIN teksttransferzemlja ON vivozemljista.id = teksttransferzemlja.spojenoNa
LEFT JOIN slikezemljista ON slikezemljista.ID_nekrenina = vivozemljista.id
where vivozemljista.aktivno = 1 AND vivozemljista.id > 320 AND vivozemljista.id < 450;";

//where vivozemljista.aktivno = 1 AND vivozemljista.id < 207;";
//where vivozemljista.aktivno = 1 AND vivozemljista.id > 207 AND vivozemljista.id < 220;";
//where vivozemljista.aktivno = 1 AND vivozemljista.id > 220 AND vivozemljista.id < 320;";


//stao si na mjesto problem


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

   $filePath = 'nekretnine_zemlja_1.xml';

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

      $nekretninaPovrsina  =  $nekrsArray[$i]['povrsina'];

      $nekretninaCijena  =  $nekrsArray[$i]['cijena'];

      $nekretninaMjesto =   $nekrsArray[$i]['grad']; // grad

      $nekretninaAdresa =  $nekrsArray[$i]['adresa'];

      $nekrenineKvart = $nekrsArray[$i]['kvart']; //kvart

      $nekretninaVlList = $nekrsArray[$i]['vlasnickiList'];

      $nekretninaSirina = $nekrsArray[$i]['sirina'];

      $nekretninaDuzina = $nekrsArray[$i]['duzina'];

      $nekretninaStruja = $nekrsArray[$i]['struja'];

      $nekretninaVoda = $nekrsArray[$i]['voda'];

      $nekreninaKanalizacija = $nekrsArray[$i]['kanalizacija'];

      $nekreninaPlin = $nekrsArray[$i]['plin'];

      $instalacijaTel =  $nekrsArray[$i]['telefon'];

      $nekrMikrolokacija = $nekrsArray[$i]['mikrolokacija'];

      $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);


    //  $nekretninaAgent  =  $nekrsArray[$i]['imeIPrezime'];

      $nekretninaNap  =  $nekrsArray[$i]['napomena'];

      //$nekretninaSlike  =  $nekrsArray[$i]['slike'];
      $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
      $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      $nekretnine_slk7 = $nekrsArray[$i]['slk7'];

    //  $nekretninaVrstPonude  =  $nekrsArray[$i]['vrstaPonude'];

      $nekretninaLat  =  $nekrsArray[$i]['lat'];

      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);

      $nekretninaAgent_1  =  $nekrsArray[$i]['agent'];

      $nekretninaMoreUdaljenost = $nekrsArray[$i]['moreUdaljenost'];

      $nekretninaMorePogled = $nekrsArray[$i]['morePogled'];

      $nekretninaTekst = $nekrsArray[$i]['tekst'];
      $nekretninaTekst = strip_tags($nekretninaTekst);

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

     $kvart = $dom->createElement('kvart', $nekrenineKvart);
     $nekretnina -> appendChild($kvart);

     $povrsina  = $dom->createElement('povrsina', $nekretninaPovrsina);
     $nekretnina->appendChild($povrsina);

     $cijena  = $dom->createElement('cijena', $nekretninaCijena );
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('grad', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);

     $adresa = $dom->createElement('adresa', $nekretninaAdresa);
     $nekretnina->appendChild($adresa);

     if($nekretninaVlList == 0)   {
       $nekretninaVlList = "nema";
     }
     else {
       $nekretninaVlList = "ima";
     }

     $vlasnickiList = $dom -> createElement('vlasnickiList', $nekretninaVlList);
     $nekretnina -> appendChild($vlasnickiList);

     $sirina = $dom -> createElement('sirina', $nekretninaSirina);
     $nekretnina -> appendChild($sirina);

     $duzina = $dom -> createElement('duzina', $nekretninaDuzina);
     $nekretnina -> appendChild($duzina);


      //nekrenine struja
     if($nekretninaStruja == 0){
       $nekretninaStruja = 'nema';
     }else{
       $nekretninaStruja = 'ima';
     }

     $struja = $dom -> createElement('struja', $nekretninaStruja);
     $nekretnina -> appendChild($struja);


     //nekrenine voda
    if($nekretninaVoda == '0'){
          $nekretninaVoda = 'nema';
    }else{
          $nekretninaVoda = 'ima';
    }

     $voda = $dom -> createElement('voda', $nekretninaVoda);
     $nekretnina -> appendChild($voda);

     //nekrenine kanalizacija
    if($nekreninaKanalizacija == '0'){
        $nekreninaKanalizacija = 'nema';
    }else{
        $nekreninaKanalizacija = 'ima';
    }

     $kanalizacija = $dom -> createElement('kanalizacija', $nekreninaKanalizacija);
     $nekretnina -> appendChild($kanalizacija);

     //nekrenine plin
    if($nekreninaPlin == '0'){
      $nekreninaPlin = 'nema';
    }else{
      $nekreninaPlin = 'ima';
    }

     $plin = $dom -> createElement('plin', $nekreninaPlin);
     $nekretnina -> appendChild($plin);

     //nekrenine plin
    if($instalacijaTel == '0'){
      $instalacijaTel = "nema";
    }else{
      $instalacijaTel = "ima";
    }

     $instalacijaTel = $dom -> createElement('telefon');
     $nekretnina -> appendChild($instalacijaTel);



     $napomena = $dom->createElement('napomena', $nekretninaNap);
     $nekretnina->appendChild($napomena);



     //slike
     if($nekretnine_slk1 == 'http://nekretnine-tomislav.hr/slike/'){
      $nekretnine_slk1 = '';
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


     if($nekretnine_slk7 == 'http://nekretnine-tomislav.hr/slike/'){
       $nekretnine_slk7 = '';
     }else{
       $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
     }
     $slike7 = $dom -> createElement('slk7',  $nekretnine_slk7);
     $nekretnina -> appendChild($slike7);






     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);


     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', $GoogleKorKarta); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);

     $agent_1 = $dom->createElement('agent', $nekretninaAgent_1);
     $nekretnina->appendChild($agent_1);

    // $pdf_ = $dom->createElement('tlocrtPDF', $nekretninaPdf);
    // $nekretnina->appendChild($pdf_);

     $moreUda = $dom->createElement('moreUdaljenost', $nekretninaMoreUdaljenost);
     $nekretnina->appendChild($moreUda);


     //nekrenine pogled na more
    if($nekretninaMorePogled == 0){
      $nekretninaMorePogled = "pogled na more";
    }else{
      $nekretninaMorePogled = "nema pogleda na more";
    }
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
