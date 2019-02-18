<?php

ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// odredi tabelu   /
$tab = substr ( $_POST['id'], 0, 1 );

switch($tab)
{
    case "s":
    $stranica = "stan";
    $tabela = "vivostanovi";
    break;

    case "k":
    $stranica = "kuce";
    $tabela = "vivokuce";
    break;

    case "p":
    $stranica = "posl";
    $tabela = "vivoposlovni";
    break;

    case "z":
    $stranica = "zem";
    $tabela = "vivozemljista";
    break;

    case "o":
    $stranica = "ost";
    $tabela = "vivokuce";
    break;

    case "z":
    $stranica = "turizam";
    $tabela = "vivoturizam";
    break;

}

// odredi ID u tabeli    /
$tabId = substr ( $_POST['id'], 1, 100 );

// sad uzmi grupu   /

$u = "SELECT grupe.vrsta AS vrsta
      FROM grupe
      INNER JOIN ".$tabela."
      ON ".$tabela.".grupa = grupe.id
      WHERE
      ".$tabela.".id = '".$tabId."'";
$o = mysql_query ( $u );
$vrsta = mysql_result ( $o, 0 );
$vrstaDio = explode ( " ", $vrsta );

if ( $_POST['vrsta'] == 2 ) {


    echo '/vivo2/0/',$stranica,'_',$vrstaDio[1],'/izmjena/',$tabId,'/';

}

if ( $_POST['vrsta'] == 1 ) {

    echo '/vivo2/0/',$stranica,'_',$vrstaDio[1],'/prikaz/',$tabId,'/samoJedan=1';

}


?>