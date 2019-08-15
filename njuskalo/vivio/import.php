<?php

ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);

header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="utf-8"?>';

session_start ();

include ( "../vivo2/vivoFunkcije/baza.php" );
mysql_query ("set names utf8");
include ( "../vivo2/vivoFunkcije/definicijePolja.php" );

//UČITAJ POSTAVKE IZ WEBKONTROLERA I POSTAVI VARIJABLE!!!!!!!!

//include ( "../includes/podesiVarijable.php" );
//include ( "../includes/funkcije.php" );


echo '<ad_list>';

//
//                                                                  
//
//           STANOVI PRODAJA                                        
//                                                                  
//
//                                                                  

$upit = "SELECT * FROM vivostanovi WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND ( grupa = 1 OR grupa = 11 OR grupa = 12 OR grupa = 13 ) ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_flats">
        <user_id>444900</user_id>
        <original_id>s-',$podaci['id'],'</original_id>
        <category_id>9580</category_id>',"\n";

//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Stan: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
			$p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }

//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/prodaja_stanovi.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi

    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivostanovi-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';

echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}

      
//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke
    
    $ar = explode ( ",", $podaci['slike'] );
    
    if ( $ar[0] ) {
    
    for ( $i = 0; $i < count ( $ar ); $i ++ ) {
        
        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );
        
        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";

        if ( $i == 9 ) {
        
            break;

        }  
        
    }

    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;

echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>'; 

     //županija 

     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );

     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 

     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );

     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 

     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );

     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>';

*/

//Lokacija na karti

if ( $podaci['lon'] AND $podaci['lat'] ) {
    

    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//vrsta stana ... njuskalo ima dvije, VIVO ima četri

switch ( $podaci['stanU'] ){
    case '1':
    $stan = "182";
    break;
    
    case "2":
    case "3":
    case "4":
    $stan = "183";
    break;
}

echo '<flat_type_id>',$stan,'</flat_type_id>',"\n";

//broj etaža

switch ( $podaci['brojEtaza'] ){
 
    case '1':
    $stan = "184";
    break;
    
    case "2":
    $stan = "185";
    break;
    
    case "3":
    $stan = "186";
    break;
    
}

echo '<floor_count_id>',$stan,'</floor_count_id>',"\n";

//broj soba, VIVO ima po grupama to riješeno

echo '<room_count_id>';

switch ( $podaci['grupa'] )
{ 
    case "1":
    $broj = "188";
    break;

    case "11":
    $broj = "189";
    break;
    
    case "12":
    $broj = "190";
    break;
    
    case "13":
    $broj = "191";
    break;   
}

    echo $broj;
    
echo '</room_count_id>',"\n";

//kat

echo '<flat_floor_id>';

    //prvo vidit jel tekstualno
    
    if ( $podaci['katOption'] ) {

        switch ( $podaci['katOption'] )
        {
        
            case "1":
            $broj = "193";
            break;
            
            case "2":
            $broj = "192";
            break;
            
            case "3":
            $broj = "194";
            break;
            
            case "4":
            $broj = "192";
            break;    
            
            case "5":
            $broj = "218";
            break;
            
        }
        
    } else if ( $podaci['katValue'] AND $podaci['katValue'] < 23 ) {
    
        $broj = $podaci['katValue'] + 194;
        
    } else {
    
        $broj = "0";
        
    }
    
    echo $broj;
    
echo '</flat_floor_id>',"\n";

//lift

if ( $podaci['lift'] ) {
    
    echo '<elevator>1</elevator>',"\n";
    
}

//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";

//vrt površina

if ( $podaci['vrtValue'] ) {
    
    echo '<garden_area>',$podaci['vrtValue'],'</garden_area>',"\n";
    
}

//balkon površina

if ( $podaci['balkonValue'] ) {
    
    echo '<balcony_area>',$podaci['balkonValue'],'</balcony_area>',"\n";
    
}

//terasa površina

if ( $podaci['terasaValue'] ) {
    
    echo '<terace_area>',$podaci['terasaValue'],'</terace_area>',"\n";
    
}
    

//godina izgradnje
    
if ( $podaci['godinaIzgradnjeValue'] ) {

    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";
    
}

//godina adaptacije
    
if ( $podaci['adaptacija'] ) {

    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";
    
}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {

    echo '<new_building>1</new_building>',"\n";
    
}

//grijanje

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {
    
        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "224";
        break;
    
        case "6":
        $broj = "226";
        break;
    
        case "7":
        case "8":
        $broj = "225";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//parking .... hmmm ... razlike su velike

echo '<parking_spot_count>';

    if ( $podaci['parking'] == 1 OR $podaci['parking'] == 2 OR $podaci['parking'] == 3 ) {

        echo $podaci['parking'];
        
    } 

echo '</parking_spot_count>',"\n";

//interna šifra oglasa

echo '<internal_item_code>stanovi - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin
    
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">223</lookup_item>',"\n";
        
    }
    
    //heating
    
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 

    if ( $podaci['grijanje'] == 5 ) {
     
     echo '<lookup_item code="heating">350</lookup_item>',"\n";

    }
    
    if ( $podaci['grijanje'] == 6) {

     echo '<lookup_item code="heating">227</lookup_item>',"\n";
        
    }

    //lož ulje
    /*
    if ( $podaci['grijanje'] == ) {

     echo '<lookup_item code="heating"></lookup_item>',"\n";
        
    }
    */
    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">229</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">230</lookup_item>',"\n";
        
    }
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">231</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">232</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">233</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">234</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">162</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */
    //garden

    if ( $podaci['bazen'] ) {

     echo '<lookup_item code="garden">164</lookup_item>',"\n";
        
    }

    //vrtna kućica
    /*
    if ( $podaci['vrtnaKucica'] ) {
     
     echo '<lookup_item code="garden"></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['rostilj'] ) {
     
     echo '<lookup_item code="garden">166</lookup_item>',"\n";
        
    }
    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">167</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {
     
     echo '<lookup_item code="electronics">168</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {

     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";

    }
    */
    if ( $podaci['alarm'] ) {

     echo '<lookup_item code="electronics">171</lookup_item>',"\n";
        
    }
    //portafon
    /*
    if ( $podaci['portafon'] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
echo '</lookup_list>',"\n";
    
// KRAJ LOOPa

echo '</ad_item>',"\n";

}



//
//
//
//                   STANOVI NAJAM
//                                                                                 
//
//





$upit = "SELECT * FROM vivostanovi WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND ( grupa = 2 OR grupa = 15 OR grupa = 16 OR grupa = 17 ) ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_flats_lease">
        <user_id>444900</user_id>
        <original_id>s-',$podaci['id'],'</original_id>
        <category_id>10920</category_id>',"\n";
        
//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Stan: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/najam_stanovi.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi
    
    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivostanovi-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';
    
echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}
      
      
//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke
    
    $ar = explode ( ",", $podaci['slike'] );
    
    if ( $ar[0] ) {
    
    for ( $i = 0; $i < count ( $ar ); $i ++ ) {
        
        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );
        
        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";
        
        if ( $i == 9 ) {
        
            break;
            
        }  
        
    }
    
    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;
    
echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>'; 

     //županija 
     
     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );
     
     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 
     
     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );
     
     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 
     
     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );
     
     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>'; 

*/

