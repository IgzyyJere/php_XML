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
            $arr = array ( 0 => "-", 1 => "ured", 2 => "ulični lokal", 3 => "trgovina", 4 => "kafić", 5 => "tihi obrt", 6 => "proizvodnja", 7 => "mini hotel", 8 => "skladište", 9 => "restoran", 10 => "club", 11 => "hala" );  
            selectPrikaz ( "Vrsta poslovnog prostora",  $podaci['vrstaPP'], 1 );
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 

                <div class="stupac">
                
                <?php
                
                selectPrikaz ( "Oprema",  $podaci['oprema'], 1 );
                formPrikaz ( "Broj prostorija",  $podaci['brojProstorija'], 1 ); 
                selectPrikaz ( "Poslovni prostor u",  $podaci['ppU'], 1 );
                multiRadioPrikaz ( "Broj etaža",  $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 2 );
                
                
                ?>
                
                </div> 
                <div class="stupac">   aaaaaaaaaa
                
                <?php
                
                selectPrikaz ( "Grijanje",  $podaci['grijanje'], 1 );
                formPrikaz ( "Sanitarni čvor",  $podaci['sanitarni'], 1 );      
                radioPrikaz ( "Čajna kuhinja", $podaci['cajnaKuhinja'], 1 ); 
                radioPrikaz ( "Lift", $podaci['lift'], 2 );
                multiRadioPrikaz ( "Skladište",  $podaci['skladiste'], 1 );      
                radioPrikaz ( "Mogučnost stambenog prostora", $podaci['mozdaStambeni'], 1 );
                radioPrikaz ( "Stambeno-poslovna kombinacija", $podaci['kombinacija'], 2 ); 
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Plaćanje najma",  $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'], 1 );
                dajPolog ( $podaci['polog']);
                mixedPrikaz ( "Godina izgradnje",  $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                multiRadioPrikaz ( "Parking",  $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",   $podaci['prijevoz'], 1 );
				selectPrikaz ( "Pristup",  $podaci['pristup'], 1 );
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'] , 2);
                
                ?>
                
                </div> 
                <hr class="ruler">
                
                <div class="opis"><b>Opis nekretnine:</b><br /> 
                
                <?php
                
                prikaziOpis ( $podaci['id'], "vivoposlovni" );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="opis"><b>Oprema poslovnog prostora:</b><br /> 
                
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

                
                ?>
                
                </div>
                <hr class="ruler">
                
                <div class="opis">
                
                <?php
                
                //režija i životinje
                prikaziRezije ( $podaci['rezije'], $podaci['rezijeS'], $podaci['rezijeV'], $podaci['rezijeP'], $podaci['rezijeT'],$podaci['rezijeI'] ); 
                
                ?>

                    
                </div> 
            <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             
            
        </div>
        
</div>

