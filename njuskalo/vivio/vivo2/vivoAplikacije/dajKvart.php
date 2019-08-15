<?php

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/formular.php" ); 
mysql_query ("set names utf8");

$nazivPoljaKvart = "Kvart";
if ( isset ( $lokacijeNazivPoljaKvart )) { $nazivPoljaKvart = $lokacijeNazivPoljaKvart; }


$id = $_POST['id'];

if ( $_POST['grad'] AND $_POST['kvart'] ) {

    $upit = "INSERT INTO `kvartovi` ( `id`, `naziv`, `zupanija`, `grad` ) 
            VALUES ( '', '".$_POST['kvart']."', '".$_POST['zupanija']."', '".$_POST['grad']."' )";
    mysql_query ( $upit );
    $id = $_POST['grad']; 
    
}

$u = "SELECT * FROM kvartovi WHERE grad ='".$id."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
}

selectInsertArray ( $nazivPoljaKvart, "kvart", $arr );


?>