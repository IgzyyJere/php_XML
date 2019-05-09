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
        
        $prvi = 1;
        
    }
    
    $i++;
    
}   
    
selectUpdateArray ( $nazivPoljaRegije, "regija", $arr, 1 );

//JS sa zupanijom

echo '<div id="zupanijaSelect">';

$i = 0; 
$u = "SELECT * FROM zupanije WHERE idRegije = '".$prvi."' ORDER BY nazivZupanije";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['nazivZupanije'];
    
    if ( !$i ) {
        
        $prvi = 19;
        
    }
    
    $i++;

}

selectUpdateArray ( $nazivPoljaZupanija, "zupanija", $arr, $prvi );

echo '</div>';

//                    

//JS sa gradom
echo '<div id="gradSelect">';

$i = 0;
$u = "SELECT * FROM gradovi WHERE zupanija ='".$prvi."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
    if ( !$i ) {

        $prvi = 125;
        
    }
    
    $i++;
    
}

selectUpdateArray ( $nazivPoljaGrad, "grad", $arr, $prvi );

echo '</div>';
//                                  

//JS sa kvartom
echo '<div id="kvartSelect">';  

$u = "SELECT * FROM kvartovi WHERE grad ='".$prvi."' ORDER BY naziv";
$o = mysql_query ( $u );
$arr = array();
while ( $p = mysql_fetch_assoc ( $o )) {
    
    $key = $p['id'];
    $arr[$key] = $p['naziv'];
    
}

selectInsertArray ( $nazivPoljaKvart, "kvart", $arr );

echo '</div>';  
//                                  


formInsert ( "Ulica", "mikrolokacija");

?>

</div>