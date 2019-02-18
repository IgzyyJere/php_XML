<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$izuzeci = Array ( "id" );
foreach ( $_POST as $key => $value ) {
    if ( !in_array ( $key, $izuzeci ) ) {
        $naziviPolja = $naziviPolja.", ".$key." ";
        $vrijednosti = $vrijednosti.", '".$value."'";
    }
}

// unos posredničkog dnevnika u bazu /
$upit = "INSERT INTO
        posrednickidnevnik
        ( id ".$naziviPolja.", datumUnosa )
        VALUES
        ( '' ".$vrijednosti.", NOW() )";
mysql_query ( $upit );

echo 'Posrednički dnevnik unesen.';

?>