<?php
// odreðivanje tabele iz koje se vuku podaci

$tabela = "provizije";

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
?>
<div id="unosProvizija">
<form method="POST" id="unosProvizijeForm" action="vivoAplikacije/unosProvizije.php">
Unos nove provizije :<br />
Naziv provizije :<input type="text" name="nazivProvizije"><button type="submit">unesi</button></form>

</div>

<div id="popisProvizija">

</div>