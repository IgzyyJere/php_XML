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

formUpdate ( "Cijena", "cijena", $podaci['cijena'] );
formUpdate ( "Površina objekta", "cvrstiObjektm2", $podaci['cvrstiObjektm2'] );
formUpdate ( "Površina zemljišta", "zemljistem2", $podaci['zemljistem2'] );
selectUpdate ( "Grijanje", "grijanje", $podaci['grijanje'] );
multiRadioUpdate ( "Klima", "klima", $podaci['klima'] );
multiRadioUpdate ( "Kabel", "kabel", $podaci['kabel'] );
multiRadioUpdate ( "Satelit", "satelit", $podaci['satelit'] );
multiRadioUpdate ( "Internet", "internet", $podaci['internet'] );
multiRadioUpdate ( "Telefonski priključak", "telefon", $podaci['telefon'] );
multiRadioUpdate ( "Bazen", "bazen", $podaci['bazen'] );
mixedUpdate ( "Garaža", "garaza", $podaci['garaza'] );
selectUpdate ( "Parkiralište", "parkiraliste", $podaci['parkiraliste'] );
formUpdate ( "Udaljenost od parkirališta", "udaljenostParkiralista", $podaci['udaljenostParkiralista'] );
selectUpdate ( "Dostupnost automobilom", "dostupnostAutomobilom", $podaci['dostupnostAutomobilom'] );
formUpdate ( "Broj parkirnih mjesta", "parkirnaMjestaBroj", $podaci['parkirnaMjestaBroj'] );
formUpdate ( "Broj garažnih mjesta", "garaznaMjestaBroj", $podaci['garaznaMjestaBroj'] );

//ruler

echo '<hr class="ruler">';
formUpdate ( "Udaljenost od centra", "udaljenostCentar", $podaci['udaljenostCentar'] );
formUpdate ( "Udaljenost od aerodroma", "udaljenostAerodrom", $podaci['udaljenostAerodrom'] );
formUpdate ( "Udaljenost od autobusa", "udaljenostAutobus", $podaci['udaljenostAutobus'] );
formUpdate ( "Udaljenost od mora", "udaljenostMore", $podaci['udaljenostMore'] );
formUpdate ( "Udaljenost od plaže", "udaljenostPlaza", $podaci['udaljenostPlaza'] );
formUpdate ( "Udaljenost od marine", "udaljenostMarina", $podaci['udaljenostMarina'] );
formUpdate ( "Udaljenost od trajekta", "udaljenostTrajekt", $podaci['udaljenostTrajekt'] );
formUpdate ( "Udaljenost od trgovine", "udaljenostTrgovina", $podaci['udaljenostTrgovina'] );
formUpdate ( "Udaljenost od restorana", "udaljenostRestoran", $podaci['udaljenostRestoran'] );
formUpdate ( "Udaljenost od ambulante", "udaljenostAmbulanta", $podaci['udaljenostAmbulanta'] );
formUpdate ( "Udaljenost od ljekarne", "udaljenostLjekarna", $podaci['udaljenostLjekarna'] );
formUpdate ( "Udaljenost od prometnice", "udaljenostPrometnica", $podaci['udaljenostPrometnica'] );


//ruler

echo '<hr class="ruler">';

radioUpdate ( "Pogled na more", "pogledMore", $podaci['pogledMore'] );
radioUpdate ( "Pogled na zelenilo", "pogledZelenilo", $podaci['pogledZelenilo'] );
radioUpdate ( "Pogled na naselje", "pogledNaselje", $podaci['pogledNaselje'] );
radioUpdate ( "Pogled na planine", "pogledPlanine", $podaci['pogledPlanine'] );


//ruler

echo '<hr class="ruler">';

formUpdate ( "Kapacitet (sobe - 1)", "kapacitetSobe1krevetne", $podaci['kapacitetSobe1krevetne'] );
formUpdate ( "Kapacitet (sobe - 2)", "kapacitetSobe2krevetne", $podaci['kapacitetSobe2krevetne'] );
formUpdate ( "Kapacitet (sobe - 3)", "kapacitetSobe3krevetne", $podaci['kapacitetSobe3krevetne'] );
formUpdate ( "Kapacitet (sobe - 4)", "kapacitetSobe4krevetne", $podaci['kapacitetSobe4krevetne'] );
formUpdate ( "Kapacitet (sobe - više)", "kapacitetSobeVisekrevetne", $podaci['kapacitetSobeVisekrevetne'] );
formUpdate ( "Kapacitet (apt - 2)", "kapacitetApartmani2krevetni", $podaci['kapacitetApartmani2krevetni'] );
formUpdate ( "Kapacitet (apt - 3)", "kapacitetApartmani3krevetni", $podaci['kapacitetApartmani3krevetni'] );
formUpdate ( "Kapacitet (apt - 4)", "kapacitetApartmani4krevetni", $podaci['kapacitetApartmani4krevetni'] );
formUpdate ( "Kapacitet (apt - više)", "kapacitetApartmaniVisekrevetni", $podaci['kapacitetApartmaniVisekrevetni'] );

formUpdate ( "Broj parcela (šatori)", "brojParcelaSatori", $podaci['brojParcelaSatori'] );
formUpdate ( "Broj parcela (kamperi)", "brojParcelaCamperi", $podaci['brojParcelaCamperi'] );
formUpdate ( "Broj čvrstih objekata", "brojCvrstihObjekata", $podaci['brojCvrstihObjekata'] );
formUpdate ( "Broj ležaja (šatori)", "brojLezajaSatori", $podaci['brojLezajaSatori'] );
formUpdate ( "Broj ležaja (kamperi)", "brojLezajaCamperi", $podaci['brojLezajaCamperi'] );
formUpdate ( "Broj ležaja (čv. objekti)", "brojLezajaCvrstiObjekti", $podaci['brojLezajaCvrstiObjekti'] );

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




