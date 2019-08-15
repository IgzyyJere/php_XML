<?php

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/formular.php" ); 
mysql_query ("set names utf8");

$nazivPoljaZupanija = "Županija";
if ( isset ( $lokacijeNazivPoljaZupanija )) { $nazivPoljaZupanija = $lokacijeNazivPoljaZupanija; }

$u = "SELECT * FROM zupanije WHERE idRegije ='".$_POST['id']."' ORDER BY nazivZupanije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['nazivZupanije'];
    
}

selectInsertArray ( $nazivPoljaZupanija, "zupanija", $arr );


?>