<?php

$upit = "SELECT * FROM podsjetnik WHERE datum = CURDATE() AND prima = '".$korisnik['id']."'";
$odgovori = mysql_query ( $upit );
$broj = mysql_num_rows( $odgovori );

if ( $broj ) {

    echo '<div class="porukaGore">';
    echo '<img src="/vivo2/ikone/bell.png" alt="" /> ';
    echo '<a href="/vivo2/podesavanja/podsjetnik/prikaz/0/"> Imate podsjetnik (',$broj,')</a></div>';

}

?>
