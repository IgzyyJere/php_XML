<?php

$u = "SELECT grupa FROM kontroler WHERE idsess='".session_id()."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );



$tabela = "vivokuce"; 

if ( $_POST['akcija'] == "brisanje" ) {
    
    if ( $p['razina'] == 1 ) {
        
        $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    } else {
        
        $upit = "UPDATE `".$tabela."` SET obrisano = 1 WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    }
    
} 


if ( $_POST['napravi'] == "arhiviranje" ) {
    
    $upit = "UPDATE `".$tabela."` SET `arhiva` = '0' WHERE id = '".$_POST['id']."'";
    mysql_query ( $upit );

}



$upit = "SELECT id, mikrolokacija, povrsina, ukupnaPovrsina, cijena, aktivno FROM ".$tabela." 
        WHERE arhiva = '1'
        ORDER BY id DESC";
$odgovori = mysql_query ( $upit );

$i = 0;

while ( $podaci = mysql_fetch_assoc ( $odgovori ))  {
    
    if ( $i % 2 ) {
        
        $back = "darkLine";
        
    } else {
        
        $back = "lightLine";
        
    }
    
    prikaziNekretninu ( $podaci, $back, $tabela );

    $i++;

}
    
?>

