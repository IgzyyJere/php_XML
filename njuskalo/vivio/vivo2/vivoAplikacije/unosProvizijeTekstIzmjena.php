<?php
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$podaci = parse_str ( $_POST['podaci'] );

if ( $id != "nema" ) {
    $upit = "UPDATE provizijeTekst SET tekst = '".$tekst."' WHERE id =  '".$id."'";
} else {
    $upit = "INSERT INTO provizijeTekst ( idProvizije, jezik, tekst ) VALUES ( '".$idProvizije."', '".$jezik."', '".$tekst."' )";
}
mysql_query ( $upit );
echo $upit;
?>