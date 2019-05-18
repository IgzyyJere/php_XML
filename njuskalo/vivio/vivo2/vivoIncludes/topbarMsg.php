<?php

$upit = "SELECT * FROM poruke WHERE datum >= '".$korisnik['zadnjaPosjeta']."' AND  prima = '".$korisnik['id']."'";
$odgovori = mysql_query ( $upit );
$broj = mysql_num_rows( $odgovori );

if ( $broj ) {

    echo '<div class="porukaGore">';
    echo '<img src="/vivo2/ikone/email.png" alt="" />';
    echo '<a href="/vivo2/podesavanja/poruke/prikaz/0/">Imate poruke (',$broj,')</a></div>';
    
}

    

