<?php
// određivanje tabele iz koje se vuku podaci

$tabela = "vivoostalo";

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

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


if ( !$_POST['submit'] ) {

?>

<form name="testForm" method="POST" id="mainForm" action="">

<?php

echo '<div class="formTitle">Osnovni podaci</div><div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeUpdate.php");


formInsert ( "Površina", "povrsina", $podaci['povrsina'] ) ;
formInsert ( "Cijena", "cijena", $podaci['cijena'] ); 
radioUpdate ( "Dodati PDV na cijenu", "pdv", $podaci['pdv'] ); 
formUpdate ( "Zadnja adaptacija", "adaptacija", $podaci['adaptacija'] ); 
radioUpdate ( "Pogled na more", "morePogled", $podaci['morePogled']);
formUpdate ( "Udaljenost mora", "moreUdaljenost", $podaci['moreUdaljenost']);

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
Broj rata : <input type="text" size="2" name="otplataRata" value="',$podaci['otplataRata'],'">
Visina rate : <input type="text" size="8" name="otplataVisina" value="',$podaci['otplataVisina'],'"> &euro;</div>';

//

echo '</div><hr class="ruler">';  

echo '<div class="formTitle">Povjerljivi podaci</div><div>';

formUpdate ( "Ime i prezima", "imeIPrezime", $podaci['imeIPrezime'] ); 
formUpdate ( "Mjesto", "mjesto", $podaci['mjesto'] );
formUpdate ( "Adresa", "adresa", $podaci['adresa'] );
formUpdate ( "Prebivalište", "prebivaliste", $podaci['prebivaliste'] );
formUpdate ( "Email", "email", $podaci['email'] ); 
formUpdate ( "Mobitel", "mobitel", $podaci['mobitel'] );
formUpdate ( "Telefon", "povTelefon", $podaci['povTelefon'] );
formUpdate ( "MAX cijena", "maxCijena", $podaci['maxCijena'] );
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


$tabela = "vivoostaloi";
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