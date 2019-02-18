<?php


//                                                     /
//            dajBrojKlijenata()                       /
//                                                     /
function dajBrojKlijenata ( $id, $tabela, $grupa )
{

// izvadi podatke o nekretnini

$upit = "SELECT * FROM ".$tabela." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$nekretnina = mysql_fetch_assoc ( $odgovori );

switch ( $tabela ) {

    case 'vivostanovi':
    $provjera = "klijentistanovi";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivoposlovni':
    $provjera = "klijentiposlovni";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivokuce':
    $provjera = "klijentikuce";
    $povrsina = "ukupnaPovrsina";
    break;

    case 'vivozemljista':
    $provjera = "klijentizemljista";
    $povrsina = "povrsina";
    break;

    case 'vivoostalo':
    $provjera = "klijentiostalo";
    $povrsina = "povrsina";
    break;

    case 'vivoturizam':
    $provjera = "klijentiturizam";
    $povrsina = "povrsina";
    break;

}

$uu = "SELECT vrsta FROM grupe WHERE id = '".$grupa."'";
$oo = mysql_query ( $uu );
$vrsta = mysql_result ( $oo, 0 );


$var = strpos ($vrsta, "prodaja" );
if ( $var === FALSE ){
    $grupa_2 = 2;
    } else {
    $grupa_2 = 1;
}

//sagradi upit

$upit = "SELECT COUNT(id) AS broj FROM ".$provjera." WHERE ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )";

      //dodaj uvijete koje daje klijent


      $upit = $upit." AND ( minCijena < ".$nekretnina['cijena']." OR !minCijena ) AND ( maxCijena >  ".$nekretnina['cijena']." OR !maxCijena )";


      $upit = $upit." AND ( povrsinaOd < ".$nekretnina[$povrsina]." OR !povrsinaOd ) AND ( povrsinaDo > ".$nekretnina[$povrsina]." OR !povrsinaDo )";

      $upit = $upit." AND zupanija = ".$nekretnina['zupanija']." ";

      $upit = $upit." AND grupa = ".$grupa_2." ";

$odgovori = mysql_query ( $upit );
return mysql_result ( $odgovori, 0 );

}





