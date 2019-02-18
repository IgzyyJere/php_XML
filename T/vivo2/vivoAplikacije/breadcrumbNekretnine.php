<?php

$uu = "SELECT * FROM grupe WHERE id = '".$grupa."'";
$oo = mysql_query ( $uu );
$pp = mysql_fetch_assoc ( $oo );

echo '<div id="breadcrumb">',$pp['vrsta'],' &nbsp;&nbsp;/&nbsp;&nbsp; ',$pp['grupa'],' &nbsp;&nbsp;/&nbsp;&nbsp; ',$akcija,'</div>';

?>