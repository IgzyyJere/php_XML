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
SELECT vivokuce.id, grupe.naziv AS 'vrsta', grupe.vrsta AS 'status', vivokuce.regija, regije.naziv as 'zemlja',zupanije.nazivZupanije, vivokuce.okucnica, vivokuce.povrsina,
vivokuce.cijena, vivokuce.mjesto as 'grad', vivokuce.mikrolokacija as 'kvart', vivokuce.telefon, vivokuce.klima, vivokuce.satelit, vivokuce.internet, vivokuce.mikrolokacija,
vivokuce.adresa, vivokuce.godinaIzgradnjeValue as 'godina_izgradnje', vivokuce.napomena, vivokuce.morePogled, vivokuce.moreUdaljenost, teksttransferkuce.tekst,
vivokuce.lat, vivokuce.lon, vivokuce.vlasnickiList, vivokuce.brojEtazaKuca, vivokuce.grijanje, vivokuce.kupaone, vivokuce.tipObjekt as 'vrsta', vivokuce.balkonOption,
vivokuce.loggiaOption, vivokuce.loggiaValue, vivokuce.vrtOption, vivokuce.vrtValue, vivokuce.terasaOption, vivokuce.terasaValue, vivokuce.lift, vivokuce.stolarija,
vivokuce.alarm, vivokuce.protupozar, vivokuce.protuprovala, vivokuce.parket, vivokuce.laminat, vivokuce.kabel, vivokuce.rostilj, vivokuce.bazen, vivokuce.supa, 
vivokuce.parking,
vivokuce.telefon, vivokuce.perilica, vivokuce.perilicaSuda, vivokuce.mozdaPoslovni, vivokuce.zivotinje, vivokuce.garazaValue, vivokuce.garazaOption, vivokuce.pologValue, 
vivokuce.minCijena, vivokuce.gradevinska, vivokuce.lokacijska, vivokuce.uporabna, vivokuce.podrum, vivokuce.useljenje, vivokuce.prijevoz, vivokuce.brojsoba, 
vivokuce.orijentacija,
vivokuce.adaptacija, vivokuce.naslovoglasa as 'naslov',
sliketransferkuce.slk1, sliketransferkuce.slk2, sliketransferkuce.slk3, sliketransferkuce.slk4, sliketransferkuce.slk5, sliketransferkuce.slk6, sliketransferkuce.slk6,
 sliketransferkuce.slk7,
sliketransferkuce.slk8, sliketransferkuce.slk9, sliketransferkuce.slk10

FROM vivokuce LEFT JOIN grupe ON vivokuce.grupa = grupe.id
LEFT JOIN regije ON vivokuce.regija = regije.id
LEFT JOIN zupanije ON vivokuce.zupanija = zupanije.id
LEFT JOIN kvartovi ON kvartovi.id = vivokuce.kvart
LEFT JOIN teksttransferkuce ON vivokuce.id = teksttransferkuce.spojenoNa
LEFT JOIN sliketransferkuce ON sliketransferkuce.ID_nekrenina = vivokuce.id
where vivokuce.aktivno = 1
order by vivokuce.id asc";




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
$counquery = "SELECT vivokuce.id from vivokuce";
$num_rows = $mysqli->query($counquery);
$num_rows = count($nekrsArray);

$str1= $num_rows;
$str2="Broj koji je prebaćen ";
//echo "<h4>".$str1 . " " . $str2."</h4>";



/* close connection */
$mysqli->close();

