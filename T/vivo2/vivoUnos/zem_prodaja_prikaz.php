﻿<?php
// određivanje tabele iz koje se vuku podaci

$tabela = "vivozemljista";

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
include ( 'vivoAplikacije/breadcrumbNekretnine.php' );


//                        /
//određivanje paginacije  /
//                        /

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela." WHERE grupa = '".$grupa."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )";
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


include ( "vivoAplikacije/prikazNekretnine.php" );

?>

