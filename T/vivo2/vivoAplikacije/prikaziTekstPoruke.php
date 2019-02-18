<?php

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8"); 

$upit = "SELECT * FROM poruke WHERE id = '".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

echo 'Pošiljatelj :<br />';

$mupit = "SELECT ime, prezime FROM korisnici WHERE id='".$podaci['poslao']."'";
$modg = mysql_query ( $mupit );
$mpod = mysql_fetch_assoc ( $modg );

echo $mpod['ime'],' ',$mpod['prezime'],'<br /><br />';

echo 'Naslov :<br />',$podaci['naslov'],'<br /><br />Tekst poruke:<br />',$podaci['tekst'];

?>