//Lokacija na karti 

if ( $podaci['lon'] AND $podaci['lat'] ) {
    

    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//vrsta stana ... njuskalo ima dvije, VIVO ima četri

switch ( $podaci['stanU'] ){
 
    case '1':
    $stan = "182";
    break;
    
    case "2":
    case "3":
    case "4":
    $stan = "183";
    break;
    
}

echo '<flat_type_id>',$stan,'</flat_type_id>',"\n";

//broj etaža

switch ( $podaci['brojEtaza'] ){
 
    case '1':
    $stan = "184";
    break;
    
    case "2":
    $stan = "185";
    break;
    
    case "3":
    $stan = "186";
    break;
    
}

echo '<floor_count_id>',$stan,'</floor_count_id>',"\n";

//broj soba, VIVO ima po grupama to riješeno

echo '<room_count_id>';

switch ( $podaci['grupa'] ) 
{
    
    case "2":
    $broj = "188";
    break;

    case "15":
    $broj = "189";
    break;
    
    case "16":
    $broj = "190";
    break;
    
    case "17":
    $broj = "191";
    break;
    
}

    echo $broj;
    
echo '</room_count_id>',"\n";

//kat

echo '<flat_floor_id>';

    //prvo vidit jel tekstualno
    
    if ( $podaci['katOption'] ) {
        
        switch ( $podaci['katOption'] )
        {
        
            case "1":
            $broj = "193";
            break;
            
            case "2":
            $broj = "192";
            break;
            
            case "3":
            $broj = "194";
            break;
            
            case "4":
            $broj = "192";
            break;    
            
            case "5":
            $broj = "218";
            break;
            
        }
        
    } else if ( $podaci['katValue'] AND $podaci['katValue'] < 23 ) {
    
        $broj = $podaci['katValue'] + 194;
        
    } else {
    
        $broj = "0";
        
    }
    
    echo $broj;
    
echo '</flat_floor_id>',"\n";

//lift 

if ( $podaci['lift'] ) {
    
    echo '<elevator>1</elevator>',"\n";
    
}

//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";

//vrt površina

if ( $podaci['vrtValue'] ) {
    
    echo '<garden_area>',$podaci['vrtValue'],'</garden_area>',"\n";
    
}

//balkon površina

if ( $podaci['balkonValue'] ) {
    
    echo '<balcony_area>',$podaci['balkonValue'],'</balcony_area>',"\n";
    
}

//terasa površina

if ( $podaci['terasaValue'] ) {
    
    echo '<terace_area>',$podaci['terasaValue'],'</terace_area>',"\n";
    
}
    
    
//godina izgradnje
    
if ( $podaci['godinaIzgradnjeValue'] ) {
    
    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";
    
}

//godina adaptacije
    
if ( $podaci['adaptacija'] ) {
    
    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";
    
}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {
 
    echo '<new_building>1</new_building>',"\n";
    
}

//grijanje

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {
    
        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "224";
        break;
    
        case "6":
        $broj = "226";
        break;
    
        case "7":
        case "8":
        $broj = "225";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//parking .... hmmm ... razlike su velike

echo '<parking_spot_count>';

    if ( $podaci['parking'] == 1 OR $podaci['parking'] == 2 OR $podaci['parking'] == 3 ) {
    
        echo $podaci['parking'];
        
    } 

echo '</parking_spot_count>',"\n";

//OVDI IDU RAZLIKE PREMA PRODAI!!!


//dostupno od
//režije
//ulaz
//namještenost

echo '<furnish_level_id>';

    switch ( $podaci['oprema'] )
    {
    
        case "1":
        $broj = "357";
        break;
    
        case "2":
        $broj = "356";
        break;
    
        case "3":
        case "4":
        $broj = "355";
        break;
    
    }

    echo $broj;

echo '</furnish_level_id>',"\n";

//provizija
//orijentacija


//blizina busa

if ( $podaci['prijevoz'] == "2" ){
    
    echo '<bus_proximity>1</bus_proximity>';
    
}

//blizina tramvaja

if ( $podaci['prijevoz'] == "1" ){
    
    echo '<tram_proximity>1</tram_proximity>';
    
}



//interna šifra oglasa

echo '<internal_item_code>stan - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin
    
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">223</lookup_item>',"\n";
        
    }
    
    //heating
    
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 
    
    if ( $podaci['grijanje'] == 5 ) {
     
     echo '<lookup_item code="heating">350</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 6) {
     
     echo '<lookup_item code="heating">227</lookup_item>',"\n";
        
    }
    
    //lož ulje
    /*
    if ( $podaci['grijanje'] == ) {
     
     echo '<lookup_item code="heating"></lookup_item>',"\n";
        
    }
    */
    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">229</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">230</lookup_item>',"\n";
        
    }
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">231</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">232</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">233</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">234</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">162</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */
    //garden

    if ( $podaci['bazen'] ) {
     
     echo '<lookup_item code="garden">164</lookup_item>',"\n";
        
    }
    
    //vrtna kućica
    /*
    if ( $podaci['vrtnaKucica'] ) {
     
     echo '<lookup_item code="garden"></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['rostilj'] ) {
     
     echo '<lookup_item code="garden">166</lookup_item>',"\n";
        
    }
    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">167</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {
     
     echo '<lookup_item code="electronics">168</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['alarm'] ) {
     
     echo '<lookup_item code="electronics">171</lookup_item>',"\n";
        
    }
    //portafon
    /*
    if ( $podaci['portafon'] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
echo '</lookup_list>',"\n";
    
// KRAJ LOOPa

echo '</ad_item>',"\n";

}

//                                                                                 
//                                                                                 
//                                                                                 
//                   POSLOVNI PRODAJA                                              
//                                                                                 
//                                                                                 
//                                                                                 






$upit = "SELECT * FROM vivoposlovni WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND ( grupa = 5 OR grupa = 18 ) ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_business_space">
        <user_id>444900</user_id>
        <original_id>pp-',$podaci['id'],'</original_id>
        <category_id>9585</category_id>',"\n";
        
//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Poslovni prostor: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/prodaja_poslovni.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi
    
    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivoposlovni-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';
    
echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";
      

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}

//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke
    
    $ar = explode ( ",", $podaci['slike'] );
    
    if ( $ar[0] ) {
    
    for ( $i = 0; $i < count ( $ar ); $i ++ ) {
        
        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );
        
        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";
        
        if ( $i == 9 ) {
        
            break;
            
        }  
        
    }
    
    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;
    
echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>'; 

     //županija 
     
     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );
     
     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 
     
     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );
     
     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 
     
     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );
     
     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>'; 

*/

