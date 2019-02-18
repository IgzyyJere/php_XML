<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "vivokuce";

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


if ( $_GET['obrisi'] ) {

    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );

}

if ( $_POST['submit'] ) {

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id" );
    mysql_query ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $_POST['id'] ));

}

// prvo ispis projekata, a onda klikom  /
// daj popis stanova u tom projektu     /

if ( $_GET['projekt'] OR $_POST['submit'] ) {

// treba ubacit podatak koji je ID projekta /
// u kontroler, da se stanove može povezati /
// sa projektom                             /

if ( $_GET['projekt'] ) {
    $upit = "UPDATE kontroler SET pomocniID = '".$_GET['projekt']."' WHERE idsess = '".session_id()."'";
    mysql_query ( $upit );
    $idProjekta = $_GET['projekt'];
// ako je pak UPDATE kroz formular, treba /
// doznati ID iz kontrolera               /
} else {
    $upit = "SELECT pomocniID FROM kontroler WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $idProjekta = mysql_result ( $odgovori, 0 );
}

// kućei, unutar projekta  /
$upit = "SELECT id, povrsina, ukupnaPovrsina, aktivno, cijena FROM ".$tabela." WHERE idProjekta = '".$idProjekta."' ORDER BY id DESC";
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
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'&projekt=',$_GET['projekt'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

    <div class="lineRight">',$podaci['ukupnaPovrsina'],' m<sup>2</sup> : ',$podaci['cijena'],' &euro; - ';

    echo ' <b> ID</b> : ',$podaci['id'],'</div>';

        // početak DIV za prikaz      /

    echo '<div class="prikazPomocniNav">';

    // on / off                   /

    echo '<a href="" title="uključi / isključi" ref="',$podaci['id'],'" class="onOff">';


    if ( $podaci['aktivno'] ) {

        echo '<img src="/vivo2/ikone/flag_green.png"> ';

    }  else {

        echo '<img src="/vivo2/ikone/flag_red.png"> ';

    }


    echo '</a>
    </div></div>';
    
    $i ++;

    }

} else {

// ovdje je ispis projekata  /

    $i = 0;
    $upit = "SELECT id, naziv FROM novoprojekti ORDER BY id DESC";
    $odgovori = mysql_query ( $upit );
    while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

        if ( $i % 2 ) {

            $back = "darkLine";

        } else {

            $back = "lightLine";

        }

        echo '<div class="',$back,' prikazFormLine">
                <div class="prikazLineLeft">
                    <a href="/vivo2/0/0/0/0/projekt=',$podaci['id'],'" class="smallButton smallBlue">Izaberi</a>
                </div>
            <div class="lineRight">',$podaci['naziv'],' <strong>ID</strong> : ',$podaci['id'],'</div></div>';

        $i++;

    }

}

?>

