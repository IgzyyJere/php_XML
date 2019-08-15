<?php

session_start();


include ( "vivoFunkcije/baza.php" );

mysql_query ("set names utf8");



// provjera dal je session prijavljen, prije bilo kakvog daljnjeg rada



$upit = "SELECT kontroler.korisnik AS korisnik, korisnici.id AS id, korisnici.zadnjaPosjeta AS zadnjaPosjeta

        FROM kontroler

        INNER JOIN korisnici

        ON korisnici.username = kontroler.korisnik

        WHERE kontroler.idsess='".session_id()."'";

$odgovori = mysql_query ( $upit );

$korisnik = mysql_fetch_assoc ( $odgovori );



if ( !$korisnik['id'] ) {



    die ('Niste prijavljeni.');



}





/*

foreach ( $_GET as $key => $value ) {



    echo $key,' - ',$value,' <strong> <> </strong>';



}



ini_set('display_errors','1');

ini_set('display_startup_errors','1');

error_reporting (E_ALL ^ E_NOTICE);



ini_set('display_errors','0');

ini_set('display_startup_errors','0');

error_reporting (0);

*/



ini_set('display_errors','0');

ini_set('display_startup_errors','0');

error_reporting (0);



// učitaj potrebne funkcije



include ( "vivoFunkcije/definicijePolja.php" );

include ( "vivoFunkcije/formular.php" );

include ( "vivoFunkcije/formularUpdate.php" );

include ( "vivoFunkcije/imenaPolja.php" );

include ( "vivoFunkcije/postFunkcije.php" );

include ( "vivoFunkcije/prikazFunkcije.php" );







/*                                        *

      ODREĐIVANJE NAVIGACIJE              *

                                         */





// određuje se koja se datoteka iz vivoNav direktorija učitava              /

// datoteku određuje podatak navigacija iz /navigacija/datoteka/akcija/id/  /

// odnosno $_GET['navigacija'] nakon .htaccess odrade URLa                  /



if ( $_GET['navigacija'] ) {



    $navigacija = $_GET['navigacija'];



    // ubaci podatak u kontroler, da se može kretati unutar navigacije



    $upit = "UPDATE kontroler SET navigacija = '".$navigacija."' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



} else {



    // nije određena promjena navigacije, treba koristiti već određenu  /

    // pitaj kontroler i prema tome odredi što se koristi               /



    $upit = "SELECT navigacija FROM kontroler WHERE idsess='".session_id()."'";

    $odgovori = mysql_query ( $upit );

    $navigacija = mysql_result ( $odgovori, 0 );



}



// ukoliko nije određena navigacija (kod logina)                  /

// prikaži default->podesavanje->obavijesti                       /



if ( !$navigacija ) {



    $navigacija = "podesavanja";



}



/*                                        *

    ODREĐIVANJE STRANICE I AKCIJE         *

                                         */



//određuje se koje se stranica učitava iz vivoUnos direktorija                        /

//datoteku određuju podaci stranica i akcija iz /navigacija/stranica/akcija/id/       /

// odnosno $_GET['navigacija'] i $_GET['stranica'] nakon .htaccess odrade URLa        /



if ( $_GET['stranica'] ) {



    $stranica = $_GET['stranica'];



    // ubaci podatak u kontroler, da se može kretati unutar vrste datoteke



    $upit = "UPDATE kontroler SET stranica = '".$stranica."' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



} else {



    // nije određena promjena stranice, treba koristiti već određenu  /

    // pitaj kontroler i prema tome odredi što se koristi             /



    $upit = "SELECT stranica FROM kontroler WHERE idsess='".session_id()."'";

    $odgovori = mysql_query ( $upit );

    $stranica = mysql_result ( $odgovori, 0 );



}



// odredi tabelu za rad prema stranici  /

include ( "vivoAplikacije/switchTabela.php" );



if ( $_GET['akcija'] ) {



    $akcija = $_GET['akcija'];



    // ubaci podatak u kontroler, da se može kretati unutar grupe



    $upit = "UPDATE kontroler SET akcija = '".$akcija."' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



} else {



    // nije određena promjena grupe, treba koristiti već određenu  /

    // pitaj kontroler i prema tome odredi što se koristi          /



    $upit = "SELECT akcija FROM kontroler WHERE idsess='".session_id()."'";

    $odgovori = mysql_query ( $upit );

    $akcija = mysql_result ( $odgovori, 0 );



}





// ukoliko nema ni jednog ni drugog podatka (kod logina)     /

// prikaži default.php koji sadrži vijesti i slične podatke  /



if ( !$stranica AND !$akcija ) {



    $stranica = "pod_obavijesti";

    $akcija = "prikaz";



}



