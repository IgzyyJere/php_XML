<?php

// izvadi podatke o nekretnini

$upit = "SELECT * FROM ".$_GET['tabela']." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$nekretnina = mysql_fetch_assoc ( $odgovori );

switch ( $_GET['tabela'] ) {

    case 'vivostanovi':
    $provjera = "klijentistanovi";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivoposlovni':
    $provjera = "klijentiposlovni";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivokuce':
    $provjera = "klijentikuce";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivozemljista':
    $provjera = "klijentizemljista";
    $povrsina = "povrsina";
    break;

    case 'vivoostalo':
    $provjera = "klijentiostalo";
    $povrsina = "povrsina";
    break;

}

switch ( $_GET['grupa'] ) {

    case '1':
    case '3':
    case '5':
    case '7':
    case '9':
    case '11':
    case '12':
    case '13':
    case '14':
    case '18':
    $grupa_2 = "1";
    break;

    case '2':
    case '4':
    case '6':
    case '8':
    case '10':
    case '15':
    case '16';
    case '17':
    case '19':
    $grupa_2 = "2";
    break;

}

//sagradi upit

$upit = "SELECT * FROM ".$provjera." WHERE ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )";

      //dodaj uvijete koje daje klijent


      $upit = $upit." AND ( minCijena < ".$nekretnina['cijena']." OR !minCijena ) AND ( maxCijena >  ".$nekretnina['cijena']." OR !maxCijena )";


      $upit = $upit." AND ( povrsinaOd < ".$nekretnina[$povrsina]." OR !povrsinaOd ) AND ( povrsinaDo > ".$nekretnina[$povrsina]." OR !povrsinaDo )";

      $upit = $upit." AND zupanija = ".$nekretnina['zupanija']." ";

      $upit = $upit." AND grupa = ".$grupa_2." ";


// prikaz podataka  /

// array sa podacima koji se preskaču      /

$preskoci = array ( "imeIPrezime", "mobitel", "povTelefon", "minCijena", "maxCijena", "pregledali", "napomena", "mjesto", "adresa", "regija", "zupanija", "grad", "kvart", "mikrolokacija", "id", "grupa", "email", "slike", "tlocrt", "brojPosjeta", "datumUnosa", "datumIzmjene", "agent", "provizije", "pdv", "arhiva", "brojPogleda", "povrsina", "ukupnaPovrsina", "cijena", "aktivno", "katCes", "katOpcina", "zkUlozak", "povrsinaOd", "povrsinaDo" );

$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    $zeleno = NULL;
    $zuto = NULL;
    $crveno = NULL;
    $zelenoBroj = NULL;
    $zutoBroj = NULL;
    $crvenoBroj = NULL;
    $nek = 0;
    $kl = 0;

    foreach ( $podaci as $key => $value ) {

    // $key je naziv polja kod klijenta                       /
    // $value je vrijednost polja kod klijenta                /
    // $nekretnina[$key] je vrijednost polja kod nekretnine   /


        // provjeri jel treba preskočiti    /
        if ( !in_array ( $key, $preskoci )) {

            // povlači ime iz imenaPolja.php     /
            $ime = dajImePolja ( $key );
            if ( !$ime ){
                $ime = $key;
            }

            // popis vrijednosti polja iz definicijePolja.php
            $popis = dajPolje ( $key );

            // vrijednost polja kod nekretnine   /
            $nek = $popis[$nekretnina[$key]];

            if ( !$nek ){
                $nek = $nekretnina[$key];
            }

            // vrijednost polja kod klijenta     /
            $kl = $popis[$value];

            if ( !$kl ){
                $kl = $value;
            }

            // gradi popis         /

            // ako nekretnina i klijent imaju upisano     /
            if ( $nekretnina[$key] AND $value ) {


                // podaci odgovaraju - zeleno    /
                if ( $nekretnina[$key] == $value ) {

                    $zeleno = $zeleno." <b>".$ime.":</b> ".$nek." &nbsp;&nbsp;&nbsp;";
                    $zelenoBroj ++;
                }

                //ako klijent ima označeno, ali ne istu vrijednost ko kod nekretnine

                if ( ($nekretnina[$key] != $value) AND $value ) {


                    $zuto = $zuto." ".$ime." &nbsp;&nbsp;&nbsp;&nbsp;
                    <b>nekretnina nudi : </b>".$nek."&nbsp;&nbsp;&nbsp;&nbsp;
                    <b> klijent traži: </b>".$kl." <br />";
                    $zutoBroj++;

                }

            // ako nekretnina nema upisano, ali klijent ima      /
            } else {

                if ( $value ) {

                $crveno = $crveno." <b>".$ime."</b> &nbsp;&nbsp;&nbsp;";
                $crvenoBroj ++;

                }

            }

         }

    }

    echo '<div class="klijentNaslov">
        <span class="klijentZeleno klijentGore"> ',$zelenoBroj,' </span> <span class="klijentZuto klijentGore"> ',$zutoBroj,' </span> <span class="klijentCrveno klijentGore"> ',$crvenoBroj,' </span>&nbsp;&nbsp;&nbsp;&nbsp; ',$podaci['imeIPrezime'],' / ',$podaci['mjesto'],' / ',$podaci['adresa'];

    // dodaj u popis za slanje ponude /

    echo ' &nbsp;&nbsp;<a href="',$id,'" title="dodaj u popis" ref="',$_GET['tabela'],'" rel="',$podaci['id'],'" class="dodajNaPopisKlijent"><img src="/vivo2/ikone/script_add.png"></a><br>';

    echo '<div class="klijentZeleno">',$zeleno,'</div>';
    echo '<div class="klijentZuto">',$zuto,'</div>';
    echo '<div class="klijentCrveno">',$crveno,'</div></div>';

}

echo '<br /><br />';
?>

