<?php

include ( "../vivoFunkcije/baza.php" );

mysql_query ("set names utf8"); 

if ( $_POST['tabela'] ) {
    
    switch ( $_POST['tabela'] ) {
    
      case 'vivostanovi':
      $kl_tabela = "klijentistanovi";
      break;
      
      case 'vivoposlovni':
      $kl_tabela = "klijentiposlovni";
      break;
      
      case 'vivokuce':
      $kl_tabela = "klijentikuce";
      break;
      
      case 'vivozemljista':
      $kl_tabela = "klijentizemljista";
      break;
      
      case 'vivoostalo':
      $kl_tabela = "klijentiostalo";
      break;
      
}
 
$tabela = $_POST['tabela'];
    
}

$upit = "SELECT id, imeIPrezime, mjesto, adresa, mobitel, povTelefon, napomena, prebivaliste, email FROM `".$tabela."` WHERE `id` = '".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

echo 'Vlasnik<br />
      Ime i prezime: ',$podaci['imeIPrezime'],'<br />
      Mjesto stanovanja: ',$podaci['mjesto'],'<br />
      Prebivalište: ',$podaci['prebivaliste'],'<br />
      Adresa: ',$podaci['adresa'],'<br />
      Mobitel: ',$podaci['mobitel'],'<br />
      Telefon: ',$podaci['povTelefon'],'<br />
      E-mail: ',$podaci['email'],'<br />
      Napomena: ',$podaci['napomena'],'<br />';
      
$upit = "SELECT id, imeIPrezime, mjesto, adresa, mobitel, povTelefon, napomena, email FROM `".$kl_tabela."` WHERE `spojeno` = '".$podaci['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

if ( $podaci['id'] ) {
    
    echo '<br /><br />Klijent<br />
      Ime i prezime: ',$podaci['imeIPrezime'],'<br />
      Mjesto stanovanja: ',$podaci['mjesto'],'<br />
      Adresa: ',$podaci['adresa'],'<br />
      Mobitel: ',$podaci['mobitel'],'<br />
      Telefon: ',$podaci['povTelefon'],'<br />
      E-mail: ',$podaci['email'],'<br />
      Napomena: ',$podaci['napomena'],'<br />';
      
}  

?>