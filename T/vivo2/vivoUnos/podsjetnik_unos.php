<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "podsjetnik";

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

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );
         

echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/">';

?>   

            <b>Naslov podsjetnika :</b> <input type="text" name="naslov" size="60"><br /><br />
            <b>Datum podsjetnika : </b>       
            
            <?php
            
            $danas_mjesec = date("m"); 
            $danas_godina = 2000 + date("y");
            $danas_dan = date("d");
            
            $mjeseci = array ( 1 => "siječanj", 2 => "veljača", 3 => "ožujak", 4 => "travanj", 5 => "svibanj", 6 => "lipanj",
                               7 => "srpanj", 8 => "kolovoz", 9 => "rujan", 10 => "listopad", 11 => "studeni", 12 => "prosinac");
            
            echo '<select id="dan" name="dan">';


            for ( $i = 1; $i < 32; $i ++ ){
            
            echo '<option value="',$i,'" ';
            
            if ( $i == $danas_dan ) {
                
                echo ' selected="selected" ';
            
                }
                
            echo ' >',$i,'</option>'; 
            
            }                   
            
            echo '</select><select id="mjesec" name="mjesec">';
                               
            for ( $i = 1; $i < 13; $i ++ ){
            
                
            echo '<option value="',$i,'" ';
            
            if ( $i == $danas_mjesec ) {
                
                echo ' selected="selected" ';
            
                }
                
            echo ' >',$mjeseci[$i],'</option>'; 
            
            }                   
            
            echo '</select>
                <select id="godina" name="godina">';
                
            for ( $i = 0; $i < 11; $i ++ ){
            
            echo '<option value="',$danas_godina + $i,'" ';
            
            if ( $i == "0" ) {
                
                echo ' selected="selected" ';
            
                }
                
            echo ' >',$danas_godina + $i,'</option>'; 

            }
            
            echo '</select><br /><br />';

// izvadi ID korisnika iz tabele korsnici    /
// koristeći issess varijablu u kontroleru   /

$upit = "SELECT k.id AS korisnik
         FROM kontroler ko
         INNER JOIN korisnici k
         ON k.username = ko.korisnik
         WHERE ko.idsess = '".session_id()."'";
$odgovori = mysql_query ( $upit );
$korisnik = mysql_result ( $odgovori, 0 );



            echo '<b>Vrsta podsjetnika :</b> <select name="prima">
                <option value="0">vidljiv svima</option>
                <option value="',$korisnik,'">osobni</option>
                </select>';
            
            textareaInsert ( "Tekst podsjetnika", "tekst" );

            ?>

<input type="hidden" name="spojiTabela" value="<?php echo $_GET['tabela']; ?>">
<input type="hidden" name="spojiId" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="napravi" value="unos">   

 
 
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="greenButton" name="submit" value="submit" type="submit"><img src="ikone/accept.png">Unesi</button>
</div>
</form>


                            
