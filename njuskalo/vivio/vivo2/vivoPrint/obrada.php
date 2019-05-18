<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: VIVOcms ::</title> 
<link href="vivoprint.css" rel="stylesheet" type="text/css" media="all">                     
</head>
<body onLoad="window.print()">

<?php

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/definicijePolja.php" );
include ( "../../includes/funkcije.php" );
mysql_query ("set names utf8"); 

$upit = "SELECT tecaj FROM tecaj";
$odgovori = mysql_query ( $upit );
$tecaj = mysql_result ( $odgovori, 0);

$jezik = "hr";

if ( $_GET['template'] == 1 ) {
    
    include ( "kartica.php" );
    
}

if ( $_GET['template'] == 2 ) {
    
    include ( "potvrda.php" );
    
}

if ( $_GET['template'] == 3 ) {
    
    include ( "ponuda.php" );
    
}

?>
     
</body>
</html>
