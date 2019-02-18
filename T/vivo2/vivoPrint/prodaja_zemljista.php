<div id="main-content">
        
            <h3><b>
            <?php 
            
            $upit = "SELECT * FROM grupe WHERE id = '".$podaci['grupa']."'";
            $odgovori = mysql_query ( $upit );
            $nek = mysql_fetch_assoc ( $odgovori );
            
            $euro_m2 = ($podaci['cijena']/$podaci['povrsina']);
            $euro_m2 = number_format($euro_m2, 0, ',', '.');
            
            echo $nek['parentGroup'],'<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  " / ";
            dajGrad ( $podaci['grad'] ); 
            echo  " / "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija']," / ",$podaci['povrsina'],' m<sup>2</sup> / ',$podaci['cijena'],' &euro; (',$euro_m2,' / m<sup>2</sup>)';
            if ( $podaci['pdv'] ) {
                
                echo '+PDV';
                
            }
            
            ?></b></h3>
        
            <div class="content">
                
                <div class="agencija">
                
                <?php
                
                formPrikaz ( "Ime i prezime", $podaci['imeIPrezime'],1 ); 
                formPrikaz ( "Mjesto", $podaci['mjesto'],1 );
                formPrikaz ( "Adresa", $podaci['adresa'],1 );
                formPrikaz ( "Prebivalište", $podaci['prebivaliste'],1 );
                formPrikaz ( "Email", $podaci['email'],1 ); 
                formPrikaz ( "Mobitel", $podaci['mobitel'],1 );
                formPrikaz ( "Telefon", $podaci['povTelefon'],1 );
                formPrikaz ( "MIN cijena", $podaci['minCijena'],1 );
                formPrikaz ( "Pregledali", $podaci['pregledali'],1 );
                
                ?>
                
                </div>

                <div class="agencija"> 
                <?php
                
                //$podaci['']
                
                echo $podaci['napomena'];
                echo '<br />';
                formPrikaz ( "Kat. čestica", $podaci['katCes'],1 );
                formPrikaz ( "Kat. općina", $podaci['katOpcina'],1 );
                formPrikaz ( "zk. uložak", $podaci['zkUlozak'],1 );
                
                ?>
                
                </div>
                
                <hr class="ruler"> 

                <div class="agencija">  
                
                <?php
                
                selectPrikaz ( "Vrsta zemljišta", $podaci['vrstaZemljista'], 1);

                ?>
                
                </div>

                <div class="agencija">  
                
                <?php
                
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
				multiRadioPrikaz ( "Lokacijska dozvola", $podaci['lokacijska'], 1 );
                multiRadioPrikaz ( "Građevinska dozvola", $podaci['gradevinska'], 2); 
                

                
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
				
				formPrikaz ( "Dužina (m)", $podaci['duzina'], 1 );
				formPrikaz ( "Širina (m)", $podaci['sirina'], 1 );
                mixedPrikaz ( "Širina pristupnog puta (m)", $podaci['sirinaPristupaOption'], $podaci['sirinaPristupaValue'], 1 ); 
				
				?>
				
				<b>Komunalije:</b><br /> 
                
                <?php
                
                radioPrikaz ( "Struja", $podaci['struja'], 1 );
                radioPrikaz ( "Voda", $podaci['voda'], 1 );
                radioPrikaz ( "Kanalizacija", $podaci['kanalizacija'], 1 );      
                radioPrikaz ( "Plin", $podaci['plin'], 1 );
                radioPrikaz ( "Telefon", $podaci['telefon'], 1 );   
                
                ?>
                
                </div>


        </div> 
                
</div>

