<?php

session_start ();

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// unesi podatke u tabelu "popisZaSlanje"   /

$upit = "INSERT INTO popiszaslanje
        ( tabela, idNekretnine, email, datum, idKlijenta, idsess )
        VALUES
        ( '".$_POST['tabela']."', '".$_POST['id']."', '0', '0', '0', '".session_id()."' )";
mysql_query ( $upit );

echo 'Nekretnina ',$_POST['tabela'],', id = ',$_POST['id'],' dodana u popis';

session_write_close ();

?>