<form method="POST" id="changePass" action="/vivo2/0/0/0/0/napravi=izmjeni">

    Upišite novu lozinku : <input type="text" name="password">
    
<button name="submit" type="submit" class="greenButton">Izmjeni lozinku</button>
</form>

<div id="lozinkaPotvrda"></div>

<?php

if ( $_POST['password'] ) {

    $u = "SELECT korisnik FROM kontroler WHERE idsess='".session_id()."'";
    $o = mysql_query ( $u );
    $user = mysql_result ( $o, 0 );

    $upit = "UPDATE korisnici SET passMD5 = '".md5($_POST['password'])."' WHERE username = '".$user."'";
    mysql_query ( $upit );

    }

?>




