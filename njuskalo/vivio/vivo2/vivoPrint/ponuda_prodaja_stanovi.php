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
                

                selectPrikaz ( "Stan u",  $podaci['stanU'], 1 );
                prikaziKat ( $podaci['katOption'], $podaci['katValue'], $podaci['ukupnoKat'], 2 ); 
                formPrikaz ( "Broj soba",  $podaci['brojSoba'] , 1); 
                multiRadioPrikaz ( "Broj etaža",  $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                selectPrikaz ( "Grijanje",  $podaci['grijanje'], 2 );
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                prikaziOrijentaciju ( $podaci['orijentacija'], 1 );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                multiRadioPrikaz ( "Parking",  $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",   $podaci['prijevoz'], 2 );
                prikaziOtplatu ( $podaci['otplataTotal'], $podaci['otplataRata'], $podaci['otplataVisina'] );
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                multiRadioPrikaz ( "Useljenje",  $podaci['useljenje'], 2 );
                mixedPrikaz ( "Godina izgradnje",  $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                selectPrikaz ( "Stanje",  $podaci['stanje'], 1 );
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'], 1 ); 
                multiRadioPrikaz ( "Vlasnički list",  $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska",  $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Uporabna",    $podaci['uporabna'], 2 ); 
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivostanovi" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis"><b>Oprema stana:</b><br /> 
                
                <?php
                
                radioPrikaz ( "Protupožarni sustav", $podaci['protupozar'] );
                radioPrikaz ( "Protuprovalna vrata", $podaci['protuprovala'] );
                multiRadioPrikaz ( "Alarm",  $podaci['alarm'] );
                selectPrikaz ( "Stolarija",  $podaci['stolarija'] );
                radioPrikaz ( "Parket", $podaci['parket'] );
                radioPrikaz ( "Laminat", $podaci['laminat'] );
                multiRadioPrikaz ( "Klima",  $podaci['klima'] );
                multiRadioPrikaz ( "Kabel",  $podaci['kabel'] );
                multiRadioPrikaz ( "Satelit",  $podaci['satelit'] );
                multiRadioPrikaz ( "Internet",  $podaci['internet'] );
                multiRadioPrikaz ( "Telefonski priključak",  $podaci['telefon'] ); 
                mixedPrikaz ( "Balkon",  $podaci['balkonOption'], $podaci['balkonValue'] );
                mixedPrikaz ( "Loggia",  $podaci['loggiaOption'], $podaci['loggiaValue'] );
                mixedPrikaz ( "Vrt",  $podaci['vrtOption'], $podaci['vrtValue'] );
                mixedPrikaz ( "Terasa",  $podaci['terasaOption'], $podaci['terasaValue'] );
                selectPrikaz ( "Namještaj",  $podaci['namjestaj'] );
                radioPrikaz ( "Roštilj", $podaci['rostilj'] );
                radioPrikaz ( "Bazen", $podaci['bazen'] );
                selectPrikaz ( "Šupa",  $podaci['supa'] );
                mixedPrikaz ( "Garaža",  $podaci['garazaOption'], $podaci['garazaValue'], 2 );

                
                ?>
                
                </div>
        
     <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
               
                
         
        </div>
        
</div>
        


