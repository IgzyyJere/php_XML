<?php

$tabela = "klijentiposlovni";

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
mixedUpdate ( "Kat", "kat",  $podaci['katOption'], $podaci['katValue'] ); 
formUpdate ( "Ukupno katova", "ukupnoKat", $podaci['ukupnoKat'] ); 
multiRadioUpdate ( "Broj etaža", "brojEtaza",  $podaci['brojEtaza'] );
selectUpdate ( "P.p. u", "stanU", $podaci['stanU'] );
selectUpdate ( "Vrsta p.p", "vrstaPP", $podaci['vrstaPP'] );
selectUpdate ( "Grijanje", "grijanje", $podaci['grijanje'] );
selectUpdate ( "Stanje", "stanje", $podaci['stanje'] );
selectUpdate ( "Oprema", "oprema", $podaci['oprema'] );
multiRadioUpdate ( "Godina izgradnje", "godinaIzgradnjeOption", $podaci['godinaIzgradnjeOption'] ); 
selectUpdate ( "Pristup", "pristup", $podaci['pristup'] );
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija" value="',$podaci['orijentacija'],'"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>';   
echo '</div>';

//ruler                   
echo '<hr class="ruler">';
//                        

radioUpdate ( "Lift", "lift", $podaci['lift'] );
radioUpdate ( "Teretni lift", "teretniLift", $podaci['teretniLift'] );
radioUpdate ( "Sanitarni čvor", "sanitarni", $podaci['sanitarni'] );    
radioUpdate ( "Čajna kuhinja", "cajnaKuhinja", $podaci['cajnaKuhinja'] ); 
selectUpdate ( "Stolarija", "stolarija", $podaci['stolarija'] );
radioUpdate ( "Namještaj", "namjestaj", $podaci['namjestaj'] ); 
radioUpdate ( "Alarm", "alarm", $podaci['alarm'] );
radioUpdate ( "Protupožarni sustav", "protupozar", $podaci['protupozar'] );
radioUpdate ( "Protuprovalna vrata", "protuprovala", $podaci['protuprovala'] );
radioUpdate ( "Parket", "parket", $podaci['parket'] );
radioUpdate ( "Laminat", "laminat", $podaci['laminat'] );
radioUpdate ( "Klima", "klima", $podaci['klima'] );
radioUpdate ( "Kabel", "kabel", $podaci['kabel'] );
radioUpdate ( "Izlog", "izlog", $podaci['izlog'] );
radioUpdate ( "Satelit", "satelit", $podaci['satelit'] );
radioUpdate ( "Internet", "internet", $podaci['internet'] );
radioUpdate ( "Mreža", "mreza", $podaci['mreza'] );
radioUpdate ( "Skladište", "skladiste", $podaci['skladiste'] );

radioUpdate ( "Parking", "parking", $podaci['parking'] );
radioUpdate ( "Telefonski priključak", "telefon", $podaci['telefon'] ); 
radioUpdate ( "Vlasnički list", "vlasnickiList", $podaci['vlasnickiList'] );
radioUpdate ( "Građevinska", "gradevinska", $podaci['gradevinska'] );
radioUpdate ( "Uporabna", "uporabna", $podaci['uporabna'] );
radioUpdate ( "Garaža", "garaza", $podaci['garaza'] );
selectUpdate ( "Prijevoz", "prijevoz", $podaci['prijevoz'] );
 
?> 

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>
</div>