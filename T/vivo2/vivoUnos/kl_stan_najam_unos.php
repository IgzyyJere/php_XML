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
multiRadioInsert ( "Godina izgradnje", "godinaIzgradnjeOption" );


//ruler                   
echo '<hr class="ruler">';
//                        

radioInsert ( "Balkon", "balkonOption" );
radioInsert ( "Loggia", "loggiaOption" );
radioInsert ( "Vrt", "vrtOption" );
radioInsert ( "Terasa", "terasaOption" );

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
radioInsert ( "Šupa", "supa" ); 

radioInsert ( "Osnovno posuđe", "osPosude" ); 
radioInsert ( "Parking", "parking" );
radioInsert ( "Perilica rublja", "perilica" ); 
radioInsert ( "Perilica suđa", "perilicaSuda"); 
radioInsert ( "Moguć poslovni prostor", "mozdaPoslovni" );
radioInsert ( "Životinje", "zivotinje" ); 
radioInsert ( "Telefonski priključak", "telefon" ); 
radioInsert ( "Garaža", "garaza" );
selectInsert ( "Prijevoz", "prijevoz" );
mixedInsert ( "Plačanje najma", "placanjeNajma" );

?>

<div class="buttonsDown">
<input type="hidden" name="aktivno" value="1">
<input type="hidden" name="napravi" value="unos">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="unesi">Unesi</button>
</div>
</form>
      