//                                                     /
//            prikaziNekretninu()                      /
//                                                     /
function prikaziNekretninu ( $podaci, $back, $tabela )
{

switch ( $tabela ) {

    case 'vivostanovi':
    $slovo = "s";
    break;

    case 'vivoposlovni':
    $slovo = "p";
    break;

    case 'vivokuce':
    $slovo = "k";
    break;

    case 'vivozemljista':
    $slovo = "z";
    break;

    case 'vivoostalo':
    $slovo = "o";
    break;

    case 'vivoturizam':
    $slovo = "t";
    break;

}
   global $grupa;

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">';

    // strlice za pomicanje nekretnine u poretku /

    echo '<div class="formPrikazStrelice">';
    // pomakni gore                     /
    echo '<a href="/vivo2/0/0/0/0/gore=',$podaci['id'],'" title="pomakni gore" class="pomakniGore"><img src="/vivo2/ikone/arrow_up.png"></a>';
    //pomakni dole                    /
    echo '<a href="/vivo2/0/0/0/0/dole=',$podaci['id'],'" title="pomakni dole" class="pomakniDole"><img src="/vivo2/ikone/arrow_down.png"></a>';
    //pomakni na vrh                   /
    //echo '<a href="/vivo2/0/0/0/0/navrh=',$podaci['id'],'" title="pomakni na vrh" class="pomakniNaVrh"><img src="/vivo2/ikone/arrow_top.png"></a>';

    // odredi položaj nekretnine unutar njene skupine i prikaži /
        // odredi skupinu  /
        $uu = "SELECT skupina FROM grupe WHERE id ='".$grupa."'";
        $oo = mysql_query ( $uu );
        $skupina = mysql_result ( $oo, 0 );

        $uu = "SELECT id FROM grupe WHERE skupina = '".$skupina."'";
        $oo = mysql_query ( $uu );
        $j = 1;
        $dioUpita = "( ";
        while ( $pp = mysql_fetch_assoc ( $oo )) {
            if ( $j == 1 ){
                $dioUpita = $dioUpita." grupa = '".$pp['id']."' ";
            } else {
                $dioUpita = $dioUpita." OR grupa = '".$pp['id']."' ";
            }
            $j++;
        }
        $dioUpita = $dioUpita." )";

        $uu = "SELECT COUNT(id) AS id FROM ".$tabela." WHERE ".$dioUpita." AND poredak > '".$podaci['poredak']."' AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' )";
        $oo = mysql_query ( $uu );
        $broj = mysql_result ( $oo, 0 );

        echo $broj+1;


    echo '</div>';

    echo '<div class="formPrikazID"><a class="dajIDnaklik" href="',$podaci['id'],'">';

    if ( $podaci['idInterni'] ) {
        echo $podaci['idInterni'];
        } else {
        echo $slovo,$podaci['id'];
        }

    echo '</a></div>
	  <div class="formPrikazPosjeti">(',$podaci['brojPosjeta'],')</div>';

    echo '<div class="formPrikazPodaci">';

    $u = "SELECT * FROM gradovi WHERE id = '".$podaci['grad']."'";
    $o = mysql_query ( $u );
    $grad = mysql_fetch_assoc ( $o );

    echo $grad['naziv'],' / ';

    $u = "SELECT * FROM kvartovi WHERE id = '".$podaci['kvart']."'";
    $o = mysql_query ( $u );
    $kvart = mysql_fetch_assoc ( $o );


    echo $kvart['naziv'],' / ';
    if ($podaci['mikrolokacija']){echo $podaci['mikrolokacija'];}

    echo ' ',$podaci['povrsina'];

    echo ' m<sup>2</sup>, ',$podaci['cijena'],' &euro;</div></div>';

    // početak DIV za prikaz      /

    echo '<div class="prikazPomocniNav">';


    // on / off                   /
    echo '<a href="" title="uključi / isključi" ref="',$podaci['id'],'" class="onOff showTooltip">';

    if ( $podaci['aktivno'] == 1 ) {

        echo '<img src="/vivo2/ikone/flag_green.png"> ';

    }  else if ( $podaci['aktivno'] == 2 ) {

        echo '<img src="/vivo2/ikone/flag_yellow.png"> ';

    }  else if ( $podaci['aktivno'] == 3 ) {

        echo '<img src="/vivo2/ikone/flag_black.png"> ';

    } else {

        echo '<img src="/vivo2/ikone/flag_red.png"> ';

    }


    echo '</a>';

    // podaci o vlasniku           /

    echo '<a href="" title="prikaži podatke o vlasniku" class="vlasnik showTooltip" ref="',$podaci['id'],'" rel="',$tabela,'"><img src="/vivo2/ikone/group_go.png"></a>';

    // podsjetnik                  /

    echo '<a href="/vivo2/podesavanja/podsjetnik/unos/0/tabela=',$tabela,'&id=',$podaci['id'],'" class="dodajPodsjetnik showTooltip" title="dodavanje podsjetnika"><img src="/vivo2/ikone/bell_add.png"></a>';

    // arhiva                      /

    echo '<a href="/vivo2/0/0/0/0/arhiva=',$podaci['id'],'" title="arhiva" class="arhivirajPodatak showTooltip"><img src="/vivo2/ikone/database.png"></a>';

    // provjera potražnje          /

    echo '<a href="/vivo2/0/provjeraNekretnine/prikaz/',$podaci['id'],'/tabela=',$tabela,'&grupa=',$grupa,'" title="provjeri potražnju" class="provjeraNekretnina showTooltip"><img src="/vivo2/ikone/eye.png">';

    echo '(',dajBrojKlijenata ( $podaci['id'], $tabela, $grupa ),')</a>';

    // printanje podataka          /

    echo '<a href="" title="ispis dokumenata" ref="',$tabela,'" rel="',$podaci['id'],'" class="printajPodatke showTooltip"><img src="/vivo2/ikone/printer.png"></a>';

    // dodaj u popis za slanje ponude /

    echo '<a href="" title="dodaj u popis za ponudu" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodajNaPopis showTooltip"><img src="/vivo2/ikone/page_white_add.png"></a>';


    // dodavanje izvještaja /

    echo '<a href="" title="dodavanje izvještaja" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodavanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_add.png"></a>';

    // prikaz izvještaja /

    //saznaj raznivu pristupa
    $uuPritup = "SELECT razina FROM kontroler WHERE idsess = '".session_id()."'";
    $ooPristup = mysql_query ( $uuPristup );
    $razina = mysql_result ( $ooPristup, 0 );

    if ( $razina < 3 ) {

        echo '<a href="/vivo2/0/izvjestaji/prikaz/',$podaci['id'],'/tabela=',$tabela,'" title="prikazivanje izvještaja" class="prikazivanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_open.png"></a>';

    }

    // napravi posrednički dnevnik /

    // treba provjeriti jel već ima unesen posrednički, ako ima ide crna ikona koja pokazuje sami posrednički umjesto forme za unos  /

    $u = "SELECT id FROM posrednickidnevnik WHERE idNekretnine = '".$slovo.$podaci['id']."'";
    $o = mysql_query ( $u );
    $p = mysql_result ( $o, 0 );

    if ( $p ) {

        echo '<a href="" title="prikaži posrednički dnevnik" ref="',$tabela,'" rel="',$podaci['id'],'" class="pokaziPosrednicki showTooltip"><img src="/vivo2/ikone/report_black.png"></a>';

    } else {

        echo '<a href="" title="napravi posrednički dnevnik" ref="',$tabela,'" rel="',$podaci['id'],'" class="napraviPosrednicki showTooltip"><img src="/vivo2/ikone/report.png"></a>';

    }

    // promjena grupa /

    echo '<a href="',$tabela,'" title="izmjena grupe" rel="',$podaci['grupa'],'" ref="',$podaci['id'],'" class="promjenaGrupe showTooltip"><img src="/vivo2/ikone/table_refresh.png"></a>';



    //kraj                         /
    echo '</div>
    </div>';


}