//Lokacija na karti 

if ( $podaci['lon'] AND $podaci['lat'] ) {
    

    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//                            
// VAŽNO !!!!!!!!!!!!         
//                            
//privremeno rješenje - treba dodat u VIVO, sad je svima isto        
//                                                                   
echo '<position_id>277</position_id>';
//                                                                   
//                                                                   



//vrsta poslovnog prostora

    $vrati = array ( 0 => "-", 1 => "ured", 2 => "ulični lokal", 3 => "trgovina", 4 => "kafić", 5 => "tihi obrt", 6 => "proizvodnja", 7 => "mini hotel", 8 => "skladište", 9 => "restoran", 10 => "club", 11 => "hala", 12 => "kozmetički salon" ); 

switch ( $podaci['vrstaPP'] ){
 
    case '1':
    $stan = "272";
    break;
    
    case '2':
    $stan = "273";
    break;
    
    case '3':
    $stan = "270";
    break;
    
    case '4':
    $stan = "274";
    break;
    
    case '5':
    $stan = "271";
    break;
    
    case '6':
    $stan = "275";
    break;
    
    case '7':
    $stan = "274";
    break;
    
    case '8':
    $stan = "275";
    break;
    
    case '9':
    $stan = "274";
    break;
    
    case '10':
    $stan = "274";
    break;
    
    case '11':
    $stan = "275";
    break;
    
    case '12':
    $stan = "271";
    break;

}

echo '<space_usage_id>',$stan,'</space_usage_id>',"\n";

//position id - ovo nemam - ulični lokal, u zgradi, u kući, u dvorištu


//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";


//broj prostorija, njuskalo to zove broj soba

echo '<room_count>',$podaci['brojProstorija'],'</room_count>',"\n";

//kat

echo '<position_floor_id>';

    //prvo vidit jel tekstualno
    
    if ( $podaci['katOption'] ) {
        
        switch ( $podaci['katOption'] )
        {
        
            case "1":
            $broj = "280";
            break;
            
            case "2":
            $broj = "281";
            break;
            
            case "3":
            $broj = "282";
            break;
            
            case "4":
            $broj = "281";
            break;    
            
            case "5":
            $broj = "218";
            break;
            
        }
        
    } else if ( $podaci['katValue'] AND $podaci['katValue'] < 18 ) {
    
        $broj = $podaci['katValue'] + 282;
        
    } else {
    
        $broj = "0";
        
    }
    
    echo $broj;
    
echo '</position_floor_id>',"\n";

//lift 

if ( $podaci['lift'] ) {
    
    echo '<elevator>1</elevator>',"\n";
    
}



    
    
//godina izgradnje
    
if ( $podaci['godinaIzgradnjeValue'] ) {
    
    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";
    
}

//godina adaptacije
    
if ( $podaci['adaptacija'] ) {
    
    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";
    
}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {
 
    echo '<new_building>1</new_building>',"\n";
    
}

//grijanje

    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {
    
        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "305";
        break;
    
        case "6":
        $broj = "307";
        break;
        
        case "4":
        $broj = "308";
        break;
    
        case "7":
        case "8":
        $broj = "306";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//interna šifra oglasa

echo '<internal_item_code>poslovni - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin
    
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">304</lookup_item>',"\n";
        
    }
    
    //heating
    /*
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 
    
    if ( $podaci['grijanje'] == 5 ) {
     
     echo '<lookup_item code="heating">350</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 6) {
     
     echo '<lookup_item code="heating">227</lookup_item>',"\n";
        
    }
    
    
    
    //lož ulje

    if ( $podaci['grijanje'] == ) {
     
     echo '<lookup_item code="heating"></lookup_item>',"\n";
        
    }

    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">229</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">230</lookup_item>',"\n";
        
    }
    
       */
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">310</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">312</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">311</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">313</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">316</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */

    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">320</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {
     
     echo '<lookup_item code="electronics">321</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
    
    //alarm
    
    if ( $podaci['alarm'] ) {
     
     echo '<lookup_item code="electronics">324</lookup_item>',"\n";
        
    }
    
    
    
    //portafon
    /*
    if ( $podaci['portafon'] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
echo '</lookup_list>',"\n";
    
// KRAJ LOOPa

echo '</ad_item>',"\n";

}


//                                                                                 
//                                                                                 
//                                                                                 
//                   POSLOVNI NAJAM                                                
//                                                                                 
//                                                                                 
//                                                                                 




$upit = "SELECT * FROM vivoposlovni WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND ( grupa = 6 OR grupa = 19 ) ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_business_space_lease">
        <user_id>444900</user_id>
        <original_id>pp-',$podaci['id'],'</original_id>
        <category_id>9839</category_id>',"\n";
        
//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Poslovni prostor: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/najam_poslovni.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi
    
    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivoposlovni-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';
    
echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}
      
//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke
    
    $ar = explode ( ",", $podaci['slike'] );
    
    if ( $ar[0] ) {
    
    for ( $i = 0; $i < count ( $ar ); $i ++ ) {
        
        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );
        
        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";
        
        if ( $i == 9 ) {
        
            break;
            
        }  
        
    }
    
    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;
    
echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>'; 

     //županija 
     
     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );
     
     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 
     
     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );
     
     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 
     
     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );
     
     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>'; 

*/

//Lokacija na karti 

if ( $podaci['lon'] AND $podaci['lat'] ) {


    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//                            
// VAŽNO !!!!!!!!!!!!         
//                            
//privremeno rješenje - treba dodat u VIVO, sad je svima isto        
//                                                                   
echo '<position_id>277</position_id>';
//                                                                   
//                                                                   

//vrsta poslovnog prostora

//$vrati = array ( 0 => "-", 1 => "ured", 2 => "ulični lokal", 3 => "trgovina", 4 => "kafić", 5 => "tihi obrt", 6 => "proizvodnja", 7 => "mini hotel", 8 => "skladište", 9 => "restoran", 10 => "club", 11 => "hala", 12 => "kozmetički salon" ); 

switch ( $podaci['vrstaPP'] ){
 
    case '1':
    $stan = "272";
    break;
    
    case '2':
    $stan = "273";
    break;
    
    case '3':
    $stan = "270";
    break;

    case '4':
    $stan = "274";
    break;
    
    case '5':
    $stan = "271";
    break;
    
    case '6':
    $stan = "275";
    break;
    
    case '7':
    $stan = "274";
    break;
    
    case '8':
    $stan = "275";
    break;
    
    case '9':
    $stan = "274";
    break;
    
    case '10':
    $stan = "274";
    break;
    
    case '11':
    $stan = "275";
    break;
    
    case '12':
    $stan = "271";
    break;

}

echo '<space_usage_id>',$stan,'</space_usage_id>',"\n";

//position id - ovo nemam - ulični lokal, u zgradi, u kući, u dvorištu


//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";


//broj prostorija, njuskalo to zove broj soba

echo '<room_count>',$podaci['brojProstorija'],'</room_count>',"\n";

//kat

echo '<position_floor_id>';

    //prvo vidit jel tekstualno
    
    if ( $podaci['katOption'] ) {
        
        switch ( $podaci['katOption'] )
        {
        
            case "1":
            $broj = "280";
            break;
            
            case "2":
            $broj = "281";
            break;
            
            case "3":
            $broj = "282";
            break;
            
            case "4":
            $broj = "281";
            break;    
            
            case "5":
            $broj = "218";
            break;
            
        }
        
    } else if ( $podaci['katValue'] AND $podaci['katValue'] < 18 ) {
    
        $broj = $podaci['katValue'] + 282;
        
    } else {
    
        $broj = "0";
        
    }
    
    echo $broj;
    
echo '</position_floor_id>',"\n";

//lift 

if ( $podaci['lift'] ) {
    
    echo '<elevator>1</elevator>',"\n";
    
}



    
    
//godina izgradnje
    
if ( $podaci['godinaIzgradnjeValue'] ) {
    
    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";
    
}

//godina adaptacije
    
if ( $podaci['adaptacija'] ) {
    
    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";
    
}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {
 
    echo '<new_building>1</new_building>',"\n";
    
}

//grijanje

    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {
    
        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "305";
        break;
    
        case "6":
        $broj = "307";
        break;
        
        case "4":
        $broj = "308";
        break;
    
        case "7":
        case "8":
        $broj = "306";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//poslovni prostor u (ppU)
    
echo '<building_type_id>';

    switch ( $podaci['ppU'] ) {
    
        case "1":
        $broj = "364";
        break;
    
        case "2":
        $broj = "362";
        break;
    
        case "3":
        case "4":
        $broj = "363";
        break;
    
    }

    echo $broj;

echo '</building_type_id>',"\n";

//interna šifra oglasa

echo '<internal_item_code>poslovni - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin
    
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">304</lookup_item>',"\n";
        
    }
    
    //heating
    /*
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 
    
    if ( $podaci['grijanje'] == 5 ) {
     
     echo '<lookup_item code="heating">350</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 6) {
     
     echo '<lookup_item code="heating">227</lookup_item>',"\n";
        
    }
    
    
    
    //lož ulje

    if ( $podaci['grijanje'] == ) {
     
     echo '<lookup_item code="heating"></lookup_item>',"\n";
        
    }

    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">229</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">230</lookup_item>',"\n";
        
    }
    
       */
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">310</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">312</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">311</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">313</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">316</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */

    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">320</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {
     
     echo '<lookup_item code="electronics">321</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
    
    //alarm
    
    if ( $podaci['alarm'] ) {
     
     echo '<lookup_item code="electronics">324</lookup_item>',"\n";
        
    }
    
    //protuprovalna vrata
    
    if ( $podaci['protuprovala'] ) {
     
     echo '<lookup_item code="electronics">365</lookup_item>',"\n";
        
    }
    
    //čajna kuhinja
    
        
    if ( $podaci['cajnaKuhinja'] ) {

     echo '<lookup_item code="electronics">367</lookup_item>',"\n";
        
    }
    

    //portafon
    /*
    if ( $podaci['portafon'] ) {

     echo '<lookup_item code="electronics"></lookup_item>',"\n";

    }
    */
echo '</lookup_list>',"\n";

// KRAJ LOOPa

echo '</ad_item>',"\n";

}





//
//
//
//                   KUĆE PRODAJA
//                                                                                 
//
//                                                                                 


$upit = "SELECT * FROM vivokuce WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND grupa = 3 ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_house">
        <user_id>444900</user_id>
        <original_id>k-',$podaci['id'],'</original_id>
        <category_id>9579</category_id>',"\n";
        
//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Kuća: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/prodaja_kuce.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi
    
    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivokuce-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';
    
echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";


//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}

//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke

    $ar = explode ( ",", $podaci['slike'] );

    if ( $ar[0] ) {

    for ( $i = 0; $i < count ( $ar ); $i ++ ) {

        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );

        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";

        if ( $i == 9 ) {

            break;

        }  

    }

    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;
    
echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>';

     //županija
     
     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );

     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 

     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );

     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 

     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );

     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>';

