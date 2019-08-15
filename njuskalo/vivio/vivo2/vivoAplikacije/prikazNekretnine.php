<?php

// slanje podatka u arhivu  /
if ( $_GET['arhiva'] ) {
    $upit = "UPDATE `".$tabela."` SET arhiva = '1' WHERE id = '".$_GET['arhiva']."'";
    mysql_query ( $upit );
}

//print_r ( $_REQUEST );


// brisanje podatka         /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

// unos izmjena              /
if ( $_POST['napravi'] == "izmjeni" ) {
    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi", "navigacija" );
    mysql_query ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $id ));
    //echo vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $_POST['id'] );
}

// pomicanje gore         /
if ( $_GET['gore'] ) {
    pomakniGore ( $tabela, $_GET['gore'], $grupa );
}
// pomicanje dole         /
if ( $_GET['dole'] ) {
    pomakniDole ( $tabela, $_GET['dole'], $grupa );
}
// pomicanje na vrh         /
if ( $_GET['navrh'] ) {
    pomakniNaVrh ( $tabela, $_GET['navrh'], $grupa );
}

if ( !$_GET['samoJedan'] ) {

// razlika između podatka za površinu kod tabela  /
// (ovo sa površinom mi nije trebalo)             /
// prikaz liste podataka                          /
if ( $tabela == "vivozemljista" OR $tabela == "vivoostalo" ) {
    $upit = "SELECT id, mikrolokacija, povrsina, cijena, aktivno, kvart, grad, brojPosjeta, grupa, poredak, idInterni FROM ".$tabela."
        WHERE grupa = '".$grupa."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )
        ORDER BY poredak DESC LIMIT ".$startIndex.", ".$poStranici."";
} else if ( $tabela == "vivoturizam" ) {
    $upit = "SELECT id, mikrolokacija, cvrstiObjektm2 AS povrsina, cijena, aktivno, kvart, grad, brojPosjeta, grupa, poredak, idInterni FROM ".$tabela."
        WHERE grupa = '".$grupa."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )
        ORDER BY poredak DESC LIMIT ".$startIndex.", ".$poStranici."";
} else {
    $upit = "SELECT id, mikrolokacija, ukupnaPovrsina AS povrsina, cijena, aktivno, kvart, grad, brojPosjeta, grupa, poredak, idInterni FROM ".$tabela."
        WHERE grupa = '".$grupa."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )
        ORDER BY poredak DESC LIMIT ".$startIndex.", ".$poStranici."";
}

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
} else {
    $upit = "SELECT * FROM ".$tabela." WHERE id = '".$id."'";
    $odgovori = mysql_query ( $upit );
    $podaci = mysql_fetch_assoc ( $odgovori );
    prikaziNekretninu ( $podaci, "lightLine", $tabela );
}


?>
<div style="line-height: 30px; height:30px; float: left; clear: left; padding: 5px; border-top:1px solid #555; width: 100%;"><img src="/vivo2/ikone/flag_green.png">: uključeno&nbsp;&nbsp;&nbsp;&nbsp;<img src="/vivo2/ikone/flag_red.png">: isključeno&nbsp;&nbsp;&nbsp;&nbsp;<img src="/vivo2/ikone/flag_yellow.png">: rezervirano&nbsp;&nbsp;&nbsp;&nbsp;<img src="/vivo2/ikone/flag_black.png">: prodano</div>