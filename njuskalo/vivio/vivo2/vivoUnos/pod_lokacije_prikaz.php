<div style="padding:10px;">Izaberite teritorijalnu jedinicu:<br>
    <?php

    $u = "SELECT id, nazivZupanije FROM zupanije WHERE lokacije = '1'";
    $o = mysql_query ( $u );
    while ( $zup = mysql_fetch_assoc ( $o )) {
        echo '<a href="/vivo2/0/0/0/0/zup=',$zup['id'],'">',$zup['nazivZupanije'],'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
        }

    ?>
    </div>


<?php

$tabela = "definiranelokacije";

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

// provjera jel poslan ID županije, ako nije izvadi pdatak iz kontrolera  /

if ( $_GET['zup'] ) {
    $zup = $_GET['zup'];
    //spremi u kontroler o kojoj se županiji radi
    $u = "UPDATE kontroler SET pomocni = '".$_GET['zup']."' WHERE idsess='".session_id()."'";
    mysql_query ( $u );
} else {
    // provjeri u kontroleru o kojoj županiji se radi
    $u = "SELECT pomocni FROM kontroler WHERE idsess='".session_id()."'";
    $o = mysql_query ( $u );
    $zup = mysql_result( $o, 0);
}



// unos podataka   /
if ( $_GET['napravi'] == "unos" ) {

    $upit = "INSERT INTO ".$tabela."
            ( naziv, zupanija )
            VALUES
            ( '".$_POST['naziv']."', '".$zup."' )";

    mysql_query ( $upit );

}


// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}



$upit = "SELECT * FROM $tabela WHERE zupanija = '".$zup."'";
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
    <div class="lineRight">&nbsp;&nbsp;
        <strong>',$podaci['naziv'],'</strong> - ';

        $u = "SELECT naziv FROM gradovi WHERE idlokacije = '".$podaci['id']."'";
        $o = mysql_query ( $u );
        while ( $p = mysql_fetch_assoc ( $o )) {
            echo $p['naziv'],', ';
        }
        echo '</div>
    </div>';

    $i ++;

    }

//                                                     /
// provjera jel ima nedodjeljenih lokacija u županiji  /
//                                                     /


$u = "SELECT naziv FROM gradovi WHERE ( idlokacije IS NULL OR idlokacije = '0' ) AND zupanija = '".$zup."' ORDER BY naziv";
$o = mysql_query ( $u );
$broj = mysql_num_rows($o);
if ( $broj ) {
    echo '<center><span style="color: #f00; font-weight: bold;">OPREZ!! NEKE LOKACIJE NISU DODJELJENE</span></center>Popis nedodjeljenih loakcija:<br>';
    while ( $podaci = mysql_fetch_assoc ( $o )) {
        echo $podaci['naziv'],', ';
        }
    echo '<br><b>Potrebno je dodijeliti sve lokacije inače se nedodjeljene lokacije neće vidjeti u pretraživaču.</b>';
}
?>

