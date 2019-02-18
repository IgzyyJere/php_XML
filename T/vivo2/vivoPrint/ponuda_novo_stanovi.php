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
                

                selectPrikaz ( "Stan u", $podaci['stanU'], 1 );
                
                
                formPrikaz ( "Stambena površina", $podaci['povrsina'], 1 );
                formPrikaz ( "Ukupna površina", $podaci['ukupnaPovrsina'], 1 ); 
                dajCijenuProdaja ( $podaci['cijena'], $podaci['ukupnaPovrsina'], $podaci['povrsina'], $podaci['pdv'] );
                prikaziOtplatu ( $podaci['otplataTotal'], $podaci['otplataRata'], $podaci['otplataVisina'], 1 );
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                prikaziKat ( $podaci['katOption'], $podaci['katValue'], $podaci['ukupnoKat']);
                formPrikaz ( "Broj soba",  $podaci['brojSoba'] , 1); 
                multiRadioPrikaz ( "Broj etaža", $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                selectPrikaz ( "Grijanje", $podaci['grijanje'], 1 );
                prikaziOrijentaciju ( $podaci['orijentacija'], 1 );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                multiRadioPrikaz ( "Parking", $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );

                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Godina izgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska dozvola", $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Uporabna dozvola",   $podaci['uporabna'] , 1); 
                multiRadioPrikaz ( "Useljenje", $podaci['useljenje'], 1 );
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "novostanovi" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis"><b>Oprema stana:</b><br /> 
                
                <?php
                
                radioPrikaz ( "Protupožarni sustav", $podaci['protupozar'] );
                radioPrikaz ( "Protuprovalna vrata", $podaci['protuprovala'] );
                multiRadioPrikaz ( "Alarm", $podaci['alarm'] );
                selectPrikaz ( "Stolarija", $podaci['stolarija'] );
                radioPrikaz ( "Parket", $podaci['parket'] );
                radioPrikaz ( "Laminat", $podaci['laminat'] );
                multiRadioPrikaz ( "Klima", $podaci['klima'] );
                multiRadioPrikaz ( "Kabelski priključak", $podaci['kabel'] );
                multiRadioPrikaz ( "Satelitski priključak", $podaci['satelit'] );
                multiRadioPrikaz ( "Internetski priključak", $podaci['internet'] );
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
        


