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
                
                formPrikaz ( "Površina okućnice",  $podaci['okucnica'], 1 ); 
                formPrikaz ( "Broj soba",  $podaci['brojSoba'] , 1); 
                multiRadioPrikaz ( "Broj etaža",  $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                formPrikaz ( "Broj WC-a", $podaci['wc'], 1 ); 
                selectPrikaz ( "Grijanje",  $podaci['grijanje'] , 2);
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                selectPrikaz ( "Oprema",  $podaci['oprema'] , 1);
                prikaziOrijentaciju ( $podaci['orijentacija'], 1 );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                multiRadioPrikaz ( "Parking",  $podaci['parking'], 1 );
                mixedPrikaz ( "Garaža",  $podaci['garazaOption'], $podaci['garazaValue'] );
                selectPrikaz ( "Prijevoz",   $podaci['prijevoz'] );
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Godina izgradnje",  $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'] );
                dajPolog ( $podaci['polog']);  
                mixedPrikaz ( "Plaćanje najma",  $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'], 1 );
                radioPrikaz ( "Moguć poslovni prostor", $podaci['mozdaPoslovni'] );
                
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivokuce" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis"><b>Oprema kuće:</b><br />  
                
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
                multiRadioPrikaz ( "Osnovno posuđe",  $podaci['osPosude'] ); 
                multiRadioPrikaz ( "Perilica rublja",  $podaci['perilica'] );
                multiRadioPrikaz ( "Perilica suđa",  $podaci['perilicaSuda'] );  

                
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

