<div id="main-content">
     
     <div class="content">
     
        <?php
        
        include ( "agencijskiHeader.php" );
        
        ?>
        
        <div class="opis"><b>
           
            <?php 
            
            
            echo 'novogradnja / objekti<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  " / ";
            dajGrad ( $podaci['grad'] ); 
            echo  " / "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija'];
            
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 

            
                <div class="stupac">
                
                <?php
                

                formPrikaz ( "Ulica", $podaci['mikrolokacija'], 1 );
                formPrikaz ( "Godina izgradnje", $podaci['godinaIzgradnje'], 1 );
                formPrikaz ( "Ukupno katova", $podaci['ukupnoKat'], 1 ); 
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska", $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Uporabna",   $podaci['uporabna'], 1 ); 

                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );
                multiRadioPrikaz ( "Useljenje", $podaci['useljenje'], 1 );
                formPrikaz ( "Useljivo od", $podaci['useljivo'], 2 );
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "novoobjekti" );
                
                ?>
                
                </div>
                <hr class="ruler">

        
     <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
               
                
         
        </div>
        
</div>
        


