<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "posrednickidnevnik";

// definicija gumba na vrhu stranice  /

// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' )

                        );

// pomoćni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = Array (
                        array ( 'Excel', 'excel' )
                        );


include ( 'vivoIncludes/buttons.php' );

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela."";
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

print_r ($_POST);

// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM ".$tabela." WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}


$upit = "SELECT * FROM ".$tabela." ORDER BY id DESC LIMIT ".$startIndex.", ".$poStranici."";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {


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
    <div class="lineRight">
        ',$podaci['oznaka'],' / ',$podaci['idNekretnine'],' / ',$podaci['vrstaNekretnine'],' / ',$podaci['vlasnikIme'],' / ',$podaci['zupanija'],' / ',$podaci['grad'],' / ',$podaci['kvart'],' </div>
    </div>';

    $i ++;

    }

?>

