<?php

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


echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/">';


echo '<div class="formPrivate">Osobni podaci</div>';

formInsert ( "Ime i prezime", "imeIPrezime" );
formInsert ( "Mjesto", "mjesto" );
formInsert ( "Adresa", "adresa" );
formInsert ( "Email", "email" ); 
formInsert ( "Mobitel", "mobitel" );
formInsert ( "Telefon", "povTelefon" );
textareaInsert ( "Napomena", "napomena" );

 
 
//osnovno pretraživanje 

//ruler                   
echo '<hr class="ruler">';
//                        



echo '<div class="formTitle">Osnovni podaci za pretraživanje</div>';

formInsert ( "Cijena od", "minCijena" );
formInsert ( "Cijena do", "maxCijena" );
formInsert ( "Površina od", "povrsinaOd" );
formInsert ( "Površina do", "povrsinaDo" );

//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");
   
 
   
//detaljno pretraživanje                                  


//ruler                   
echo '<hr class="ruler">';
//                        

echo '<div class="formTitle">Detalji za pretraživanje</div>';  
formInsert ( "Broj soba", "brojSoba" ); 
multiRadioInsert ( "Broj etaža", "brojEtazaKuca" );
multiRadioInsert ( "Tip Objekta", "tipObjekt" );
selectInsert ( "Grijanje", "grijanje" );
formInsert ( "Broj kupaonica", "kupaone" );
selectInsert ( "Stanje", "stanje" );
selectInsert ( "Oprema", "oprema" );
multiRadioInsert ( "Godina izgradnje", "godinaIzgradnjeOption" );
echo '<div class="miniContainer"><strong>Orijentacija</strong><br />';
echo '<input type="text" name="orijentacija"><br />Orijentaciju objekta unositi u polje za unos u obliku(primjer):<b>s,j</b><br />sjever - <b>s</b> :: zapad - <b>z</b> ::jug - <b>j</b> :: istok - <b>i</b>'; 
echo '</div>';

//ruler                   
echo '<hr class="ruler">';
//                        

radioInsert ( "Balkon", "balkonOption" );
radioInsert ( "Loggia", "loggiaOption" );
radioInsert ( "Vrt", "vrtOption" );
radioInsert ( "Terasa", "terasaOption" );


echo '<hr class="ruler">'; 
radioInsert ( "Lift", "lift" );
selectInsert ( "Stolarija", "stolarija" );
radioInsert ( "Namještaj", "namjestaj" );
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
radioInsert ( "Bazen", "bazen" );
radioInsert ( "Podrum", "podrum" ); 
radioInsert ( "Vrtna kućica", "vrtnaKucica" ); 

radioInsert ( "Parking", "parking" );
radioInsert ( "Telefonski priključak", "telefon" ); 
radioInsert ( "Vlasnički list", "vlasnickiList" );
radioInsert ( "Građevinska", "gradevinska"  );
radioInsert ( "Lokacijska", "lokacijska"  );
radioInsert ( "Uporabna", "uporabna" );
radioInsert ( "Garaža", "garaza" );
selectInsert ( "Prijevoz", "prijevoz" );


?>
 
<div class="buttonsDown">
<input type="hidden" name="aktivno" value="1">
<input type="hidden" name="napravi" value="unos">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="unesi">Unesi</button>
</div>
</form>