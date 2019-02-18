<?php

// odreðivanje tabele iz koje se vuku podaci

$tabela = "definiranelokacije";

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


echo '<form name="mainForm" method="POST" id="mainForm" action="/vivo2/0/0/prikaz/0/napravi=unos">';

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


formUpdate ( "Naziv lokacije", "naziv", $podaci['naziv'] );


//odredi županiju   /
    $u = "SELECT pomocni FROM kontroler WHERE idsess='".session_id()."'";
    $o = mysql_query ( $u );
    $zup = mysql_result( $o, 0);

?>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmit greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>
<hr>
<center><strong>Dodjeljivanje lokacija</strong></center>
<form name="dodjeljivanjeLokacija" method="POST" id="dodjeljivanjeLokacija" action="">
    <center>
    <input type="hidden" name="lokacija" value="<?php echo $id; ?>">
    <select name="idgrada">
        <?php

        $u = "SELECT id, naziv FROM gradovi WHERE zupanija = '".$zup."' ORDER BY naziv";
        $o = mysql_query ( $u );
        while ( $p = mysql_fetch_assoc ( $o )) {
            echo '<option value="',$p['id'],'">',$p['naziv'],'</option>';
        }

        ?>
    </select>
    <br><button class="buttonSubmit greenButton" name="submit" type="submit" value="submit">Dodijeli</button>
    </center>
</form>
<br><br>
Popis dodijeljenih lokacija:<p class="popisDodjeljenihLokacija">
<?php
$u = "SELECT naziv FROM gradovi WHERE idlokacije = '".$id."'";
$o = mysql_query ( $u );
while ( $p = mysql_fetch_assoc ( $o )) {
    echo $p['naziv'],', ';
    }


?></p>