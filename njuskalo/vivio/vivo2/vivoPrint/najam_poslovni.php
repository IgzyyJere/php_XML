<div id="main-content">
        
            <h3><b>
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
                 
                selectPrikaz ( "Vrsta poslovnog prostora", $podaci['vrstaPP'], 1 );
                echo $podaci['napomena'];
                echo '<br />';
                formPrikaz ( "Djeca", $podaci['djeca'], 1 );
                formPrikaz ( "Prijava", $podaci['prijava'], 1 );
                
                ?>
                
                </div>
                <hr class="ruler">
                <div class="stupac">
                
                <?php
                
                prikaziKat ( $podaci['katOption'], $podaci['katValue'], $podaci['ukupnoKat'], 2); 
                selectPrikaz ( "Oprema", $podaci['oprema'], 1 );
                formPrikaz ( "Broj prostorija",  $podaci['brojProstorija'], 1 ); 
                selectPrikaz ( "Pos. prostor u", $podaci['ppU'], 1 );
                multiRadioPrikaz ( "Broj etaža", $podaci['brojEtaza'], 1 ); 
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 2 );
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                selectPrikaz ( "Grijanje", $podaci['grijanje'], 1 );
                formPrikaz ( "Sanitarni čvor",  $podaci['sanitarni'], 1 );    
                radioPrikaz ( "Čajna kuhinja", $podaci['cajnaKuhinja'], 1 ); 
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                multiRadioPrikaz ( "Skladište", $podaci['skladiste'], 1 );      
                radioPrikaz ( "Mogučnost stambenog prostora", $podaci['mozdaStambeni'], 1 );
                radioPrikaz ( "Stambeno-poslovna kombinacija", $podaci['kombinacija'], 2 ); 
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Plaćanje najma", $podaci['placanjeNajmaOption'], $podaci['placanjeNajmaValue'], 1 );
                dajPolog ( $podaci['polog']);
                mixedPrikaz ( "Godina izgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                multiRadioPrikaz ( "Parking", $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );
				selectPrikaz ( "Pristup", $podaci['pristup'], 1 );
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
                multiRadioPrikaz ( "Alarm", $podaci['alarm'] );
                selectPrikaz ( "Stolarija", $podaci['stolarija'] );
                radioPrikaz ( "Parket", $podaci['parket'] );
                radioPrikaz ( "Laminat", $podaci['laminat'] );
                multiRadioPrikaz ( "Klima", $podaci['klima'] );
                multiRadioPrikaz ( "Kabel", $podaci['kabel'] );
                multiRadioPrikaz ( "Satelit", $podaci['satelit'] );
                multiRadioPrikaz ( "Internet", $podaci['internet'] );   
                multiRadioPrikaz ( "Telefonski priključak", $podaci['telefon'] ); 
                multiRadioPrikaz ( "Mreža", $podaci['mreza'] ); 
                radioPrikaz ( "Teretni lift", $podaci['teretniLift'] ); 
                radioPrikaz ( "Izlog", $podaci['izlog'] ); 
                mixedPrikaz ( "Balkon", $podaci['balkonOption'], $podaci['balkonValue'] );
                mixedPrikaz ( "Loggia", $podaci['loggiaOption'], $podaci['loggiaValue'] );
                mixedPrikaz ( "Vrt", $podaci['vrtOption'], $podaci['vrtValue'] );
                mixedPrikaz ( "Terasa", $podaci['terasaOption'], $podaci['terasaValue'] );
                selectPrikaz ( "Namještaj", $podaci['namjestaj'] );
                radioPrikaz ( "Roštilj", $podaci['rostilj'] );
                radioPrikaz ( "Bazen", $podaci['bazen'] );
                selectPrikaz ( "Šupa", $podaci['supa'] );
                mixedPrikaz ( "Garaža", $podaci['garazaOption'], $podaci['garazaValue'] );
                multiRadioPrikaz ( "Osnovno posuđe", $podaci['osPosude'] ); 
                multiRadioPrikaz ( "Perilica rublja", $podaci['perilica'] );
                multiRadioPrikaz ( "Perilica suđa", $podaci['perilicaSuda'] ); 
                prikaziOrijentaciju ( $podaci['orijentacija'] ); 

                
                ?>
                
                </div>
                <hr class="ruler">
                
                <div class="opis">
                
                <?php
                
                //režija i životinje
                prikaziRezije ( $podaci['rezije'], $podaci['rezijeS'], $podaci['rezijeV'], $podaci['rezijeP'], $podaci['rezijeT'],$podaci['rezijeI'] ); 
                
                ?>

                    
                </div> 
            
        </div>
        
</div>
