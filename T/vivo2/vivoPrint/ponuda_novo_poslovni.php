<div id="main-content">
     
     <div class="content">
     
        <?php
        
        include ( "agencijskiHeader.php" );
        
        ?>
        
        <div class="opis"><b>
           
            <?php 
            
            
            echo 'novogradnja / stanovi<br />';
            
            $upit = "SELECT zupanija, grad, kvart, mikrolokacija FROM novoobjekti WHERE id = '".$podaci['objektID']."'";
            $odgovori = mysql_query ( $upit );
            $objekt = mysql_fetch_assoc ( $odgovori );
            
            dajZupaniju ( $objekt['zupanija'] ); 
            echo  " / ";
            dajGrad ( $objekt['grad'] ); 
            echo  " / "; 
            dajKvart ( $objekt['kvart'] );
            echo  "<br />",$objekt['mikrolokacija'];
            
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 

            
                <div class="stupac">
                
                <?php
                

                selectPrikaz ( "Poslovni prostor u", $podaci['ppU'], 1 );
                selectPrikaz ( "Vrsta poslovnog prostora", $podaci['vrstaPP'], 1 );
                formPrikaz ( "Ukupno katova", $podaci['ukupnoKat'], 1 );
                formPrikaz ( "Ukupna površina", $podaci['ukupnaPovrsina'], 1 ); 
                dajCijenuProdaja ( $podaci['cijena'], $podaci['ukupnaPovrsina'], $podaci['povrsina'], $podaci['pdv'] );
                multiRadioPrikaz ( "Skladište", $podaci['skladiste'], 1 );
                prikaziOtplatu ( $podaci['otplataTotal'], $podaci['otplataRata'], $podaci['otplataVisina'], 1 );
                multiRadioPrikaz ( "Useljenje", $podaci['useljenje'], 1 );
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                formPrikaz ( "Broj prostorija", $podaci['brojProstorija'], 1 ); 
                multiRadioPrikaz ( "Broj etaža", $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                selectPrikaz ( "Grijanje", $podaci['grijanje'], 1 );
                radioPrikaz ( "Sanitarni čvor",  $podaci['sanitarni'], 1 );    
                radioPrikaz ( "Čajna kuhinja", $podaci['cajnaKuhinja'], 1 );
                prikaziOrijentaciju ( $podaci['orijentacija'] );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                radioPrikaz ( "Teretni lift", $podaci['teretniLift'], 1 );

                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Godina izgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska dozvola", $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Uporabna dozvola",   $podaci['uporabna'], 1 ); 
                multiRadioPrikaz ( "Parking", $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );
                selectPrikaz ( "Pristup", $podaci['pristup'], 1 );
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "novostanovi" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis"><b><?php prevediTekst('Oprema poslovnog prostora'); ?>:</b><br /> 
                
                <?php
                
                radioPrikaz ( "Protupožarni sustav", $podaci['protupozar'] );
                radioPrikaz ( "Protuprovalna vrata", $podaci['protuprovala'] );
                multiRadioPrikaz ( "Alarm", $podaci['alarm'] );
                selectPrikaz ( "Stolarija", $podaci['stolarija'] );
                radioPrikaz ( "Parket", $podaci['parket'] );
                radioPrikaz ( "Laminat", $podaci['laminat'] );
                multiRadioPrikaz ( "Klima", $podaci['klima'] );
                multiRadioPrikaz ( "Kabel", $podaci['kabel'] );
                multiRadioPrikaz ( "Satelit", $podaci['satelit'] );
                multiRadioPrikaz ( "Internet", $podaci['internet'] );
                multiRadioPrikaz ( "Mreža", $podaci['mreza'] );
                multiRadioPrikaz ( "Telefonski priključak", $podaci['telefon'] ); 
                mixedPrikaz ( "Balkon", $podaci['balkonOption'], $podaci['balkonValue'] );
                mixedPrikaz ( "Loggia", $podaci['loggiaOption'], $podaci['loggiaValue'] );
                mixedPrikaz ( "Vrt", $podaci['vrtOption'], $podaci['vrtValue'] );
                mixedPrikaz ( "Terasa", $podaci['terasaOption'], $podaci['terasaValue'] );
                selectPrikaz ( "Namještaj", $podaci['namjestaj'] );
                radioPrikaz ( "Roštilj", $podaci['rostilj'] );
                radioPrikaz ( "Bazen", $podaci['bazen'] );
                selectPrikaz ( "Šupa", $podaci['supa'] );
                mixedPrikaz ( "Garaža", $podaci['garazaOption'], $podaci['garazaValue'] );

                
                ?>
                </div>

        
     <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
               
                
         
        </div>
        
</div>
        


