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

$upit = "SELECT * FROM novoobjekti WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


if ( !$_POST['submit'] ) {

?>

<form name="testForm" method="POST" id="mainForm" action="">

<?php

echo '<div class="formTitle">Osnovni podaci</div><div>';

formUpdate ( "Naziv", "naziv", $podaci['naziv'] );

formUpdate ( "Broj stanova", "brojStanova", $podaci['brojStanova'] );
formUpdate ( "Broj poslovnih", "brojPoslovnih", $podaci['brojPoslovnih'] );
formUpdate ( "Broj parkirnih", "brojParkirnih", $podaci['brojParkirnih'] );
formUpdate ( "Broj garažnih", "brojGaraznih", $podaci['brojGaraznih'] );
formUpdate ( "Broj objekata", "brojObjekata", $podaci['brojObjekata'] );

formUpdate ( "Br. razvijena površina", "brutoRazvijenaPovrsina", $podaci['brutoRazvijenaPovrsina'] );

selectUpdate ( "Faza gradnje", "fazaGradnje", $podaci['fazaGradnje'] );

formUpdate ( "Ukupno katova", "ukupnoKat", $podaci['ukupnoKat'] ); 
formUpdate ( "Godina izgradnje", "godinaIzgradnje", $podaci['godinaIzgradnje'] );
multiRadioUpdate ( "Useljenje", "useljenje", $podaci['useljenje'] );
formUpdate ( "Useljivo od", "useljivo", $podaci['useljivo'] );


//ruler

echo '<hr class="ruler">';

selectUpdate ( "Prijevoz", "prijevoz", $podaci['prijevoz'] );
multiRadioUpdate ( "Vlasnički list", "vlasnickiList", $podaci['vlasnickiList'] );
multiRadioUpdate ( "Građevinska", "gradevinska", $podaci['gradevinska'] ); 
multiRadioUpdate ( "Uporabna", "uporabna", $podaci['uporabna'] ); 
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




//ruler

echo '</div><hr class="ruler">';  




?>
<input type="hidden" name="izmjenaObjekta" value="1">
<div class="buttonsDown">
<button class="buttonClear redButton" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmitBack greenButton" name="submit" type="submit" value="submit">Unesi</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="continue">Unesi i nastavi</button>
</div>
</form>

<?php

}

if ( ($_POST['submit'] == "continue") OR  ( preg_match ( '/Unesi i nastavi/', $_POST['submit'] )) ) {


$tabela = "novoobjekti";
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