*/

//Lokacija na karti

if ( $podaci['lon'] AND $podaci['lat'] ) {
    

    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//vrsta stana ... njuskalo ima dvije, VIVO ima četri
 

switch ( $podaci['tipObjekt'] ){

    case '1':
    $stan = "351";
    break;

    case '2':
    $stan = "174";
    break;

    case '3':
    $stan = "176";
    break;

    case '4':
    $stan = "175";
    break;

    case '5':
    case '6':
    $stan = "174";
    break;
    

}

echo '<house_type_id>',$stan,'</house_type_id>',"\n";

//broj etaža


switch ( $podaci['brojEtazaKuca'] ){
 
    case '1':
    $etaza = "177";
    break;
    
    case "2":
    $etaza = "178";
    break;
    
    case "3":
    $etaza = "179";
    break;
    
    case "4":
    $etaza = "180";
    break;
    
    case "3":
    $etaza = "181";
    break;
    
}

echo '<floor_count_id>',$etaza,'</floor_count_id>',"\n";

//broj soba, VIVO ima po grupama to riješeno

echo '<room_count>',$podaci['brojSoba'],'</room_count>',"\n";



//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";


//površina okućnice

echo '<other_area>',$podaci['okucnica'],'</other_area>',"\n";



//godina izgradnje

if ( $podaci['godinaIzgradnjeValue'] ) {

    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";

}

//godina adaptacije

if ( $podaci['adaptacija'] ) {

    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";

}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {

    echo '<new_building>1</new_building>',"\n";

}

//grijanje

    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" );

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {

        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "155";
        break;
    
        case "6":
        $broj = "158";
        break;
    
        case "7":
        case "8":
        $broj = "156";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//parking .... hmmm ... razlike su velike

echo '<parking_spot_count>';

    if ( $podaci['parking'] == 1 OR $podaci['parking'] == 2 OR $podaci['parking'] == 3 ) {
    
        echo $podaci['parking'];
        
    } 

echo '</parking_spot_count>',"\n";

//OVDI IDU RAZLIKE PREMA PRODAI!!!


//dostupno od
//režije
//ulaz
//namještenost

echo '<furnish_level_id>';

    switch ( $podaci['oprema'] )
    {

        case "1":
        $broj = "357";
        break;
    
        case "2":
        $broj = "356";
        break;
    
        case "3":
        case "4":
        $broj = "355";
        break;
    
    }

    echo $broj;

echo '</furnish_level_id>',"\n";

//provizija
//orijentacija


//blizina busa

if ( $podaci['prijevoz'] == "2" ){

    echo '<bus_proximity>1</bus_proximity>';
    
}

//blizina tramvaja

if ( $podaci['prijevoz'] == "1" ){
    
    echo '<tram_proximity>1</tram_proximity>';
    
}



//interna šifra oglasa

echo '<internal_item_code>kuće - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin

    /*
    if ( $podaci[''] ) {

     echo '<lookup_item code=""></lookup_item>',"\n";

    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">150</lookup_item>',"\n";
        
    }
    
    //heating
    
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" );
    
    if ( $podaci['grijanje'] == 5 ) {

     echo '<lookup_item code="heating">153</lookup_item>',"\n";
        
    }


    
    //lož ulje
    /*
    if ( $podaci['grijanje'] == ) {
     
     echo '<lookup_item code="heating"></lookup_item>',"\n";

    }
    */
    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">151</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 2 ) {
     
     echo '<lookup_item code="heating">152</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">152</lookup_item>',"\n";
        
    }
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">154</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">161</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">159</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">160</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">162</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */
    //garden

    if ( $podaci['bazen'] ) {
     
     echo '<lookup_item code="garden">164</lookup_item>',"\n";
        
    }
    
    //vrtna kućica

    if ( $podaci['vrtnaKucica'] ) {
     
     echo '<lookup_item code="garden">165</lookup_item>',"\n";
        
    }

    if ( $podaci['rostilj'] ) {
     
     echo '<lookup_item code="garden">166</lookup_item>',"\n";
        
    }
    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">167</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {

     echo '<lookup_item code="electronics">168</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {

     echo '<lookup_item code="electronics"></lookup_item>',"\n";

    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['alarm'] ) {
     
     echo '<lookup_item code="electronics">171</lookup_item>',"\n";
        
    }
    //portafon
    /*
    if ( $podaci['portafon'] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
echo '</lookup_list>',"\n";
    
// KRAJ LOOPa

echo '</ad_item>',"\n";

}






//                                                                                 
//                                                                                 
//                                                                                 
//                   KUĆE NAJAM                                                    
//                                                                                 
//                                                                                 
//                                                                                 



$upit = "SELECT * FROM vivokuce WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND grupa = 4 ORDER BY id";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_house_lease">
        <user_id>444900</user_id>
        <original_id>k-',$podaci['id'],'</original_id>
        <category_id>10919</category_id>',"\n";
        
//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Kuća: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/najam_kuce.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi
    
    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivokuce-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);
    
    echo '<![CDATA[',$tekst,']]>';
    
echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";
      

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}

//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke
    
    $ar = explode ( ",", $podaci['slike'] );
    
    if ( $ar[0] ) {
    
    for ( $i = 0; $i < count ( $ar ); $i ++ ) {
        
        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";        
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );
        
        
        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";
        
        if ( $i == 9 ) {
        
            break;
            
        }  
        
    }
    
    }
    
echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona
    
    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );
    
    echo $mobitel;
    
echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>'; 

     //županija 
     
     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );
     
     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>'; 

     //grad 
     
     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );
     
     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>'; 

     //kvart (naselje) 
     
     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );
     
     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";

//kućni broj nije predviđen u VIVO sustavu
/*

echo '<street_number></street_number>'; 

*/