//                                                     /
//            prikaziNekretninuArhiva()                /
//                                                     /

function prikaziNekretninuArhiva ( $podaci, $back, $tabela )
{

switch ( $tabela ) {

    case 'vivostanovi':
    $slovo = "s";
    $str = "stan";
    break;

    case 'vivoposlovni':
    $slovo = "p";
    $str = "posl";
    break;

    case 'vivokuce':
    $slovo = "k";
    $str = "kuce";
    break;

    case 'vivozemljista':
    $slovo = "z";
    $str = "zem";
    break;

    case 'vivoostalo':
    $slovo = "o";
    $str = "ost";
    break;

    case 'vivoturizam':
    $slovo = "t";
    $str = "turizam";
    break;

}

    $uu = "SELECT vrsta FROM grupe WHERE id = '".$podaci['grupa']."'";
    $oo = mysql_query ( $uu );
    $pp = mysql_result ( $oo, 0 );

    if ( preg_match ( "/\bprodaja\b/i", $pp ) ) {
          $str = $str."_prodaja";
          } else {
          $str = $str."_najam";
          }



    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/',$str,'/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">';

    echo '<strong>',$slovo,$podaci['id'],' </strong>&nbsp;';

    //ubaci podatak u grupi

    $uuu = "SELECT naziv FROM grupe WHERE id = '".$podaci['grupa']."'";
    $ooo = mysql_query ( $uuu );
    echo mysql_result ( $ooo, 0 ),' / ';


    $u = "SELECT * FROM gradovi WHERE id = '".$podaci['grad']."'";
    $o = mysql_query ( $u );
    $grad = mysql_fetch_assoc ( $o );

    echo $grad['naziv'],' / ';

    $u = "SELECT * FROM kvartovi WHERE id = '".$podaci['kvart']."'";
    $o = mysql_query ( $u );
    $kvart = mysql_fetch_assoc ( $o );


    echo $kvart['naziv'],' / ',$podaci['mikrolokacija'],' : ';

    echo $podaci['povrsina'],' m<sup>2</sup> : ',$podaci['cijena'],' &euro;</div>';

    // početak DIV za prikaz      /

    echo '<div class="prikazPomocniNav">';



    // podaci o vlasniku           /

    echo '<a href="" title="prikaži podatke o vlasniku" class="vlasnik showTooltip" ref="',$podaci['id'],'" rel="',$tabela,'"><img src="/vivo2/ikone/group_go.png"></a>';

    // podsjetnik                  /

    echo '<a href="/vivo2/podesavanja/podsjetnik/unos/0/tabela=',$tabela,'&id=',$podaci['id'],'" class="dodajPodsjetnik showTooltip" title="dodavanje podsjetnika"><img src="/vivo2/ikone/bell_add.png"></a>';

    // arhiva                      /

    echo '<a href="/vivo2/0/0/0/0/arhiva=',$podaci['id'],'" title="vrati iz arhive" class="arhivirajPodatak showTooltip"><img src="/vivo2/ikone/database.png"></a>';

    // provjera potražnje          /

    //echo '<a href="/vivo2/0/provjeraNekretnine/prikaz/',$podaci['id'],'/tabela=',$tabela,'&grupa=',$grupa,'" title="provjeri potražnju" class="provjeraNekretnina showTooltip"><img src="/vivo2/ikone/eye.png">';

    //echo '(',dajBrojKlijenata ( $podaci['id'], $tabela, $grupa ),')</a>';

    // printanje podataka          /

    //echo '<a href="" title="ispis dokumenata" ref="',$tabela,'" rel="',$podaci['id'],'" class="printajPodatke showTooltip"><img src="/vivo2/ikone/printer.png"></a>';

    // dodaj u popis za slanje ponude /

    //echo '<a href="" title="dodaj u popis za ponudu" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodajNaPopis showTooltip"><img src="/vivo2/ikone/page_white_add.png"></a>';


    // dodavanje izvještaja /

    echo '<a href="" title="dodavanje izvještaja" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodavanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_add.png"></a>';

    // prikaz izvještaja /

    //saznaj raznivu pristupa
    $uuPristup = "SELECT razina FROM kontroler WHERE idsess = '".session_id()."'";
    $ooPristup = mysql_query ( $uuPristup );
    $razina = mysql_result ( $ooPristup, 0 );

    if ( $razina < 3 ) {

        echo '<a href="/vivo2/0/izvjestaji/prikaz/',$podaci['id'],'/tabela=',$tabela,'" title="prikazivanje izvještaja" class="prikazivanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_open.png"></a>';

   }

    // dodaj ugovor u bazu podataka /

    //echo '<a href="" title="dodaj poslani ugovor" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodajUgovor showTooltip"><img src="/vivo2/ikone/script_add.png"></a>';

    //kraj                         /
    echo '</div>
    </div>';


}





