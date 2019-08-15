<?php

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// sagradi upit na bazu    /


switch ( $_POST['tabela'] ) {

    case "vivostanovi":
    $vr = "stanovi";
    $vrs = "stan";
    $pov = "ukupnaPovrsina";
    break;

    case "vivoposlovni":
    $vr = "poslovni";
    $vrs = "posl";
    $pov = "ukupnaPovrsina";
    break;

    case "vivokuce":
    $vr = "kuce";
    $vrs = "kuce";
    $pov = "ukupnaPovrsina";
    break;

    case "vivozemljista":
    $vr = "zemljista";
    $vrs = "zem";
    $pov = "povrsina";
    break;

    case "vivoostalo":
    $vr = "ostalo";
    $vrs = "ost";
    $pov = "povrsina";
    break;

    case "vivoturizam":
    $vr = "turizam";
    $vrs = "turizam";
    $pov = "povrsina";
    break;

}

$upit = "SELECT id, $pov, cijena, zupanija, grad, kvart, mikrolokacija, cijena, slike FROM ".$_POST['tabela']." WHERE ";
$tabela = $_POST['tabela'];

if ( $_POST['grad'] ) {

    $upit = $upit." grad = '".$_POST['grad']."' AND ";

} else {

    $upit = $upit." zupanija = '".$_POST['pretraziZupanija']."' AND ";

}

//odredi grupe
$grupa = "( ";
$uu = "SELECT * FROM grupe WHERE vrsta = '".$vr." ".$_POST['navigacija']."'";
$oo = mysql_query ( $uu );
while ( $pp = mysql_fetch_assoc ( $oo )) {
    $grupa = $grupa." grupa = ".$pp['id']." OR ";
}
$grupa = $grupa." grupa = NULL )";



if ( $_POST['cijenaOd'] ) {
    $grupa = $grupa." AND cijena > ".$_POST['cijenaOd']." ";
}

if ( $_POST['cijenaDo'] ) {
    $grupa = $grupa." AND cijena < ".$_POST['cijenaDo']." ";
}

if ( $_POST['povrsinaOd'] ) {
    $grupa = $grupa." AND ".$pov." > ".$_POST['povrsinaOd']." ";
}

if ( $_POST['povrsinaDo'] ) {
    $grupa = $grupa." AND ".$pov." < ".$_POST['povrsinaDo']." ";
}

//echo '<br><br>',$upit.$grupa,'<br><br>';

$odgovori = mysql_query ( $upit.$grupa );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    echo '<div class="pretrazivanjeNaPocetnojRezultati">';

    // dodaj prvu sliku  /

    $slika = explode ( ',', $podaci['slike'] );
    $uu = "SELECT * FROM slike WHERE id = '".$slika[0]."'";
    $oo = mysql_query ( $uu );
    $jednaSlika = mysql_fetch_assoc ( $oo );

    if ( $jednaSlika['datoteka'] ) {

        if ( file_exists($_SERVER['DOCUMENT_ROOT']."/slike/srednja".$jednaSlika['datoteka'])) {

            echo '<img src="/slike/srednja',$jednaSlika['datoteka'],'"><br />';
            }  else {
            echo '<img src="/slike/mala',$jednaSlika['datoteka'],'"><br />';
            }

    } else {

        echo 'Nema slike.<br />';

    }

    $u = "SELECT * FROM gradovi WHERE id = '".$podaci['grad']."'";
    $o = mysql_query ( $u );
    $grad = mysql_fetch_assoc ( $o );

    echo $grad['naziv'],' / ';

    $u = "SELECT * FROM kvartovi WHERE id = '".$podaci['kvart']."'";
    $o = mysql_query ( $u );
    $kvart = mysql_fetch_assoc ( $o );


    echo $kvart['naziv'],' / ',$podaci['mikrolokacija'],'<br />';

    if ( $tabela == "vivozemljista" ) {

        echo $podaci['povrsina'];

    } else {

        echo $podaci['ukupnaPovrsina'];

    }

    echo 'm<sup>2</sup> : ',$podaci['cijena'],' &euro; - ';

    echo '<br /><b> ID</b> : ',$podaci['id'];

    // podaci o vlasniku           /

    echo '<br /><a href="" title="prikaži podatke o vlasniku" class="smallButton smallBlue vlasnik showTooltip" ref="',$podaci['id'],'" rel="',$tabela,'">Vlasnik</a>';

    echo ' &nbsp;&nbsp;&nbsp; <a href="/vivo2/',$_POST['navigacija'],'/',$vrs,'_',$_POST['navigacija'],'/izmjena/',$podaci['id'],'/" class="smallButton smallBlue">Prikaži</a>';


    //kraj                         /
    echo '</div>';

    $i++;


}

?>