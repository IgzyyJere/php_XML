<?php

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/formular.php" );
mysql_query ("set names utf8");


$nazivPoljaGrad = "Grad";
if ( isset ( $lokacijeNazivPoljaGrad )) { $nazivPoljaGrad = $lokacijeNazivPoljaGrad; }


$id = $_POST['id'];

if ( $_POST['grad'] AND $_POST['zupanija'] ) {

    $upit = "INSERT INTO `gradovi` ( `id`, `naziv`, `zupanija` ) VALUES ( '', '".$_POST['grad']."', '".$_POST['zupanija']."' )";
    mysql_query ( $upit );
    $id = $_POST['zupanija'];

}

$u = "SELECT * FROM gradovi WHERE zupanija='".$id."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['naziv'];

}

selectInsertArray ( $nazivPoljaGrad, "grad", $arr );


?>