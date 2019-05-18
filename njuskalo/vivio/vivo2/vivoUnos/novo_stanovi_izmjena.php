<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "vivostanovi";

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


$upit = "SELECT * FROM vivostanovi WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


if ( !$_POST['submit'] ) {

?>

<form name="testForm" method="POST" id="mainForm" action="">

<?php

echo '<div class="formTitle">Osnovni podaci</div><div>';

//rad sa lokacijama na jednom mjestu

$u = "SELECT pomocniID FROM kontroler WHERE idsess = '".session_id()."'";
$o = mysql_query ( $u );
$grupa = mysql_result ( $o, 0 );

//dodaj unos grupe i izbor jel se prikazuje sa ostalima

$u = "SELECT * FROM grupe WHERE ( vrsta = 'stanovi prodaja' ) ORDER BY id";
$o = mysql_query ( $u );
$arr = array();

$arr[0] = "Ne prikazivati sa ostalim nekretninama";

while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['vrsta'].' - '.$p['grupa'];

}

selectUpdateArray ( "Prikaz / grupa", "grupa", $arr, $podaci['grupa'] );

$u = "SELECT id, naziv FROM novoobjekti WHERE idProjekta = '".$grupa."'";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {

    $key = $p['id'];
    $arr[$key] = $p['naziv'];

}

selectUpdateArray ( "Objekt", "idObjekta", $arr, $podaci['idObjekta'] );

selectUpdate ( "Status prodaje", "statusProdaje", $podaci['statusProdaje'] );


formUpdate ( "St. površina", "povrsina", $podaci['povrsina'] );
formUpdate ( "Ukupna površina", "ukupnaPovrsina", $podaci['ukupnaPovrsina'] );
formUpdate ( "Cijena", "cijena", $podaci['cijena'] );  
radioUpdate ( "Dodati PDV na cijenu", "pdv", $podaci['pdv'] ); 
mixedUpdate ( "Kat", "kat", $podaci['katOption'], $podaci['katValue'] ); 
formUpdate ( "Ukupno katova", "ukupnoKat", $podaci['ukupnoKat'] ); 
multiRadioUpdate ( "Broj etaža", "brojEtaza",  $podaci['brojEtaza'] );
formUpdate ( "Broj soba", "brojSoba", $podaci['brojSoba'] );  
selectUpdate ( "Stan u", "stanU", $podaci['stanU'] );
radioUpdate ( "Lift", "lift", $podaci['lift'] ); 
selectUpdate ( "Grijanje", "grijanje", $podaci['grijanje'] );
formUpdate ( "Broj kupaonica", "kupaone", $podaci['kupaone'] );
selectUpdate ( "Stanje", "stanje", $podaci['stanje'] );
mixedUpdate ( "Godina izgradnje", "godinaIzgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'] );
formUpdate ( "Zadnja adaptacija", "adaptacija", $podaci['adaptacija'] ); 
multiRadioUpdate ( "Useljenje", "useljenje", $podaci['useljenje'] );
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija" value="',$podaci['orijentacija'],'"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>';  
echo '</div>';


//ruler

echo '</div><hr class="ruler">';
echo '<div class="formDescription">Detaljni podaci</div><div>';
mixedUpdate ( "Balkon", "balkon", $podaci['balkonOption'], $podaci['balkonValue'] );
mixedUpdate ( "Loggia", "loggia", $podaci['loggiaOption'], $podaci['loggiaValue'] );
mixedUpdate ( "Vrt", "vrt", $podaci['vrtOption'], $podaci['vrtValue'] );
mixedUpdate ( "Terasa", "terasa", $podaci['terasaOption'], $podaci['terasaValue'] );

//ruler

echo '<hr class="ruler">'; 
      
selectUpdate ( "Stolarija", "stolarija", $podaci['stolarija'] );
selectUpdate ( "Namještaj", "namjestaj", $podaci['namjestaj'] );
multiRadioUpdate ( "Alarm", "alarm",  $podaci['alarm'] );
radioUpdate ( "Protupožarni sustav", "protupozar", $podaci['protupozar'] );
radioUpdate ( "Protupr. vrata", "protuprovala", $podaci['protuprovala'] );
radioUpdate ( "Parket", "parket", $podaci['parket'] );
radioUpdate ( "Laminat", "laminat", $podaci['laminat'] );
multiRadioUpdate ( "Klima", "klima", $podaci['klima'] );
multiRadioUpdate ( "Kabel", "kabel", $podaci['kabel'] );
multiRadioUpdate ( "Satelit", "satelit", $podaci['satelit'] );
multiRadioUpdate ( "Internet", "internet", $podaci['internet'] );
radioUpdate ( "Roštilj", "rostilj", $podaci['rostilj'] );
radioUpdate ( "Bazen", "bazen", $podaci['bazen'] );
selectUpdate ( "Šupa", "supa", $podaci['supa'] );



//ruler

echo '<hr class="ruler">';
multiRadioUpdate ( "Parking", "parking", $podaci['parking'] );
multiRadioUpdate ( "Telefonski priključak", "telefon", $podaci['telefon'] ); 
multiRadioUpdate ( "Vlasnički list", "vlasnickiList", $podaci['vlasnickiList'] );
multiRadioUpdate ( "Građevinska", "gradevinska", $podaci['gradevinska'] ); 
multiRadioUpdate ( "Uporabna", "uporabna", $podaci['uporabna'] ); 
mixedUpdate ( "Garaža", "garaza", $podaci['garazaOption'], $podaci['garazaValue'] );
selectUpdate ( "Prijevoz", "prijevoz", $podaci['prijevoz'] );
radioUpdate ( "Pogled na more", "morePogled", $podaci['morePogled']);
formUpdate ( "Udaljenost od mora", "moreUdaljenost", $podaci['moreUdaljenost']);


//

echo '<hr class="ruler">'; 

$u = "SELECT * FROM provizije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['nazivProvizije'];
    
}
    
    
selectUpdateArray ( "Provizija", "provizije", $arr, $podaci['provizije'] ); 
  
  
$u = "SELECT * FROM korisnici";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['ime']." ".$p['prezime'];
    
}
    
    
selectUpdateArray ( "Kontakt agent", "agent", $arr, $podaci['agent'] ); 

echo '<div class="buttonsDown"><br />Otplata :<br />(ukoliko nema, ne trebate unosite podatke)<br />
Ukupna otplata : <input type="text" name="otplataTotal" value="',$podaci['otplataTotal'],'"> 
Broj rata : <input type="text" size="2" name="otplataRata" value="',$podaci['otplataRata'],'">
Visina rate : <input type="text" size="8" name="otplataVisina" value="',$podaci['otplataVisina'],'"> &euro;</div>';

//


//ruler

echo '</div><hr class="ruler">';




?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmitBack greenButton" name="submit" type="submit" value="submit">Unesi</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( ($_POST['submit'] == "continue") OR  ( preg_match ( '/Unesi i nastavi/', $_POST['submit'] )) ) {

    
$tabela = "vivostanovi"; 
$u = "SELECT radniID FROM kontroler WHERE idsess='".session_id()."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );
$id = $p['radniID'];
$izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi" );
mysql_query ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $id ));
//echo ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $id ));

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




