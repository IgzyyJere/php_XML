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



// brisanje podataka    /
if ( $_GET['obrisi'] ) {
    $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
    mysql_query ( $upit );
}


if ( $_POST['napravi'] == 'unos' ) {

    // ako je osobni, unosi se samo za ID tog korisnika   /

    if ( $_POST['prima'] ) {

        $upit = "INSERT INTO `".$tabela."`
                ( `id`, `naslov`, `tekst`, `prima`, `poslao`, `datum` )
                VALUES
                ( '', '".$_POST['naslov']."', '".$_POST['tekst']."', '".$_POST['prima']."',
                '".$korisnik['id']."', CURDATE()   )";
        mysql_query ( $upit );

    } else {

    // ako je za svakoga, onda treba upisati za sve korisnike   /
    // po jedan podsjetnik, tako da svaki korisnik može brisati /
    // podsjetnike po želji, bez da omete drugim korisnicima    /
    // rad (izbriše podsjetnik)                                 /

        $uu = "SELECT id FROM korisnici";
        $oo = mysql_query ( $uu );
        while ( $pp = mysql_fetch_assoc ( $oo )) {

            $upit = "INSERT INTO `".$tabela."`
                    ( `id`, `naslov`, `tekst`, `prima`, `poslao`, `datum` )
                    VALUES
                    ( '', '".$_POST['naslov']."', '".$_POST['tekst']."', '".$pp['id']."',
                    '".$korisnik['id']."',  CURDATE()   )";
            mysql_query ( $upit );
        }

    }
    
}

if ( $_POST['napravi'] == 'izmjena' ) {

    $upit = "UPDATE `".$tabela."` SET 
            `naslov` = '".$_POST['naslov']."', 
            `tekst` = '".$_POST['tekst']."'
            WHERE id = '".$id."'";
    mysql_query ( $upit );

}


$upi = "SELECT * FROM ".$tabela." WHERE ( obrisano IS NULL OR obrisano = '0' ) AND prima ='".$korisnik['id']."' ORDER BY datum";
$od = mysql_query ( $upi );

$i = 0;

while ( $podi = mysql_fetch_assoc ( $od ) ) {
    
    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }
    
    list ( $godina, $mjesec, $dan ) =  explode ( "-", $podi['datum'] );
    
    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podi['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podi['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">
        ',$dan,'.',$mjesec,'.',$godina,' - ',$podi['naslov'],'</div><div class="pomocniNav"><a href="" title="prikaži poruku" class="prikaziPoruku" ref="',$podi['id'],'""><img src="/vivo2/ikone/email.png"></a></div>
    </div>';
    
    $i++;
}


?>