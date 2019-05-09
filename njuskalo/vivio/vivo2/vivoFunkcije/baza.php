<?php

//require ( "vivoDiff/spajanje.php" );
include $_SERVER['DOCUMENT_ROOT']."/vivo2/vivoDiff/spajanje.php";
$db = mysql_connect ( $spajanjeServer,$spajanjeUser, $spajanjePass );
mysql_select_db ( $spajanjeBaza , $db );

?>
