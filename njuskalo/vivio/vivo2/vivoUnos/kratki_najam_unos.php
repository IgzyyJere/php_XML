<?php
// određivanje tabele iz koje se vuku podaci

$tabela = "kratkinajam";

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

 
echo '<div class="formTitle">Osnovni podaci</div><div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");

formInsert ( "St. površina", "povrsina" ); 
formInsert ( "Ukupna površina", "ukupnaPovrsina" );
formInsert ( "Cijena", "cijena" );  
radioInsert ( "Dodati PDV na cijenu", "pdv" );  
mixedInsert ( "Kat", "kat" );
formInsert ( "Ukupno katova", "ukupnoKat" ); 
multiRadioInsert ( "Broj etaža", "brojEtaza" );
selectInsert ( "Stan u", "stanU" );
formInsert ( "Broj soba", "brojSoba" );
selectInsert ( "Grijanje", "grijanje" );
formInsert ( "Broj kupaonica", "kupaone" ); 
formInsert ( "Broj WC-a", "wc" ); 
selectInsert ( "Stanje", "stanje" );
selectInsert ( "Oprema", "oprema" );
mixedInsert ( "Godina izgradnje", "godinaIzgradnje" );
formInsert ( "Zadnja adaptacija", "adaptacija" ); 
radioInsert ( "Stambeno-poslovna kombinacija", "kombinacija" );     
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>'; 
echo '</div>';

//ruler
echo '<hr class="ruler">';
formInsert ( "Visina režija (cca)", "rezije");
radioInsert ( "Struja (po potr.)", "rezijeS" );
radioInsert ( "Voda (po potr.)", "rezijeV" );  
radioInsert ( "Plin (po potr.)", "rezijeP" );  
radioInsert ( "Telefon (po potr.)", "rezijeT" );
radioInsert ( "Internet (po potr.)", "rezijeI" );


//ruler
echo '<hr class="ruler">';

mixedInsert ( "Balkon", "balkon" );
mixedInsert ( "Loggia", "loggia" );
mixedInsert ( "Vrt", "vrt" );
mixedInsert ( "Terasa", "terasa" );

//ruler

echo '<hr class="ruler">'; 
radioInsert ( "Lift", "lift" );
selectInsert ( "Stolarija", "stolarija" );
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
selectInsert ( "Šupa", "supa"); 

//ruler

echo '<hr class="ruler">';
multiRadioInsert ( "Osnovno posuđe", "osPosude" ); 
multiRadioInsert ( "Parking", "parking" );
multiRadioInsert ( "Perilica rublja", "perilica" ); 
multiRadioInsert ( "Perilica suđa", "perilicaSuda" ); 
radioInsert ( "Moguć poslovni prostor", "mozdaPoslovni" );
radioInsert ( "Životinje", "zivotinje" );
formInsert ( "Polog", "polog" ); 
multiRadioInsert ( "Telefonski priključak", "telefon" ); 
mixedInsert ( "Garaža", "garaza" );
selectInsert ( "Prijevoz", "prijevoz" );
mixedInsert ( "Plačanje najma", "placanjeNajma" );

 
//kraj privremenog

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


echo '<hr class="ruler">'; 

echo '<div class="formPrivate">Povjerljivi podaci</div><div>';

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
formInsert ( "Djeca", "djeca" ); 
formInsert ( "Prijava", "prijava" ); 
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
$tabela = "kratkinajam";
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