//                                                     /
//            prikaziKlijenta()                        /
//                                                     /
function prikaziKlijenta ( $podaci, $back, $tabela )
{

        global $grupa;

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">';


    echo $podaci['imeIPrezime'];

    if ( $podaci['spojeno'] ) {

        echo ' (',$podaci['spojeno'],') ';

    }


    // početak DIV za prikaz      /

    echo '</div><div class="prikazPomocniNav">';

    // on / off                   /
    echo '<a href="" title="uključi / isključi" ref="',$podaci['id'],'" class="onOff showTooltip">';
    if ( $podaci['aktivno'] ) {

        echo '<img src="/vivo2/ikone/flag_green.png"> ';

    }  else {

        echo '<img src="/vivo2/ikone/flag_red.png"> ';

    }


    // spajanje na nekretninu                 /

    echo '<a href="',$podaci['id'],'" class="spojiNaNekretninu showTooltip" title="spoji na nekretninu"><img src="/vivo2/ikone/house.png"></a>';


    // podsjetnik                  /

    echo '<a href="/vivo2/podesavanja/podsjetnik/unos/0/tabela=',$tabela,'&id=',$podaci['id'],'" class="dodajPodsjetnik showTooltip" title="dodavanje podsjetnika"><img src="/vivo2/ikone/bell_add.png"></a>';

    // arhiva                      /

    echo '<a href="/vivo2/0/0/0/0/arhiva=',$podaci['id'],'" title="arhiva" class="arhivirajPodatak showTooltip"><img src="/vivo2/ikone/database.png"></a>';


    // provjera potražnje          /

    echo '<a href="/vivo2/0/provjeraKlijenta/prikaz/',$podaci['id'],'/tabela=',$tabela,'&grupa=',$grupa,'" title="provjeri potražnju" class="provjeraNekretnina showTooltip"><img src="/vivo2/ikone/eye.png"></a>';

    // dodavanje izvještaja /

    echo '<a href="" title="dodavanje izvještaja" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodavanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_add.png"></a>';

    // prikaz izvještaja /

    //saznaj raznivu pristupa
    $uuPritup = "SELECT razina FROM kontroler WHERE idsess = '".session_id()."'";
    $ooPristup = mysql_query ( $uuPristup );
    $razina = mysql_result ( $ooPristup, 0 );

    if ( $razina < 3 ) {

        echo '<a href="/vivo2/0/izvjestaji/prikaz/',$podaci['id'],'/tabela=',$tabela,'" title="prikazivanje izvještaja" class="prikazivanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_open.png"></a>';

   }


    echo '</div></div>';


}




