<?php

$tabela = "novoprojekti";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' ),
                        array ( 'unos', 'unos' )

                        );

// pomoćni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = "";


include ( 'vivoIncludes/buttons.php' );


//                        /
//određivanje paginacije  /
//                        /

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela." WHERE ( obrisano IS NULL OR obrisano = '0' )";
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

$u = "SELECT * FROM kontroler WHERE idsess='".session_id()."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );


// brisanje podataka   /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `novoprojekti` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}
if ( $_GET['obrisiObjekt'] ) {
    $upit = "DELETE FROM `novoobjekti` WHERE id = '".$_GET['obrisiObjekt']."'";
    mysql_query ( $upit );
}


// izmjene podataka   /
if ( $_POST['izmjenaProjekta'] ) {
    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "izmjenaProjekta" );
    mysql_query ( vivoPOSTizmjena ( $_POST, "novoprojekti", $izuzeci, $_POST['id'] ));
}
if ( $_POST['izmjenaObjekta'] ) {
    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "izmjenaObjekta" );
    mysql_query ( vivoPOSTizmjena ( $_POST, "novoobjekti", $izuzeci, $_POST['id'] ));
}


// prikaz podataka   /
$upit = "SELECT id, naziv, aktivno FROM ".$tabela." ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
$i = 0;
while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {
    
    if ( $i % 2 ) {

        $back = "darkLine";
        
    } else {
        
        $back = "lightLine";
        
    }
    
    echo '<div class="',$back,' prikazFormLineNoHeight">
            <div class="prikazLineLeftLong">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
                <a href="/vivo2/0/0/dodavanjeObjekta/',$podaci['id'],'/" class="smallButtonLong smallBlue">Dodaj objekt</a>
            </div>

            <div class="prikazLineRightShort">',$podaci['naziv'],'<b> ID</b> : ',$podaci['id'],'</div>

            <div class="prikazPomocniNav">';

        // on / off                   /
    echo '<a href="" title="uključi / isključi" ref="',$podaci['id'],'" class="onOff">';


    if ( $podaci['aktivno'] ) {

        echo '<img src="/vivo2/ikone/flag_green.png"> ';

    }  else {

        echo '<img src="/vivo2/ikone/flag_red.png"> ';

    }


    echo '</a>';


    // podsjetnik                  /

    echo '<a href="/vivo2/podesavanja/podsjetnik/unos/0/?tabela="',$tabela,'&id=',$podaci['id'],'" class="dodajPodsjetnik"><img src="/vivo2/ikone/bell_add.png"></a>';

    // printanje podataka          /

    echo '<a href="" title="isprintaj podatke" ref="',$tabela,'" rel="',$podaci['id'],'" class="printajPodatke"><img src="/vivo2/ikone/printer.png"></a>';

    // dodaj u popis za slanje ponude /


    echo '<a href="" title="dodaj u popis" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodajNaPopis"><img src="/vivo2/ikone/script_add.png"></a>';


    echo '</div>';

$upitObjekt = "SELECT id, naziv FROM novoobjekti WHERE idProjekta = '".$podaci['id']."' ORDER BY id DESC";
$odgovoriObjekt = mysql_query ( $upitObjekt );
while ( $podaciObjekt = mysql_fetch_assoc ( $odgovoriObjekt ))  {

    echo '<div class="formLineObjekt">
            <div class="lineLeftObjekt">
                <a href="/vivo2/0/0/0/0/obrisiObjekt=',$podaciObjekt['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjenaObjekta/',$podaciObjekt['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRightShort"> &nbsp;&nbsp;&nbsp; <strong>objekt</strong>: ',$podaciObjekt['naziv'],'&nbsp;&nbsp;&nbsp;<b> ID</b> : ',$podaciObjekt['id'],'</div>

        </div>';


}

    $i ++;

    echo '</div>';

    }

?>
