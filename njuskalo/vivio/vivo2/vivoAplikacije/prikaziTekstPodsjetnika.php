<?php

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8"); 

$upit = "SELECT * FROM podsjetnik WHERE id = '".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

switch ( $podaci['spojiTabela'] ) {

    case 'klijentikuce':
    case 'klijentistanovi':
    case 'klijentiposlovni':
    case 'klijentiostalo':
    case 'klijentizemljista': 
    
    $vrsta = "klijent";
    break;
    
    case 'vivokuce':
    case 'vivostanovi':
    case 'vivoposlovni':
    case 'vivoostalo':
    case 'vivozemljista': 
    
    $vrsta = "nekretnina";
    break;
    
}

if ( $vrsta == "klijent" ){
    
    echo 'Naslov:<br />',$podaci['naslov'],'<br /><br />Tekst podsjetnika:<br />',$podaci['tekst'],'<br />';
    
    //podaci o klijentu 
    
    echo '<br /><br />Podaci o klijentu :<br />';
    
    $u = "SELECT id, imeIPrezime, mjesto, adresa, mobitel, povTelefon, napomena, email FROM `".$podaci['spojiTabela']."` WHERE `id` = '".$podaci['spojiId']."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );

if ( $p['id'] ) {
    
    echo 'Ime i prezime: ',$p['imeIPrezime'],'<br />
      Mjesto stanovanja: ',$p['mjesto'],'<br />
      Adresa: ',$p['adresa'],'<br />
      Mobitel: ',$p['mobitel'],'<br />
      Telefon: ',$p['povTelefon'],'<br />
      E-mail: ',$p['email'],'<br />';
      
}
    
}

if ( $vrsta == "nekretnina" ){
    
    echo 'Naslov:<br />',$podaci['naslov'],'<br /><br />Tekst podsjetnika:<br />',$podaci['tekst'],'<br />';
    
    //podaci o vlasniku 
    
    $u = "SELECT id, mikrolokacija, povrsina, imeIPrezime, mjesto, adresa, mobitel, povTelefon, napomena, email, kvart, grad, grupa, prebivaliste FROM `".$podaci['spojiTabela']."` WHERE `id` = '".$podaci['spojiId']."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    
    echo '<br /><br />Podaci o nekretnini:<br />';
    
    $mupit = "SELECT * FROM grupe WHERE id='".$p['grupa']."'";
    $modg = mysql_query ( $mupit );
    $mpod = mysql_fetch_assoc ( $modg );
    
    echo $mpod['parentGroup'],' / ',$mpod['groupName'],'<br /><br />';
    
    $mupit = "SELECT * FROM gradovi WHERE id='".$p['grad']."'";
    $modg = mysql_query ( $mupit );
    $mpod = mysql_fetch_assoc ( $modg );
    
    echo $mpod['naziv'],' / ';    
    
    $mupit = "SELECT * FROM kvartovi WHERE id='".$p['kvart']."'";
    $modg = mysql_query ( $mupit );
    $mpod = mysql_fetch_assoc ( $modg );  
        
    echo $mpod['naziv'],' / ',$p['mikrolokacija'],' - ',$p['povrsina'],' m<sup>2</sup><br />';
    
    echo '<br />Podaci o vlasniku nekretnine :<br />';

if ( $p['id'] ) {
    
    echo 'Ime i prezime: ',$p['imeIPrezime'],'<br />
      Mjesto stanovanja: ',$p['mjesto'],'<br />
      Adresa: ',$p['adresa'],'<br />
      Prebivalište: ',$p['prebivaliste'],'<br />
      Mobitel: ',$p['mobitel'],'<br />
      Telefon: ',$p['povTelefon'],'<br />
      E-mail: ',$p['email'],'<br />';
      
}
    
}

?>