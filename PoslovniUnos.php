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
SELECT vivoposlovni.id, grupe.naziv as 'vrsta', grupe.vrsta AS 'status',  zupanije.nazivZupanije, vivoposlovni.mikrolokacija as 'kvart', vivoposlovni.mjesto as 'grad',
vivoposlovni.mjesto as 'naslov', vivoposlovni.ukupnaPovrsina, vivoposlovni.cijena, vivoposlovni.cijena, vivoposlovni.katValue as 'stan na katu',
vivoposlovni.ukupnoKat as 'ukupno katova', vivoposlovni.grijanje,  vivoposlovni.stanje, vivoposlovni.godinaIzgradnjeValue, vivoposlovni.brojProstorija, vivoposlovni.lift,
vivoposlovni.stolarija, vivoposlovni.alarm, vivoposlovni.protupozar, vivoposlovni.protuprovala, vivoposlovni.parket, vivoposlovni.laminat, vivoposlovni.klima, vivoposlovni.kabel,
vivoposlovni.satelit, vivoposlovni.internet, vivoposlovni.mozdaStambeni, vivoposlovni.teretniLift, vivoposlovni.izlog, vivoposlovni.mreza, vivoposlovni.supa,
vivoposlovni.vlasnickiList, vivoposlovni.parking, vivoposlovni.telefon, vivoposlovni.sanitarni, vivoposlovni.cajnaKuhinja, vivoposlovni.garazaValue, vivoposlovni.brojEtaza,
vivoposlovni.namjestaj, vivoposlovni.prijevoz, vivoposlovni.gradevinska, vivoposlovni.uporabna, vivoposlovni.kombinacija, vivoposlovni.orijentacija,
vivoposlovni.adaptacija, vivoposlovni.skladiste, vivoposlovni.morePogled, vivoposlovni.moreUdaljenost, vivoposlovni.pologOption, vivoposlovni.naslovoglasa,
sliketransferposlovno.slk1, sliketransferposlovno.slk2, sliketransferposlovno.slk3, sliketransferposlovno.slk4, sliketransferposlovno.slk5, sliketransferposlovno.slk6,
sliketransferposlovno.slk7, sliketransferposlovno.slk8, sliketransferposlovno.slk9, teksttransferposlovno.tekst,
vivoposlovni.lat, vivoposlovni.lon

from vivoposlovni
LEFT JOIN grupe ON vivoposlovni.grupa = grupe.id
LEFT JOIN regije ON vivoposlovni.regija = regije.id
LEFT JOIN zupanije ON vivoposlovni.zupanija = zupanije.id
LEFT JOIN sliketransferposlovno ON vivoposlovni.id = sliketransferposlovno.ID_nekrenina
LEFT JOIN teksttransferposlovno ON vivoposlovni.id = teksttransferposlovno.spojenoNa
where vivoposlovni.aktivno = 1";



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
$counquery = "SELECT vivoposlovni.id from vivostanovi";
$num_rows = $mysqli->query($counquery);
$num_rows = count($nekrsArray);

$str1= $num_rows;
$str2="Broj koji je prebaćen ";
echo "<h4>".$str1 . " " . $str2."</h4>";




/* close connection */
$mysqli->close();