//                                                     /
//            prikaziKlijentaArhiva()                  /
//                                                     /
function prikaziKlijentaArhiva ( $podaci, $back, $tabela )
{

    global $grupa;

    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/0/0/obrisi=',$podaci['id'],'" class="smallButton smallRed deleteContent">Obriši</a>
                <a href="/vivo2/0/0/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Izmjeni</a>
            </div>

            <div class="prikazLineRight">';


    echo $podaci['imeIPrezime'];

    if ( $podaci['spojeno'] ) {

        echo ' (',$podaci['spojeno'],') ';

    }

    if ( $podaci['grupa'] == "1" ) {

        echo ' &nbsp;&nbsp; - prodaja ';

    }

    if ( $podaci['grupa'] == "2" ) {

        echo ' &nbsp;&nbsp; - najam ';

    }


    // početak DIV za prikaz      /

    echo '</div><div class="prikazPomocniNav">';

    // spajanje na nekretninu                 /

    //echo '<a href="',$podaci['id'],'" class="spojiNaNekretninu showTooltip" title="spoji na nekretninu"><img src="/vivo2/ikone/house.png"></a>';


    // podsjetnik                  /

    echo '<a href="/vivo2/podesavanja/podsjetnik/unos/0/tabela=',$tabela,'&id=',$podaci['id'],'" class="dodajPodsjetnik showTooltip" title="dodavanje podsjetnika"><img src="/vivo2/ikone/bell_add.png"></a>';

    // arhiva                      /

    echo '<a href="/vivo2/0/0/0/0/arhiva=',$podaci['id'],'" title="vrati iz arhive" class="arhivirajPodatak showTooltip"><img src="/vivo2/ikone/database.png"></a>';


    // provjera potražnje          /

    //echo '<a href="/vivo2/0/provjeraKlijenta/prikaz/',$podaci['id'],'/tabela=',$tabela,'&grupa=',$grupa,'" title="provjeri potražnju" class="provjeraNekretnina showTooltip"><img src="/vivo2/ikone/eye.png"></a>';

    // dodavanje izvještaja /

    echo '<a href="" title="dodavanje izvještaja" ref="',$tabela,'" rel="',$podaci['id'],'" class="dodavanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_add.png"></a>';

    // prikaz izvještaja /

    //saznaj raznivu pristupa
    $uuPritup = "SELECT razina FROM kontroler WHERE idsess = '".session_id()."'";
    $ooPristup = mysql_query ( $uuPristup );
    $razina = mysql_result ( $ooPristup, 0 );

    if ( $razina < 3 ) {

        echo '<a href="/vivo2/0/izvjestaji/prikaz/',$podaci['id'],'/tabela=',$tabela,'" title="prikazivanje izvještaja" class="prikazivanjeIzvjestaja showTooltip"><img src="/vivo2/ikone/book_open.png"></a>';

   }


    echo '</div></div>';


}

function pomakniGore ( $tabela, $id, $grupa )
{

    //saznaj koji je gornji

    $upit = "SELECT id, poredak FROM ".$tabela." WHERE id = '".$id."'";
    $odgovori = mysql_query ( $upit );
    $donji = mysql_fetch_assoc ( $odgovori);

    // umjesto grupe sada je treba provjeriti skupinu /
        // odredi skupinu  /
        $uu = "SELECT skupina FROM grupe WHERE id ='".$grupa."'";
        $oo = mysql_query ( $uu );
        $skupina = mysql_result ( $oo, 0 );

        $uu = "SELECT id FROM grupe WHERE skupina = '".$skupina."'";
        $oo = mysql_query ( $uu );
        $j = 1;
        $dioUpita = "( ";
        while ( $pp = mysql_fetch_assoc ( $oo )) {
            if ( $j == 1 ){
                $dioUpita = $dioUpita." grupa = '".$pp['id']."' ";
            } else {
                $dioUpita = $dioUpita." OR grupa = '".$pp['id']."' ";
            }
            $j++;
        }
        $dioUpita = $dioUpita." )";

    $upit = "SELECT id, poredak FROM ".$tabela." WHERE poredak > ".$donji['poredak']." AND ".$dioUpita." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) ORDER BY poredak";
    $odgovori = mysql_query ( $upit );
    $gornji = mysql_fetch_assoc ( $odgovori );

    //promjeni poredak na gornjem

    $upit = "UPDATE ".$tabela." SET poredak = '".$donji['poredak']."' WHERE  id = '".$gornji['id']."'";
    mysql_query ( $upit );

    //promjeni poredak na donjem

    $upit = "UPDATE ".$tabela." SET poredak = '".$gornji['poredak']."' WHERE  id = '".$donji['id']."'";
    mysql_query ( $upit );

}

