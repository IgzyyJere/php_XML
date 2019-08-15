<div id="main-content">
     
     <div class="content">
     
        <?php
        
        include ( "agencijskiHeader.php" );
        
        ?>
        
        <div class="opis"><b>
           
            <?php 
            
            $upit = "SELECT * FROM grupe WHERE id = '".$podaci['grupa']."'";
            $odgovori = mysql_query ( $upit );
            $nek = mysql_fetch_assoc ( $odgovori );
            
            echo $nek['parentGroup'],' / ',$nek['groupName'],'<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  " / ";
            dajGrad ( $podaci['grad'] ); 
            echo  " / "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija']," / ",$podaci['povrsina'],' m<sup>2</sup> / ',$podaci['cijena'],' &euro;';
            
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 

                <div class="agencija">  
                
                <?php
                
                selectPrikaz ( "Vrsta zemljišta", $podaci['vrstaZemljista'], 1);

                ?>
                
                </div>

                <div class="agencija">  
                
                <?php
                
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
				multiRadioPrikaz ( "Lokacijska dozvola",  $podaci['lokacijska'], 1 );
                multiRadioPrikaz ( "Građevinska dozvola",  $podaci['gradevinska'], 2); 
                

                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivozemljista" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis">
				
				<?php
				
				formPrikaz ( "Dužina (m)", $podaci['duzina'] );
				formPrikaz ( "Širina (m)", $podaci['sirina'] );
                mixedPrikaz ( "Širina pristupnog puta (m)", $podaci['sirinaPristupaOption'], $podaci['sirinaPristupaValue'], 1 ); 
				
				?>
				
				<b>Komunalije:</b><br /> 
                
                <?php
                
                radioPrikaz ( "Struja", $podaci['struja'] );
                radioPrikaz ( "Voda", $podaci['voda'] );
                radioPrikaz ( "Kanalizacija", $podaci['kanalizacija'] );      
                radioPrikaz ( "Plin", $podaci['plin'] );
                radioPrikaz ( "Telefon", $podaci['telefon'] );   
                
                ?>
                
                </div>
                
                    <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             

        </div> 
                
</div>


