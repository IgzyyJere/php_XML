<?php
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$upit = "INSERT INTO provizijeTekst ( idProvizije, jezik, tekst ) VALUES ( '".$_POST['id']."', '".$_POST['jezik']."', '".$_POST['text']."' )";
mysql_query ( $upit );
?>