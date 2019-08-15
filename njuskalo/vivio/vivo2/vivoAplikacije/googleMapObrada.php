<?php
session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

    // prvo saznati na kojoj smo stranici   /
    $upit = "SELECT stranica, akcija FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $podaci = mysql_fetch_assoc($odgovori);

    $stranica = $podaci['stranica'];
    $akcija = $podaci['akcija'];

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

$lon = round ( $_POST['longitude'], 6 );
$lat = round ( $_POST['latitude'], 6 );

$upit = "UPDATE ".$tabela."
         SET
         lon = ".$lon.",
         lat = ".$lat."
         WHERE
         id = '".$id."'";
mysql_query ($upit );
echo '<strong>Podaci uneseni:</strong> lon = ',$lon,' lat = ',$lat,'<br />';

?>