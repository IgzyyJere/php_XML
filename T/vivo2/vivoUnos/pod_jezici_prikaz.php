<?php

mysql_query ("set names utf8");

$u = "SELECT * FROM kontroler WHERE idsess='".session_id()."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );

if ( $_POST['akcija'] == "brisanje" ) {
    
    $tabela = "jezici";
    
    if ( $p['razina'] == 1 ) {
        
        $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    } else {
        
        $upit = "UPDATE `".$tabela."` SET obrisano = 1 WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    }
    
}


if ( $_POST['napravi'] == 'unos' ) { 
    
    $upit = "INSERT INTO `jezici` ( `id`, `naziv`, `kratica`, `aktivno` ) VALUES ( '', '".$_POST['naziv']."', '".$_POST['kratica']."', '1' )";
    mysql_query ( $upit );
    
}

if ( $_POST['napravi'] == 'izmjena' ) {
    
    $upit = "UPDATE `jezici` SET `naziv` = '".$_POST['naziv']."', `kratica` = '".$_POST['kratica']."' WHERE id = '".$p['radniID']."'";
    mysql_query ( $upit );
    
}


$upit = "SELECT * FROM jezici";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    
    
    if ( $i % 2 ) {
        
        $back = "darkLine";
        
    } else {
        
        $back = "lightLine";
        
    }
    
    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/brisanje/',$podaci['id'],'/" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">
        ',$podaci['naziv'],' : ',$podaci['kratica'];
        
        if ( $podaci['aktivno'] ){
        
        echo ' :: aktivan';
        
    }
        
        
        echo '</div>
    </div>';
    
    $i ++;
    
}

?>

