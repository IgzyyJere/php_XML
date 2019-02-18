<?php

session_start();

if ( $_GET['prestanak'] ) {                                              

    session_destroy();

}

include ( "vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

//ak su poslane varijable, provjeri jel odgovaraju
if ( $_POST['user'] && $_POST['pass'] ) {


     $upit = "SELECT * FROM korisnici WHERE userMD5='".md5($_POST['user'])."' AND passMD5='".md5($_POST['pass'])."'";
     $odgovori = mysql_query ( $upit );
     $korisnik = mysql_fetch_assoc ( $odgovori );

     if ( $korisnik['username'] ) {

         $upit = "UPDATE korisnici SET zadnjaPosjeta = CURDATE() WHERE id ='".$korisnik['id']."'";
         mysql_query ( $upit );

         $upit = "UPDATE kontroler SET grupa = '0', stranica= '0', akcija= '0', navigacija= '0', idsess= '".session_id()."', razina= '".$korisnik['vrsta']."' WHERE korisnik='".$korisnik['username']."'";
         mysql_query ( $upit );
         unset ( $upit );

         header ("Location: vivo.php");


     }

}


/*
ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);
*/

ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: VIVOcms ::</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>

    
<div id="login-cont">
    
    <div id="login-logo"><img src="elementi/vivo.png"></div>

    <div id="login">
    
        <form action="index.php" method="POST" name="login">
        <div id="login-user"><div class="loginTekst">korisničko ime:</div><input type="text" name="user"></div>
        <div id="login-pass"><div class="loginTekst">lozinka:</div><input type="password" name="pass"></div>
        <div id="login-button"><button type="submit" name="submit">prijavi se</button></div>
        </form>


    </div>

<?php

if ( $_POST['user'] OR $_POST['pass'] ) {

echo 'Pristupni podaci pogrešni, pokušajte ponovno.';

}

?>

</div>

</body>
</html>
