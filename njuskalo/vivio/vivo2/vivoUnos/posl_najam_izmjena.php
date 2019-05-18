<?php
// određivanje tabele iz koje se vuku podaci

$tabela = "vivoposlovni";

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

if ( $_POST['submit'] ) {

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id" );
    mysql_query ( vivoPOSTizmjena ( $_POST, "vivoposlovni", $izuzeci, $_POST['id'] ));

    
}

if ( !$_POST['submit'] ) {

?>

<form name="testForm" method="POST" id="mainForm" action="">

<?php

echo '<div class="formTitle">Osnovni podaci</div>';

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeUpdate.php");


formUpdate ( "St. površina", "povrsina", $podaci['povrsina'] ); 
formUpdate ( "Ukupna površina", "ukupnaPovrsina", $podaci['ukupnaPovrsina'] );
formUpdate ( "Broj prostorija", "brojProstorija", $podaci['brojProstorija'] ); 
formUpdate ( "Cijena", "cijena", $podaci['cijena'] );
radioUpdate ( "Dodati PDV na cijenu", "pdv", $podaci['pdv'] );   
mixedUpdate ( "Kat", "kat", $podaci['katOption'], $podaci['katValue'] );  
formUpdate ( "Ukupno katova", "ukupnoKat", $podaci['ukupnoKat'] ); 
multiRadioUpdate ( "Broj etaža", "brojEtaza", $podaci['brojEtaza'] );
selectUpdate ( "P.p. u", "ppU", $podaci['ppU'] );
selectUpdate ( "Vrsta p.p", "vrstaPP", $podaci['vrstaPP'] );
multiRadioUpdate ( "Skladište", "skladiste", $podaci['skladiste'] );
selectUpdate ( "Grijanje", "grijanje", $podaci['grijanje'] );
selectUpdate ( "Stanje", "stanje", $podaci['stanje'] );
selectUpdate ( "Oprema", "oprema", $podaci['oprema'] );
mixedUpdate ( "Godina izgradnje", "godinaIzgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'] );
formUpdate ( "Zadnja adaptacija", "adaptacija", $podaci['adaptacija'] ); 
selectUpdate ( "Pristup", "pristup", $podaci['pristup'] );
mixedUpdate ( "Plačanje najma", "placanjeNajma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'] );
radioUpdate ( "Stambeno-poslovna kombinacija", "kombinacija", $podaci['kombinacija'] ); 
radioUpdate ( "Moguć stambeni", "mozdaStambeni", $podaci['mozdaStambeni'] );  
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija" value="',$podaci['orijentacija'],'"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>';  
echo '</div>';

//ruler
echo '<hr class="ruler">';
formUpdate ( "Visina režija (cca)", "rezije", $podaci['rezije'] );
radioUpdate ( "Struja (po potr.)", "rezijeS", $podaci['rezijeS'] );
radioUpdate ( "Voda (po potr.)", "rezijeV", $podaci['rezijeV'] );  
radioUpdate ( "Plin (po potr.)", "rezijeP", $podaci['rezijeP'] );  
radioUpdate ( "Telefon (po potr.)", "rezijeT", $podaci['rezijeT'] );
radioUpdate ( "Internet (po potr.)", "rezijeI", $podaci['rezijeI'] );

//ruler

echo '<hr class="ruler">'; 
radioUpdate ( "Lift", "lift", $podaci['lift'] );
radioUpdate ( "Teretni lift", "teretniLift", $podaci['teretniLift'] );
formUpdate ( "Sanitarni čvor", "sanitarni", $podaci['sanitarni'] );    
radioUpdate ( "Čajna kuhinja", "cajnaKuhinja", $podaci['cajnaKuhinja'] ); 
selectUpdate ( "Stolarija", "stolarija", $podaci['stolarija'] ); 
radioUpdate ( "Alarm", "alarm", $podaci['alarm'] );
radioUpdate ( "Protupožarni sustav", "protupozar", $podaci['protupozar'] );
radioUpdate ( "Protuprovalna vrata", "protuprovala", $podaci['protuprovala'] );
radioUpdate ( "Parket", "parket", $podaci['parket'] );
radioUpdate ( "Laminat", "laminat", $podaci['laminat'] );
multiRadioUpdate ( "Klima", "klima", $podaci['klima'] );
multiRadioUpdate ( "Kabel", "kabel", $podaci['kabel'] );
multiRadioUpdate ( "Satelit", "satelit", $podaci['satelit'] );
multiRadioUpdate ( "Internet", "internet", $podaci['internet'] );
radioUpdate ( "Izlog", "izlog", $podaci['izlog'] );
radioUpdate ( "Mreža", "mreza", $podaci['mreza'] );
selectUpdate ( "Šupa", "supa", $podaci['supa'] ); 

//ruler
echo '<hr class="ruler">';
multiRadioUpdate ( "Parking", "parking", $podaci['parking'] );
multiRadioUpdate ( "Telefonski priključak", "telefon", $podaci['telefon'] ); 
mixedUpdate ( "Polog", "polog", $podaci['pologOption'], $podaci['pologValue'] );
mixedUpdate ( "Garaža", "garaza", $podaci['garazaOption'], $podaci['garazaValue'] ); 
selectUpdate ( "Prijevoz", "prijevoz", $podaci['prijevoz'] );
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



//



//kraj privremenog
echo '<div class="formPrivate">Povjerljivi podaci</div>';

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
<button class="buttonSubmitBack greenButton">Unesi</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>
</div>

<?php

}

if ( ($_POST['submit'] == "continue") OR  ( preg_match ( '/Unesi i nastavi/', $_POST['submit'] )) ) { 

    
$tabela = "vivoposlovni";    
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