<?php
// određivanje tabele iz koje se vuku podaci

$tabela = "vivoturizam";

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

$pomocniGumbi = Array (
                        array ( 'adresar', 'adresar' ),
                        array ( 'lista', 'lista' )

                        );

include ( 'vivoIncludes/buttons.php' );
include ( 'vivoAplikacije/breadcrumbNekretnine.php' );

if ( !$_POST['submit'] ) {

echo '<form name="testForm" method="POST" id="mainForm" action="">';
echo '<div class="formPrivate">Osnovni podaci</div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");

formInsert ( "Cijena", "cijena" );
formInsert ( "Površina objekta", "cvrstiObjektm2" );
formInsert ( "Površina zemljišta", "zemljistem2" );
selectInsert ( "Grijanje", "grijanje" );
multiRadioInsert ( "Klima", "klima" );
multiRadioInsert ( "Kabel", "kabel" );
multiRadioInsert ( "Satelit", "satelit" );
multiRadioInsert ( "Internet", "internet" );
multiRadioInsert ( "Telefonski priključak", "telefon" );
multiRadioInsert ( "Bazen", "bazen" );
mixedInsert ( "Garaža", "garaza" );
selectInsert ( "Parkiralište", "parkiraliste" );
formInsert ( "Udaljenost od parkirališta", "udaljenostParkiralista" );
selectInsert ( "Dostupnost automobilom", "dostupnostAutomobilom" );
formInsert ( "Broj parkirnih mjesta", "parkirnaMjestaBroj" );
formInsert ( "Broj garažnih mjesta", "garaznaMjestaBroj" );

//ruler

echo '<hr class="ruler">';
formInsert ( "Udaljenost od centra", "udaljenostCentar" );
formInsert ( "Udaljenost od aerodroma", "udaljenostAerodrom" );
formInsert ( "Udaljenost od autobusa", "udaljenostAutobus" );
formInsert ( "Udaljenost od mora", "udaljenostMore" );
formInsert ( "Udaljenost od plaže", "udaljenostPlaza" );
formInsert ( "Udaljenost od marine", "udaljenostMarina" );
formInsert ( "Udaljenost od trajekta", "udaljenostTrajekt" );
formInsert ( "Udaljenost od trgovine", "udaljenostTrgovina" );
formInsert ( "Udaljenost od restorana", "udaljenostRestoran" );
formInsert ( "Udaljenost od ambulante", "udaljenostAmbulanta" );
formInsert ( "Udaljenost od ljekarne", "udaljenostLjekarna" );
formInsert ( "Udaljenost od prometnice", "udaljenostPrometnica" );


//ruler

echo '<hr class="ruler">';

radioInsert ( "Pogled na more", "pogledMore");
radioInsert ( "Pogled na zelenilo", "pogledZelenilo");
radioInsert ( "Pogled na naselje", "pogledNaselje");
radioInsert ( "Pogled na planine", "pogledPlanine");


//ruler

echo '<hr class="ruler">';

formInsert ( "Kapacitet (sobe - 1)", "kapacitetSobe1krevetne" );
formInsert ( "Kapacitet (sobe - 2)", "kapacitetSobe2krevetne" );
formInsert ( "Kapacitet (sobe - 3)", "kapacitetSobe3krevetne" );
formInsert ( "Kapacitet (sobe - 4)", "kapacitetSobe4krevetne" );
formInsert ( "Kapacitet (sobe - više)", "kapacitetSobeVisekrevetne" );
formInsert ( "Kapacitet (apt - 2)", "kapacitetApartmani2krevetni" );
formInsert ( "Kapacitet (apt - 3)", "kapacitetApartmani3krevetni" );
formInsert ( "Kapacitet (apt - 4)", "kapacitetApartmani4krevetni" );
formInsert ( "Kapacitet (apt - više)", "kapacitetApartmaniVisekrevetni" );

formInsert ( "Broj parcela (šatori)", "brojParcelaSatori" );
formInsert ( "Broj parcela (kamperi)", "brojParcelaCamperi" );
formInsert ( "Broj čvrstih objekata", "brojCvrstihObjekata" );
formInsert ( "Broj ležaja (šatori)", "brojLezajaSatori" );
formInsert ( "Broj ležaja (kamperi)", "brojLezajaCamperi" );
formInsert ( "Broj ležaja (čv. objekti)", "brojLezajaCvrstiObjekti" );

//ruler

echo '<hr class="ruler">';

$u = "SELECT * FROM provizije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['nazivProvizije'];

}


selectInsertArray ( "Provizija", "provizije", $arr, $podaci['nazivProvizije'] );


$u = "SELECT * FROM korisnici";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['ime']." ".$p['prezime'];

}


selectInsertArray ( "Kontakt agent", "agent", $arr, $p['ime']." ".$p['prezime'] );


echo '<div class="formPrivate">Povjerljivi podaci</div>';

formInsert ( "Ime i prezima", "imeIPrezime" );
formInsert ( "Mjesto", "mjesto" );
formInsert ( "Adresa", "adresa" );
formInsert ( "Prebivalište", "prebivaliste" );
formInsert ( "Email", "email" );
formInsert ( "Mobitel", "mobitel" );
formInsert ( "Telefon", "povTelefon" );
formInsert ( "MIN cijena", "minCijena" );
formInsert ( "Pregledali", "pregledali" );
formInsert ( "Kat. čestica", "katCes" );
formInsert ( "Kat. općina", "katOpcina" );
formInsert ( "zk. uložak", "zkUlozak" );
formInsert ( "Interni ID", "idInterni" ) ;
formInsert ( "Naslov oglasa na portalima", "naslovoglasa" ) ;
textareaInsert ( "Napomena", "napomena" );

?>
<input type="hidden" name="brojPogleda" value="1">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( $_POST['submit']  ) {
        

//upis podataka u bazu
$izuzeci = array ( "submit", "continue", "akcija", "stranica", "id" );
$id = vivoPOSTunos( $_POST, $tabela, $izuzeci );

//back button
echo '<a href="/vivo2/0/0/izmjena/',$id,'/" class="bigButtonLong greenButton">Povratak na uređivanje</a>';

//rad sa opisom             /
include ( "vivoAplikacije/opis.php" );

// upravljenje datoteka     /
include ( "vivoAplikacije/upravljanjeDatotekama.php" );

// YouTube                  /
include ( "vivoAplikacije/youtube.php" );

// Google Maps              /
include ( "vivoAplikacije/googleMap.php" );


}

?>

