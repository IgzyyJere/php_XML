<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "zamjene";

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


if ( $_GET['napravi'] == "unos" ) {

    $upit = "INSERT INTO ".$tabela."
            ( id, tabela, idNekretnine, nek1, nek2, nek3, nek4, vr1Option, vr1Value, vr2Option, vr2Value,
              vr3Option, vr3Value, vr4Option, vr4Value, poKvadraturi, poVrijednosti, lokacija, doplata   )
            VALUES
            ( '', '".$_POST['tabela']."', '".$_POST['idNekretnine']."', '".$_POST['nek1']."', '".$_POST['nek2']."',
                '".$_POST['nek3']."', '".$_POST['nek4']."', '".$_POST['vr1Option']."', '".$_POST['vr1Value']."',
                '".$_POST['vr2Option']."', '".$_POST['vr2Value']."', '".$_POST['vr3Option']."', '".$_POST['vr3Value']."',
                '".$_POST['vr4Option']."', '".$_POST['vr4Value']."', '".$_POST['poKvadraturi']."', '".$_POST['poKvadraturi']."',
                '".$_POST['lokacija']."', '".$_POST['doplata']."')";
    mysql_query ( $upit );
}

if ( $_GET['napravi'] == "izmjeni" ) {


    $upit = "UPDATE `".$tabela."`
            SET
            tabela = '".$_POST['tabela']."',
            idNekretnine = '".$_POST['idNekretnine']."',
            nek1 = '".$_POST['nek1']."',
            nek2 = '".$_POST['nek2']."',
            nek3 = '".$_POST['nek3']."',
            nek4 = '".$_POST['nek4']."',
            vr1Option = '".$_POST['vr1Option']."',
            vr1Value = '".$_POST['vr1Value']."',
            vr2Option = '".$_POST['vr2Option']."',
            vr2Value = '".$_POST['vr2Value']."',
            vr3Option = '".$_POST['vr3Option']."',
            vr3Value = '".$_POST['vr3Value']."',
            vr4Option = '".$_POST['vr4Option']."',
            vr4Value = '".$_POST['vr4Value']."',
            poKvadraturi = '".$_POST['poKvadraturi']."',
            poVrijednosti = '".$_POST['poVrijednosti']."',
            lokacija = '".$_POST['lokacija']."',
            doplata = '".$_POST['doplata']."'
            WHERE
            id = '".$_GET['id']."'";
            
    mysql_query ( $upit );

}

// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}

if ( !$_POST['grupa'] ) {
    
    $u = "SELECT grupa FROM kontroler WHERE idsess='".session_id()."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    $_POST['grupa'] = $p['grupa'];

}

$upit = "SELECT id, tabela, idNekretnine FROM ".$tabela." ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    

    if ( $i % 2 ) {
        
        $back = "darkLine";
        
    } else {
        
        $back = "lightLine";
        
    }
    
    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>
    <div class="lineRight">
        ',$podaci['tabela'],' - ',$podaci['idNekretnine'],' </div>
    </div>';
    
    $i ++;
    
    }

?>

