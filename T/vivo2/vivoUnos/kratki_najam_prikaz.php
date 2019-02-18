<?php
// odreðivanje tabele iz koje se vuku podaci

$tabela = "kratkinajam";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' ),
                        array ( 'unos', 'unos' )

                        );

// pomoæni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = Array (
                        array ( 'adresar', 'adresar' ),
                        array ( 'lista', 'lista' )

                        );


include ( 'vivoIncludes/buttons.php' );


//                        /
//odreðivanje paginacije  /
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

// slanje podatka u arhivu  /
if ( $_GET['arhiva'] ) {
    $upit = "UPDATE `".$tabela."` SET arhiva = '1' WHERE id = '".$_GET['id']."'";
    mysql_query ( $upit );
}


// brisanje podatka         /
if ( $_GET['obrisi'] ) {
    if ( $p['razina'] == 1 ) {
        $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
        mysql_query ( $upit );
    } else {
        $upit = "UPDATE `".$tabela."` SET obrisano = 1 WHERE id = '".$_GET['obrisi']."'";
        mysql_query ( $upit );
    }
}

// unos izmjena              /
if ( $_POST['napravi'] == "izmjeni" ) {
    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi", "navigacija" );
    mysql_query ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $id ));
    //echo vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $_POST['id'] );
}



$upit = "SELECT id, mikrolokacija, povrsina, ukupnaPovrsina, cijena, aktivno, kvart, grad FROM ".$tabela."
        WHERE ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )
        ORDER BY id DESC LIMIT ".$startIndex.", ".$poStranici."";
$odgovori = mysql_query ( $upit );
$i = 0;
while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {
    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }
    prikaziNekretninu ( $podaci, $back, $tabela );
    $i++;
}
    
?>

