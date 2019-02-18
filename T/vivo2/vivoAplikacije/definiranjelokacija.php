<?php

session_start ();

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL ^ E_NOTICE);

include ( "../vivoFunkcije/baza.php" );

mysql_query ("set names utf8");

$upit = "UPDATE gradovi SET idlokacije = '".$_POST['lokacija']."' WHERE id = '".$_POST['grad']."'";
mysql_query ( $upit );

$upit = "SELECT naziv FROM gradovi WHERE idlokacije = '".$_POST['lokacija']."'";
$o = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $o )) {
    echo $podaci['naziv'],', ';
    }

//echo $upit,'<br>',$upi;

session_write_close ();

?>