<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "korisnici";

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

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );


//                        /
//određivanje paginacije  /
//                        /

$poStranici = 25;
$padding = 3;
$sqlUkupno = "SELECT COUNT(id) FROM korisnici ORDER BY id DESC";
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


// unos podataka   /
if ( $_GET['napravi'] == "unos" ) {

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi" );
    mysql_query ( vivoPOSTunosPass ( $_POST, $tabela, $izuzeci ));
    //echo vivoPOSTunosPass ( $_POST, "korisnici", $izuzeci );
    $u = "INSERT INTO kontroler ( korisnik ) VALUES ( '".$_POST['username']."' )";
    mysql_query ( $u );
}

// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

// izmejna podataka        /
if ( $_GET['napravi'] == "izmjeni" ) {

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi" );
    mysql_query ( vivoPOSTizmjenaPass ( $_POST, $tabela, $izuzeci, $id ));
    //echo vivoPOSTizmjenaPass ( $_POST, $tabela, $izuzeci, $id );
    $u = "UPDATE kontroler SET korisnik = '".$_POST['username']."' WHERE id = '".$id."'";
    mysql_query ( $u );

}

$upit = "SELECT id, ime, prezime FROM ".$tabela." ORDER BY id DESC";
$odgovori = mysql_query ( $upit );

$i = 0;

while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {

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

            <div class="prikazLineRight"> &nbsp;&nbsp;
        ',$podaci['ime'],' ',$podaci['prezime'],'</div>
    </div>';

    $i ++;

    }


?>




