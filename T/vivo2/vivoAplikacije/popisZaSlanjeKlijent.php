<?php

session_start ();

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// unesi podatke u tabelu "popisZaSlanje"   /

$upit = "INSERT INTO popiszaslanje
        ( tabela, idNekretnine, email, idKlijenta, idsess )
        VALUES
        ( '".$_POST['tabela']."', '".$_POST['idNekretnine']."', '0', '".$_POST['id']."', '".session_id()."' )";
mysql_query ( $upit );

echo 'Klijent / kupac id = ',$_POST['id'],' dodan u popis';

session_write_close ();

?>