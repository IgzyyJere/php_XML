<br />

<?php 
        
mysql_query ("set names utf8"); 

$upit = "SELECT * FROM regije WHERE id='".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );    

echo '<form name="testForm" method="POST" id="mainForm">';


formUpdate ( "Naziv regije", "nazivRegije", $podaci['nazivRegije'] ); 
formUpdate ( "Zem. dužina", "lon", $podaci['lon'] );
formUpdate ( "Zem. širina", "lat", $podaci['lat'] );  
formUpdate ( "Razina zooma", "zoomLvl", $podaci['zoomLvl'] ); 


?>
 
<input type="hidden" name="akcija" value="prikaz">
<input type="hidden" name="napravi" value="izmjena">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmit" name="submit" value="submit" type="submit"><img src="ikone/accept.png">Unesi</button> 
</div>
</form>

                            
