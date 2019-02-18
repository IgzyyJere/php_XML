<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "zamjene";

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


echo '<form name="mainForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/napravi=unos">';



$arr = Array ( vivostanovi => "stanovi", vivoposlovni => "poslovni", vivokuce => "kuće", vivozemljista => "zemljišta", vivoostalo => "ostalo", vivoturizam => "turistički" );
selectInsertArray ( "Vrsta nekretnine", "tabela", $arr );
formInsert ( "ID nekretnine", "idNekretnine" );

$u = "SELECT naziv FROM grupe WHERE vrsta LIKE '%prodaja'";
$o = mysql_query ( $u );
$vr = array();
$vr[0] = "-----------------";
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['naziv'];
    $vr[$key] = $p['naziv'];

}
selectInsertArray ( "Zamjena za", "nek1", $vr );
mixedInsert ( "Vrijednost", "vr1" );

selectInsertArray ( "Zamjena za:", "nek2", $vr );
mixedInsert ( "Vrijednost", "vr2" );

selectInsertArray ( "Zamjena za:", "nek3", $vr );
mixedInsert ( "Vrijednost", "vr3" );

selectInsertArray ( "Zamjena za:", "nek4", $vr );
mixedInsert ( "Vrijednost", "vr4" );

selectInsert ( "Po kvadraturi", "poKvadraturi" );
selectInsert ( "Po vrijednosti", "poVrijednosti" );

formInsert ( "Lokacija", "lokacija" );
formInsert ( "Doplata", "doplata" );



?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>