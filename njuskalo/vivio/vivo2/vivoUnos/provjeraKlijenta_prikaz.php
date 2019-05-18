<?php

// ubaci podatak o IDu klijenta u kontroler u radniID  /

$upit = "UPDATE kontroler
        SET
        radniID = '".$id."',
        pomocni = '".$_GET['tabela']."'
        WHERE idsess = '".session_id()."'";
mysql_query ( $upit );

// izvadi podatke o nekretnini

$upit = "SELECT * FROM ".$_GET['tabela']." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$klijent = mysql_fetch_assoc ( $odgovori );

switch ( $_GET['tabela'] ) {

    case 'klijentistanovi':
    $tabela = "vivostanovi";
    $povrsina = "ukupnaPovrsina";
    $grupa = "stanovi";
    break;

    case 'klijentiposlovni':
    $tabela = "vivoposlovni";
    $povrsina = "ukupnaPovrsina";
    $grupa = "poslovni";
    break;

    case 'klijentikuce':
    $tabela = "vivokuce";
    $povrsina = "ukupnaPovrsina";
    $grupa = "kuće";
    break;

    case 'klijentizemljista':
    $tabela = "vivozemljista";
    $povrsina = "povrsina";
    $grupa = "zemljišta";
    break;

    case 'klijentiostalo':
    $tabela = "vivoostalo";
    $povrsina = "povrsina";
    $grupa = "ostalo";
    break;

    case 'klijentiturizam':
    $tabela = "vivoturizam";
    $povrsina = "povrsina";
    $grupa = "turizam";
    break;

}

switch ( $_GET['grupa'] ) {

    case '1':
    $grupa_2 = "prodaja";
    break;

    case '2':
    $grupa_2 = "najam";
    break;

}

//sagradi upit

$upit = "SELECT * FROM ".$tabela." WHERE ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )";

      //dodaj uvijete koje daje klijent

      if ( $klijent['minCijena'] ) {

          $upit = $upit." AND cijena > ".$klijent['minCijena']." ";

      }

      if ( $klijent['maxCijena'] ) {

          $upit = $upit." AND cijena < ".$klijent['maxCijena']." ";

      }

      if ( $klijent['povrsinaOd'] ) {

          $upit = $upit." AND $povrsina > ".$klijent['povrsinaOd']." ";

      }

      if ( $klijent['povrsinaDo'] ) {

          $upit = $upit." AND $povrsina < ".$klijent['povrsinaDo']." ";

      }

      if ( $klijent['zupanija'] ) {

          $upit = $upit." AND zupanija = ".$klijent['zupanija']." ";

      }

      //dodaj grupe, prvo provjeri njihove IDove

      $grupaU = NULL;
      $upit = $upit." AND ( ";
      $podupit = "SELECT id FROM grupe WHERE vrsta = '".$grupa." ".$grupa_2."'";
      $odgovori = mysql_query ( $podupit );
      while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

         if ( $grupaU ) {

            $grupaU = $grupaU." OR grupa = ".$podaci['id']." ";

         } else {

            $grupaU = " grupa = ".$podaci['id']." ";

         }

      }

     $upit = $upit.$grupaU." ) ";


//prikaz podataka

//array sa podacima koji se preskaču

$preskoci = array ( "imeIPrezime", "mobitel", "povTelefon", "minCijena", "maxCijena", "pregledali", "napomena", "mjesto", "adresa", "regija", "zupanija", "grad", "kvart", "mikrolokacija", "id", "grupa", "email", "slike", "tlocrt", "brojPosjeta", "datumUnosa", "datumIzmjene", "agent", "provizije", "pdv", "arhiva", "brojPogleda", "povrsina", "ukupnaPovrsina", "cijena", "aktivno", "katCes", "katOpcina", "zkUlozak" );

$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    $zeleno = NULL;
    $zuto = NULL;
    $crveno = NULL;
    $zelenoBroj = NULL;
    $zutoBroj = NULL;
    $crvenoBroj = NULL;


    foreach ( $podaci as $key => $value ) {

        $polje = dajPolje( $key );
        $kodKlijenta = $klijent[$key];

        if ( !in_array ( $key, $preskoci )) {

            if ( $klijent[$key] ) {

                //ako upit klijenta odgovara onome kaj nekretnina ima

                    // povlači ime iz imenaPolja.php     /
                    $ime = dajImePolja ( $key );
                    if ( !$ime ){
                        $ime = $key;
                    }

                    // popis vrijednosti polja iz definicijePolja.php
                    $popis = dajPolje ( $key );

                    // vrijednost polja kod nekretnine   /
                    $nek = $popis[$klijent[$key]];

                    if ( !$nek ){
                        $nek = $klijent[$key];
                    }

                    // vrijednost polja kod klijenta     /
                    $kl = $popis[$value];

                    if ( !$kl ){
                        $kl = $value;
                    }

                    if ( $klijent[$key] == $value ) {

                        $zeleno = $zeleno." <b>".$ime.":</b> ".$nek." &nbsp;&nbsp;&nbsp;";
                        $zelenoBroj ++;
                    }

                    //ako klijent ima označeno, ali ne istu vrijednost ko kod nekretnine



                    if ( ($klijent[$key] != $value) AND $value ) {


                        $zuto = $zuto." ".$ime." &nbsp;&nbsp;&nbsp;&nbsp;<b>klijent traži : </b>".$nek." &nbsp;&nbsp;&nbsp;&nbsp;<b>nekretnina nudi : </b>".$kl." <br />";
                        $zutoBroj++;

                    }

                    if ( $klijent[$key] AND !$value ) {

                        $crveno = $crveno." <b>".$ime."</b> &nbsp;&nbsp;&nbsp;";
                        $crvenoBroj ++;

                    }


            }

         }

    }

    echo '<div class="klijentNaslov">
        <span class="klijentZeleno klijentGore"> ',$zelenoBroj,' </span> <span class="klijentZuto klijentGore"> ',$zutoBroj,' </span> <span class="klijentCrveno klijentGore"> ',$crvenoBroj,' </span>';

// dodajem još podataka, da se bude jasnije koja je nekretnina   /

// tabela i ID

echo ' &nbsp;&nbsp;&nbsp;&nbsp;ID:',$podaci['id'],'&nbsp;&nbsp;&nbsp;&nbsp; ';

// dodaj grad  /

$uu = "SELECT naziv FROM gradovi WHERE id = '".$podaci['grad']."'";
$oo = mysql_query ( $uu );
echo mysql_result ( $oo, 0 ),' / ';

// dodaj kvart  /

$uu = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
$oo = mysql_query ( $uu );
echo mysql_result ( $oo, 0 ),' / ';

echo $podaci['mikrolokacija'],' / ',$podaci[$povrsina],' m<sup>2</sup> / ',$podaci['cijena'],' &euro;';

    // podaci o vlasniku           /

    echo ' &nbsp;&nbsp;&nbsp;&nbsp; <a href="" title="prikaži podatke o vlasniku" class="vlasnik" ref="',$podaci['id'],'" rel="',$tabela,'"><img src="/vivo2/ikone/group_go.png"></a>&nbsp;&nbsp;';

    // dodaj u popis za slanje ponude /

    echo ' &nbsp;&nbsp;<a href="" title="dodaj u popis" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodajNaPopis"><img src="/vivo2/ikone/script_add.png"></a>';

     echo '<br />';
    echo '<div class="klijentZeleno">',$zeleno,'</div>';
    echo '<div class="klijentZuto">',$zuto,'</div>';
    echo '<div class="klijentCrveno">',$crveno,'</div></div>';

}

echo '<br /><br />';
?>

