<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "vivokuce";

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

if ( !$_POST['submit'] ) {


echo '<form name="testForm" method="POST" id="mainForm" action="">';


echo '<div class="formTitle">Osnovni podaci</div>';

$u = "SELECT pomocniID  FROM kontroler WHERE idsess = '".session_id()."'";
$o = mysql_query ( $u );
$grupa = mysql_result ( $o, 0 );

//dodaj unos grupe i izbor jel se prikazuje sa ostalima

$u = "SELECT * FROM grupe WHERE ( vrsta = 'kuće prodaja' ) ORDER BY id";
$o = mysql_query ( $u );
$arr = array();

$arr[0] = "Ne prikazivati sa ostalim nekretninama";

while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['vrsta'].' - '.$p['grupa'];

}

selectInsertArray ( "Prikaz / grupa", "grupa", $arr );

$u = "SELECT regija, zupanija, grad, kvart FROM novoprojekti WHERE id = '".$grupa."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );

echo '<input type="hidden" name="zupanija" value="',$p['zupanija'],'">';
echo '<input type="hidden" name="regija" value="',$p['regija'],'">';
echo '<input type="hidden" name="grad" value="',$p['grad'],'">';
echo '<input type="hidden" name="kvart" value="',$p['kvart'],'">';
echo '<input type="hidden" name="idProjekta" value="',$grupa,'">';

$u = "SELECT id, naziv FROM novoobjekti WHERE idProjekta = '".$grupa."'";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['naziv'];

}

selectInsertArray ( "Objekt", "idObjekta", $arr );
selectInsert ( "Status prodaje", "statusProdaje" );

//rad sa lokacijama na jednom mjestu


formInsert ( "St. površina", "povrsina" );
formInsert ( "Ukupna površina", "ukupnaPovrsina" );
formInsert ( "Površina okućnice", "okucnica" );
formInsert ( "Cijena", "cijena" );
radioInsert ( "Dodati PDV na cijenu", "pdv" );
formInsert ( "Broj soba", "brojSoba" );
multiRadioInsert ( "Broj etaža", "brojEtazaKuca" );
multiRadioInsert ( "Tip Objekta", "tipObjekt" );
selectInsert ( "Grijanje", "grijanje" );
formInsert ( "Broj kupaonica", "kupaone" );
selectInsert ( "Stanje", "stanje" );
selectInsert ( "Oprema", "oprema" );
mixedInsert ( "Godina izgradnje", "godinaIzgradnje" );
formInsert ( "Zadnja adaptacija", "adaptacija" );
multiRadioInsert ( "Useljenje", "useljenje" );
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>';
echo '</div>';

//ruler
echo '<hr class="ruler">';

mixedInsert ( "Balkon", "balkon" );
mixedInsert ( "Loggia", "loggia" );
mixedInsert ( "Vrt", "vrt" );
mixedInsert ( "Terasa", "terasa" );

echo '<hr class="ruler">';

radioInsert ( "Lift", "lift" );
selectInsert ( "Stolarija", "stolarija" );
selectInsert ( "Namještaj", "namjestaj" );
radioInsert ( "Alarm", "alarm" );
radioInsert ( "Protupožarni sustav", "protupozar" );
radioInsert ( "Protuprovalna vrata", "protuprovala" );
radioInsert ( "Parket", "parket" );
radioInsert ( "Laminat", "laminat" );
radioInsert ( "Klima", "klima" );
radioInsert ( "Kabel", "kabel" );
radioInsert ( "Satelit", "satelit" );
radioInsert ( "Internet", "internet" );
radioInsert ( "Roštilj", "rostilj" );
radioInsert ( "Bazen", "bazen" );
selectInsert ( "Šupa", "supa" );
radioInsert ( "Vrtna kućica", "vrtnaKucica" );
//ruler
echo '<hr class="ruler">';
multiRadioInsert ( "Parking", "parking" );
multiRadioInsert ( "Telefonski priključak", "telefon" );
multiRadioInsert ( "Vlasnički list", "vlasnickiList" );
multiRadioInsert ( "Građevinska", "gradevinska" );
multiRadioInsert ( "Lokacijska", "lokacijska" );
multiRadioInsert ( "Uporabna", "uporabna" );
mixedInsert ( "Garaža", "garaza" );
selectInsert ( "Prijevoz", "prijevoz" );
radioInsert ( "Pogled na more", "morePogled");
formInsert ( "Udaljenost mora", "moreUdaljenost");

//povjerljivi podaci

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

echo '<div class="buttonsDown"><br />Otplata :<br />(ukoliko nema, ne trebate unosite podatke)<br />
Ukupna otplata : <input type="text" name="otplataTotal">
Broj rata : <input type="text" size="2" name="otplataRata">
Visina rate : <input type="text" size="8" name="otplataVisina"> &euro;</div>';

echo '<hr class="ruler">';

formInsert ( "Ime i prezima", "imeIPrezime" );
formInsert ( "Mjesto", "mjesto" );
formInsert ( "Adresa", "adresa" );
formInsert ( "Prebivalište", "prebivaliste" );
formInsert ( "Email", "email" );
formInsert ( "Mobitel", "mobitel" );
formInsert ( "Telefon", "povTelefon" );
formInsert ( "MAX cijena", "maxCijena" );
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
</div><div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue"><img src="ikone/accept.png">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( $_POST['submit']  ) {


//upis podataka u bazu
$tabela = "vivokuce";
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

