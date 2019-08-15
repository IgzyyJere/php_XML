<?php

echo '<br /><br /><br />Tekst provizije po jezicima :<br />';

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$upit = "INSERT INTO provizije ( nazivProvizije ) VALUES ( '".$_POST['naziv']."' )";
mysql_query ( $upit );
$id = mysql_insert_id();

$upit = "SELECT * FROM jezici";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {


     echo '<div><form class="unosProvizijaDiv" method="POST" action="vivoAplikacije/unosTekstaProvizije.php">',
     $podaci['naziv'],' : <input type="text" name="tekst" ';

     $u = "SELECT * FROM provizijeTekst WHERE idProvizije = '".$id."' AND jezik = '".$podaci['kratica']."'";
     $o = mysql_fetch_assoc ( $u );
     $p = mysql_fetch_assoc ( $o );
     
     if ( $p['tekst'] ) {
         
         echo ' value="',$p['tekst'],'" ';
         
     }
    
     echo ' size="80"><input type="hidden" name="jezik" value="',$podaci['kratica'],'"><input type="hidden" name="id" value="',$id,'"><a><button type="submit">unesi</button></a></form></div>';
    
    }
    


?> 

<div id="provizijeObavijest">
</div> 