<?php

$tabela = "topnekretnine";

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
$sqlUkupno = "SELECT COUNT(id) FROM ".$tabela." WHERE grupa = '".$grupa."'";
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



// unos podataka        /
if ( $_POST['napravi'] == "unos" ) {


    $upit = "INSERT INTO ".$tabela."
            (  grupa, tabela, idNekretnine )
            VALUES
            ( '".$grupa."', '".$_POST['tabela']."', '".$_POST['idNekretnine']."' )";

    mysql_query ( $upit );

}

// izmejna podataka        /
if ( $_POST['napravi'] == "izmjeni" ) {

    $upit = "UPDATE ".$tabela."
            SET
            tabela = '".$_POST['tabela']."',
            idNekretnine = '".$_POST['idNekretnine']."'
            WHERE
            id = '".$id."'";

    mysql_query ( $upit );

}

// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

// prikaz liste podataka   /

if ( $grupa ) {
    $upit = "SELECT * FROM ".$tabela." WHERE grupa = '".$grupa."'";
} else {
    $upit = "SELECT * FROM ".$tabela."";
}
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
        ',$podaci['tabela'],' (',$podaci['idNekretnine'],')</div>
    </div>';

    $i ++;

    }

?>

