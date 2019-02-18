<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$upit = "UPDATE ".$_POST['tabela']." SET grupa = '".$_POST['novaGrupa']."' WHERE id = '".$_POST['id']."'";
mysql_query ( $upit );

echo $upit;

?>
