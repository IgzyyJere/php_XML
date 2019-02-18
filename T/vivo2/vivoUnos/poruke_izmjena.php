<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "poruke";

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

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/',$podaci['id'],'/">';

    echo '<b>Naslov poruke :</b> <input type="text" name="naslov" size="60" value="',$podaci['naslov'],'"><br /><br />';
    textareaUpdate ( "Tekst poruke", "tekst", $podaci['tekst']  );
            
?>

</div>
<div class="buttonsDown">
<input type="hidden" name="napravi" value="izmjena">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" value="submit" type="submit">Unesi</button>
</div>
</form>

                            


                            