/*                                        *

      ODREĐIVANJE ID-a                    *

                                         */



if ( $_GET['id'] ) {



    $id = $_GET['id'];



    // ubaci podatak u kontroler, naziv polja je "radniID"  /



    $upit = "UPDATE kontroler SET radniID = '".$id."' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



}





/*                                        *

      ODREĐIVANJE GRUPE                   *

                                         */



// grupa (odnosno id grupe) se određuje samo prilikom  /

// specifičnog poziva, npr. ->                         /

// /0/stanovi_prodaja/prikaz/12/                       /

// /navigacija/stranica/akcija/id/                     /

//                                                     /

// akcija mora biti "prikaz", a stranica i ID moraju   /

// biti određeni                                       /



if ( $_GET['akcija'] == "prikaz" AND $_GET['id'] AND $_GET['stranica'] ) {



    $upit = "UPDATE kontroler SET grupa = '".$_GET['id']."' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



}



if ( $_GET['akcija'] == "prikaz" AND $_GET['id'] == 0 AND $_GET['stranica'] ) {



    $upit = "UPDATE kontroler SET grupa = '0' WHERE idsess='".session_id()."'";

    mysql_query ( $upit );



}



// sada vadimo podatak koja je grupa zadnja unesena /

// i taj podatak koristimo kao $grupa na svakoj     /

// stranici                                         /



$upit = "SELECT grupa FROM kontroler WHERE idsess='".session_id()."'";

$odgovori = mysql_query ( $upit );

$grupa = mysql_result ( $odgovori, 0 );





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>:: VIVOcms ::</title>

<link href="/vivo2/css/vivoLayout.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/vivoButtons.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/vivoForms.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/vivoApplication.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/uploadify.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/tip-twitter.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/superfish.css" rel="stylesheet" type="text/css" />

<link href="/vivo2/css/js_color_picker_v2.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="/vivo2/js/jquery-1.8.3.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.dimensions.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.shadow.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.fancyzoom.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.form.min.js"></script>

<script type="text/javascript" src="/vivo2/js/impromptu.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.wysiwyg.js"></script>

<script type="text/javascript" src="/vivo2/js/swfobject.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.uploadify.v2.1.0.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.poshytip.js"></script>

<script type="text/javascript" src="/vivo2/js/superfish.js"></script>

<script type="text/javascript" src="/vivo2/js/supersubs.js"></script>

<script type="text/javascript" src="/vivo2/js/hoverIntent.js"></script>

<script type="text/javascript" src="/vivo2/js/jquery.bgiframe.min.js"></script>

<script type="text/javascript" src="/vivo2/js/color_functions.js"></script>

<script type="text/javascript" src="/vivo2/js/js_color_picker_v2.js"></script>

<script type="text/javascript" src="/vivo2/js/vivo.js"></script>

</head>

<body>

<div id="vivoContainer">

<div id="header">



    <div id="logo"></div>



    <div id="topbar">



    <?php



	include ( "vivoIncludes/topbarMsg.php" );

        include ( "vivoIncludes/topbarReminder.php" );



    ?>



    </div>



    <div id="helpbar">

	<!--

        <a href="/vivo2/dokumenti/faq/0/0"><img src="/vivo2/elementi/faq.png" alt="" /></a>

        <a href="/vivo2/dokumenti/help/0/0"><img src="/vivo2/elementi/help.png" alt="" /></a>

        -->

	<a href="/vivo2/index.php?prestanak=1"><img src="/vivo2/elementi/close.png" alt="" /></a>



    </div>



    <div id="mainbar"><?php include ( 'vivoIncludes/mainbar.php'); ?></div>



</div>



<div id="main">



<div id="mainAreaContainer">



    <div id="mainarea">



<?php



// ovdje ubaci u glavni dio stranice datoteku prema vrsti i akciji  /



include ( "vivoUnos/".$stranica."_".$akcija.".php" );



?>



    </div>



</div>

</div>

</div>

<?php



// ovaj dio (sa JavaScriptom dole) označava trenutno aktivni dio /

// navigacije



if ( $akcija == "unos" OR $akcija == "izmjena" ){

  $akcija = "prikaz";

}



?>

<script>

  $(document).ready(function(){

      var cssObj = {

        'background-color' : '#bbb',

        'font-weight' : 'bold',

        'color' : '#000'

      }



    $(".navLinksList a[href$='<?php echo "/".$stranica."/".$akcija."/".$grupa."/";  ?>']").css(cssObj);

  });

</script>





<div id="ajaxLoader">učitavanje .....<img src="/vivo2/elementi/loader.gif" alt="" /></div>



<?php



session_write_close();



?>

<br /><br /><br />

</body>

</html>

