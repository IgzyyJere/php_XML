<?php

$tabela = "portali";

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

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );


if ( $_GET['napravi'] == "izmjeni" ) {
    $upit = "UPDATE `".$tabela."`
            SET
            userID = '".$_POST['userid']."',
            kontakti = '".$_POST['kontakti']."'
            WHERE
            id = '".$_GET['id']."'";
    mysql_query ( $upit );
}


$upit = "SELECT id, naziv FROM ".$tabela." ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {


    if ( $i % 2 ) {

        $back = "darkLine";

    } else {

        $back = "lightLine";

    }

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>
    <div class="lineRight">
        ',$podaci['naziv'],'</div>
    </div>';

    $i ++;

    }




?>

