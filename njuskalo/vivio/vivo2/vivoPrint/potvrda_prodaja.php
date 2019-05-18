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
            
            if ( $tabela == "novoobjekti" ){ 
                
                dajZupaniju ( $podaci['zupanija'] ); 
                echo  ", ";
                dajGrad ( $podaci['grad'] ); 
                echo  ", "; 
                dajKvart ( $podaci['kvart'] );
                echo  "<br />",$podaci['mikrolokacija'];
                
            
            } else if ( $tabela == "novostanovi" OR $tabel == "novoposlovni" ){
                
                $upit = "SELECT * FROM novoobjekti WHERE id = '".$podaci['objektID']."'";
                $odgovori = mysql_query ( $upit );
                $objekt = mysql_fetch_assoc ( $odgovori );
                
                dajZupaniju ( $objekt['zupanija'] ); 
                echo  ", ";
                dajGrad ( $objekt['grad'] ); 
                echo  ", "; 
                dajKvart ( $objekt['kvart'] );
                echo  "<br />",$objekt['mikrolokacija'];
                
            } else {
            
                echo $nek['parentGroup'],', ',$nek['groupName'],'<br />';
                dajZupaniju ( $podaci['zupanija'] ); 
                echo  ", ";
                dajGrad ( $podaci['grad'] ); 
                echo  ", "; 
                dajKvart ( $podaci['kvart'] );
                echo  "<br />",$podaci['mikrolokacija'],", ",$podaci['ukupnaPovrsina'],' m<sup>2</sup>, ',$podaci['cijena'],' &euro;';
                
            }
            
            
            ?>
        
          </div>
          <p>Opis nekretnine:<br />  
                
                <?php
                
                prikaziOpis ( $podaci['id'], $tabela );
                
                ?>
                
                </p> 

    <h4>Članak 2.</h4>
    
<p>Ovom potvrdom prihvaćam i obvezujem se platiti proviziju u iznosu 2(dva) %, uvećano za PDV,  od kupovne cijene nekretnine, koju ću uplatiti, u skladu s dogovorom, odmah u trenutku potpisivanja  kupoprodajnog ugovora, predugovora ili drugog sličnog pravnog dokumenta.
Nagrada iz prethodnog stavka pripada posredniku Agenciji PAPIRUS i u slučaju kada nije izravno sudjelovala u pregovorima između nalogodavca i prodavatelja koje je dovela u vezu, a oni su izravno pregovarali i napokon sklopili ugovor.
Agencija ima pravo na proviziju ako bračni,odnosno izvanbračni drug,potomak ili roditelj nalogodavca zaključi poredovani pravni posao s osobom (prodavateljom) s kojom je Agencija nalogodavca dovela u vezu.</p>  

<h4>Članak 3</h4>
<p>U cijenu provizije uključena je izrada  Predugovora ili Kupoprodajnog ugovora, a sve u skladu s Općim uvjetima poslovanja Agencija Papirus.</p>


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
 
