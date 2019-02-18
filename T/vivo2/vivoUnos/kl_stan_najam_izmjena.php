<?php

$tabela = "klijentistanovi";

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

$pomocniGumbi = NULL;


include ( 'vivoIncludes/buttons.php' );

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

?>

<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/izmjeni=<?php echo $id; ?>">

<?php

echo '<div class="formTitle">Osobni podaci</div>';

formUpdate ( "Ime i prezime", "imeIPrezime", $podaci['imeIPrezime'] );
formUpdate ( "Mjesto", "mjesto", $podaci['mjesto'] );
formUpdate ( "Adresa", "adresa", $podaci['adresa'] );
formUpdate ( "Email", "email", $podaci['email'] ); 
formUpdate ( "Mobitel", "mobitel", $podaci['mobitel'] );
formUpdate ( "Telefon", "povTelefon", $podaci['povTelefon'] );
textareaUpdate ( "Napomena", "napomena", $podaci['napomena'] );

//osnovno pretraživanje 

//ruler                   
echo '<hr class="ruler">';
//                        



echo '<div class="formTitle">Osnovni podaci za pretraživanje</div>';


formUpdate ( "Cijena od", "minCijena", $podaci['minCijena'] );
formUpdate ( "Cijena do", "maxCijena", $podaci['maxCijena'] );
formUpdate ( "Površina od", "povrsinaOd", $podaci['povrsinaOd'] );
formUpdate ( "Površina do", "povrsinaDo", $podaci['povrsinaDo'] );

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeUpdate.php");

//detaljno pretraživanje                                  


//ruler                   
echo '<hr class="ruler">';
//                        



echo '<div class="formTitle">Detalji za pretraživanje</div>';
mixedUpdate ( "Kat", "kat", $podaci['katOption'], $podaci['katValue'] ); 
formUpdate ( "Ukupno katova", "ukupnoKat", $podaci['ukupnoKat'] ); 
multiRadioUpdate ( "Broj etaža", "brojEtaza", $podaci['brojEtaza'] );
selectUpdate ( "Stan u", "stanU", $podaci['stanU'] );
formUpdate ( "Broj soba", "brojSoba", $podaci['brojSoba'] ); 
selectUpdate ( "Grijanje", "grijanje", $podaci['grijanje'] );
formUpdate ( "Broj kupaonica", "kupaone", $podaci['kupaone'] );  
formUpdate ( "Broj WC-a", "wc", $podaci['wc'] ); 
selectUpdate ( "Stanje", "stanje", $podaci['stanje'] );
selectUpdate ( "Oprema", "oprema", $podaci['oprema'] );
multiRadioUpdate ( "Godina izgradnje", "godinaIzgradnjeOption", $podaci['godinaIzgradnjeOption'] ); 


//ruler                   
echo '<hr class="ruler">';
//                        

radioUpdate ( "Balkon", "balkonOption", $podaci['balkonOption'] );
radioUpdate ( "Loggia", "loggiaOption", $podaci['loggiaOption'] );
radioUpdate ( "Vrt", "vrtOption", $podaci['vrtOption'] );
radioUpdate ( "Terasa", "terasaOption", $podaci['terasaOption'] );

radioUpdate ( "Lift", "lift", $podaci['lift'] );
selectUpdate ( "Stolarija", "stolarija", $podaci['stolarija'] );
radioUpdate ( "Alarm", "alarm", $podaci['alarm'] );
radioUpdate ( "Protupožarni sustav", "protupozar", $podaci['protupozar'] );
radioUpdate ( "Protuprovalna vrata", "protuprovala", $podaci['protuprovala'] );
radioUpdate ( "Parket", "parket", $podaci['parket'] );
radioUpdate ( "Laminat", "laminat", $podaci['laminat'] );
radioUpdate ( "Klima", "klima", $podaci['klima'] );
radioUpdate ( "Kabel", "kabel", $podaci['kabel'] );
radioUpdate ( "Satelit", "satelit", $podaci['satelit'] );
radioUpdate ( "Internet", "internet", $podaci['internet'] );
radioUpdate ( "Roštilj", "rostilj", $podaci['rostilj'] );
radioUpdate ( "Bazen", "bazen", $podaci['bazen'] );
radioUpdate ( "Šupa", "supa", $podaci['supa'] );


radioUpdate ( "Osnovno posuđe", "osPosude", $podaci['osPosude'] ); 
radioUpdate ( "Parking", "parking", $podaci['parking'] );
radioUpdate ( "Perilica rublja", "perilica", $podaci['perilica'] ); 
radioUpdate ( "Perilica suđa", "perilicaSuda", $podaci['perilicaSuda'] ); 
radioUpdate ( "Moguć poslovni prostor", "mozdaPoslovni", $podaci['mozdaPoslovni'] );
radioUpdate ( "Životinje", "zivotinje", $podaci['zivotinje'] );
radioUpdate ( "Telefonski priključak", "telefon", $podaci['telefon'] ); 
radioUpdate ( "Garaža", "garaza", $podaci['garaza'] );
selectUpdate ( "Prijevoz", "prijevoz", $podaci['prijevoz'] );
mixedUpdate ( "Plačanje najma", "placanjeNajma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'] );

?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>
</div>