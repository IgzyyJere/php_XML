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

$pomocniGumbi = Array (
                        array ( 'adresar', 'adresar' ),
                        array ( 'lista', 'lista' )

                        );


include ( 'vivoIncludes/buttons.php' );

include ( 'vivoAplikacije/breadcrumbNekretnine.php' );


if ( $_GET['interni'] ) {
    $upit = "SELECT * FROM ".$tabela." WHERE idInterni='".$id."'";
} else {
    $upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
}

$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

if ( $_GET['interni'] ) {
    $uu = "UPDATE kontroler
           SET
           radniID = '".$podaci['id']."',
           grupa = '".$podaci['grupa']."'
           WHERE
           idsess='".session_id()."'";
    mysql_query ( $uu );
}
if ( !$_POST['submit'] ) {

?>

<form name="testForm" method="POST" id="mainForm" name="mainForm" action="">

<?php

echo '<div class="formTitle">Osnovni podaci</div><div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeUpdate.php");



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

echo '<div class="formTitle">Povjerljivi podaci</div><div>';

formUpdate ( "Ime i prezima", "imeIPrezime", $podaci['imeIPrezime'] ); 
formUpdate ( "Mjesto", "mjesto", $podaci['mjesto'] );
formUpdate ( "Adresa", "adresa", $podaci['adresa'] );
formUpdate ( "Prebivalište", "prebivaliste", $podaci['prebivaliste'] );
formUpdate ( "Email", "email", $podaci['email'] ); 
formUpdate ( "Mobitel", "mobitel", $podaci['mobitel'] );
formUpdate ( "Telefon", "povTelefon", $podaci['povTelefon'] );
formUpdate ( "MIN cijena", "minCijena", $podaci['minCijena'] );
formUpdate ( "Pregledali", "pregledali", $podaci['pregledali'] );
formUpdate ( "Kat. čestica", "katCes", $podaci['katCes'] ); 
formUpdate ( "Kat. općina", "katOpcina", $podaci['katOpcina'] ); 
formUpdate ( "zk. uložak", "zkUlozak", $podaci['zkUlozak'] );
formUpdate ( "Interni ID", "idInterni", $podaci['idInterni'] ) ;
formUpdate ( "Naslov oglasa na portalima", "naslovoglasa", $podaci['naslovoglasa'] ) ;
textareaUpdate ( "Napomena", "napomena", $podaci['napomena'] );



?>
<input type="hidden" name="akcija" value="prikaz">
<input type="hidden" name="napravi" value="izmjeni">
<div class="buttonsDown">
<button class="buttonClear greenButton" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmitBack greenButton" type="submit">Unesi</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>
</div>
</div>

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




