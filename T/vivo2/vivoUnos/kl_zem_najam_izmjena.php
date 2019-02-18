<?php

$tabela = "klijentizemljista";

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

selectUpdate ( "Vrsta zemljišta", "vrstaZemljista", $podaci['vrstaZemljista'] );
formUpdate ( "Širina prstupnog puta", "sirinaPristupaValue", $podaci['sirinaPristupaValue'] ); 
radioUpdate ( "Struja", "struja", $podaci['struja'] );
radioUpdate ( "Voda", "voda", $podaci['voda'] );
radioUpdate ( "Kanalizacija", "kanalizacija", $podaci['kanalizacija'] );      
radioUpdate ( "Plin", "plin", $podaci['plin'] );
radioUpdate ( "Telefon", "telefon", $podaci['telefon'] );      
radioUpdate ( "Vlasnički list", "vlasnickiList", $podaci['vlasnickiList'] );
radioUpdate ( "Građevinska", "gradevinska", $podaci['gradevinska'] );
radioUpdate ( "Lokacijska", "lokacijska", $podaci['lokacijska'] );


?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>
</div>