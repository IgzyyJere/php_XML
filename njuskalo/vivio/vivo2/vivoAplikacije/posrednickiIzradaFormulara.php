<?php

session_start();
include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

// saznam sve o nekretnini

$upit = "SELECT * FROM ".$_POST['tabela']." WHERE id = '".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$nekretnina = mysql_fetch_assoc ( $odgovori );

$upit = "SELECT tecaj FROM tecaj";
$odgovori = mysql_query ( $upit );
$tecaj = mysql_result ( $odgovori, 0 );



    // površina / kvadratura   /
    switch ( $_POST['tabela'] )
    {
    case "vivostanovi":
    case "vivokuce":
    case "vivoposlovni":
    $povrsina = $nekretnina['ukupnaPovrsina'];
    break;

    case "vivoostalo":
    case "vivozemljista":
    case "vivoturizam":
    $povrsina = $nekretnina['povrsina'];
    break;

    }

    // odredi slovo ispred IDa /
    switch ( $_POST['tabela'] ) {

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
    $idNekretnine = $slovo.$_POST['id'];

    // cijena   /
    $cijenaEuro = $nekretnina['cijena'];
    $cijenaKune = ($nekretnina['cijena']*$tecaj);

    $cijenaEurom2 = round (($nekretnina['cijena']/$povrsina), 2);
    $cijenaKunem2 = round ((($nekretnina['cijena']*$tecaj)/$povrsina),2);

    // broj soba  /

    if ( $nekretnina['brojSoba']) {
        $sobe = $nekretnina['brojSoba'];
        }

    // odredi lokacije   /
        // županija  /
        $u = "SELECT nazivZupanije FROM zupanije WHERE id = '".$nekretnina['zupanija']."'";
        $o = mysql_query ( $u );
        $zupanija = mysql_result ( $o, 0 );
        /// grad    / ž
        $u = "SELECT naziv FROM gradovi WHERE id = '".$nekretnina['grad']."'";
        $o = mysql_query ( $u );
        $grad = mysql_result ( $o, 0 );
        // kvart   /
        $u = "SELECT naziv FROM kvartovi WHERE id = '".$nekretnina['kvart']."'";
        $o = mysql_query ( $u );
        $kvart = mysql_result ( $o, 0 );

    // vrsta nekretnina  /
    $u = "SELECT * FROM grupe WHERE id ='".$nekretnina['grupa']."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc( $o );
    $vrsta = $p['vrsta']." - ".$p['grupa'];

?>


<?php
if ( $_POST['browserHeight'] < 600 ) {
    echo '<div style="height: 350px; overflow: auto;">';
    }
?>
<input type="hidden" name="idNekretnine" value="<?php echo $idNekretnine; ?>">
<table width="780" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td colspan="2">Oznaka (redni broj) posredničkog dnevnika</td>
        <td colspan="4"><input type="text" name="oznaka"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Lokacija nekretnine</td>
    </tr>
    <tr>
        <td width="100">Županija</td><td width="200"><input type="text" name="zupanija" value="<?php echo $zupanija; ?>"></td>
        <td width="100">Grad</td><td width="200"><input type="text" name="grad" value="<?php echo $grad; ?>"></td>
        <td width="100"></td><td width="100"></td>
    </tr>
    <tr>
       <td width="100">Kvart</td><td width="200"><input type="text" name="kvart" value="<?php echo $kvart;  ?>"></td>
       <td width="100">Ulica</td><td width="200"><input type="text" name="ulica" value="<?php echo $nekretnina['mikrolokacija']; ?>"></td>
       <td width="100">Kućni broj</td><td width="100"><input type="text" name="kucniBroj" size="4"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vrsta nekretnine: <input type="text" name="vrstaNekretnine" value="<?php echo $vrsta; ?>" size="30"></td>
    </tr>
    <tr>
       <td width="100">Površina</td><td width="200"><input type="text" name="povrsina" value="<?php echo $povrsina; ?>"></td>
       <td width="100">Kat</td><td width="200"><input type="text" name="kat" value=""></td>
       <td width="100">Sobnost</td><td width="100"><input type="text" name="sobnost" size="4" value="<?php echo $sobe; ?>"></td>
    </tr>
    <tr>
       <td width="100">Kat. čestica</td><td width="200"><input type="text" name="katastarskaCestica" value="<?php echo $nekretnina['katCes']; ?>"></td>
       <td width="100">Vrsta vlasništa</td><td width="200"><input type="text" name="vrstaVlasnistva" value=""></td>
       <td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Ukupna cijena</td><td width="200">Euro <input type="text" name="cijenaUkupnaEuro" value="<?php echo $cijenaEuro; ?>"></td><td width="100"></td><td width="200">Kune <input type="text" name="cijenaUkupnaKune" value="<?php echo $cijenaKune; ?>"></td><td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Po kvadratu</td><td width="200">Euro <input type="text" name="cijenaKvadrataEuro" value="<?php echo $cijenaEurom2; ?>"></td><td width="100"></td><td width="200">Kune <input type="text" name="cijenaKvadrataKune" value="<?php echo $cijenaKunem2; ?>"></td><td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Ugovor</td>
    </tr>
    <tr>
       <td width="100">Vrsta</td><td width="200"><select name="vrstaUgovora">
                                                    <option value="prodaja">prodaja</option>
                                                    <option value="najam">najam</option>
                                                    <option value="zakup">zakup</option>
                                                </select></td>
       <td width="100">Datum</td><td width="200"><input type="text" name="datum" value="<?php echo date("j.n.Y"); ?>"></td>
       <td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vlasnik / vlasnici</td>
    </tr>
    <tr>
       <td width="100">Ime i prezime</td><td width="600" colspan="5"><input type="text" name="vlasnikIme" value="<?php echo $nekretnina['imeIPrezime']; ?>" size="100"></td>
    </tr>
    <tr>
       <td width="100">Adresa</td><td width="600" colspan="5"><input type="text" name="vlasnikAdresa" value="<?php echo $nekretnina['adresa']; ?>" size="100"></td>
    </tr>
    <tr>
       <td width="100">Telefon</td><td width="600" colspan="5"><input type="text" name="vlasnikTelefon" value="<?php echo $nekretnina['povTelefon'],',',$podaci['mobitel']; ?>" size="100"></td>
    </tr>
    <tr>
       <td colspan="6">Prema ZSPNT stranka je:
        <select name="ZSPNT">
            <option value="visoko rizična">visoko rizična</option>
            <option value="srednje rizična">srednje rizična</option>
            <option value="nisko rizična">nisko rizična</option>
        </select></td>
    </tr>
</table>
<?php
if ( $_POST['browserHeight'] < 600 ) {
    echo '</div>';
    }
?>






