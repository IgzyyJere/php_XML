<?php

session_start();
include ( "../vivoFunkcije/baza.php" );

    // prvo saznati na kojoj smo stranici   /
    $upit = "SELECT stranica FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $stranica = mysql_result ( $odgovori, 0 );

    // saznati tabelu u koju unosimo promjene    /
    require ( 'switchTabela.php' );

    // vrati ID    /
    $upit = "SELECT akcija FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $akcija = mysql_result ( $odgovori, 0 );
    if ( $akcija == "unos" ) {
        $upit = "SELECT lastID FROM `kontroler` WHERE idsess = '".session_id()."'";
    }
    if ( $akcija == "izmjena" ) {
        $upit = "SELECT radniID FROM `kontroler` WHERE idsess = '".session_id()."'";
    }
    $odgovori = mysql_query ( $upit );
    $id = mysql_result ( $odgovori, 0);

// dohvati popis slika od nekretnine   /
$upit = "SELECT slike FROM ".$tabela." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$galerija = mysql_fetch_assoc ( $odgovori );

$gal = explode ( ",", $galerija['slike'] );
foreach ( $gal as $key => $value ) {

    if ( $value != $_POST['idSlike'] ) {
        if ( $slike ) {
            $slike = $slike.",".$value;
        } else {
            $slike = $value;
        }
    }
}

// izmjeni podatke u tabeli od         /
// nekretnine i unesi slike koje idu   /
$upit = "UPDATE `".$tabela."` SET `slike` = '".$slike."' WHERE `id` = '".$id."'";
mysql_query ( $upit );

// označi da je slika "izbrisana" u tabeli  /
// slike i dodaj podatke gdje se nalazila   /
// ovdje ne radimo fizičko brisanje, jer možda slika još uvijek treba negdje na stranici /
$upit = "UPDATE `slike` SET `obrisano` = '1' WHERE `id` = '".$_POST['idSlike']."'";
mysql_query ( $upit ) or die ('ne radi');

session_write_close ();

?>