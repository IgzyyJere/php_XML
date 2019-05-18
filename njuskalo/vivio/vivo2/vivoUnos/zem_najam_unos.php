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

if ( !$_POST['submit'] ) {


echo '<form name="testForm" method="POST" id="mainForm" action="">';

 
//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");

selectInsert ( "Vrsta zemljišta", "vrstaZemljista" );
formInsert ( "Širina", "sirina" ) ;
formInsert ( "Dužina", "duzina" );
formInsert ( "Površina", "povrsina" ); 
formInsert ( "Ukupna površina", "ukupnaPovrsina" );
formInsert ( "Cijena", "cijena" ); 
radioInsert ( "Dodati PDV na cijenu", "pdv" );  
mixedInsert ( "Širina prstupnog puta", "sirinaPristupa" ); 

//ruler
echo '<hr class="ruler">';
radioInsert ( "Struja", "struja" );
radioInsert ( "Voda", "voda" );
radioInsert ( "Kanalizacija", "kanalizacija" );      
radioInsert ( "Plin", "plin" );
radioInsert ( "Telefon", "telefon" );      

//ruler
echo '<hr class="ruler">';
multiRadioInsert ( "Vlasnički list", "vlasnickiList" );
multiRadioInsert ( "Građevinska", "gradevinska" );
multiRadioInsert ( "Lokacijska", "lokacijska" );
selectInsert ( "Mogućnost plačanja", "mogucePalacanje" );
formInsert ( "Polog", "polog" );
radioInsert ( "Pogled na more", "morePogled");
formInsert ( "Udaljenost mora", "moreUdaljenost");

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

echo '<div class="buttonsDown"><br />Otplata :<br />(ukoliko nema, ne trebate unosite podatke)<br />
Broj rata : <input type="text" size="2" name="otplataRata">
Visina rate : <input type="text" size="8" name="otplataVisina"> &euro;</div>';

echo '<hr class="ruler">';



//kraj privremenog
echo '<div class="formPrivate">Povjerljivi podaci</div>';

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
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue"><img src="ikone/accept.png">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( $_POST['submit']  ) {
        

//upis podataka u bazu
$tabela = "vivozemljista";
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

