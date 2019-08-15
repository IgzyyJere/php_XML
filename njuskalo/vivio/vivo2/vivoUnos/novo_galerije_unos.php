<?php

$upit = "UPDATE kontroler SET uploadGalerija = NULL WHERE idsess = '".session_id()."'";
mysql_query ( $upit );

echo '<form name="testForm" method="POST" id="mainForm" action="">';


echo '<div class="formTitle">Osnovni podaci</div><div>';


$u = "SELECT grupa FROM kontroler WHERE idsess = '".session_id()."'";
$o = mysql_query ( $u );
$grupa = mysql_result ( $o, 0 );

echo '<input type="hidden" name="idProjekta" value="',$grupa,'">';

formInsert ( "Naslov", "naslov" );
selectInsert ( "Vrsta galerije", "vrstaGalerije" );

// upravljanje datotekama             /
// treba iskljuèiti neke opcije i     /
// podesiti da sprema popise u        /
// kontroler pošto nema ID-a podatka  /
$iskljuciVideo = 1;
$iskljuciSlike = 0;
$iskljuciDatoteke = 1;
$izFormulara = 1;
include ( "vivoAplikacije/upravljanjeDatotekama.php" );


?>

 
<input type="hidden" name="brojPogleda" value="1">
<input type="hidden" name="akcija" value="prikaz">
<input type="hidden" name="napravi" value="unos">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="buttonSubmitBack greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>
</div>