function pomakniDole ( $tabela, $id, $grupa )
{

    //saznaj koji je gornji
    $upit = "SELECT id, poredak FROM ".$tabela." WHERE id = '".$id."'";
    $odgovori = mysql_query ( $upit );
    $donji = mysql_fetch_assoc ( $odgovori);

    // umjesto grupe sada je treba provjeriti skupinu /
        // odredi skupinu  /
        $uu = "SELECT skupina FROM grupe WHERE id ='".$grupa."'";
        $oo = mysql_query ( $uu );
        $skupina = mysql_result ( $oo, 0 );

        $uu = "SELECT id FROM grupe WHERE skupina = '".$skupina."'";
        $oo = mysql_query ( $uu );
        $j = 1;
        $dioUpita = "( ";
        while ( $pp = mysql_fetch_assoc ( $oo )) {
            if ( $j == 1 ){
                $dioUpita = $dioUpita." grupa = '".$pp['id']."' ";
            } else {
                $dioUpita = $dioUpita." OR grupa = '".$pp['id']."' ";
            }
            $j++;
        }
        $dioUpita = $dioUpita." )";

    $upit = "SELECT id, poredak FROM ".$tabela." WHERE poredak < ".$donji['poredak']." AND ".$dioUpita." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) ORDER BY poredak DESC";
    $odgovori = mysql_query ( $upit );
    $gornji = mysql_fetch_assoc ( $odgovori );

    //promjeni poredak na gornjem
    $upit = "UPDATE ".$tabela." SET poredak = '".$donji['poredak']."' WHERE  id = '".$gornji['id']."'";
    mysql_query ( $upit );


    //promjeni poredak na donjem
    $upit = "UPDATE ".$tabela." SET poredak = '".$gornji['poredak']."' WHERE  id = '".$donji['id']."'";
    mysql_query ( $upit );

}

function pomakniNaVrh ( $tabela, $id, $grupa )
{

    //saznaj koji je gornji
    $upit = "SELECT id, poredak FROM ".$tabela." WHERE id = '".$id."'";
    $odgovori = mysql_query ( $upit );
    $donji = mysql_fetch_assoc ( $odgovori);

    // umjesto grupe sada je treba provjeriti skupinu /
        // odredi skupinu  /
        $uu = "SELECT skupina FROM grupe WHERE id ='".$grupa."'";
        $oo = mysql_query ( $uu );
        $skupina = mysql_result ( $oo, 0 );

        $uu = "SELECT id FROM grupe WHERE skupina = '".$skupina."'";
        $oo = mysql_query ( $uu );
        $j = 1;
        $dioUpita = "( ";
        while ( $pp = mysql_fetch_assoc ( $oo )) {
            if ( $j == 1 ){
                $dioUpita = $dioUpita." grupa = '".$pp['id']."' ";
            } else {
                $dioUpita = $dioUpita." OR grupa = '".$pp['id']."' ";
            }
            $j++;
        }
        $dioUpita = $dioUpita." )";

    $upit = "SELECT id, poredak FROM ".$tabela." WHERE ".$dioUpita." AND ( obrisano IS NULL OR obrisano = '0' ) AND ( arhiva IS NULL OR arhiva = '0' ) ORDER BY poredak DESC LIMIT 0,1";
    $odgovori = mysql_query ( $upit );
    $gornji = mysql_fetch_assoc ( $odgovori );

    //promjeni poredak na gornjem
    $upit = "UPDATE ".$tabela." SET poredak = '".$donji['poredak']."' WHERE  id = '".$gornji['id']."'";
    mysql_query ( $upit );


    //promjeni poredak na donjem
    $upit = "UPDATE ".$tabela." SET poredak = '".$gornji['poredak']."' WHERE  id = '".$donji['id']."'";
    mysql_query ( $upit );

}

        
?>
