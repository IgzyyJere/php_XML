<div id="main-content">
            
            <h3><b>
            <?php 
            
            
            $upit = "SELECT * FROM grupe WHERE id = '".$podaci['grupa']."'";
            $odgovori = mysql_query ( $upit );
            $nek = mysql_fetch_assoc ( $odgovori );
            
            $euro_m2 = ($podaci['cijena']/$podaci['ukupnaPovrsina']);
            $euro_m2 = number_format($euro_m2, 0, ',', '.');
            
            echo $nek['parentGroup'],'<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  " / ";
            dajGrad ( $podaci['grad'] ); 
            echo  " / "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija']," / ",$podaci['ukupnaPovrsina'],' m<sup>2</sup> / ',$podaci['cijena'],' &euro; (',$euro_m2,' / m<sup>2</sup>)';    
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
                formPrikaz ( "MIN cijena", $podaci['minCijena'],1 );
                formPrikaz ( "Pregledali", $podaci['pregledali'],1 );

                
                ?>
                
                </div>

                <div class="agencija"> 
                <?php
                
                //$podaci['']
                
                
                formPrikaz ( "Email", $podaci['email'],1 ); 
                formPrikaz ( "Mobitel", $podaci['mobitel'],1 );
                formPrikaz ( "Telefon", $podaci['povTelefon'],1 );
                
                echo $podaci['napomena']; 
                echo '<br />';
                formPrikaz ( "Kat. čestica", $podaci['katCes'],1 );
                formPrikaz ( "Kat. općina", $podaci['katOpcina'],1 );
                formPrikaz ( "zk. uložak", $podaci['zkUlozak'],1 );
                
                ?>
                
                </div>
                
                <hr class="ruler"> 
                <div class="stupac">
                
                <?php
                
                multiRadioPrikaz ( "Tip objekta",  $podaci['tipObjekt'],1 );
                formPrikaz ( "Površina okućnice", $podaci['okucnica'], 1 ); 
                formPrikaz ( "Broj soba",  $podaci['brojSoba'], 1 ); 
                multiRadioPrikaz ( "Broj etaža", $podaci['brojEtazaKuca'], 1 );
                formPrikaz ( "Broj kupaonica", $podaci['kupaone'], 1 );
                
                
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                  
                selectPrikaz ( "Grijanje", $podaci['grijanje'], 1 );
                prikaziOtplatu ( $podaci['otplataTotal'], $podaci['otplataRata'], $podaci['otplataVisina'], 1 );
                multiRadioPrikaz ( "Useljenje", $podaci['useljenje'], 1 );
                prikaziOrijentaciju ( $podaci['orijentacija'], 1 );
                radioPrikaz ( "Lift", $podaci['lift'], 1 );
                multiRadioPrikaz ( "Parking", $podaci['parking'], 1 );
                selectPrikaz ( "Prijevoz",  $podaci['prijevoz'], 1 );
                
                ?>
                
                </div> 
                <div class="stupac">
                
                <?php
                
                mixedPrikaz ( "Godina izgradnje", $podaci['godinaIzgradnjeOption'], $podaci['godinaIzgradnjeValue'], 1 );
                selectPrikaz ( "Stanje", $podaci['stanje'], 1 );
                formPrikaz ( "Zadnja adaptacija", $podaci['adaptacija'], 1 ); 
                multiRadioPrikaz ( "Vlasnički list", $podaci['vlasnickiList'], 1 );
                multiRadioPrikaz ( "Građevinska dozvola", $podaci['gradevinska'], 1 ); 
                multiRadioPrikaz ( "Lokacijska", $podaci['lokacijska'], 1 ); 
                multiRadioPrikaz ( "Uporabna dozvola",   $podaci['uporabna'], 2 );
                
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
                multiRadioPrikaz ( "Alarm", $podaci['alarm'] );
                selectPrikaz ( "Stolarija", $podaci['stolarija'] );
                radioPrikaz ( "Parket", $podaci['parket'] );
                radioPrikaz ( "Laminat", $podaci['laminat'] );
                multiRadioPrikaz ( "Klima", $podaci['klima'] );
                multiRadioPrikaz ( "Kabel", $podaci['kabel'] );
                multiRadioPrikaz ( "Satelit", $podaci['satelit'] );
                multiRadioPrikaz ( "Internet", $podaci['internet'] );
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
                radioPrikaz ( "Vrtna kućica",  $podaci['vrtnaKucica'] ); 

                
                ?>
                
                </div>

            
        </div>
        
</div>