//Lokacija na karti 

if ( $podaci['lon'] AND $podaci['lat'] ) {
    

    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";
    
}

//vrsta stana ... njuskalo ima dvije, VIVO ima četri
 

switch ( $podaci['tipObjekt'] ){
 
    case '1':
    $stan = "351";
    break;
    
    case '2':
    $stan = "174";
    break;
    
    case '3':
    $stan = "176";
    break;
    
    case '4':
    $stan = "175";
    break;
    
    case '5':
    case '6':
    $stan = "174";
    break;
    
    
}

echo '<house_type_id>',$stan,'</house_type_id>',"\n";

//broj etaža


switch ( $podaci['brojEtazaKuca'] ){
 
    case '1':
    $etaza = "177";
    break;
    
    case "2":
    $etaza = "178";
    break;
    
    case "3":
    $etaza = "179";
    break;
    
    case "4":
    $etaza = "180";
    break;
    
    case "3":
    $etaza = "181";
    break;
    
}

echo '<floor_count_id>',$etaza,'</floor_count_id>',"\n";

//broj soba, VIVO ima po grupama to riješeno

echo '<room_count>',$podaci['brojSoba'],'</room_count>',"\n";



//površina

echo '<main_area>',$podaci['ukupnaPovrsina'],'</main_area>',"\n";


