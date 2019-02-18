<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "novoprojekti";

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

$pomocniGumbi = "";

include ( 'vivoIncludes/buttons.php' );

if ( !$_POST['submit'] ) {


echo '<form name="testForm" method="POST" id="mainForm" action="">';
 echo '<div class="formTitle">Osnovni podaci</div><div>';

formInsert ( "Naziv", "naziv" );
//rad sa lokacijama na jednom mjestu
include ( "vivoAplikacije/lokacijeInsert.php");

formInsert ( "Broj stanova", "brojStanova" );
formInsert ( "Broj poslovnih", "brojPoslovnih" );
formInsert ( "Broj parkirnih", "brojParkirnih" );
formInsert ( "Broj garažnih", "brojGaraznih" );
formInsert ( "Broj objekata", "brojObjekata" );

formInsert ( "Br. razvijena površina", "brutoRazvijenaPovrsina" );

selectInsert ( "Faza gradnje", "fazaGradnje" );

formInsert ( "Godina izgradnje", "godinaIzgradnje" );
formInsert ( "Useljivo od", "useljivo" );
 

selectInsert ( "Oprema stanova", "opremaStanova" );
selectInsert ( "Oprema poslovnih prostora", "opremaPoslovnih" );
selectInsert ( "Keramika", "keramika" );
selectInsert ( "Sanitarna oprema", "sanitarnaOprema" );
selectInsert ( "Sanitarna armatura", "sanitarnaArmatura" );
selectInsert ( "Parket", "parket" );

radioInsert ( "Noćni čuvar", "nocniCuvar" );
radioInsert ( "Video nadzor", "videoNadzor" );

selectInsert ( "Grijanje", "grijanje" );
radioInsert ( "Protupr. vrata", "protuprovala" );

multiRadioInsert ( "telefon", "telefon" );
multiRadioInsert ( "Kabel", "kabel" );
multiRadioInsert ( "Satelit", "satelit" );
multiRadioInsert ( "Internet", "internet" );

selectInsert ( "Prijevoz", "prijevoz" );
multiRadioInsert ( "Vlasnički list", "vlasnickiList" ); 
multiRadioInsert ( "Građevinska", "gradevinska" );  
multiRadioInsert ( "Uporabna", "uporabna" ); 
radioInsert ( "Pogled na more", "morePogled");
formInsert ( "Udaljenost mora", "moreUdaljenost");


echo '<hr class="ruler">'; 

$u = "SELECT * FROM provizije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['nazivProvizije'];
    
}
    
    
selectInsertArray ( "Provizija", "provizije", $arr, $podaci['nazivProvizije'] );


echo '<hr class="ruler">';



//kraj privremenog
echo '<div class="formPrivate">Povjerljivi podaci</div><div>';

formInsert ( "Ime i prezima", "imeIPrezime" );  
formInsert ( "Mjesto", "mjesto" );
formInsert ( "Adresa", "adresa" );
formInsert ( "Prebivalište", "prebivaliste" ); 
formInsert ( "Email", "email" );
formInsert ( "Mobitel", "mobitel" );
formInsert ( "Telefon", "povTelefon" );
formInsert ( "MIN cijena", "minCijena" );
formInsert ( "Pregledali", "pregledali" );
formInsert ( "Kat. čestica", "katCes" ); 
formInsert ( "Kat. općina", "katOpcina" ); 
formInsert ( "zk. uložak", "zkUlozak" ); 
textareaInsert ( "Napomena", "napomena" );

?>
 
</div></div><div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( $_POST['submit']  ) {


//upis podataka u bazu
$tabela = "novoprojekti";
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



