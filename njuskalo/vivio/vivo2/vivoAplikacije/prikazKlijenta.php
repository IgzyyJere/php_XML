<?php



// brisanje podatka         /
if ( $_GET['obrisi'] ) {
    if ( $p['razina'] == 1 ) {
        $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_GET['obrisi']."'";
        mysql_query ( $upit );
    } else {
        $upit = "UPDATE `".$tabela."` SET obrisano = 1 WHERE id = '".$_GET['obrisi']."'";
        mysql_query ( $upit );
    }
}

// spajanje na nekretninu

if ( $_GET['spojeno'] ) {

    $upit = "UPDATE `".$tabela."` SET `spojeno` = '".$_GET['spojeno']."' WHERE `id` = '".$_GET['id']."'";
    mysql_query ( $upit );

}

// unos izmjena u podatke
if ( $_GET['izmjeni'] ) {    

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi" );
    mysql_query ( vivoPOSTizmjena ( $_POST, $tabela, $izuzeci, $_GET['izmjeni'] ));
    //echo vivoPOSTizmjena ( $_POST, "klijentistanovi", $izuzeci, $_POST['id'] );

}

// unos podataka u bazu

if ( $_POST['napravi'] == "unos" ) {

    $izuzeci = array ( "submit", "continue", "akcija", "stranica", "id", "napravi" );
    mysql_query ( vivoPOSTunos ( $_POST, $tabela, $izuzeci, $_POST['id'] ));
    //echo vivoPOSTunos ( $_POST, "klijentistanovi", $izuzeci, $_POST['id'] );

}

// slanje podatka u arhivu  /
if ( $_GET['arhiva'] ) {
    $upit = "UPDATE `".$tabela."` SET arhiva = '1' WHERE id = '".$_GET['arhiva']."'";
    mysql_query ( $upit );
}


$upit = "SELECT id, imeIPrezime, aktivno, spojeno FROM ".$tabela." 
        WHERE grupa = '".$grupa."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )
        ORDER BY id DESC LIMIT ".$startIndex.", ".$poStranici."";
$odgovori = mysql_query ( $upit );
$i = 0;
while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {
    
    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }
    
    prikaziKlijenta ( $podaci, $back, $tabela );

    $i++;

}

?>