//površina okućnice

echo '<other_area>',$podaci['okucnica'],'</other_area>',"\n";


    
//godina izgradnje
    
if ( $podaci['godinaIzgradnjeValue'] ) {
    
    echo '<year_built>',$podaci['godinaIzgradnjeValue'],'</year_built>',"\n";
    
}

//godina adaptacije
    
if ( $podaci['adaptacija'] ) {
    
    echo '<year_last_rebuild>',$podaci['adaptacija'],'</year_last_rebuild>',"\n";
    
}

//novogradnja

if ( $podaci['godinaIzgradnjeOption'] == 2 ) {
 
    echo '<new_building>1</new_building>',"\n";
    
}

//grijanje

    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 

echo '<heating_type_id>';

    switch ( $podaci['grijanje'] )
    {
    
        case "1":
        case "2":
        case "3":
        case "5":
        $broj = "155";
        break;
    
        case "6":
        $broj = "158";
        break;
    
        case "7":
        case "8":
        $broj = "156";
        break;
    
    }

    echo $broj;

echo '</heating_type_id>',"\n";


//parking .... hmmm ... razlike su velike

echo '<parking_spot_count>';

    if ( $podaci['parking'] == 1 OR $podaci['parking'] == 2 OR $podaci['parking'] == 3 ) {
    
        echo $podaci['parking'];
        
    } 

