<?php

session_start ();

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL ^ E_NOTICE);

include ( "../vivoFunkcije/baza.php" );

mysql_query ("set names utf8");

//saznaj koju tabelu pitat

$tabela = "zupanije";

$upit = "SELECT lokacije FROM ".$tabela." WHERE id = '".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$pod = mysql_fetch_assoc ( $odgovori );


if ( $pod['lokacije'] ) {

    $upi = "UPDATE ".$tabela." SET lokacije = 0 WHERE id = '".$_POST['id']."'";
    mysql_query ( $upi ) or die ('p1');
    echo '<img src="/vivo2/ikone/flag_red.png"> ';

} else {

    $upi = "UPDATE ".$tabela." SET lokacije = 1 WHERE id = '".$_POST['id']."'";
    mysql_query ( $upi ) or die ('p2');
    echo '<img src="/vivo2/ikone/flag_green.png"> ';

}

//echo $upit,'<br>',$upi;

session_write_close ();

?>