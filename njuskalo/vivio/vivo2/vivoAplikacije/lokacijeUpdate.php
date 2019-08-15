<div id="formLokacije">

<?php

$nazivPoljaRegije = "Država";
$nazivPoljaZupanija = "Županija";
$nazivPoljaGrad = "Grad";
$nazivPoljaKvart = "Kvart";
if ( isset ( $lokacijeNazivPoljaRegija )) { $nazivPoljaRegije = $lokacijeNazivPoljaRegija; }
if ( isset ( $lokacijeNazivPoljaZupanija )) { $nazivPoljaZupanija = $lokacijeNazivPoljaZupanija; }
if ( isset ( $lokacijeNazivPoljaGrad )) { $nazivPoljaGrad = $lokacijeNazivPoljaGrad; }
if ( isset ( $lokacijeNazivPoljaKvart )) { $nazivPoljaKvart = $lokacijeNazivPoljaKvart; }




$u = "SELECT * FROM regije ORDER BY id";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
    if ( !$i ) {

        $prvi = $p['id'];
        
    }
    
    $i++;
    
}   
    
selectUpdateArray ( $nazivPoljaRegije, "regija", $arr, $podaci['regija'] );
                
//JS sa zupanijom

echo '<div id="zupanijaSelect">';

$i = 0; 
$u = "SELECT * FROM zupanije WHERE idRegije = '".$podaci['regija']."' ORDER BY nazivZupanije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['nazivZupanije'];
    
    if ( !$i ) {
        
        $prvi = $p['id'];
        
    }
    
    $i++;
    
}

selectUpdateArray ( $nazivPoljaZupanija, "zupanija", $arr, $podaci['zupanija'] );

echo '</div>';
 
//                    

//JS sa gradom
echo '<div id="gradSelect">';

$i = 0;
$u = "SELECT * FROM gradovi WHERE zupanija ='".$podaci['zupanija']."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
    if ( !$i ) {
        
        $prvi = $p['id'];
        
    }
    
    $i++;

}


selectUpdateArray ( $nazivPoljaGrad, "grad", $arr, $podaci['grad'] );

echo '</div>';
//                                  
    
//JS sa kvartom
echo '<div id="kvartSelect">';

$u = "SELECT * FROM kvartovi WHERE grad ='".$podaci['grad']."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
}

selectUpdateArray ( $nazivPoljaKvart, "kvart", $arr, $podaci['kvart'] );

echo '</div>';
//                                  

formUpdate ( "Ulica", "mikrolokacija", $podaci['mikrolokacija'] );

?>


</div>