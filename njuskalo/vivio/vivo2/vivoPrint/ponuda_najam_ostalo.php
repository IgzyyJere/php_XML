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
            echo  "<br />",$podaci['mikrolokacija']," / ",$podaci['ukupnaPovrsina'],' m<sup>2</sup> / ',$podaci['cijena'],' &euro;';
            
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 
                <div class="stupac">
                
                <?php
                
                formPrikaz ( "Površina", $podaci['povrsina'] ) ;
                dajCijenu ( $podaci['cijena'], $podaci['ukupnaPovrsina'], $podaci['povrsina'], $podaci['pdv'] ); 
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'] ); 
                
                ?>
                
                </div> 
                
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Plačanje najma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'] );
                radioPrikaz ( "Životinje", "zivotinje", $podaci['zivotinje'] );
                formPrikaz ( "Polog", "polog", $podaci['polog'], 2 ); 
                
                ?>
                
                </div> 
                
                <div class="opis">
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivoostalo" );
                
                ?>
                
                </div>
            
            <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             
            
        </div>
        
</div>
