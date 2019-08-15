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
                formPrikaz ( "Broj soba",  $podaci['brojSoba'], 1 ); 
                prikaziKat ( $podaci['katOption'], $podaci['katValue'], $podaci['ukupnoKat']); 
                multiRadioPrikaz ( "Broj etaža",  $podaci['brojEtaza'], 1 ); 
                mixedPrikaz ( "Plaćanje najma",  $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'], 1 );
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                 
                dajPolog ( $podaci['polog'] );           
                selectPrikaz ( "Oprema",  $podaci['oprema'], 1 );
                selectPrikaz ( "Grijanje",  $podaci['grijanje'], 1 );
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );  
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Godina izgradnje",  $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'], 1 );
                multiRadioPrikaz ( "Parking",  $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",   $podaci['prijevoz'], 1 );
                radioPrikaz ( "Mogučnost poslovnog prostora", $podaci['mozdaPoslovni'], 2 );
                
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
                mixedPrikaz ( "Garaža",  $podaci['garazaOption'], $podaci['garazaValue'] );
                multiRadioPrikaz ( "Osnovno posuđe",  $podaci['osPosude'] ); 
                multiRadioPrikaz ( "Perilica rublja",  $podaci['perilica'] );
                multiRadioPrikaz ( "Perilica suđa",  $podaci['perilicaSuda'] ); 
                formPrikaz ( "Broj WC-a", $podaci['wc'] );
                prikaziOrijentaciju ( $podaci['orijentacija'] );  

                
                ?>
                
                </div>
                
                <hr class="ruler">
                
                <div class="opis">
                
                <?php
                
                //režija i životinje
                prikaziRezije ( $podaci['rezije'], $podaci['rezijeS'], $podaci['rezijeV'], $podaci['rezijeP'], $podaci['rezijeT'],$podaci['rezijeI'] ); 
                echo '<br />';
				radioPrikaz ( "Kućni ljubimci - dopušteni", $podaci['zivotinje'], 1 ); 
                
                ?>
                
                </div>
            <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             
            
        </div> 
            
</div>
