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

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );    
      

echo '<form name="testForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/',$podaci['id'],'/">';

            echo '<b>Naslov podsjetnika :</b> <input type="text" name="naslov" size="60" value="',$podaci['naslov'],'"><br /><br />
            <b>Datum podsjetnika : </b>';       

            list ( $godina, $mjesec, $dan ) =  explode ( "-", $podaci['datum'] );
            
            $mjeseci = array ( 1 => "Siječanj", 2 => "Veljača", 3 => "Ožujak", 4 => "Travanj", 5 => "Svibanj", 6 => "Lipanj",
                               7 => "Srpanj", 8 => "Kolovoz", 9 => "Rujan", 10 => "Listopad", 11 => "Studeni", 12 => "Prosinac");
            
            echo '<select id="dan" name="dan">';


            for ( $i = 1; $i < 32; $i ++ ){
            
            echo '<option value="',$i,'" ';
            
            if ( $i == $dan ) {
                
                echo ' selected="selected" ';
            
                }
                
            echo ' >',$i,'</option>'; 
            
            }                   
            
            echo '</select><select id="mjesec" name="mjesec">';
                               
            for ( $i = 1; $i < 13; $i ++ ){
            

            echo '<option value="',$i,'" ';
            
            if ( $i == $mjesec ) {
                
                echo ' selected="selected" ';

                }

            echo ' >',$mjeseci[$i],'</option>';

            }

            echo '</select>
                <select id="godina" name="godina">';

            for ( $i = 0; $i < 11; $i ++ ){
                echo '<option value="',$godina + $i,'" ';
                if ( $i == "0" ) {
                    echo ' selected="selected" ';
                }
                echo ' >',$godina + $i,'</option>';
            }
            echo '</select><br /><br />';
            textareaUpdate ( "Tekst podsjetnika", "tekst", $podaci['tekst']  );
            
            ?>


</div>
<div class="buttonsDown">
<input type="hidden" name="napravi" value="izmjena">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" value="submit" type="submit">Unesi</button>
</div>
</form>

                            


                            
