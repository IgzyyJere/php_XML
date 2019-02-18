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
             selectPrikaz ( "Vrsta poslovnog prostora",  $podaci['vrstaPP'], 1 );
            
            ?>
        
          </b></div> 
                
                <hr class="ruler"> 
                <div class="stupac">
                
                <?php
                
               
                
                prikaziKat ( $podaci['katOption'], $podaci['katValue'], $podaci['ukupnoKat']); 
                selectPrikaz ( "Poslovni prostor u",  $podaci['ppU'], 1 );
                formPrikaz ( "Broj prostorija", $podaci['brojProstorija'], 1 ); 
                multiRadioPrikaz ( "Broj etaža",  $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                selectPrikaz ( "Grijanje",  $podaci['grijanje'], 1 );
                radioPrikaz ( "Sanitarni čvor",  $podaci['sanitarni'], 1 );    
                radioPrikaz ( "Čajna kuhinja", $podaci['cajnaKuhinja'] ); 
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                prikaziOrijentaciju ( $podaci['orijentacija'] );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                radioPrikaz ( "Teretni lift", $podaci['teretniLift'], 1 );
                multiRadioPrikaz ( "Parking",  $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",   $podaci['prijevoz'], 1 );
                selectPrikaz ( "Pristup",  $podaci['pristup'], 1 );
                multiRadioPrikaz ( "Skladište",  $podaci['skladiste'], 1 );
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                prikaziOtplatu ( $podaci['otplataTotal'], $podaci['otplataRata'], $podaci['otplataVisina'], 1 );
                multiRadioPrikaz ( "Useljenje",  $podaci['useljenje'] );
                mixedPrikaz ( "Godina izgradnje",  $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                multiRadioPrikaz ( "Vlasnički list",  $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska",  $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Uporabna",    $podaci['uporabna'] ); 
                
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
                multiRadioPrikaz ( "Mreža",  $podaci['mreza'] );
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

                
                ?>
                
                </div>

           <?php
        
        include ( "agencijskiFooter.php" );
        
        ?>        
             
            
        </div>
        
</div>
  

