<?php

// odreðivanje tabele iz koje se vuku podaci

$tabela = "zamjene";

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


$arr = Array ( vivostanovi => "stanovi", vivoposlovni => "poslovni", vivokuce => "kuæe", vivozemljista => "zemljišta", vivoostalo => "ostalo", vivoturizam => "turistièki" );
selectUpdateArray ( "Vrsta nekretnine", "tabela", $arr, $podaci['tabela'] );
formUpdate ( "ID nekretnine", "idNekretnine", $podaci['idNekretnine'] );

$u = "SELECT naziv FROM grupe WHERE vrsta LIKE '%prodaja'";
$o = mysql_query ( $u );
$vr = array();
$vr[0] = "-----------------";
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['naziv'];
    $vr[$key] = $p['naziv'];

}
selectUpdateArray ( "Zamjena za", "nek1", $vr, $podaci['nek1'] );
mixedUpdate ( "Vrijednost", "vr1", $podaci['vr1'] );

selectUpdateArray ( "Zamjena za:", "nek2", $vr, $podaci['nek2'] );
mixedUpdate ( "Vrijednost", "vr2", $podaci['vr2'] );

selectUpdateArray ( "Zamjena za:", "nek3", $vr, $podaci['nek3'] );
mixedUpdate ( "Vrijednost", "vr3", $podaci['vr3'] );

selectUpdateArray ( "Zamjena za:", "nek4", $vr, $podaci['nek4'] );
mixedUpdate ( "Vrijednost", "vr4", $podaci['vr4'] );

selectUpdate ( "Po kvadraturi", "poKvadraturi", $podaci['poKvadraturi'] );
selectUpdate ( "Po vrijednosti", "poVrijednosti", $podaci['poVrijednosti'] );

formUpdate ( "Lokacija", "lokacija", $podaci['lokacija'] );
formUpdate ( "Doplata", "doplata", $podaci['doplata'] );

?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>