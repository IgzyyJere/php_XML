<?php

$tabela = "klijentiturizam";

//brisanje podataka
if ( $_POST['akcija'] == "brisanje" ) {

    if ( $p['razina'] == 1 ) {
        $upit = "DELETE FROM ".$tabela." WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
    } else {
        $upit = "UPDATE ".$tabela." SET obrisano = 1 WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
    }
}


if ( $_GET['arhiva'] ) {
    $upit = "UPDATE ".$tabela." SET arhiva = '0' WHERE id = '".$_GET['arhiva']."'";
    mysql_query ( $upit );
}

$upit = "SELECT id, imeIPrezime, aktivno FROM ".$tabela."
        WHERE arhiva = '1'
        ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
$i = 0;
while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {
    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }
    prikaziKlijenta ( $podaci, $back, $tabela );
    $i++;
}
    
?>

