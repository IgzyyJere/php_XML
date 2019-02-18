<?php



session_start ();



ini_set('display_errors','0');

ini_set('display_startup_errors','0');

error_reporting (0);



include ( "../vivoFunkcije/baza.php" );



mysql_query ("set names utf8");



//saznaj koju tabelu pitat



$upit = "SELECT stranica, akcija FROM kontroler WHERE idsess = '".session_id()."'";

$odgovori = mysql_query ( $upit );

$podaci = mysql_fetch_assoc ( $odgovori );

$stranica = $podaci['stranica'];

$akcija =  $podaci['akcija'];



// DEFINICIJE TABELA, include iz istog direktorija,

// se tabele definiraju na jednom mjestu uvijek

include ( "switchTabela.php" );



//



$upit = "SELECT aktivno FROM ".$tabela." WHERE id = '".$_POST['id']."'";

$odgovori = mysql_query ( $upit );

$pod = mysql_fetch_assoc ( $odgovori );



if ( $pod['aktivno'] == 3 ) {



    $upi = "UPDATE ".$tabela." SET aktivno = 0 WHERE id = '".$_POST['id']."'";

    mysql_query ( $upi ) or die ('p1');

    echo '<img src="/vivo2/ikone/flag_red.png"> ';



}





if ( $pod['aktivno'] == 2 ) {



    $upi = "UPDATE ".$tabela." SET aktivno = 3 WHERE id = '".$_POST['id']."'";

    mysql_query ( $upi ) or die ('p1');

    echo '<img src="/vivo2/ikone/flag_black.png"> ';



}



if ( $pod['aktivno'] == 1 ) {



    $upi = "UPDATE ".$tabela." SET aktivno = 2 WHERE id = '".$_POST['id']."'";

    mysql_query ( $upi ) or die ('p1');

    echo '<img src="/vivo2/ikone/flag_yellow.png"> ';



}



if ( $pod['aktivno'] == 0 ) {



    $upi = "UPDATE ".$tabela." SET aktivno = 1 WHERE id = '".$_POST['id']."'";

    mysql_query ( $upi ) or die ('p1');

    echo '<img src="/vivo2/ikone/flag_green.png"> ';



}



//echo $upit,'<br>',$upi;



session_write_close ();



?>