function createXMLfile($nekrsArray){

   $filePath = 'prerade/nekretnine_kuce.xml';

   $dom  = new DOMDocument('1.0', 'utf-8');
//  $dom = new DOMDocument('1.0', 'ISO-8859-1');

   $root  = $dom->createElement('kuca');

   for($i=0; $i<count($nekrsArray); $i++){

     $nekrID  =  $nekrsArray[$i]['id'];

     $nekrNaslov  =  $nekrsArray[$i]['naslov'];

     $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

     $nekrStatus  =  $nekrsArray[$i]['status'];

      $nekrZupanija =  $nekrsArray[$i]['nazivZupanije'];

      $nekretninaPovrsina  =  $nekrsArray[$i]['povrsina'];

      $nekretninaZemljiste  =  $nekrsArray[$i]['okucnica'];

      $nekretninaCijena  =  $nekrsArray[$i]['minCijena'];

      $nekretninaMjesto =   $nekrsArray[$i]['grad']; // grad

      $nekrenineKvart = $nekrsArray[$i]['kvart']; //kvart

      $nekretninaTelefon = $nekrsArray[$i]['telefon'];

      $nekretninaKlima = $nekrsArray[$i]['klima'];

      $nekretninaGrijanje = $nekrsArray[$i]['grijanje'];

      $nekretninaInternet = $nekrsArray[$i]['internet'];

      $nekretninaSatelitska = $nekrsArray[$i]['satelit'];

      $nekretninaVlList = $nekrsArray[$i]['vlasnickiList'];

      $nekreninaBrojEtaza = $nekrsArray[$i]['brojEtazaKuca'];

      $nekreninaKupaona =  $nekrsArray[$i]['kupaone'];

    //  $nekrVrsta  =  $nekrsArray[$i]['vrsta'];

      $nekretninaBalkon =  $nekrsArray[$i]['balkonOption'];

      $nekretninaLoggia =  $nekrsArray[$i]['loggiaOption'];

      $nekretninaLoggiaVel = $nekrsArray[$i]['loggiaValue'];

      $nekretninaVrt = $nekrsArray[$i]['vrtOption'];

      $nekretninaVrtVel = $nekrsArray[$i]['vrtValue'];

      $nekretninaTerasa = $nekrsArray[$i]['terasaOption'];

      $nekretninaTerasaVel =  $nekrsArray[$i]['terasaValue'];

      $nekretninaLift = $nekrsArray[$i]['lift'];

      $nekretninaStolarija = $nekrsArray[$i]['stolarija'];

      $nekretninaAlarm = $nekrsArray[$i]['alarm'];

      $nekretninaProtuPozarni = $nekrsArray[$i]['protupozar'];

      $nekretninaProtuprovala = $nekrsArray[$i]['protuprovala'];

      $nekretninaParket = $nekrsArray[$i]['parket'];

      $nekretninaLaminat = $nekrsArray[$i]['laminat'];

      $nekretninaKablovska = $nekrsArray[$i]['kabel'];

      $nekretninaRostilj = $nekrsArray[$i]['rostilj'];

      $nekretninaBazen = $nekrsArray[$i]['bazen'];

      $nekretninaSupa = $nekrsArray[$i]['supa'];

      $nekretninaParking = $nekrsArray[$i]['parking'];


      $nekrMikrolokacija  = $nekrsArray[$i]['mikrolokacija'];

      $nekretninaAdresa = $nekrsArray[$i]['adresa'];

      $godinaIzgradnjeValue = $nekrsArray[$i]['godina_izgradnje'];

      $nekretninaPerilica =  $nekrsArray[$i]['perilica'];

      $nekretninaPerilicaSuda =  $nekrsArray[$i]['perilicaSuda'];

      $nekretninaMozdaPoslovni =  $nekrsArray[$i]['mozdaPoslovni'];

      $nekretninaZivotinje = $nekrsArray[$i]['zivotinje'];

      $garaznaMjestaBroj = $nekrsArray[$i]['garazaValue'];

      $nekreninaGaraga = $nekrsArray[$i]['garazaOption'];

      $pologValue = $nekrsArray[$i]['pologValue'];

      $nekretninaGradjevniska =  $nekrsArray[$i]['gradevinska'];

      $nekretninaLokacijska =  $nekrsArray[$i]['lokacijska'];

      $nekretninaPodrum =  $nekrsArray[$i]['podrum'];

      $nekretninaUseljenje =  $nekrsArray[$i]['useljenje'];

      $nekretninaPrijevoz =  $nekrsArray[$i]['prijevoz'];

      $nekretninaBrSoba =  $nekrsArray[$i]['brojsoba'];

      $nekretnineOrijentacija = $nekrsArray[$i]['orijentacija'];

      $nekretninaAdaptacija =  $nekrsArray[$i]['adaptacija'];

      $nekretninaUporabna =  $nekrsArray[$i]['uporabna'];

      $GoogleKarta = mapa($nekrMikrolokacija, "", $nekretninaMjesto);


      $nekretninaNap  =  $nekrsArray[$i]['napomena'];
      $nekretnine_slk1 =  $nekrsArray[$i]['slk1'];
      $nekretnine_slk2 = $nekrsArray[$i]['slk2'];
      $nekretnine_slk3 = $nekrsArray[$i]['slk3'];
      $nekretnine_slk4 = $nekrsArray[$i]['slk4'];
      $nekretnine_slk5 = $nekrsArray[$i]['slk5'];
      $nekretnine_slk6 = $nekrsArray[$i]['slk6'];
      $nekretnine_slk7 = $nekrsArray[$i]['slk7'];
      $nekretnine_slk8 = $nekrsArray[$i]['slk8'];
      $nekretnine_slk9 = $nekrsArray[$i]['slk9'];
      $nekretnine_slk10 = $nekrsArray[$i]['slk10'];

      $nekretninaLat  =  $nekrsArray[$i]['lat'];
      $nekretninaLon  =  $nekrsArray[$i]['lon'];

      $GoogleKorKarta = mapaLtd($nekretninaLat, $nekretninaLon);

      $nekretninaMoreUdaljenost = $nekrsArray[$i]['moreUdaljenost'];

      $nekretninaMorePogled = $nekrsArray[$i]['morePogled'];

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



      if($nekrVrsta == '0'){
          $nekrVrsta = '';}
          elseif($nekrVrsta == '1'){
            $nekrVrsta = 'Stambeno-poslovna';
          }elseif($nekrVrsta == '2'){
            $nekrVrsta = "Samostojeća";}
            elseif($nekrVrsta == '3'){
              $nekrVrsta = "Kuća u nizu";
            }elseif($nekrVrsta == '4'){
              $nekrVrsta = "Dvojni objekt";
            }elseif($nekrVrsta == '5'){
              $nekrVrsta = 'Roh-bau';
            }elseif($nekrVrsta == '6'){
              $nekrVrsta = "Vikendica";
            }
  



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

     
    $Vrsta = $dom->createElement('Vrsta', $nekrVrsta);
    $nekretnina->appendChild($Vrsta);

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

      if($nekretninaVlList == 0)   {
       $nekretninaVlList = '';
     }else {
       $nekretninaVlList = "Vlasnički list u posjedu";
     }
     $vlasnickiList = $dom -> createElement('VlasnickiList', $nekretninaVlList);
     $nekretnina -> appendChild($vlasnickiList);


      $BrojEtaza = $dom -> createElement('Etaze', $nekreninaBrojEtaza);
      $nekretnina -> appendChild($BrojEtaza);


      $Kupaona = $dom -> createElement('Kupaona', $nekreninaKupaona);
      $nekretnina -> appendChild($Kupaona);


      if($Kupaona == '0'){
          $Kupaona = '';
      }
      $moreUda = $dom->createElement('UdaljenostMore', $nekretninaMoreUdaljenost);
      $nekretnina->appendChild($moreUda);







     
    //ima nema balkon
     if($nekretninaBalkon == '0'){
         $nekretninaBalkon = '';
     }else{
         $nekretninaBalkon = 'Balkon: ima';
     }

     $balkon = $dom -> createElement('Balkon', $nekretninaBalkon);
     $nekretnina -> appendChild($balkon);


     //ima nema lođu $nekretninaLoggia
    if($nekretninaLoggia == '0'){
        $nekretninaLoggia = '';
     }else{
         $nekretninaLoggia = 'Loggia: ima';
     }

     $loggia = $dom -> createElement('Loggia', $nekretninaLoggia);
     $nekretnina -> appendChild($loggia);



     //veličina loggie $nekretninaLoggiaVel
    if($nekretninaLoggiaVel == '0'){
        $nekretninaLoggiaVel = '';
     }

     $loggiaVel = $dom -> createElement('LoggiaVel', $nekretninaLoggiaVel);
     $nekretnina -> appendChild($loggiaVel);



     //ima nema vrt $nekretninaVrt
    if($nekretninaVrt == '0'){
            $nekretninaVrt = '';
        }else{
            $nekretninaVrt = 'Vrt: ima';
        }

        $vrt = $dom -> createElement('Vrt', $nekretninaVrt);
        $nekretnina -> appendChild($vrt);



     //veličina vrta
    if($nekretninaVrtVel == '0'){
        $nekretninaVrtVel = '';
     }

     $vrtVel = $dom -> createElement('Vrt_Vel', $nekretninaVrtVel);
     $nekretnina -> appendChild($vrtVel);


    //ima nema terase 
    if($nekretninaTerasa == '0'){
        $nekretninaTerasa = '';
     }else{
        $nekretninaTerasa = 'Terasa: ima';
     }

     $terasa = $dom -> createElement('terasa', $nekretninaTerasa);
     $nekretnina -> appendChild($terasa );



    //Terasa  vel $nekretninaTerasaVel
    if($nekretninaTerasaVel == '0'){
        $nekretninaTerasaVel = '';
     }

     $terasaVel = $dom -> createElement('terasa_vel', $nekretninaTerasaVel);
     $nekretnina -> appendChild($terasaVel);


          if($nekretninaLift == '0' || $nekretninaLift == 0 || $nekretninaLift == ''){
      $nekretninaLift = '';
     }else{
      $nekretninaLift = 'Lift';
     }
     $lift = $dom ->createElement('lift',   $nekretninaLift);
     $nekretnina -> appendChild($lift);


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
    //
    // //
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


         // //  //nekrenine kablovska
    if($nekretninaKablovska == '0'){
          $nekretninaKablovska = '';
    }else{
          $nekretninaKablovska = 'Kablovska';
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



       if(trim($nekretninaParking) == '0' || is_numeric($nekretninaParking) < 1 || is_null($nekretninaParking)){
             $nekretninaParking = '';
       }else{
            $nekretninaParking = 'Parking mjesta '.$nekretninaParking;
       }

        $parking = $dom -> createElement('Parking', $nekretninaParking);
        $nekretnina -> appendChild($parking);


        //ima nema perilicu $nekretninaPerilica 
        if($nekretninaPerilica == '0'){
              $nekretninaPerilica = '';
        }else{
              $nekretninaPerilica = 'Perilica: ima';
        }

        $perilica = $dom -> createElement('Perilica', $nekretninaPerilica);
        $nekretnina -> appendChild($perilica);


           //ima nema perilicu $nekretninaPerilica $nekretninaPerilicaSuda
        if($nekretninaPerilicaSuda == '0'){
              $nekretninaPerilicaSuda = '';
        }else{
              $nekretninaPerilicaSuda = 'Perilica suđa: ima';
        }

        $perilicaS = $dom -> createElement('PerilicaS', $nekretninaPerilicaSuda);
        $nekretnina -> appendChild($perilicaS);


        if($nekretninaMozdaPoslovni == '0'){
              $nekretninaMozdaPoslovni = '';
        }else{
              $nekretninaMozdaPoslovni = 'Može se namjeniti i za poslovni prostor!';
        }

        $mozdaPosl = $dom -> createElement('Mozda_poslovni', $nekretninaMozdaPoslovni);
        $nekretnina -> appendChild($mozdaPosl);



        //životinje da ili  $nekretninaZivotinje

      if($nekretninaZivotinje == '0'){
              $nekretninaZivotinje = '';
        }else{
              $nekretninaZivotinje = 'Životinje dozvoljene';
        }

        $ziv = $dom -> createElement('Ziv', $nekretninaZivotinje);
        $nekretnina -> appendChild($ziv);



        //garažarray
            if($nekreninaGaraga == '0'){
                   $nekreninaGaraga = '';
            }else{
                $nekreninaGaraga= 'Garaža';
            }
             $garage = $dom -> createElement('Garaža',  $nekreninaGaraga);
             $nekretnina -> appendChild($garage);


        $garaznaMjestaBroj = $dom->createElement('Broj_garaznihMjesta', $garaznaMjestaBroj);
        $nekretnina->appendChild($garaznaMjestaBroj);



        //polog  $pologValue
      if( $pologValue == '0'){
               $pologValue = '';
        }

        $polog = $dom -> createElement('Polog', $pologValue);
        $nekretnina -> appendChild($polog);


        // $nekretninaPodrum
            if($nekretninaPodrum == '0'){
                   $nekretninaPodrum = '';
            }else{
                $nekretninaPodrum= 'Podrum';
            }
             $podrum = $dom -> createElement('Podrum',  $nekretninaPodrum);
             $nekretnina -> appendChild($podrum);


             //$nekretninaUseljenje
             switch($nekretninaUseljenje){
                case 1:
                $nekretninaUseljenje = 'Odmah po isplati';
                  break;

                case 2:
                 $nekretninaUseljenje = 'Po dogovoru';
                 break;

                 default:
                  $nekretninaUseljenje = '';

             }
             $useli = $dom -> createElement('Useljenje',   $nekretninaUseljenje);
             $nekretnina -> appendChild($useli);




                    //$nekretninaUseljenje
             switch($nekretninaPrijevoz){
                case 1:
                $nekretninaUseljenje = 'Zona tramvaja';
                  break;

                case 2:
                 $nekretninaUseljenje = 'Autobus';
                 break;

                    case 3:
                 $nekretninaUseljenje = 'Vlak';
                 break;

                    case 4:
                 $nekretninaUseljenje = 'Samo osobni prijevoz';
                 break;

                 default:
                  $nekretninaPrijevoz = '';

             }
             $prijevoz = $dom -> createElement('Prijevoz',   $nekretninaPrijevoz);
             $nekretnina -> appendChild($prijevoz);



             
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


              $sobeNum = $dom -> createElement('Broj_sobaNum',  $nekretninaBrSoba);
              $nekretnina -> appendChild($sobeNum);
         



              //orijentacija
              if($nekretnineOrijentacija == '0'){
                     $$nekretnineOrijentacija = '';
              }else{
                  $nekretnineOrijentacija = $nekretnineOrijentacija;
              }
              $orijen = $dom -> createElement('Orijantacija',  $nekretnineOrijentacija);
              $nekretnina -> appendChild($orijen);


              //adaptacija  $nekretninaAdaptacija
              $adap = $dom -> createElement('adaptacija',  $nekretninaAdaptacija);
              $nekretnina -> appendChild($adap);



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

               if($nekretnine_slk10 == 'http://nekretnine-tomislav.hr/elementi/pageBack.png'){
             $nekretnine_slk10 = '';
           }else{
             $slike10 = $dom -> createElement('slk10',  $nekretnine_slk10);
           }
           $slike10 = $dom -> createElement('slk10',  $nekretnine_slk10);
           $nekretnina -> appendChild($slike10);


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



          //građevinska dozvola
      if($nekretninaGradjevniska == '0'){
              $nekretninaGradjevniska = '';
      }else{
          $nekretninaGradjevniska = 'Građevinska dozvola';
      }
      $gradevisnka = $dom -> createElement('Gradevisnka_dozvola',  $nekretninaGradjevniska);
      $nekretnina -> appendChild($gradevisnka);


      // $nekretninaLokacijska 
      if($nekretninaLokacijska  == '0'){
              $nekretninaLokacijska  = '';
      }else{
          $nekretninaLokacijska  = 'Lokacijska dozvola';
      }
      $lokacij = $dom -> createElement('Lokacijska_dozvola',  $nekretninaLokacijska );
      $nekretnina -> appendChild($lokacij);

      
      //uporabna dozvola $nekretninaUporabna
      if(trim($nekretninaUporabna) == ''){
              $nekretninaUporabna = '';
      }else{
          $nekretninaUporabna = 'Uporabna dozvola';
      }
      $uporabna = $dom -> createElement('Uporabna_dozvola',  $nekretninaUporabna);
      $nekretnina -> appendChild($uporabna);


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
        <a class="nav-link" href="">Kuće <span class="sr-only">(current)</span></a>
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
  <h1 class="display-4">Kuće</h1>
  <p class="lead">Uspjeh , rješene kuće</p>
  <hr class="my-4">
  <?php print '<h1>'.$str1. " " .$str2.'</h1>'; ?>
 
</div>



</div>








</body>
</html>