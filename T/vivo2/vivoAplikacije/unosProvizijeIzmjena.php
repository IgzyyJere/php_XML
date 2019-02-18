<?php

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$upit = "UPDATE
        provizije
        SET
        nazivProvizije = '".$_POST['naziv']."'
        WHERE
        id = '".$_POST['id']."'";
mysql_query ( $upit );
echo $upit;
?> 
