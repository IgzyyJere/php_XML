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
         

echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/">';

?>

            <b>Naslov poruke :</b> <input type="text" name="naslov" size="60"><br /><br />

<?php

            echo '<b>Primatelj poruke :</b> <select name="prima">
                <option value="0">svi korisnici</option>';

            // izvadi popis korisnika i napravi listu kome se šalje poruka /

            $upit = "SELECT id, ime, prezime FROM korisnici";
            $odgovori = mysql_query ($upit );
            while ( $podaci = mysql_fetch_assoc($odgovori)){
                echo '<option value="',$podaci['id'],'">',$podaci['ime'],' ',$podaci['prezime'],'</option>';
                }

            echo '</select>';
            
            textareaInsert ( "Tekst poruke", "tekst" );

            ?>

<input type="hidden" name="napravi" value="unos">   

 
 
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="greenButton" name="submit" value="submit" type="submit"><img src="ikone/accept.png">Unesi</button>
</div>
</form>


                            
