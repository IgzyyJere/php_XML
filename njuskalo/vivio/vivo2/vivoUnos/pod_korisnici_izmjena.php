<?php

// odreðivanje tabele iz koje se vuku podaci

$tabela = "korisnici";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' ),
                        array ( 'unos', 'unos' )

                        );

// pomoæni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );


echo '<form name="mainForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/napravi=izmjeni">';

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


formUpdate ( "Ime", "ime", $podaci['ime'] );
formUpdate ( "Prezime", "prezime", $podaci['prezime'] );
formUpdate ( "Username", "username", $podaci['username'] );
formUpdate ( "E-mail", "email", $podaci['email'] );
formUpdate ( "Telefon", "telefon", $podaci['telefon'] );
formUpdate ( "Mobitel", "mobitel", $podaci['mobitel'] );

$arr = array ( 1 => "Admin", 2 => "Korisnik" );
selectUpdateArray ( "Razina pristupa", "vrsta", $arr, $podaci['vrsta'] );



?>

<input type="hidden" name="napravi" value="izmjena">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="greenButton" name="submit" type="submit" ref="<?php echo $_POST['id']; ?>" value="submit"><img src="ikone/accept.png">Unesi</button>
</div>

</form>

