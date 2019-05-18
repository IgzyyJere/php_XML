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
                <div class="stupac">
                
                <?php
                

                mixedPrikaz ( "Širina prstupnog puta", $podaci['sirinaPristupaOption'], $podaci['sirinaPristupaValue'], 2 ); 
                selectPrikaz ( "Vrsta zemljišta", "vrstaZemljista", $arr, $podaci['vrstaZemljista'] );
                
                ?>
                
                </div>
                <div class="stupac">
                
                <?php

                mixedPrikaz ( "Plačanje najma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'] );
                formPrikaz ( "Polog", "polog", $podaci['polog'], 2 ); 
                
                
                ?>
                
                </div> 
                
                <div class="opis">
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivozemljista" );
                
                ?>
                
            
                    
                </div>
            <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             
            
        </div>
        
</div>

