<div id="main-content">
        
            <h3><?php prevediTekst('Novogradnja'); ?></h3>
        
            <div class="content">
                
                <div class="stupac">
                
                <?php
                
                dajPrvuSliku ( $podaci['slike'] );
                
                ?>
                
                </div>
                <div class="stupac">
                <?php
                
                //$podaci['']
                
                dajZupaniju ( $podaci['zupanija'] );
                echo '<br />';
                dajGrad ( $podaci['grad'] ); 
                echo '<br />';
                dajKvart ( $podaci['kvart'] );
                echo '<br />';
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
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );
                multiRadioPrikaz ( "Useljenje", $podaci['useljenje'], 1 );
                formPrikaz ( "Useljivo od", $podaci['useljivo'], 2 );
                
                
                ?>
                
                </div> 

                <hr class="ruler">
                
                <div class="opis"><b><?php prevediTekst('Opis objekta'); ?>
:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "novoobjekti" );
                
                ?>
                
                </div>
                
                <hr class="ruler">
                
                <div class="opis"><b><?php prevediTekst('Popis stanova u objektu'); ?>
:</b><br />  
                
                <?php
                
                $upit = "SELECT id, ukupnaPovrsina FROM novostanovi WHERE objektID = '".$podaci['id']."'";
                $odgovori = mysql_query ( $upit );
                while ( $stanovi = mysql_fetch_assoc ( $odgovori )) {
                    
                    echo '<a href="novogradnja_stanovi.php?id=',$stanovi['id'],'">Stan ',$stanovi['ukupnaPovrsina'],'m<sup>2</sup></a>, ';
                    
                }

                ?>
                
                <br /><br /><b><?php prevediTekst('Popis poslovnih protora u objektu'); ?>:</b><br />  
                
                <?php
                
                $upit = "SELECT id, ukupnaPovrsina FROM novoposlovni WHERE objektID = '".$podaci['id']."'";
                $odgovori = mysql_query ( $upit );
                while ( $poslovni = mysql_fetch_assoc ( $odgovori )) {
                    
                    echo '<a href="novogradnja_poslovni.php?id=',$poslovni['id'],'">Stan ',$poslovni['ukupnaPovrsina'],'m<sup>2</sup></a>, ';
                    
                }

                ?>
                
                </div>


        
        </div>
        
</div>

