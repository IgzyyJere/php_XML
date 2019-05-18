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
                <div class="opis">
                
                <?php
                
                formPrikaz ( "Površina", $podaci['povrsina'], 1 ) ;
                dajCijenuProdaja ( $podaci['cijena'], $podaci['ukupnaPovrsina'], $podaci['povrsina'], $podaci['pdv'] ); 
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'], 1 ); 

                
                ?>
                
                </div> 
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivoostalo" );
                
                ?>
                
                </div>

        </div>
        
</div>
