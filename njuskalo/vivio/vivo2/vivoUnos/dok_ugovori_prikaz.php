<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "ugovori";

//                        /
//određivanje paginacije  /
//                        /

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela." WHERE status = '".$grupa."'";
$sqlOdgovor = mysql_query ( $sqlUkupno );
$ukupnoPodataka = mysql_result ( $sqlOdgovor, 0 );
$paginacija = ( $ukupnoPodataka > $poStranici ) ? true : false;

if ( $_GET['kreni'] ) {
    $startIndex = ($_GET['kreni'] * $poStranici) - $poStranici;
} else {
  $startIndex = 0;
  $_GET['kreni'] = 1;
}

include ( 'vivoIncludes/pagination.php' );


// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

$upit = "SELECT * FROM `".$tabela."` WHERE status = '".$grupa."' ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    $datum = date_create( $podaci['datum'] );
    $datum = date_format($datum, 'd.m.Y');


    if ( $i % 2 ) {

        $back = "darkLine";

    } else {

        $back = "lightLine";

    }

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>
    <div class="prikazLineRight">ime i prezime kupca: <strong>',$podaci['imeIPrezime'],'</strong> datum izrade: <strong>',$datum,'</strong></div>';



    // početak DIV za prikaz      /

    echo '<div class="prikazPomocniNav">';


    // napravi posrednički dnevnik /

    if ( !$podaci['posrednicki'] ) {

    echo '<a href="" title="napravi posrednicki dnevnik" rel="',$podaci['id'],'" class="napraviPosrednicki"><img src="/vivo2/ikone/report.png"></a>';

    }


    //kraj                         /
    echo '</div>';


    echo '</div>';

    $i ++;

    }

?>

