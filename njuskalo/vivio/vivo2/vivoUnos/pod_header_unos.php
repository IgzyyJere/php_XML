<?php

$tabela = "headerslike";

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

echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/">';


// upravljenje datoteka     /
$iskljuciVideo = 1;
$iskljuciSlike = 0;
$iskljuciDatoteke = 1;
$izFormulara = 1;
include ( "vivoAplikacije/upravljanjeDatotekama.php" );

?>

<input type="hidden" name="napravi" value="unos">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" value="submit" type="submit">Unesi</button>
</div>
</form>