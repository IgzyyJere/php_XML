<?php

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/formular.php" );
mysql_query ("set names utf8");

$id = $_POST['id'];

$u = "SELECT * FROM gradovi WHERE zupanija='".$id."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['naziv'];

}

selectInsertArray ( "Grad", "grad", $arr );


?>