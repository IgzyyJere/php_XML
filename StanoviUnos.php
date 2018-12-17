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
        $part = "&hl=es;z=14&amp;output=embed";
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
SELECT vivostanovi.id, grupe.naziv as 'vrsta', grupe.vrsta AS 'status',  zupanije.nazivZupanije, vivostanovi.mikrolokacija as 'kvart', vivostanovi.mjesto as 'grad',
vivostanovi.mjesto as 'naslov', vivostanovi.ukupnaPovrsina,
vivostanovi.cijena, vivostanovi.katValue as 'stan na katu', vivostanovi.ukupnoKat as 'ukupno katova',vivostanovi.brojEtaza, vivostanovi.grijanje,
vivostanovi.godinaIzgradnjeValue as 'godina izgradnje', vivostanovi.balkonOption, vivostanovi.telefon,
vivostanovi.loggiaOption, vivostanovi.vrtOption, vivostanovi.terasaOption, vivostanovi.lift, vivostanovi.stolarija,
vivostanovi.alarm, vivostanovi.protupozar, vivostanovi.protuprovala, vivostanovi.parket, vivostanovi.laminat, vivostanovi.klima,
vivostanovi.kabel, vivostanovi.satelit, vivostanovi.internet, vivostanovi.rostilj, vivostanovi.bazen, teksttransferstanovi.tekst, vivostanovi.supa, vivostanovi.parking,
vivostanovi.vlasnickiList, vivostanovi.osPosude, vivostanovi.perilica, vivostanovi.perilicaSuda, vivostanovi.zivotinje, vivostanovi.garazaOption, vivostanovi.kupaone,
vivostanovi.namjestaj, vivostanovi.brojSoba, vivostanovi.gradevinska, vivostanovi.uporabna, vivostanovi.orijentacija, vivostanovi.adaptacija, vivostanovi.morePogled,
vivostanovi.moreUdaljenost, vivostanovi.lon, vivostanovi.lat , slikestanovitransfer.slk1, slikestanovitransfer.slk2, slikestanovitransfer.slk3, slikestanovitransfer.slk4,
slikestanovitransfer.slk5, slikestanovitransfer.slk6, slikestanovitransfer.slk7, slikestanovitransfer.slk8, slikestanovitransfer.slk9,

vivostanovi.adresa

FROM vivostanovi
LEFT JOIN grupe ON vivostanovi.grupa = grupe.id
LEFT JOIN regije ON vivostanovi.regija = regije.id
LEFT JOIN zupanije ON vivostanovi.zupanija = zupanije.id
LEFT JOIN kvartovi ON kvartovi.id = vivostanovi.kvart
LEFT JOIN teksttransferstanovi ON  teksttransferstanovi.spojenoNa = vivostanovi.id
LEFT JOIN slikestanovitransfer ON slikestanovitransfer.ID_nekrenina = vivostanovi.id
where vivostanovi.aktivno = 1
order by vivostanovi.id asc;";



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
$counquery = "SELECT vivostanovi.id from vivostanovi";
$num_rows = $mysqli->query($counquery);
$num_rows = count($nekrsArray);

$str1= $num_rows;
$str2="Broj koji je prebaćen ";
echo "<h4>".$str1 . " " . $str2."</h4>";




/* close connection */
$mysqli->close();

