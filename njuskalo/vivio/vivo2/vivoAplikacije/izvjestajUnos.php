<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// saznaj ID korisnika iz tabele "korisnici"   /
$upit = "SELECT korisnici.id AS korisnik
        FROM kontroler
        INNER JOIN korisnici
        ON korisnici.username = kontroler.korisnik
        WHERE kontroler.idsess='".session_id()."'";
$odgovori = mysql_query ( $upit );
$korisnik = mysql_result ( $odgovori, 0 );

// unos izvještaja u bazu /

$upit = "INSERT INTO izvjestaji
        ( korisnik, datum, tekst, spojenoNa, vrijemeUnosa )
        VALUES
        ( '".$korisnik."', NOW(), '".$_POST['tekst']."', '".$_POST['tabela']."-".$_POST['id']."', NOW() )";
mysql_query ( $upit );

echo 'Izvještaj unesen.';

?>