<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "novoobjekti";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' )

                        );

// pomoćni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = "";

include ( 'vivoIncludes/buttons.php' );

if ( !$_POST['submit'] ) {


echo '<form name="testForm" method="POST" id="mainForm">';

 
echo '<div class="formTitle">Osnovni podaci</div>';

formInsert ( "Naziv", "naziv" );

formInsert ( "Broj stanova", "brojStanova" );
formInsert ( "Broj poslovnih", "brojPoslovnih" );
formInsert ( "Broj parkirnih", "brojParkirnih" );
formInsert ( "Broj garažnih", "brojGaraznih" );
formInsert ( "Broj objekata", "brojObjekata" );

formInsert ( "Br. razvijena površina", "brutoRazvijenaPovrsina" );

selectInsert ( "Faza gradnje", "fazaGradnje" );

formInsert ( "Ukupno katova", "ukupnoKat" );

radioInsert ( "Lift", "lift" );  
formInsert ( "Godina izgradnje", "godinaIzgradnje" );
multiRadioInsert ( "Useljenje", "useljenje" );
formInsert ( "Useljivo od", "useljivo" );
 
 

//ruler

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
  
  
$u = "SELECT * FROM korisnici";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['ime']." ".$p['prezime'];
    
}
    
    
selectInsertArray ( "Kontakt agent", "agent", $arr, $p['ime']." ".$p['prezime'] ); 




echo '<hr class="ruler">';

?>

<input type="hidden" name="idProjekta" value="<? echo $_GET['id']; ?>">
 
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( $_POST['submit']  ) {
        

//upis podataka u bazu
$tabela = "novoobjekti";
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
//include ( "vivoAplikacije/googleMap.php" );
}

?>



