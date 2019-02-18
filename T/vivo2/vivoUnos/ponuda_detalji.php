<?php

//podaci o klijentu

$upit = "(SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentikuce WHERE email ='".$_GET['mail']."')
        UNION (SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentiposlovni WHERE email ='".$_GET['mail']."')
        UNION (SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentistanovi WHERE email ='".$_GET['mail']."')
        UNION (SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentizemljista WHERE email ='".$_GET['mail']."')
        UNION (SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentiostalo WHERE email ='".$_GET['mail']."')
        UNION (SELECT imeIPrezime, povTelefon, mobitel, email, napomena FROM klijentiturizam WHERE email ='".$_GET['mail']."')";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

echo '<strong>ime i prezime:</strong>',$podaci['imeIPrezime'],'<br>';
echo '<strong>telefon:</strong>',$podaci['povTelefon'],'<br>';
echo '<strong>mobitel:</strong>',$podaci['mobitel'],'<br>';
echo '<strong>napomena:</strong>',strip_tags($podaci['napomena'],'<br>,<br />'),'<br>';

echo '<br><strong>Pregled poslanih ponuda:</strong><br><br>';

$uu = "SELECT * FROM popiszaslanje WHERE email = '".$podaci['email']."' ORDER BY id DESC";
$oo = mysql_query ( $uu );

while ( $pp = mysql_fetch_assoc ( $oo )) {

    echo '<strong>datum</strong>: ',date(" d.m.Y H:i", strtotime( $pp['datum'])),'  &nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;&nbsp;  <strong>tabela</strong>: ',$pp['tabela'],' &nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;&nbsp; <strong>id nekretnine</strong>: ',$pp['idNekretnine'],'<br><br>';

}

?>