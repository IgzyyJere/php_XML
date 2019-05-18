<?php

// odreðivanje tabele iz koje se vuku podaci

$tabela = "tekstovistranica";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' ),
                        array ( 'unos', 'unos' )

                        );

// pomoæni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );


echo '<form name="mainForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/napravi=izmjeni&id=',$id,'">';

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );



formUpdate ( "Naslov", "naslov", $podaci['naslov'] );

$u = "SELECT * FROM jezici WHERE aktivno = '1'";
$o = mysql_query ( $u );
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['kratica'];
    $arr[$key] = $p['naziv'];
    
}
    
    
selectUpdateArray ( "Jezik", "jezik", $arr, $podaci['jezik'] );
textareaUpdate ( "Tekst", "tekst", $podaci['tekst'] );

// upravljanje datotekama             /
// treba iskljuèiti neke opcije i     /
// podesiti da sprema popise u        /
// kontroler pošto nema ID-a podatka  /
$iskljuciVideo = 1;
$iskljuciSlike = 0;
$iskljuciDatoteke = 1;
$izFormulara = 1;
include ( "vivoAplikacije/upravljanjeDatotekama.php" );

?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div></div>
</form>