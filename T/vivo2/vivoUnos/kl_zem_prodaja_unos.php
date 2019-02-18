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

selectInsert ( "Vrsta zemljišta", "vrstaZemljista" );

radioInsert ( "Struja", "struja" );
radioInsert ( "Voda", "voda" );
radioInsert ( "Kanalizacija", "kanalizacija" );      
radioInsert ( "Plin", "plin" );
radioInsert ( "Telefon", "telefon" );      


radioInsert ( "Vlasnički list", "vlasnickiList" );
radioInsert ( "Građevinska", "gradevinska" );
radioInsert ( "Lokacijska", "lokacijska" );

?>
 
<div class="buttonsDown">
<input type="hidden" name="aktivno" value="1">
<input type="hidden" name="napravi" value="unos">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="unesi">Unesi</button>
</div>
</form>