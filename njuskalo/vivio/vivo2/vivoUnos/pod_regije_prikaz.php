<?php

if ( $_POST['akcija'] == "brisanje" ) {
    
    $tabela = "regije";
    
    if ( $p['razina'] == 1 ) {
        
        $upit = "DELETE FROM `".$tabela."` WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    } else {
        
        $upit = "UPDATE `".$tabela."` SET obrisano = 1 WHERE id = '".$_POST['id']."'";
        mysql_query ( $upit );
        
    }
    
}


if ( $_POST['napravi'] == 'unos' ) { 
    
    $upit = "INSERT INTO `regije` ( `id`, `nazivRegije`, `lon`, `lat`, `zoomLvl` ) VALUES ( '', '".$_POST['nazivRegije']."', '".$_POST['lon']."', '".$_POST['lat']."', '".$_POST['zoomLvl']."' )";
    mysql_query ( $upit );
    
}

if ( $_POST['napravi'] == 'izmjena' ) {

    
    $upit = "UPDATE `regije` SET `nazivRegije` = '".$_POST['nazivRegije']."', `lon` = '".$_POST['lon']."', `lat` = '".$_POST['lat']."', `zoomLvl` = '".$_POST['zoomLvl']."' WHERE id = '".$p['radniID']."'";
    mysql_query ( $upit );
    
}

$upi = "SELECT * FROM regije";
$od = mysql_query ( $upi );

$i = 0;  

while ( $podi = mysql_fetch_assoc ( $od ) ) {
    
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
        ',$podi['nazivRegije'],'</div>
    </div>';
    
    $i++;
}

echo '<br /><br /><br /><br /><br /><b>Popis županija :</b><br />';

$upi = "SELECT * FROM zupanije";
$od = mysql_query ( $upi );


while ( $podi = mysql_fetch_assoc ( $od ) ) {
    
    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }
    
    echo '<form class="popisZupanija" action="vivoAplikacije/izmjenaZupanije.php" method="POST"><div class="',$back,' prikazFormLine">',$podi['nazivZupanije'];
    
    $u = "SELECT * FROM regije";
    $o = mysql_query ( $u );
    echo ' : <select name="regija">';
    while ( $p = mysql_fetch_assoc ( $o )) {
    
    echo '<option value="',$p['id'],'" '; 
    
    if ( $p['id'] == $podi['idRegije'] ) {
        
        echo ' selected ';
        
    }
    
    echo ' >',$p['nazivRegije'],'</option>';
    
    }
    
    echo '</select><input type="hidden" name="id" value="',$podi['id'],'"><button type="submit" class="greenButton">izmijeni</button><br /></form></div>';

    $i++;
}

?>
