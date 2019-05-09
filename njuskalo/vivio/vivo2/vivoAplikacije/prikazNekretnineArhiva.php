<?php

// slanje podatka u arhivu  /
if ( $_GET['arhiva'] ) {
    $upit = "UPDATE ".$tabela." SET arhiva = '0' WHERE id = '".$_GET['arhiva']."'";
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

// razlika između podatka za površinu kod tabela  /
// (ovo sa površinom mi nije trebalo)             /
// prikaz liste podataka                          /
if ( $tabela == "vivozemljista" OR $tabela == "vivoostalo" ) {
    $upit = "SELECT id, mikrolokacija, povrsina, cijena, aktivno, kvart, grad, brojPosjeta, grupa, poredak FROM ".$tabela."
        WHERE ".$popisGrupa." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva = '1' )
        ORDER BY poredak DESC LIMIT ".$startIndex.", ".$poStranici."";
} else {
    $upit = "SELECT id, mikrolokacija, ukupnaPovrsina AS povrsina, cijena, aktivno, kvart, grad, brojPosjeta, grupa, poredak FROM ".$tabela."
        WHERE ".$popisGrupa." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva = '1' )
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
    prikaziNekretninuArhiva ( $podaci, $back, $tabela );
    $i++;
}
?>