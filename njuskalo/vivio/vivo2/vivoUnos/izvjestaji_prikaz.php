<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "izvjestaji";

// definicija gumba na vrhu stranice  /


// određivanje varijabli koje sastavljaju upit  /

    // ako je poslana samo $_GET varijabla  /

    if ( $_GET['tabela'] ){

        $upit = "SELECT * FROM izvjestaji WHERE spojenoNa = '".$_GET['tabela']."-".$id."' ORDER BY id DESC";

    }

    // ovo je iz dokumenti > izvjestaji > pretraživanje /
    // upit se gradi prema više kriterija               /
    if ( $_POST ) {

        $upit = "SELECT * FROM izvjestaji WHERE 1 = 1";

        // odredi korisnika    /
        if ( $_POST['korisnik'] ) {

            $upit = $upit. " AND korisnik = '".$_POST['korisnik']."' ";

        }

        // odredi na koji podatak je spojeno   /
        if ( $_POST['tabela'] AND $_POST['id'] ) {

            $upit = $upit. " AND spojenoNa = '".$_POST['tabela']."-".$_POST['id']."' ";

        }

        // donja vremenska granica       /
        if ( $_POST['dDan'] OR $_POST['dMjesec'] OR $_POST['dGodina'] ) {

            // ako je unesen dan, koristi, ako ne, uzmi današnji   /
            if ( $_POST['dDan'] ) {
                $dan = $_POST['dDan'];
            } else {
                $dan = date('d');
            }
            // ako je unesen mjesec, koristi, ako ne, uzmi trenutni   /
            if ( $_POST['dMjesec'] ) {
                $mjesec = $_POST['dMjesec'];
            } else {
                $mjesec = date('m');
            }
            // ako je unesena godina, koristi, ako ne, uzmi trenutnu   /
            if ( $_POST['dGodina'] ) {
                $godina = $_POST['dGodina'];
            } else {
                $godina = date('Y');
            }
            $upit = $upit. " AND datum > = '".$godina."-".$mjesec."-".$dan."' ";
        }

        // gornja vremenska granica      /
        if ( $_POST['gDan'] OR $_POST['gMjesec'] OR $_POST['gGodina'] ) {

            // ako je unesen dan, koristi, ako ne, uzmi današnji   /
            if ( $_POST['gDan'] ) {
                $dan = $_POST['gDan'];
            } else {
                $dan = date('d');
            }
            // ako je unesen mjesec, koristi, ako ne, uzmi trenutni   /
            if ( $_POST['gMjesec'] ) {
                $mjesec = $_POST['gMjesec'];
            } else {
                $mjesec = date('m');
            }
            // ako je unesena godina, koristi, ako ne, uzmi trenutnu   /
            if ( $_POST['gGodina'] ) {
                $godina = $_POST['gGodina'];
            } else {
                $godina = date('Y');
            }
            $upit = $upit. " AND datum < = '".$godina."-".$mjesec."-".$dan."' ";
        }

    $upit = $upit." ORDER BY id DESC";


    }

$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    $datum = date_create( $podaci['datum'] );
    $datum = date_format($datum, 'd m Y - G:i');
    echo '<div class="izvjestajPrikaz"><strong>Datum i vrijeme</strong>: ',$datum,' <br /><strong>Izvještaj upisao</strong>: ';
    $uu = "SELECT ime, prezime FROM korisnici WHERE id = '".$podaci['korisnik']."'";
    $oo = mysql_query ( $uu );
    echo mysql_result ( $oo, 0 ),'<br />';
    echo 'Agent: ';
    $uu = "SELECT ime, prezime FROM korisnici WHERE id = '".$podaci['agent']."'";
    $oo = mysql_query ( $uu );
    echo mysql_result ( $oo, 0 ),'<br />';
    echo '<strong>Tekst izvještaja</strong>: ',$podaci['tekst'],'</div><hr>';
}


?>

