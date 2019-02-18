<div id="main-content">
     
     <div class="contentPotvrda">
     
<div class="agencijskiHeader">
        
            <div class="agencijskiLogo">
                <img src="logomali.png">
            </div>
            
            <div class="agencijskiPodaci">
                Agencija za promet nekretninama<br />
                Horvaćanska 142, 10110 Zagreb<br />
                matični broj obrta: 92033849<br />

                
            </div>
</div>
            
        <div id="potvrdaopis">
        
            <div id="potvrdaDatum">
            
                <?php
                
                echo 'Zagreb, ',date("d.m.Y"); 
                
                ?>
                
            </div>
            
         <table width="600" cellpadding="0" cellspacing="0" border="0">
         <tr>
         <td width="350">
         NALOGODAVAC:</td>
         <td width="250">
         IZ:</td>
         </tr>
         <tr>
         <td width="350">
         ULICA:</td>
         <td width="250">
         TELEFON:</td>
         </tr>
         </table>  
            
                
        
        <h2>POTVRDA O RAZGLEDAVANJU NEKRETNINE  U SVEZI KUPOPRODAJE  BR.</h2> 
        
        <h4>Članak 1.</h4>
        <p>
Potpisom na ovoj potvrdi potvrđujem da me je Agencija PAPIRUS, iz Zagreba,Horvaćanska 142, dovela u neposrednu vezu s podacima i informacijama s dole opisanom nekretninom, te mi omogučila razgledavanje te iste nekretnine:</p>

        <div class="opis">Osnovni podaci:<br />
           
            <?php 
            
            $upit = "SELECT * FROM grupe WHERE id = '".$podaci['grupa']."'";
            $odgovori = mysql_query ( $upit );
            $nek = mysql_fetch_assoc ( $odgovori );
            
            echo $nek['parentGroup'],', ',$nek['groupName'],'<br />';
            
            dajZupaniju ( $podaci['zupanija'] ); 
            echo  ", ";
            dajGrad ( $podaci['grad'] ); 
            echo  ", "; 
            dajKvart ( $podaci['kvart'] );
            echo  "<br />",$podaci['mikrolokacija'],", ",$podaci['ukupnaPovrsina'],' m<sup>2</sup>, ',$podaci['cijena'],' &euro;';
            
            
            ?>
        
          </div>
          <p>Opis nekretnine:<br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], $tabela );
                
                ?>
                
                </p> 

    <h4>Članak 2.</h4>
    
<p>Također potpisom na ovoj potvrdi prihvaćam obvezu plaćanja provizije prema posredniku Agenciji Papirus u iznosu <?php

    $upit = "SELECT * FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."' AND jezik = 'hr'";
    $odgovori = mysql_query ( $upit );
    $podaci = mysql_fetch_assoc ( $odgovori );
    
    echo $podaci['tekst'];

?>  koji  koji ću platiti u trenutku potpisivanja Ugovora o najmu. </p>  

<h4>Članak 3</h4>
<p>U cijenu provizije uključena je izrada  Ugovora o najmu, a sve u skladu s Općim uvjetima poslovanja Agencija Papirus.
</p>


<h4>Članak 4.</h4>
<p>Jamčim za preuzete obveze iz ove potvrde, a u slučaju spora prihvaćam nadležnost stvarno nadležnog suda u Zagrebu.</p>


    </div>
    
    <div id="potvrdaPotpisi">
    
        <div id="potpisiLijevo">
        ___________________________<br /><br /><br /><br />
        ___________________________
        </div>
        
        <div id="potpisiDesno">
        __________________________
        </div>

            
        </div>
        
</div>
 
