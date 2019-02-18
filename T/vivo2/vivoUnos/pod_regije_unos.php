<br />

<?php 
             

echo '<form name="testForm" method="POST" id="mainForm">';


formInsert ( "Naziv regije", "nazivRegije" ); 
formInsert ( "Zem. dužina", "lon" );
formInsert ( "Zem. širina", "lat" );  
formInsert ( "Razina zooma", "zoomLvl" ); 


?>
 
<input type="hidden" name="akcija" value="prikaz">
<input type="hidden" name="napravi" value="unos">
<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmit" name="submit" value="submit" type="submit"><img src="ikone/accept.png">Unesi</button> 
</div>
</form>

                            
