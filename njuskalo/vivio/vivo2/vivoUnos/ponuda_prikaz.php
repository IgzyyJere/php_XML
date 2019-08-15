<?php

// briasnje iz popisa, to treba biti prvo    /

if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `popisZaSlanje` WHERE idNekretnine = '".$_GET['obrisi']."'  AND idsess = '".session_id()."'";
    mysql_query ( $upit );
}

// sami upit, da se pokaže što je    /
// sve u popisu                      /

$upit = "SELECT * FROM popiszaslanje WHERE email = '0' AND idsess = '".session_id()."'";
$odgovori = mysql_query ( $upit );

$i = 0;

while ( $popis = mysql_fetch_assoc ( $odgovori )) {

    $tabela = $popis['tabela'];

    if ( $tabela == "vivozemljista" OR $tabela == "vivoostalo" ) {
        $uu = "SELECT id, mikrolokacija, povrsina, cijena, aktivno, kvart, grad FROM ".$tabela."
        WHERE id '".$popis['idNekretnine']."'";
    } else {
        $uu = "SELECT id, mikrolokacija, povrsina, ukupnaPovrsina, cijena, aktivno, kvart, grad FROM ".$tabela."
        WHERE id = '".$popis['idNekretnine']."'";
    }
    $oo = mysql_query ( $uu );
    $pp = mysql_fetch_assoc ( $oo );


    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$pp['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
            </div>

            <div class="prikazLineRight">';

    $u = "SELECT * FROM gradovi WHERE id = '".$pp['grad']."'";
    $o = mysql_query ( $u );
    $grad = mysql_fetch_assoc ( $o );

    echo $grad['naziv'],' / ';

    $u = "SELECT * FROM kvartovi WHERE id = '".$pp['kvart']."'";
    $o = mysql_query ( $u );
    $kvart = mysql_fetch_assoc ( $o );


    echo $kvart['naziv'],' / ',$pp['mikrolokacija'],' : ';

    if ( $tabela == "vivozemljista" ) {

        echo $pp['povrsina'];

    } else {

        echo $pp['ukupnaPovrsina'];

    }

    echo ' m<sup>2</sup> : ',$pp['cijena'],' &euro; - ';

    echo ' <b> ID</b> : ',$popis['idNekretnine'],'</div>';

    if ( $popis['idKlijenta'] ) {

        switch ( $tabela ) {

            case 'vivostanovi':
            $provjera = "klijentistanovi";
            break;

            case 'vivoposlovni':
            $provjera = "klijentiposlovni";
            break;

            case 'vivokuce':
            $provjera = "klijentikuce";
            break;

            case 'vivozemljista':
            $provjera = "klijentizemljista";
            break;

            case 'vivoostalo':
            $provjera = "klijentiostalo";
            break;

            }

        $uuK = "SELECT imeIPrezime FROM ".$provjera." WHERE id = '".$popis['idKlijenta']."'";
        $ooK = mysql_query ( $uuK );
        echo 'Klijent / kupac: <strong>', mysql_result ( $ooK, 0 ), '</strong>';

        }

        echo '</div>
            ';


    $i++;
}
    
?>