echo '</parking_spot_count>',"\n";

//OVDI IDU RAZLIKE PREMA PRODAI!!!


//dostupno od
//režije
//ulaz
//namještenost

echo '<furnish_level_id>';

    switch ( $podaci['oprema'] )
    {
    
        case "1":
        $broj = "357";
        break;
    
        case "2":
        $broj = "356";
        break;
    
        case "3":
        case "4":
        $broj = "355";
        break;
    
    }

    echo $broj;

echo '</furnish_level_id>',"\n";

//provizija
//orijentacija


//blizina busa

if ( $podaci['prijevoz'] == "2" ){
    
    echo '<bus_proximity>1</bus_proximity>';
    
}

//blizina tramvaja

if ( $podaci['prijevoz'] == "1" ){
    
    echo '<tram_proximity>1</tram_proximity>';
    
}



//interna šifra oglasa

echo '<internal_item_code>kuće - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //plin
    
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //vodovod
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    //kanalizacija
    if ( $podaci[''] ) {
     
     echo '<lookup_item code=""></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['telefon'] ) {
     
     echo '<lookup_item code="installations">150</lookup_item>',"\n";
        
    }
    
    //heating
    
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju", 8 => "Grijanje na struju" ); 
    
    if ( $podaci['grijanje'] == 5 ) {
     
     echo '<lookup_item code="heating">153</lookup_item>',"\n";
        
    }
    

    
    //lož ulje
    /*
    if ( $podaci['grijanje'] == ) {
     
     echo '<lookup_item code="heating"></lookup_item>',"\n";
        
    }
    */
    
    if ( $podaci['grijanje'] == 1 ) {
     
     echo '<lookup_item code="heating">151</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 2 ) {
     
     echo '<lookup_item code="heating">152</lookup_item>',"\n";
        
    }
    
    if ( $podaci['grijanje'] == 3 ) {
     
     echo '<lookup_item code="heating">152</lookup_item>',"\n";
        
    }
    
    if ( $podaci['klima'] ) {
     
     echo '<lookup_item code="heating">154</lookup_item>',"\n";
        
    }

    //permits
    
    if ( $podaci['vlasnickList'] ) {
     
     echo '<lookup_item code="permits">161</lookup_item>',"\n";
        
    }
    
    if ( $podaci['gradevinska'] ) {
     
     echo '<lookup_item code="permits">159</lookup_item>',"\n";
        
    }
    
    if ( $podaci['uporabna'] ) {
     
     echo '<lookup_item code="permits">160</lookup_item>',"\n";
        
    }

    //parking

    if ( $podaci['garaza'] ) {
     
     echo '<lookup_item code="parking">162</lookup_item>',"\n";
        
    }
    
    //natkriveno parkirno mjesto
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="parking"></lookup_item>',"\n";
        
    }
    */
    //garden

    if ( $podaci['bazen'] ) {
     
     echo '<lookup_item code="garden">164</lookup_item>',"\n";
        
    }
    
    //vrtna kućica

    if ( $podaci['vrtnaKucica'] ) {
     
     echo '<lookup_item code="garden">165</lookup_item>',"\n";
        
    }

    if ( $podaci['rostilj'] ) {
     
     echo '<lookup_item code="garden">166</lookup_item>',"\n";
        
    }
    
    //electronics

    if ( $podaci['kabel'] ) {
     
     echo '<lookup_item code="electronics">167</lookup_item>',"\n";
        
    }
    
    if ( $podaci['satelit'] ) {
     
     echo '<lookup_item code="electronics">168</lookup_item>',"\n";
        
    }
    //ISDN
    /*
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    //ADSL
    if ( $podaci[''] ) {
     
     echo '<lookup_item code="electronics"></lookup_item>',"\n";
        
    }
    */
    if ( $podaci['alarm'] ) {

     echo '<lookup_item code="electronics">171</lookup_item>',"\n";
        
    }
    //portafon
    /*
    if ( $podaci['portafon'] ) {

     echo '<lookup_item code="electronics"></lookup_item>',"\n";

    }
    */
echo '</lookup_list>',"\n";

// KRAJ LOOPa

echo '</ad_item>',"\n";

}



//                                      /
//                                      /
//                                      /
//           ZEMLJIŠTA PRODAJA          /
//                                      /
//                                      /
//                                      /

