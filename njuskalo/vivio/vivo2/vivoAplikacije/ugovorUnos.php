<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// ako je unesen dan, koristi, ako ne, uzmi današnji   /
if ( $_POST['dan'] ) {
    $dan = $_POST['dan'];
} else {
    $dan = date('d');
}
// ako je unesen mjesec, koristi, ako ne, uzmi trenutni   /
if ( $_POST['mjesec'] ) {
    $mjesec = $_POST['mjesec'];
} else {
    $mjesec = date('m');
}
// ako je unesena godina, koristi, ako ne, uzmi trenutnu   /
if ( $_POST['godina'] ) {
    $godina = $_POST['godina'];
} else {
    $godina = date('Y');
}

$datum = $godina.'-'.$mjesec.'-'.$dan;

// unos izvještaja u bazu /
$upit = "INSERT INTO ugovori
        ( imeIPrezime, datum, tabela, idNekretnine, status, posrednicki )
        VALUES
        ( '".$_POST['ime']."', '".$datum."', '".$_POST['tabela']."', '".$_POST['id']."', '".$_POST['status']."', '0' )";
mysql_query ( $upit );

echo 'Ugovor unesen.';

?>