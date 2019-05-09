<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// odredi koje još grupe postoje sa istom vrstom  /

$grupa = $_POST['grupa'];

$upit = "SELECT vrsta FROM grupe WHERE id = '".$grupa."'";
$odgovori = mysql_query ( $upit );
$vrsta = mysql_result ( $odgovori, 0 );


$upit = "SELECT * FROM grupe WHERE vrsta = '".$vrsta."'";
$odgovori = mysql_query ( $upit );
//$i = 1;
echo '<select id="novaGrupa">';
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    echo'<option value="',$podaci['id'],'">',$podaci['grupa'],'</option>';
}

//echo '<input type="hidden" name="broj" id="broj" value="',$i-1,'">';

?>
</select>