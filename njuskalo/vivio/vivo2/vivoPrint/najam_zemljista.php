<div id="main-content">
        
            <h3><b>
            <?php 
            
            $upit = "SELECT * FROM grupe WHERE id = '".$podaci['grupa']."'";
            $odgovori = mysql_query ( $upit );
            $nek = mysql_fetch_assoc ( $odgovori );
            
            echo $nek['parentGroup'],'<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  " / ";
            dajGrad ( $podaci['grad'] ); 
            echo  " / "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija']," / ",$podaci['ukupnaPovrsina'],' m<sup>2</sup> / ',$podaci['cijena'],' &euro;';
            
            
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
                formPrikaz ( "Djeca", $podaci['djeca'], 1 );
                formPrikaz ( "Prijava", $podaci['prijava'], 1 );

                
                ?>
                
                </div>
                <div class="stupac">
                
                <?php
                

                mixedPrikaz ( "Širina prstupnog puta", $podaci['sirinaPristupaOption'], $podaci['sirinaPristupaValue'], 2 ); 
                selectPrikaz ( "Vrsta zemljišta", "vrstaZemljista", $podaci['vrstaZemljista'] , 1);
                
                ?>
                
                </div>
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Plačanje najma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'], 1 );
                formPrikaz ( "Polog", "polog", $podaci['polog'], 2 ); 
                
                
                ?>
                
                </div> 
                
                <div class="opis">
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivozemljista" );
                
                ?>
                
            
                    
                </div>

            
        </div>
        
</div>

