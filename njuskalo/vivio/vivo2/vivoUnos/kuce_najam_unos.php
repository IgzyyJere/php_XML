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

mysql_query ("set names utf8"); 


if ( !$_POST['submit'] ) {


echo '<form name="testForm" method="POST" id="mainForm" action="">';

echo '<div class="formTitle">Osnovni podaci</div><div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");

formInsert ( "St. površina", "povrsina" );
formInsert ( "Ukupna površina", "ukupnaPovrsina" );
formInsert ( "Broj soba", "brojSoba" ); 
formInsert ( "Površina okućnice", "okucnica" );
formInsert ( "Cijena", "cijena" );
radioInsert ( "Dodati PDV na cijenu", "pdv" );  
multiRadioInsert ( "Broj etaža", "brojEtazaKuca" );
multiRadioInsert ( "Tip Objekta", "tipObjekt" );
selectInsert ( "Grijanje", "grijanje" );
formInsert ( "Broj kupaonica", "kupaone" );
selectInsert ( "Stanje", "stanje" );
selectInsert ( "Oprema", "oprema" );
mixedInsert ( "Godina izgradnje", "godinaIzgradnje" );
radioInsert ( "Stambeno-poslovna kombinacija", "kombinacija" ); 
formInsert ( "Zadnja adaptacija", "adaptacija" ); 
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
echo '<hr class="ruler">'; 
radioInsert ( "Lift", "lift" );
selectInsert ( "Stolarija", "stolarija" ); 
radioInsert ( "Alarm", "alarm" );
radioInsert ( "Protupožarni sustav", "protupozar" );
radioInsert ( "Protuprovalna vrata", "protuprovala" );
radioInsert ( "Parket", "parket" );
radioInsert ( "Laminat", "laminat" );
multiRadioInsert ( "Klima", "klima" );
multiRadioInsert ( "Kabel", "kabel" );
multiRadioInsert ( "Satelit", "satelit" );
multiRadioInsert ( "Internet", "internet" );
radioInsert ( "Roštilj", "rostilj" );
radioInsert ( "Bazen", "bazen" );
selectInsert ( "Šupa", "supa" ); 
radioInsert ( "Podrum", "podrum" );
radioInsert ( "Vrtna kućica", "vrtnaKucica" ); 

//ruler

echo '<hr class="ruler">';

multiRadioInsert ( "Parking", "parking" );
multiRadioInsert ( "Telefonski priključak", "telefon" );
multiRadioInsert ( "Osnovno posuđe", "osPosude" ); 
multiRadioInsert ( "Perilica rublja", "perilica" ); 
multiRadioInsert ( "Perilica suđa", "perilicaSuda" );  
radioInsert ( "Moguć poslovni prostor", "mozdaPoslovni" );
radioInsert ( "Životinje", "zivotinje" );
mixedInsert ( "Polog", "polog" ); 
mixedInsert ( "Plačanje najma", "placanjeNajma"  );
mixedInsert ( "Garaža", "garaza" );
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


echo '<hr class="ruler">'; 


formInsert ( "Ime i prezima", "imeIPrezime" ); 
formInsert ( "Mjesto", "mjesto" );
formInsert ( "Adresa", "adresa" );
formInsert ( "Prebivalište", "prebivaliste" ); 
formInsert ( "Email", "email" ); 
formInsert ( "Mobitel", "mobitel" );
formInsert ( "Telefon", "povTelefon" );
formInsert ( "MIN cijena", "minCijena" );
formInsert ( "Pregledali", "pregledali" );
formInsert ( "Djeca", "djeca" );
formInsert ( "Prijava", "prijava" );
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