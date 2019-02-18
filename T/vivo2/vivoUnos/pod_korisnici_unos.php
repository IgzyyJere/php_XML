<?php

// odreðivanje tabele iz koje se vuku podaci

$tabela = "korisnici";

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


echo '<form name="mainForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/napravi=unos">';


formInsert ( "Ime", "ime" );
formInsert ( "Prezime", "prezime" );
formInsert ( "Username", "username" );
formInsert ( "Password", "password" );
formInsert ( "E-mail", "email" );
formInsert ( "Telefon", "telefon" );
formInsert ( "Mobitel", "mobitel" );
$arr = array ( 1 => "Admin", 2 => "Korisnik" );
selectInsertArray ( "Razina pristupa", "vrsta", $arr );

?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>