function createXMLfile($nekrsArray){

   $filePath = 'nekretnine_poslovni.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('stan');

   for($i=0; $i<count($nekrsArray); $i++){

     $nekrID  =  $nekrsArray[$i]['id'];

     $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

     $nekrStatus  =  $nekrsArray[$i]['status'];

     $nekrNaslov  =  $nekrsArray[$i]['naslov'];

     $nekretnineNaslovOglasa = $nekrsArray[$i]['naslovoglasa'];

     $nekrZupanija =  $nekrsArray[$i]['nazivZupanije'];

      $nekretninaPovrsina  =  $nekrsArray[$i]['ukupnaPovrsina'];

      $nekretninaMjesto =   $nekrsArray[$i]['grad']; // grad

      $nekrenineKvart = $nekrsArray[$i]['kvart']; //kvart

      $nekretninaCijena  =  $nekrsArray[$i]['cijena'];

      $nekretninaKat  =  $nekrsArray[$i]['stan na katu'];

      $nekretninaUkupnoKat  =  $nekrsArray[$i]['ukupno katova'];

      $nekretninaCajnaKuhinja  =  $nekrsArray[$i]['cajnaKuhinja'];

      $nekretninaGrijanje = $nekrsArray[$i]['grijanje'];

      $godinaIzgradnjeValue = $nekrsArray[$i]['godinaIzgradnjeValue'];

      $brojPoslovanja = $nekrsArray[$i]['brojProstorija'];

      $StanbeniKredit = $nekrsArray[$i]['mozdaStambeni'];

      $nekretninaGarazaV = $nekrsArray[$i]['garazaValue'];

      $nekretninaEtaza  =  $nekrsArray[$i]['brojEtaza'];

      $nekretninaNamjestaj = $nekrsArray[$i]['namjestaj'];


      $nekretninaPrijevoz = $nekrsArray[$i]['prijevoz'];
     //
     //  $nekretninaVrt = $nekrsArray[$i]['vrtOption'];
     //
     //  $nekretninaTerasa = $nekrsArray[$i]['terasaOption'];
     //
      $nekretninaLift = $nekrsArray[$i]['lift'];

      $nekretninaTeretniLift = $nekrsArray[$i]['teretniLift'];

      $nekretninaSkladiste = $nekrsArray[$i]['skladiste'];

      $nekretninaStolarija = $nekrsArray[$i]['stolarija'];

       $nekretninaAlarm = $nekrsArray[$i]['alarm'];

      $nekretninaProtuPozarni = $nekrsArray[$i]['protupozar'];

      $nekretninaProtuprovala = $nekrsArray[$i]['protuprovala'];

      $nekretninaParket = $nekrsArray[$i]['parket'];

      $nekretninaLaminat = $nekrsArray[$i]['laminat'];

      $nekretnineIzlog = $nekrsArray[$i]['izlog'];

      $nekretninaTelefon = $nekrsArray[$i]['telefon'];

    //   $nekretninaLogia = $nekrsArray[$i]['loggiaOption'];
     //

      $nekretninaSanitarni = $nekrsArray[$i]['sanitarni'];


      $nekretninaKlima = $nekrsArray[$i]['klima'];

      $nekretninaInternet = $nekrsArray[$i]['internet'];

      $nekretninaSatelitska = $nekrsArray[$i]['satelit'];

      $nekretninaKablovska = $nekrsArray[$i]['kabel'];

      $nekretnineMreza = $nekrsArray[$i]['mreza'];

     //  $nekretninaRostilj = $nekrsArray[$i]['rostilj'];
     //
     //  $nekretninaBazen = $nekrsArray[$i]['bazen'];

       $nekretninaSupa = $nekrsArray[$i]['supa'];

      $nekretninaParking = $nekrsArray[$i]['parking'];

      $nekretninaVlasnickiList = $nekrsArray[$i]['vlasnickiList'];

      $nekretninaPolog = $nekrsArray[$i]['pologOption'];
     //
     //  $nekretninaPerilica = $nekrsArray[$i]['perilica'];
     //
     //  $nekretninaPerilicaS = $nekrsArray[$i]['perilicaSuda'];
     //
     //  $nekretninaZivotinje = $nekrsArray[$i]['zivotinje'];
     //
     //  $nekreninaGaraga = $nekrsArray[$i]['garazaOption'];

        $nekretninaNamjestaj =  $nekrsArray[$i]['namjestaj'];

     //  $nekretninaBrSoba =  $nekrsArray[$i]['brojSoba'];

       $nekretninaGradjevniska =  $nekrsArray[$i]['gradevinska'];

      $nekretninaUporabna =  $nekrsArray[$i]['uporabna'];

     //  $nekretninaOrijentacija =  $nekrsArray[$i]['orijentacija'];

      $nekretninaAdaptacija =  $nekrsArray[$i]['adaptacija'];

       $nekrMikrolokacija  = $nekrsArray[$i]['kvart'];
     //
       $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);
     //
     //
     //  //slike
      $nekretnine_slk1 = $nekrsArray[$i]['slk1'];
      $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      $nekretnine_slk7 = $nekrsArray[$i]['slk7'];
      $nekretnine_slk8 = $nekrsArray[$i]['slk8'];
      $nekretnine_slk9 = $nekrsArray[$i]['slk9'];
     //
     //
      $nekretninaLat  =  $nekrsArray[$i]['lat'];
      $nekretninaLon  =  $nekrsArray[$i]['lon'];
     //
      $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);
     //
     $nekretninaMoreUdaljenost = $nekrsArray[$i]['moreUdaljenost'];
     //
      $nekretninaMorePogled = $nekrsArray[$i]['morePogled'];
     //
      $nekretninaTekst = $nekrsArray[$i]['tekst'];
      $nekretninaTekst = strip_tags($nekretninaTekst);
     //






     $nekretnina = $dom->createElement('post');

     //195,233,150




     if($nekretnineNaslovOglasa == '' & $nekretnineNaslovOglasa === 0 || is_numeric($nekretnineNaslovOglasa) || is_numeric($nekretnineNaslovOglasa) || is_null($nekretnineNaslovOglasa))
       {

         if($nekretninaMjesto == '' || $nekretninaMjesto == 0  || is_numeric($nekretninaMjesto) || is_null($nekretninaMjesto) & $nekrMikrolokacija !== 0 ||
            $nekrMikrolokacija !== '' &  $nekrMikrolokacija !== '0' & is_numeric($nekrMikrolokacija)){

                if($nekrZupanija != '' || is_null($nekrMikrolokacija) || is_numeric($nekrMikrolokacija)){
                    $naslovM = $nekrZupanija; //zupanija
                }else{
                    $naslovM = $nekrMikrolokacija; //kvart
                 }


         }

               else{
                 $naslovM = $nekretninaMjesto; //grad
               }
       }

     else{
       $naslovM = $nekretnineNaslovOglasa;
     }

     if($nekrID == 103){
       $naslovM = "Šibensko-kninska";
     }

     if($nekrID == 108){
       $naslovM = "Zagrebačka";
     }

     if($nekrID == 118 || $nekrID == 123 || $nekrID == 129 || $nekrID == 131 || $nekrID == 136 ){
       $naslovM = "Grad Zagreb";
     }

     if($nekrID == 109){
       $naslovM = "Dubrovačko-neretvanska";
     }


     if($nekrID == 114 || $nekrID == 115 || $nekrID == 138){
       $naslovM = "Zadarska";
     }


     if($nekrID == 120 || $nekrID == 135){
       $naslovM = "Primorsko-goranska";
     }

     $IDNk = $dom-> createElement('id', $naslovM . " - ".$nekrID .", ". $nekrVrsta);
     $nekretnina->appendChild($IDNk);

     $naslov  = $dom->createElement('naslov', $naslovM . " - ".$nekrID . ", ".$nekrVrsta);
     $nekretnina->appendChild($naslov);
     $naslovM = ''; //prazni varijablu



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


     $cijena  = $dom->createElement('cijena', $nekretninaCijena);
     $nekretnina ->appendChild($cijena);

     $mjesto  = $dom->createElement('grad', $nekretninaMjesto);
     $nekretnina ->appendChild($mjesto);

     $kat  = $dom->createElement('kat', $nekretninaKat);
     $nekretnina ->appendChild($kat);

     $Broj_etaza  = $dom->createElement('broj_etaza', $nekretninaEtaza);
     $nekretnina ->appendChild($Broj_etaza);



      if($nekretninaNamjestaj < 1)
      {
        $nekretninaNamjestaj = '';
      }else{
        $nekretninaNamjestaj = 'Namjestaj';
      }
      $namjestaj = $dom->createElement('namjestaj', $nekretninaNamjestaj);
      $nekretnina -> appendChild($namjestaj);



     $Broj_kat  = $dom->createElement('broj_kat', $nekretninaUkupnoKat);
     $nekretnina ->appendChild($Broj_kat);

     if($nekretninaCajnaKuhinja == 0 ||  $nekretninaCajnaKuhinja == ''){
        $nekretninaCajnaKuhinja = '';
     }
     else{
       $nekretninaCajnaKuhinja = 'Čajna kuhinja';
     }
     $Cajna_kuh  = $dom->createElement('cajna_kuhinja', $nekretninaCajnaKuhinja);
     $nekretnina ->appendChild($Cajna_kuh);


     $godinaIzgradnje = $dom ->createElement('GodinaGradnje', $godinaIzgradnjeValue);
     $nekretnina -> appendChild($godinaIzgradnje);

     $BrojProst = $dom ->createElement('BrojProstorija', $brojPoslovanja);
     $nekretnina -> appendChild($BrojProst);



     if($nekretninaPrijevoz == '0'){
         $nekretninaPrijevoz = '';
     }elseif ($nekretninaPrijevoz < 5 &&  $nekretninaPrijevoz > 0 ) {
       $nekretninaPrijevoz = 'Odlićna povezanost prijevozom';
     }
     $prijevoz = $dom ->createElement('prijevoz', $nekretninaPrijevoz);
     $nekretnina -> appendChild($prijevoz);


    //  if($nekretninaLogia == '0'){
    //    $nekretninaLogia = '';
    //  }else{
    //    $nekretninaLogia = 'Lođa';
    //  }
    //  $logia = $dom ->createElement('lođa', $nekretninaLogia);
    //  $nekretnina -> appendChild($logia);
    //
    //
    //  if($nekretninaVrt == '0'){
    //    $nekretninaVrt = '';
    //  }else{
    //    $nekretninaVrt = 'Vrt';
    //  }
    //  $vrt = $dom ->createElement('vrt', $nekretninaVrt);
    //  $nekretnina -> appendChild($vrt);
    //
    //  if($nekretninaTerasa == '0'){
    //   $nekretninaTerasa = '';
    //  }else{
    //      $nekretninaTerasa = 'Terasa';
    //  }
    //  $terasa = $dom ->createElement('terasa',   $nekretninaTerasa);
    //  $nekretnina -> appendChild($terasa);
    //
    //
    //
     if($nekretninaLift == '0' || $nekretninaLift == 0 || $nekretninaLift == ''){
      $nekretninaLift = '';
     }else{
      $nekretninaLift = 'Lift';
     }
     $lift = $dom ->createElement('lift',   $nekretninaLift);
     $nekretnina -> appendChild($lift);


     if($nekretninaTeretniLift == '0' || $nekretninaTeretniLift == 0 || $nekretninaTeretniLift == ''){
       $nekretninaTeretniLift = '';
     }else{
         $nekretninaTeretniLift = 'Teretni Lift';
     }
     $Tlift = $dom ->createElement('Teretnilift', $nekretninaTeretniLift);
     $nekretnina -> appendChild($Tlift);


     if($nekretninaSkladiste == '0' || $nekretninaSkladiste == 0 || $nekretninaSkladiste == ''){
       $nekretninaSkladiste = '';
     }else{
         $nekretninaSkladiste = 'Skladiste';
     }
     $skladiste = $dom ->createElement('Skladiste', $nekretninaSkladiste);
     $nekretnina -> appendChild($skladiste);





     if($nekretnineIzlog == '0' || $nekretnineIzlog == 0 || $nekretnineIzlog == ''){
       $nekretnineIzlog = '';
     }else{
         $nekretnineIzlog = 'Izlog';
     }
     $Izlog = $dom ->createElement('Izlog', $nekretnineIzlog);
     $nekretnina -> appendChild($Izlog);


    //  //stolarija
     if($nekretninaStolarija == '0'){
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
    //
    //

      if($StanbeniKredit == 0 || $StanbeniKredit == ''){
       $StanbeniKredit = 'nema';
     }

     elseif($StanbeniKredit == '1'){
            $StanbeniKredit = 'Mogućnost stanbenog kredita';
       }
      $StKredit = $dom ->createElement('StKredit',  $StanbeniKredit);
      $nekretnina -> appendChild($StKredit);



     if($nekretninaAlarm == '0' || $nekretninaAlarm == 0 || $nekretninaAlarm == ''){
      $nekretninaAlarm = '';
     }else{
        $nekretninaAlarm = 'Alarm';
     }
     $alarm = $dom ->createElement('alarm', $nekretninaAlarm);
     $nekretnina -> appendChild($alarm);
    //
    //
     if($nekretninaProtuPozarni  == '0' || $nekretninaProtuPozarni == ''){
      $nekretninaProtuPozarni  = '';
     }else{
        $nekretninaProtuPozarni  = 'Protupožarni';
     }
     $pozarni = $dom ->createElement('protuPozarniAlaram', $nekretninaProtuPozarni);
     $nekretnina -> appendChild($pozarni);

    //
     if($nekretninaProtuprovala  == '0' || $nekretninaProtuprovala == ''){
      $nekretninaProtuprovala  = '';
     }else{
      $nekretninaProtuprovala  = 'Protuprovalni';
     }
     $provalni = $dom ->createElement('protuProvalni', $nekretninaProtuprovala);
     $nekretnina -> appendChild($provalni);
    //
    //
     if($nekretninaParket  == '0'){
      $nekretninaParket  = '';
     }else{
      $nekretninaParket = 'Parket';
     }
     $parket = $dom ->createElement('parket', $nekretninaParket);
     $nekretnina -> appendChild($parket);
    //
     if($nekretninaLaminat  == '0'){
      $nekretninaLaminat  = '';
     }else{
      $nekretninaLaminat = 'Laminat';
     }
     $laminat = $dom ->createElement('laminat', $nekretninaLaminat);
     $nekretnina -> appendChild($laminat);
    //
    //  //nekretnine features


     //ima nema grijanje
     if($nekretninaGrijanje == '0'){
         $nekretninaGrijanje = '';
     }else{
         $nekretninaGrijanje = 'Grijanje';
     }

     $grijanje = $dom -> createElement('Grijanje', $nekretninaGrijanje);
     $nekretnina -> appendChild($grijanje);


    // nekrenine telefon
    if($nekretninaTelefon == 0){
      $nekretninaTelefon = '';
    }else{
      $nekretninaTelefon = 'Telefon';
    }

    $tel = $dom -> createElement('Telefon', $nekretninaTelefon);
    $nekretnina -> appendChild($tel);


    // nekretnina sanitarni
    if($nekretninaSanitarni == 0){
      $nekretninaSanitarni = '';
    }else{
      $nekretninaSanitarni = 'Sanitarni';
    }

    $sanitarni = $dom -> createElement('Sanitarni', $nekretninaSanitarni);
    $nekretnina -> appendChild($sanitarni);


    //  //nekrenine klima
    if($nekretninaKlima == 0){
      $nekretninaKlima = '';
    }else{
      $nekretninaKlima = 'Klima uređaj';
    }

    $klima = $dom -> createElement('Klima', $nekretninaKlima);
    $nekretnina -> appendChild($klima);
    //
    //
    //   //nekrenine internet
     if($nekretninaInternet == 0){
       $nekretninaInternet = '';
     }else{
       $nekretninaInternet = 'Internet';
     }

     $internet = $dom -> createElement('Internet', $nekretninaInternet);
     $nekretnina -> appendChild($internet);



      // nekretnina mreza
      if($nekretnineMreza == 0 || $nekretnineMreza == ''){
        $nekretnineMreza = '';
      }else{
        $nekretnineMreza = 'Mreza';
      }

      $mreza = $dom -> createElement('Mreza', $nekretnineMreza);
      $nekretnina -> appendChild($mreza);



    //  //nekrenine satelitska
    if($nekretninaSatelitska == '0'){
          $nekretninaSatelitska = '';
    }else{
          $nekretninaSatelitska = 'Satelitska';
    }

     $satelitska = $dom -> createElement('Instalirana_satelitska', $nekretninaSatelitska);
     $nekretnina -> appendChild($satelitska);
    //
    //
    //  //nekrenine kablovska
    if($nekretninaKablovska == '0'){
          $nekretninaKablovska = '';
    }else{
          $nekretninaKablovska = 'Kablovska';
    }

     $kabel = $dom -> createElement('Kablovska_tv', $nekretninaKablovska);
     $nekretnina -> appendChild($kabel);



      //garaža mjesta
         if($nekretninaGarazaV == '0'){
               $nekretninaGarazaV = '';
         }else{
               $nekretninaGarazaV = 'Garažna mjesta '. $nekretninaGarazaV;
         }

          $garazna_M = $dom -> createElement('Garazna_mjesta', $nekretninaGarazaV);
          $nekretnina -> appendChild($garazna_M);



          //polog
             if($nekretninaPolog == 0 || $nekretninaPolog == ''){
                   $nekretninaPolog = '';
             }else{
                   $nekretninaPolog = 'Obavezan polog';
             }

              $polog = $dom -> createElement('Polog', $nekretninaPolog);
              $nekretnina -> appendChild($polog);





    //
    //
    // //roštilj
    // if($nekretninaRostilj == '0'){
    //       $nekretninaRostilj = '';
    // }else{
    //       $nekretninaRostilj = 'Roštilj';
    // }
    //
    //  $rostilj = $dom -> createElement('Roštilj', $nekretninaRostilj);
    //  $nekretnina -> appendChild($rostilj);
    //
    //
    //  //bazen
    //  if($nekretninaBazen == '0'){
    //        $nekretninaBazen = '';
    //  }else{
    //       $nekretninaBazen = 'Bazen';
    //  }
    //
    //   $bazen = $dom -> createElement('Bazen', $nekretninaBazen);
    //   $nekretnina -> appendChild($bazen);
    //
    //
    //   //šupa
      if($nekretninaSupa == '0'){
            $nekretninaSupa = '';
      }else{
           $nekretninaSupa = 'Šupa';
      }

       $supa = $dom -> createElement('Supa', $nekretninaSupa);
       $nekretnina -> appendChild($supa);
    //
    //
    //
    //    //parking
       if($nekretninaParking == '0'){
             $nekretninaParkinga = '';
       }else{
            $nekretninaParkinga = 'Parking';
       }

        $parking = $dom -> createElement('Parking', $nekretninaParking);
        $nekretnina -> appendChild($parking);
    //
    //
    //     //vlasnicki list
        if($nekretninaVlasnickiList == '0'){
              $nekretninaVlasnickiList = '';
        }else{
             $nekretninaVlasnickiList = 'Vlasnički list';
        }

         $vlasnik = $dom -> createElement('vlasnicki_List', $nekretninaVlasnickiList);
         $nekretnina -> appendChild($vlasnik);
    //
    //      //perilica
    //      if($nekretninaPerilica == '0'){
    //            $nekretninaPerilica = '';
    //      }else{
    //           $nekretninaPerilica = 'Perilica';
    //      }
    //
    //       $peri = $dom -> createElement('Perilica', $nekretninaPerilica);
    //       $nekretnina -> appendChild($peri);
    //
    //
    //       //perilica sudja
    //       if($nekretninaPerilicaS == '0'){
    //             $nekretninaPerilicaS = '';
    //       }else{
    //            $nekretninaPerilicaS = 'Perilica suđa';
    //       }
    //
    //        $periS = $dom -> createElement('Perilica_posudje', $nekretninaPerilicaS);
    //        $nekretnina -> appendChild($periS);
    //
    //
    //        //životinje
    //        if($nekretninaZivotinje == '0'){
    //               $nekretninaZivotinje = '';
    //        }else{
    //              $nekretninaZivotinje = 'Životinje';
    //        }
    //         $ziv = $dom -> createElement('Zivotinje',  $nekretninaZivotinje);
    //         $nekretnina -> appendChild($ziv);
    //
    //
    //
    //         //garažarray
    //         if($nekreninaGaraga == '0'){
    //                $nekreninaGaraga = '';
    //         }else{
    //             $nekreninaGaraga= 'Garaža';
    //         }
    //          $garage = $dom -> createElement('Garaža',  $nekreninaGaraga);
    //          $nekretnina -> appendChild($garage);
    //

    //
    //           //namještaj
              if($nekretninaNamjestaj == '0'){
                     $nekretninaNamjestaj = '';
              }else{
                  $nekretninaNamjestaj = 'Namjestaj';
              }
              $namjestaj = $dom -> createElement('Namjestaj',  $nekretninaNamjestaj);
              $nekretnina -> appendChild($namjestaj);
    //
    //           //broj soba $nekretninaBrSoba
    //           if($nekretninaBrSoba == '0'){
    //                  $nekretninaBrSoba = 'Broj soba - 1';
    //                  $brojSoba = 1;
    //           }else{
    //               $brojSoba = $nekretninaBrSoba;
    //               $nekretninaBrSoba = 'Broj soba - '.$nekretninaBrSoba;
    //
    //           }
    //           $sobe = $dom -> createElement('Broj_soba',  $brojSoba);
    //           $nekretnina -> appendChild($sobe);
    //
    //           $SobaBroj = $dom -> createElement('Broj_sobaNum', $brojSoba);
    //           $nekretnina -> appendChild($SobaBroj);
    //
    //
    //           //građevinska dozvola
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




    //           //orijentacija $nekretninaOrijentacija
    //           if($nekretninaOrijentacija == '0'){
    //                  $nekretninaOrijentacija = '';
    //           }else{
    //               $nekretninaOrijentacija = 'Orijentacija';
    //           }
    //           $orijentacija = $dom -> createElement('orijentacija',  $nekretninaOrijentacija);
    //           $nekretnina -> appendChild($orijentacija);
    //
    //
    //
              //adaptacija  $nekretninaAdaptacija
              $adap = $dom -> createElement('adaptacija',  $nekretninaAdaptacija);
              $nekretnina -> appendChild($adap);
    //
    //
         $moreUda = $dom->createElement('UdaljenostMore', $nekretninaMoreUdaljenost);
         $nekretnina->appendChild($moreUda);
    //
    //
    //
    //
    //   //slike
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
    //
     $Lat = $dom->createElement('lat', $nekretninaLat);
     $nekretnina->appendChild($Lat);

     $Lon = $dom->createElement('lon', $nekretninaLon);
     $nekretnina->appendChild($Lon);
    //
    //
     $karta = $dom ->createElement('karta', $GoogleKarta); //$GoogleKarta
     $nekretnina -> appendChild($karta);

     $kartaKordina = $dom ->createElement('kartaKord', $GoogleKorKarta); //$GoogleKarta
     $nekretnina -> appendChild($kartaKordina);
    //
    //
    //
    //
    //  //nekrenine pogled na more
      if($nekretninaMorePogled == 0){
        $nekretninaMorePogled = '';
      }else{
        $nekretninaMorePogled = "Pogled na more";
      }
     $morePogled = $dom->createElement('morePogled', $nekretninaMorePogled);
     $nekretnina->appendChild($morePogled);
    //
    //
     $tekst = $dom->createElement('tekst', $nekretninaTekst);
     $nekretnina->appendChild($tekst);


     $root->appendChild($nekretnina);

   }

   $dom->appendChild($root);

   $dom->save($filePath);
   echo'<h1>Uspjeh , rješeni poslovni</h1>';
 }
 ?>