function createXMLfile($nekrsArray){

   $filePath = 'nekretnine_stanovi.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('stan');

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

      $godinaIzgradnjeValue = $nekrsArray[$i]['godina izgradnje'];

      $nekretninaBalkon = $nekrsArray[$i]['balkonOption'];

      $nekretninaVrt = $nekrsArray[$i]['vrtOption'];

      $nekretninaTerasa = $nekrsArray[$i]['terasaOption'];

      $nekretninaLift = $nekrsArray[$i]['lift'];

      $nekretninaStolarija = $nekrsArray[$i]['stolarija'];

      $nekretninaAlarm = $nekrsArray[$i]['alarm'];

      $nekretninaProtuPozarni = $nekrsArray[$i]['protupozar'];

      $nekretninaProtuprovala = $nekrsArray[$i]['protuprovala'];

      $nekretninaParket = $nekrsArray[$i]['parket'];

      $nekretninaLaminat = $nekrsArray[$i]['laminat'];

      $nekretninaTelefon = $nekrsArray[$i]['telefon'];

      $nekretninaLogia = $nekrsArray[$i]['loggiaOption'];

      $nekretninaKlima = $nekrsArray[$i]['klima'];

      $nekretninaInternet = $nekrsArray[$i]['internet'];

      $nekretninaSatelitska = $nekrsArray[$i]['satelit'];

      $nekretninaKablovska = $nekrsArray[$i]['kabel'];

      $nekretninaRostilj = $nekrsArray[$i]['rostilj'];

      $nekretninaBazen = $nekrsArray[$i]['bazen'];

      $nekretninaSupa = $nekrsArray[$i]['supa'];

      $nekretninaParking = $nekrsArray[$i]['parking'];

      $nekretninaVlasnickiList = $nekrsArray[$i]['vlasnickiList'];

      $nekretninaPerilica = $nekrsArray[$i]['perilica'];

      $nekretninaPerilicaS = $nekrsArray[$i]['perilicaSuda'];

      $nekretninaZivotinje = $nekrsArray[$i]['zivotinje'];

      $nekreninaGaraga = $nekrsArray[$i]['garazaOption'];

      $nekreninaBrojKupaona = $nekrsArray[$i]['kupaone'];

      $nekretninaNamjestaj =  $nekrsArray[$i]['namjestaj'];

      $nekretninaBrSoba =  $nekrsArray[$i]['brojSoba'];

      $nekretninaGradjevniska =  $nekrsArray[$i]['gradevinska'];

      $nekretninaUporabna =  $nekrsArray[$i]['uporabna'];

      $nekretninaOrijentacija =  $nekrsArray[$i]['orijentacija'];

      $nekretninaAdaptacija =  $nekrsArray[$i]['adaptacija'];

      $nekrMikrolokacija  = $nekrsArray[$i]['kvart'];

      $nekretninaAdresa = $nekrsArray[$i]['adresa'];

      $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);


      //slike
      $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
      $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      $nekretnine_slk7 = $nekrsArray[$i]['slk7'];
      $nekretnine_slk8 = $nekrsArray[$i]['slk8'];
      $nekretnine_slk9 = $nekrsArray[$i]['slk9'];


      $nekretninaLat  =  $nekrsArray[$i]['lat'];
      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);

     $nekretninaMoreUdaljenost = $nekrsArray[$i]['moreUdaljenost'];

      $nekretninaMorePogled = $nekrsArray[$i]['morePogled'];

      $nekretninaTekst = $nekrsArray[$i]['tekst'];
      $nekretninaTekst = strip_tags($nekretninaTekst);

      $nekretnina = $dom->createElement('post');

     if($nekrNaslov == "" || $nekrNaslov == 0){

       if($nekretninaMjesto == ""){
           $naslovM = $nekrZupanija;
       }
       else{$naslovM = $nekretninaMjesto;}
     }else{

       $naslovM = $nekrNaslov;
     }



    if(is_numeric($nekrID) == 2108 || is_numeric($nekrID) == 2139 || is_numeric($nekrID) == 2317 || is_numeric($nekrID) == 2339 || is_numeric($nekrID) == 2372 ||
       is_numeric($nekrID) == 2470 || is_numeric($nekrID) == 2530 || is_numeric($nekrID) == 2635 || is_numeric($nekrID) == 2926 || is_numeric($nekrID) == 3210 ||
       is_numeric($nekrID) == 3332 || is_numeric($nekrID) == 3356 || is_numeric($nekrID) == 3527 ||  is_numeric($nekrID) == 3539 ||  is_numeric($nekrID) == 3541 ||
       is_numeric($nekrID) == 3541 || is_numeric($nekrID) == 3582 || is_numeric($nekrID) == 3587 || is_numeric($nekrID) == 3592 || is_numeric($nekrID) == 3610 ||
       is_numeric($nekrID) == 3617 || is_numeric($nekrID) == 3619 || is_numeric($nekrID) == 3629 || is_numeric($nekrID) == 3647 || is_numeric($nekrID) == 3648 ||
       is_numeric($nekrID) == 3670 || is_numeric($nekrID) == 3683 || is_numeric($nekrID) == 3686 || is_numeric($nekrID) == 3687 || is_numeric($nekrID) == 3714 ||
       is_numeric($nekrID) == 3716 || is_numeric($nekrID) == 3735 || is_numeric($nekrID) == 3741 || is_numeric($nekrID) == 3743 || is_numeric($nekrID) == 3761 ||
       is_numeric($nekrID) == 3778 || is_numeric($nekrID) == 3781 || is_numeric($nekrID) == 3794 || is_numeric($nekrID) == 3801 || is_numeric($nekrID) == 3808 ||
       is_numeric($nekrID) == 3836 || is_numeric($nekrID) == 3838 || is_numeric($nekrID) == 3841 || is_numeric($nekrID) == 3848 || is_numeric($nekrID) == 3852 ||
       is_numeric($nekrID) == 3853 || is_numeric($nekrID) == 3870 || is_numeric($nekrID) == 3871 || is_numeric($nekrID) == 3875 || is_numeric($nekrID) == 3881 ||
       is_numeric($nekrID) == 3888 || is_numeric($nekrID) == 3896 || is_numeric($nekrID) == 3909 || is_numeric($nekrID) == 3910 || is_numeric($nekrID) == 3911 ||
       is_numeric($nekrID) == 3912 || is_numeric($nekrID) == 3915 || is_numeric($nekrID) == 3917 || is_numeric($nekrID) == 3927 || is_numeric($nekrID) == 3929 ||
       is_numeric($nekrID) == 3931 || is_numeric($nekrID) == 3939 || is_numeric($nekrID) == 3942 || is_numeric($nekrID) == 3944 || is_numeric($nekrID) == 3949 ||
       is_numeric($nekrID) == 3953 || is_numeric($nekrID) == 3957 || is_numeric($nekrID) == 3958 || is_numeric($nekrID) == 3962 || is_numeric($nekrID) == 3963 ||
       is_numeric($nekrID) == 3967 || is_numeric($nekrID) == 3969 || is_numeric($nekrID) == 3977 || is_numeric($nekrID) == 3978 || is_numeric($nekrID) == 3979 ||
       is_numeric($nekrID) == 3980 || is_numeric($nekrID) == 3983 || is_numeric($nekrID) == 3985 || is_numeric($nekrID) == 3986 || is_numeric($nekrID) == 3988 ||
       is_numeric($nekrID) == 3990 || is_numeric($nekrID) == 3991 || is_numeric($nekrID) == 3993 || is_numeric($nekrID) == 3998 || is_numeric($nekrID) == 3999 ||
       is_numeric($nekrID) == 4004 || is_numeric($nekrID) == 4005 || is_numeric($nekrID) == 4006 || is_numeric($nekrID) == 4007 || is_numeric($nekrID) == 4008 ||
       is_numeric($nekrID) == 4011 || is_numeric($nekrID) == 4013 || is_numeric($nekrID) == 4014 || is_numeric($nekrID) == 4015 || is_numeric($nekrID) == 4016 ||
       is_numeric($nekrID) == 4017 || is_numeric($nekrID) == 4018 || is_numeric($nekrID) == 4021 || is_numeric($nekrID) == 4022 || is_numeric($nekrID) == 4025  ){
      $naslovM == 'Zagreb';
    }

    if(is_numeric($nekrID) == 2264 || is_numeric($nekrID) == 2284 || is_numeric($nekrID) == 2285 || is_numeric($nekrID) == 3280 || is_numeric($nekrID) == 3331){
      $naslovM = 'Primorsko-goranska';
    }

    if(is_numeric($nekrID) == 2274 || is_numeric($nekrID) == 2514){
      $naslovM = 'Istarska';
    }

    if(is_numeric($nekrID) == 2459 || is_numeric($nekrID) == 2630){
      $naslovM = 'Splitsko-dalmatinska';
    }

    if(is_numeric($nekrID) == 2492){
      $naslovM = 'Zagrebačka';
    }

    if(is_numeric($nekrID) == 2883 || is_numeric($nekrID) == 3315 ||  is_numeric($nekrID) == 3961){
      $naslovM = 'Ličko-senjska';
    }

    if(is_numeric($nekrID) == 3917 || is_numeric($nekrID) == 3918 || is_numeric($nekrID) == 3920 || is_numeric($nekrID) == 3921 || is_numeric($nekrID) == 3922){
      $naslovM = 'Šibensko-kninska';
    }

    if(is_numeric($nekrID) == 3952 || is_numeric($nekrID) == 3960){
      $naslovM = 'Zadarska';
    }





     $IDNk = $dom-> createElement('id', $naslovM . " - ".$nekrID .", ". $nekrVrsta);
     $nekretnina->appendChild($IDNk);

     $naslov  = $dom->createElement('naslov', $naslovM . " - ".$nekrID . ", ".$nekrVrsta);
     $nekretnina->appendChild($naslov);

    // $naslovM = ''; //prazni varijablu
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
     //  src="'.$GoogleKarta = mapa($nekretninaAdresa, "", "").'"
     //  width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
     //  </iframe> <br/>';
     // echo $nekretninaAdresa;
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


     $cijena  = $dom->createElement('cijena', $nekretninaCijena );
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('grad', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);


     //kat
     if(is_numeric($nekretninaKat) == 0 || trim($nekretninaKat) == '0' || is_null($nekretninaKat)){
       $nekretninaKat =  '';
     }else{
       $nekretninaKat = 'Kat '.$nekretninaKat;
     }
     $kat  = $dom->createElement('Kat', $nekretninaKat);
     $nekretnina ->appendChild($kat);



     //broj katova
     if(is_numeric($nekretninaUkupnoKat) < 1 || trim($nekretninaUkupnoKat) == '' || is_null($nekretninaUkupnoKat)){
         $nekretninaUkupnoKat = '';
     }else{
         $nekretninaUkupnoKat = 'Zgrada ima katova : '.$nekretninaUkupnoKat;
     }
     $Broj_kat  = $dom->createElement('broj_kat', $nekretninaUkupnoKat);
     $nekretnina ->appendChild($Broj_kat);

     $Broj_etaza  = $dom->createElement('broj_etaza', $nekretninaEtaza);
     $nekretnina ->appendChild($Broj_etaza);


     //godina izgradnje
     if(is_numeric($godinaIzgradnjeValue) < 1 || trim($godinaIzgradnjeValue) == '' || is_null($godinaIzgradnjeValue)){
       $godinaIzgradnjeValue = '';
     }else{
       $godinaIzgradnjeValue = 'Godina izgradnje : '.$godinaIzgradnjeValue;
     }
     $godinaIzgradnje = $dom ->createElement('GodinaGradnje', $godinaIzgradnjeValue);
     $nekretnina -> appendChild($godinaIzgradnje);


     if( is_numeric($nekretninaBalkon == 0) || is_null($nekretninaBalkon) || $nekretninaBalkon == ''){
       $nekretninaBalkon = '';
     }else{
       $nekretninaBalkon = 'Balkon';
     }
     $balkon = $dom ->createElement('balkon', $nekretninaBalkon);
     $nekretnina -> appendChild($balkon);


     if(is_numeric($nekretninaLogia) == 0 || is_null($nekretninaLogia) || $nekretninaLogia == ''){
       $nekretninaLogia = '';
     }else{
       $nekretninaLogia = 'Lođa';
     }
     $logia = $dom ->createElement('lođa', $nekretninaLogia);
     $nekretnina -> appendChild($logia);


     if(is_numeric($nekretninaVrt) == 0 || is_null($nekretninaVrt) || $nekretninaVrt == ''){
       $nekretninaVrt = '';
     }else{
       $nekretninaVrt = 'Vrt';
     }
     $vrt = $dom ->createElement('vrt', $nekretninaVrt);
     $nekretnina -> appendChild($vrt);

     if(is_numeric($nekretninaTerasa ) == 0|| is_null($nekretninaTerasa) || $nekretninaTerasa == ''){
      $nekretninaTerasa = '';
     }else{
         $nekretninaTerasa = 'Terasa';
     }
     $terasa = $dom ->createElement('terasa',   $nekretninaTerasa);
     $nekretnina -> appendChild($terasa);



     if($nekretninaLift == '0' || $nekretninaLift == 0 || $nekretninaLift == ''){
      $nekretninaLift = '';
     }else{
      $nekretninaLift = 'Lift';
     }
     $lift = $dom ->createElement('lift',   $nekretninaLift);
     $nekretnina -> appendChild($lift);



     //stolarija
     if(trim($nekretninaStolarija == '0') || is_numeric($nekretninaStolarija == 0) || is_null($nekretninaStolarija)){
      $nekretninaStolarija = '';
      }elseif($nekretninaStolarija == 1){
           $nekretninaStolarija = 'Stolarija';
      }elseif($nekretninaStolarija == 2){
       $nekretninaStolarija = 'Stolarija';
      }elseif($nekretninaStolarija == 3){
       $nekretninaStolarija = 'Stolarija';
      }elseif($nekretninaStolarija > 3){
       $nekretninaStolarija = 'Stanje stolarije je - odlično';}
     $stolarija = $dom ->createElement('Stolarija',   $nekretninaStolarija);
     $nekretnina -> appendChild($stolarija);


     if($nekretninaAlarm == '0' || $nekretninaAlarm == 0 || $nekretninaAlarm == ''){
      $nekretninaAlarm = '';
     }else{
        $nekretninaAlarm = 'Alarm instaliran';
     }
     $alarm = $dom ->createElement('alarm', $nekretninaAlarm);
     $nekretnina -> appendChild($alarm);


     if($nekretninaProtuPozarni  == '0' || $nekretninaProtuPozarni == ''){
      $nekretninaProtuPozarni  = '';
     }else{
        $nekretninaProtuPozarni  = 'Protupožarni alarm';
     }
     $pozarni = $dom ->createElement('protuPozarniAlaram', $nekretninaProtuPozarni);
     $nekretnina -> appendChild($pozarni);


     if($nekretninaProtuprovala  == '0' || $nekretninaProtuprovala == ''){
      $nekretninaProtuprovala  = '';
     }else{
      $nekretninaProtuprovala  = 'Protuprovalni alarm';
     }
     $provalni = $dom ->createElement('protuProvalni', $nekretninaProtuprovala);
     $nekretnina -> appendChild($provalni);


     if($nekretninaParket  == '0'){
      $nekretninaParket  = '';
     }else{
      $nekretninaParket = 'Podni parket';
     }
     $parket = $dom ->createElement('parket', $nekretninaParket);
     $nekretnina -> appendChild($parket);
    // //
     if($nekretninaLaminat  == '0'){
      $nekretninaLaminat  = '';
     }else{
      $nekretninaLaminat = 'Podni laminat';
     }
     $laminat = $dom ->createElement('laminat', $nekretninaLaminat);
     $nekretnina -> appendChild($laminat);

     //nekretnine features

     //ima nema grijanje
      if($nekretninaGrijanje == '0'){
          $nekretninaGrijanje = '';
      }else{
          $nekretninaGrijanje = 'Ugrađeno Grijanje';
      }

      $grijanje = $dom -> createElement('Grijanje', $nekretninaGrijanje);
      $nekretnina -> appendChild($grijanje);;



     // // nekrenine telefon
     if($nekretninaTelefon == 0){
       $nekretninaTelefon = '';
     }else{
       $nekretninaTelefon = 'Telefon (infrastruktura ili upotreba)';
     }

     $tel = $dom -> createElement('Telefon', $nekretninaTelefon);
     $nekretnina -> appendChild($tel);


     //nekrenine klima
    if($nekretninaKlima == 0){
      $nekretninaKlima = '';
    }else{
      $nekretninaKlima = 'Instalirana Klima';
    }

    $klima = $dom -> createElement('Klima', $nekretninaKlima);
    $nekretnina -> appendChild($klima);


      //nekrenine internet
      if($nekretninaInternet == 0){
        $nekretninaInternet = '';
      }else{
        $nekretninaInternet = 'Internet (infrastruktura ili instalacija)';
      }

      $internet = $dom -> createElement('Internet', $nekretninaInternet);
      $nekretnina -> appendChild($internet);


     //nekrenine satelitska
     if($nekretninaSatelitska == '0'){
           $nekretninaSatelitska = '';
     }else{
           $nekretninaSatelitska = 'Satelitska (instalacija)';
     }
      $satelitska = $dom -> createElement('Instalirana_satelitska', $nekretninaSatelitska);
      $nekretnina -> appendChild($satelitska);


     //nekrenine kablovska
    if($nekretninaKablovska == '0'){
          $nekretninaKablovska = '';
    }else{
          $nekretninaKablovska = 'Kablovska (infrastruktura)';
    }

     $kabel = $dom -> createElement('Kablovska_tv', $nekretninaKablovska);
     $nekretnina -> appendChild($kabel);


    //roštilj
    if($nekretninaRostilj == '0'){
          $nekretninaRostilj = '';
    }else{
          $nekretninaRostilj = 'Ugrađen roštilj';
    }

     $rostilj = $dom -> createElement('Roštilj', $nekretninaRostilj);
     $nekretnina -> appendChild($rostilj);


     //bazen
     if($nekretninaBazen == '0'){
           $nekretninaBazen = '';
     }else{
          $nekretninaBazen = 'Bazen';
     }

      $bazen = $dom -> createElement('Bazen', $nekretninaBazen);
      $nekretnina -> appendChild($bazen);


      //šupa
      if(is_numeric($nekretninaSupa) == 0 || is_null($nekretninaSupa) || trim($nekretninaSupa) =='0'){
            $nekretninaSupa = '';
      }else{
           $nekretninaSupa = 'Šupa';
      }

       $supa = $dom -> createElement('Supa', $nekretninaSupa);
       $nekretnina -> appendChild($supa);


     //
     //   //parking
       if(trim($nekretninaParking) == '0' || is_numeric($nekretninaParking) < 1 || is_null($nekretninaParking)){
             $nekretninaParking = '';
       }else{
            $nekretninaParking = 'Parking mjesta '.$nekretninaParking;
       }

        $parking = $dom -> createElement('Parking', $nekretninaParking);
        $nekretnina -> appendChild($parking);


        //vlasnicki list
        if($nekretninaVlasnickiList == '0'){
              $nekretninaVlasnickiList = '';
        }else{
             $nekretninaVlasnickiList = 'Vlasnički list';
        }

         $vlasnik = $dom -> createElement('vlasnicki_List', $nekretninaVlasnickiList);
         $nekretnina -> appendChild($vlasnik);

         //perilica
         if($nekretninaPerilica == '0'){
               $nekretninaPerilica = '';
         }else{
              $nekretninaPerilica = 'Perilica';
         }

          $peri = $dom -> createElement('Perilica', $nekretninaPerilica);
          $nekretnina -> appendChild($peri);


          //perilica sudja
          if($nekretninaPerilicaS == '0'){
                $nekretninaPerilicaS = '';
          }else{
               $nekretninaPerilicaS = 'Perilica suđa';
          }

           $periS = $dom -> createElement('Perilica_posudje', $nekretninaPerilicaS);
           $nekretnina -> appendChild($periS);


           //životinje
           if($nekretninaZivotinje == '0'){
                  $nekretninaZivotinje = '';
           }else{
                 $nekretninaZivotinje = 'Životinje dozvoljene';
           }
            $ziv = $dom -> createElement('Zivotinje',  $nekretninaZivotinje);
            $nekretnina -> appendChild($ziv);



            //garažarray
            if($nekreninaGaraga == '0'){
                   $nekreninaGaraga = '';
            }else{
                $nekreninaGaraga= 'Garaža';
            }
             $garage = $dom -> createElement('Garaža',  $nekreninaGaraga);
             $nekretnina -> appendChild($garage);


             //broj kupaona
             if(trim($nekreninaBrojKupaona) == '' || is_null($nekreninaBrojKupaona) || is_numeric($nekreninaBrojKupaona)){
                    $nekreninaBrojKupaona = '1';
             }else{
                 $nekreninaBrojKupaona = $nekreninaBrojKupaona;
             }
             $kupaonaBr = $dom -> createElement('Broj_kupaona', $nekreninaBrojKupaona);
             $nekretnina -> appendChild($kupaonaBr);



              //namještaj
              if($nekretninaNamjestaj == '0'){
                     $nekretninaNamjestaj = '';
              }else{
                  $nekretninaNamjestaj = 'Namjestaj';
              }
              $namjestaj = $dom -> createElement('Namjestaj',  $nekretninaNamjestaj);
              $nekretnina -> appendChild($namjestaj);

              //broj soba $nekretninaBrSoba
              if($nekretninaBrSoba == '0'){
                     $nekretninaBrSoba = 'Broj soba - 1';
                     $brojSoba = 1;
              }else{
                  $brojSoba = $nekretninaBrSoba;
                  $nekretninaBrSoba = 'Broj soba - '.$nekretninaBrSoba;

              }
              $sobe = $dom -> createElement('Broj_soba',  $brojSoba);
              $nekretnina -> appendChild($sobe);

              $SobaBroj = $dom -> createElement('Broj_sobaNum', $brojSoba);
              $nekretnina -> appendChild($SobaBroj);


              //građevinska dozvola
              if($nekretninaGradjevniska == '0'){
                     $nekretninaGradjevniska = '';
              }else{
                  $nekretninaGradjevniska = 'Građevinska dozvola';
              }
              $gradevisnka = $dom -> createElement('Gradevisnka_dozvola',  $nekretninaGradjevniska);
              $nekretnina -> appendChild($gradevisnka);


              //uporabna dozvola $nekretninaUporabna
              if($nekretninaUporabna == '0'){
                     $nekretninaUporabna = '';
              }else{
                  $nekretninaUporabna = 'Uporabna dozvola';
              }
              $uporabna = $dom -> createElement('Uporabna_dozvola',  $nekretninaUporabna);
              $nekretnina -> appendChild($uporabna);


              //orijentacija $nekretninaOrijentacija
              if($nekretninaOrijentacija == '0'){
                     $nekretninaOrijentacija = '';
              }else{
                  $nekretninaOrijentacija = 'Orijentacija :'.$nekretninaOrijentacija;
              }
              $orijentacija = $dom -> createElement('Orijentacija',  $nekretninaOrijentacija);
              $nekretnina -> appendChild($orijentacija);



              //adaptacija  $nekretninaAdaptacija
              $adap = $dom -> createElement('adaptacija',  $nekretninaAdaptacija);
              $nekretnina -> appendChild($adap);


     $moreUda = $dom->createElement('UdaljenostMore', $nekretninaMoreUdaljenost);
     $nekretnina->appendChild($moreUda);




      //slike
      if($nekretnine_slk1 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
       $nekretnine_slk1 = '';
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


      if($nekretnine_slk8 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
        $nekretnine_slk8 = '';
      }else{
        $slike8 = $dom -> createElement('slk8',  $nekretnine_slk8);
      }
      $slike8 = $dom -> createElement('slk8',  $nekretnine_slk8);
      $nekretnina -> appendChild($slike8);


      if($nekretnine_slk9 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
        $nekretnine_slk9 = '';
      }else{
        $slike9 = $dom -> createElement('slk9',  $nekretnine_slk9);
      }
      $slike9 = $dom -> createElement('slk9',  $nekretnine_slk9);
      $nekretnina -> appendChild($slike9);

     //
     //
     //
     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);

     if($nekrID == 3990 & $nekrID == 3952 & $nekrID == 3922 & $nekrID == 3921 & $nekrID == 3918 & $nekrID == 3881)
     {
       $GoogleKarta = '';
     }

     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', htmlEntities($GoogleKorKarta)); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);

     //
     //
     //
     // //nekrenine pogled na more
      if($nekretninaMorePogled == 0){
        $nekretninaMorePogled = '';
      }else{
        $nekretninaMorePogled = "Pogled na more";
      }
     $morePogled = $dom->createElement('morePogled', $nekretninaMorePogled);
     $nekretnina->appendChild($morePogled);


     $tekst = $dom->createElement('tekst', $nekretninaTekst);
     $nekretnina->appendChild($tekst);


     if(trim($nekretninaAdresa) == '' || is_null($nekretninaAdresa)){
       $nekretninaAdresa = '';
     }else{
       $nekretninaAdresa = 'Adresa : '.$nekretninaAdresa;
     }
     $adresa = $dom->createElement('adresa', $nekretninaAdresa);
     $nekretnina->appendChild($adresa);


      $root->appendChild($nekretnina);

   }

   $dom->appendChild($root);

   $dom->save($filePath);
   echo'<h1>Uspjeh , rješeni stanovi</h1>';
 }
 ?>
