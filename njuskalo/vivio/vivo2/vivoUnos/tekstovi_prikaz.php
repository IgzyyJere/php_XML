<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "tekstovistranica";

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


if ( $_GET['napravi'] == "unos" ) {

// HTMLpurifier, treba rješiti problem ubacivanja iz Worda   /
// prvo uključiti potrebne datoteke   /

     $opis = nl2br($_POST['tekst']);
     $opis = str_replace("\n", "", $opis);
     $opis = str_replace("\r", "", $opis);
     $newstring = preg_replace("/[\n\r]/","",$subject);
     require_once 'vivoFunkcije/htmlpurifier/library/HTMLPurifier.auto.php';
     $config = HTMLPurifier_Config::createDefault();
     $config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
     $purifier = new HTMLPurifier($config);

     $clean = $purifier->purify($opis);
     $opis = mysql_real_escape_string($clean);

    $upit = "INSERT INTO ".$tabela."
            ( id, grupa, jezik, tekst, naslov, obrisano, slike, datoteke )
            VALUES
            ( '', '".$grupa."', '".$_POST['jezik']."', '".$opis."',
            '".$_POST['naslov']."',  '0', '".$_POST['inputPopisSlika']."', '".$_POST['inputPopisDatoteka']."')";
    mysql_query ( $upit );
}

if ( $_GET['napravi'] == "izmjeni" ) {

     $opis = nl2br($_POST['tekst']);
     $opis = str_replace("\n", "", $opis);
     $opis = str_replace("\r", "", $opis);
     $newstring = preg_replace("/[\n\r]/","",$subject);
     require_once 'vivoFunkcije/htmlpurifier/library/HTMLPurifier.auto.php';
     $config = HTMLPurifier_Config::createDefault();
     $config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
     $purifier = new HTMLPurifier($config);

     $clean = $purifier->purify($opis);
     $opis = mysql_real_escape_string($clean);


    $upit = "UPDATE `".$tabela."`
            SET
            jezik = '".$_POST['jezik']."',
            naslov = '".$_POST['naslov']."',
            slike = '".$_POST['inputPopisSlika']."',
            datoteke = '".$_POST['inputPopisDatoteka']."',
            tekst = '".$opis."'
            WHERE
            id = '".$_GET['id']."'";
            
    mysql_query ( $upit );

}

// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

if ( !$_POST['grupa'] ) {
    
    $u = "SELECT grupa FROM kontroler WHERE idsess='".session_id()."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    $_POST['grupa'] = $p['grupa'];

}

$upit = "SELECT * FROM `".$tabela."` WHERE grupa = '".$_POST['grupa']."' ORDER BY id DESC";
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
        ',$podaci['naslov'],' (',$podaci['jezik'],')</div>
    </div>';
    
    $i ++;
    
    }

?>

