<?php

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

include ( "vivoFunkcije/baza.php" ); 
mysql_query ("set names utf8");


$pupit = "SELECT * FROM provizije WHERE id ='".$id."'";
$podg = mysql_query ( $pupit );
$ppod = mysql_fetch_assoc ( $podg );   


?>
<form method="POST" id="izmjenaProvizijeForm" action="">
Izmjena naziva provizije :<br />
Naziv provizije :<input type="text" name="nazivProvizije" value="<?php echo $ppod['nazivProvizije']; ?>">
<input type="hidden" name="id" value="<?php echo $ppod['id']; ?>"><button type="submit">unesi</button></form>

<div id="provizijeObavijestTekst">
</div>

<br /><br /><br />

<?php



$upit = "SELECT * FROM jezici";
$odgovori = mysql_query ( $upit );

while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
    
    
     echo '<div><form class="izmjeneProvizijaDiv" method="POST" action="vivoAplikacije/izmjenaTekstaProvizije.php">',
     $podaci['naziv'],' : <input type="text" name="tekst" ';
     
     $u = "SELECT * FROM provizijeTekst WHERE idProvizije = '".$ppod['id']."' AND jezik = '".$podaci['kratica']."'";
     $o = mysql_query ( $u );
     $p = mysql_fetch_assoc ( $o );


     if ( $p['tekst'] ) {
         
         echo ' value="',$p['tekst'],'" ';
         
     }

     if ( $p['id'] ) {
        $pid = $p['id'];
        } else {
        $pid = "nema";
        }

     echo ' size="80"><input type="hidden" name="jezik" value="',$podaci['kratica'],'"><input type="hidden" name="idProvizije" value="',$id,'"><input type="hidden" name="id" value="',$pid,'"><a><button type="submit">unesi</button></a></form></div>';
    
    }


?> 

<div id="provizijeObavijest">
</div>