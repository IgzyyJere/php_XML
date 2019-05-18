<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "vivoposlovni";

// napravi upit za grupe   /

$popisGrupa = "( ";
$i = 0;
$upit = "SELECT * FROM grupe WHERE vrsta = 'poslovni najam'";
$odgovori = mysql_query ( $upit );
while  ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    if ( !$i ) {
        $popisGrupa = $popisGrupa." grupa ='".$podaci['id']."' ";
    } else {
        $popisGrupa = $popisGrupa." OR grupa ='".$podaci['id']."' ";
    }
    $i++;
}
$popisGrupa = $popisGrupa." )";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' ),
                        array ( 'unos', 'unos' )

                        );

// pomoćni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = Array (
                        array ( 'adresar', 'adresar' ),
                        array ( 'lista', 'lista' )

                        );


include ( 'vivoIncludes/buttons.php' );
//include ( 'vivoAplikacije/breadcrumbNekretnine.php' );


//                        /
//određivanje paginacije  /
//                        /

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela." WHERE ".$popisGrupa." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva = '1' )";
$sqlOdgovor = mysql_query ( $sqlUkupno );
$ukupnoPodataka = mysql_result ( $sqlOdgovor, 0 );
$paginacija = ( $ukupnoPodataka > $poStranici ) ? true : false;

if ( $_GET['kreni'] ) {
    $startIndex = ($_GET['kreni'] * $poStranici) - $poStranici;
} else {
  $startIndex = 0;
  $_GET['kreni'] = 1;
}

include ( 'vivoIncludes/pagination.php' );
include ( "vivoAplikacije/prikazNekretnineArhiva.php" );
    
?>