$upit = "SELECT * FROM vivozemljista WHERE aktivno = 1 AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) AND grupa = 7 ORDER BY id DESC";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {



//napravi XML


//početak pojedinog oglasa

echo '<ad_item class="ad_land">
        <user_id>444900</user_id>
        <original_id>s-',$podaci['id'],'</original_id>
        <category_id>9581</category_id>',"\n";

//napravi naslov oglasa (lokacija, površina)

if ( $podaci['naslovoglasa'] )  {
            echo '<title>',$podaci['naslovoglasa'],'</title>';
        } else {
            echo '<title>Zemljište: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }


//link na stranicu

echo '<external_url>http://www.nekretnine-tomislav.hr/prodaja_stanovi.php?id=',$podaci['id'],'</external_url>',"\n";

//opis stana na hrvatskom

echo '<description_raw>';

    //povuci podatke iz tabele tekstovi

    $u = "SELECT tekst FROM tekstovi WHERE jezik = 'hr' AND spojenoNa = 'vivozemljista-".$podaci['id']."'";
    $o = mysql_query ( $u );
    $tekst = mysql_result ( $o, 0 );
	$tekst = str_replace('&nbsp;', ' ', $tekst);

    echo '<![CDATA[',$tekst,']]>';

echo '</description_raw>',"\n";

//cijena i valuta (2 za Euro)

echo '<price>',$podaci['cijena'],'</price>
      <currency_id>2</currency_id>',"\n";

//provizija

if ( $podaci['provizije'] ) {

echo '<provision>';

    //pitaj koja provizija

    $u = "SELECT tekst FROM provizijeTekst WHERE idProvizije = '".$podaci['provizije']."'";
    $o = mysql_query ( $u );

    echo substr ( mysql_result( $o, 0 ), 0, 20 );

echo '</provision>';

}


//popis slika

echo '<image_list>',"\n";

    //izvadi podatke koje slike i kako se zovu datoteke

    $ar = explode ( ",", $podaci['slike'] );

    if ( $ar[0] ) {

    for ( $i = 0; $i < count ( $ar ); $i ++ ) {

        $u = "SELECT * FROM slike WHERE id = '".$ar[$i]."'";
        $o = mysql_query ( $u );
        $jednaSlika = mysql_fetch_assoc ( $o );


        echo '<image>http://www.nekretnine-tomislav.hr/slike/',$jednaSlika['datoteka'],'</image>',"\n";

        if ( $i == 9 ) {

            break;

        }

    }

    }

echo '</image_list>',"\n";

//broj telefona vezan uz nekretninu (može se izvuć broj agenta)

echo '<additional_contact>';

    //provjeri koji je agent i saznaj njegov broj telefona

    $u = "SELECT mobitel FROM korisnici WHERE id = '".$podaci['agent']."'";
    $o = mysql_query ( $u );
    $mobitel = mysql_result ( $o, 0 );

    echo $mobitel;

echo '</additional_contact>',"\n";

//određivanje lokacija

echo '<level_0_location_id>';

     //županija

     $u = "SELECT njuskaloId FROM zupanije WHERE id = '".$podaci['zupanija']."'";
     $o = mysql_query ( $u );
     $zupanija = mysql_result ( $o, 0 );

     echo $zupanija;

echo '</level_0_location_id>',"\n";

echo '<level_1_location_id>';

     //grad

     $u = "SELECT njuskaloId FROM gradovi  WHERE id = '".$podaci['grad']."'";
     $o = mysql_query ( $u );
     $grad = mysql_result ( $o, 0 );

     echo $grad;

echo '</level_1_location_id>',"\n";

echo '<level_2_location_id>';

     //kvart (naselje)

     $u = "SELECT njuskaloId FROM kvartovi WHERE id = '".$podaci['kvart']."'";
     $o = mysql_query ( $u );
     $kvart = mysql_result ( $o, 0 );

     echo $kvart;

echo '</level_2_location_id>',"\n";

//ulica (mikrolokacija po JAKO starom)

echo '<street_name>',$podaci['mikrolokacija'],'</street_name>',"\n";



//Lokacija na karti

if ( $podaci['lon'] AND $podaci['lat'] ) {


    echo '<location_x>',$podaci['lon'],'</location_x>',"\n";
    echo '<location_y>',$podaci['lat'],'</location_y>',"\n";

}


//vrsta zemljišta

if ( $podaci['vrstaZemljista'] ) {

switch ($podaci['vrstaZemljista']) {

    case "1":
    case "4":
    $vrsta = "235";
    break;

    case "2":
    case "3":
    case "5":
    $vrsta = "236";
    break;

}

echo '<land_type_id>',$vrsta,'</land_type_id>',"\n";

}

//površina

echo '<main_area>',$podaci['povrsina'],'</main_area>',"\n";


//interna šifra oglasa

echo '<internal_item_code>zemljišta - ',$podaci['id'],'</internal_item_code>',"\n";

//LOOKUP LISTA

echo '<lookup_list>';

    //installations

    //vodovod
    if ( $podaci['voda'] ) {

     echo '<lookup_item code="">241</lookup_item>',"\n";

    }
    //plin
    if ( $podaci['plin'] ) {

     echo '<lookup_item code="">240</lookup_item>',"\n";

    }
    //kanalizacija
    if ( $podaci['kanalizacija'] ) {

     echo '<lookup_item code="">243</lookup_item>',"\n";

    }

    //kanalizacija
    if ( $podaci['telefon'] ) {

     echo '<lookup_item code="">244</lookup_item>',"\n";

    }





    //permits

    if ( $podaci['vlasnickList'] ) {

     echo '<lookup_item code="permits">248</lookup_item>',"\n";

    }

    if ( $podaci['gradevinska'] ) {

     echo '<lookup_item code="permits">246</lookup_item>',"\n";

    }

    if ( $podaci['uporabna'] ) {

     echo '<lookup_item code="permits">247</lookup_item>',"\n";

    }


echo '</lookup_list>',"\n";

// KRAJ LOOPa

echo '</ad_item>',"\n";

}

echo '</ad_list>';

?>

