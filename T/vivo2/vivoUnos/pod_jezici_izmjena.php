<?php 

include ( "vivoFunkcije/postFunkcije.php" );

mysql_query ("set names utf8");

$upit = "SELECT * FROM jezici WHERE id='".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );
             

echo '<form name="testForm" method="POST" id="mainForm">';


formUpdate ( "Ime jezika", "naziv", $podaci['naziv'] ); 
formUpdate ( "Kratica", "kratica", $podaci['kratica'] );


?>
 
<input type="hidden" name="akcija" value="prikaz">
<input type="hidden" name="napravi" value="izmjena"> 
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmit" name="submit" value="submit" type="submit"><img src="ikone/accept.png">Unesi</button> 
</div>
</form>