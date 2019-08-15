<?php

// određivanje tabele iz koje se vuku podaci

$tabela = "posrednickidnevnik";

// definicija gumba na vrhu stranice  /


// glavni gumbi vode na stranice, pa se elementi polja prevode  /
// u link oblika /0/prikaz/0/0/ - > $glavniGumbi[0][0]          /
// i ime/naziv gumba u prikaz - > $glavniGumbi[0][1]            /

$glavniGumbi = Array (
                        array ( 'prikaz', 'prikaz' )

                        );

// pomoćni gumbi pozivaju AJAX  , pa se elementi polja prevode   /
// u ID elementa "addButton_adresar" - > $pomocniGumbi[0][0      /
// i ime/naziv gumba u adresar - > $glavniGumbi[0][1]            /

$pomocniGumbi = 0;


include ( 'vivoIncludes/buttons.php' );

$upit = "SELECT * FROM ".$tabela." WHERE id='".$id."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

?>
<table width="800" cellpadding="0" cellspacing="0" border="0" class="posrednckiDetalji">
    <tr>
        <td colspan="2">Oznaka (redni broj) posredničkog dnevnika</td>
        <td colspan="4"><?php echo $podaci['oznaka']; ?></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Lokacija nekretnine</td>
    </tr>
    <tr>
        <td width="100">Županija</td><td width="200"><?php echo $podaci['zupanija']; ?></td>
        <td width="100">Grad</td><td width="200"><?php echo $podaci['grad']; ?></td>
        <td width="100"></td><td width="100"></td>
    </tr>
    <tr>
       <td width="100">Kvart</td><td width="200"><?php echo $podaci['kvart']; ?></td>
       <td width="100">Ulica</td><td width="200"><?php echo $podaci['ulica']; ?></td>
       <td width="100">Kućni broj</td><td width="100"><?php echo $podaci['kucniBroj']; ?></td></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vrsta nekretnine: <?php echo $podaci['vrstaNekretnine']; ?></td>
    </tr>
    <tr>
       <td width="100">Površina</td><td width="200"><?php echo $podaci['povrsina']; ?></td>
       <td width="100">Kat</td><td width="200"><?php echo $podaci['kat']; ?></td>
       <td width="100">Sobnost</td><td width="100"><?php echo $podaci['sobnost']; ?></td>
    </tr>
    <tr>
       <td width="100">Kat. čestica</td><td width="200"><?php echo $podaci['katastarskaCestica']; ?></td>
       <td width="100">Vrsta vlasništa</td><td width="200"><?php echo $podaci['vrstaVlasnistva']; ?></td>
       <td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Ukupna cijena</td><td width="200">Euro <?php echo $podaci['cijenaUkupnaEuro']; ?></td><td width="100"></td><td width="200">Kune <?php echo $podaci['cijenaUkupnaKune']; ?></td><td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Po kvadratu</td><td width="200">Euro <?php echo $podaci['cijenaKvadrataEuro']; ?></td><td width="100"></td><td width="200">Kune <?php echo $podaci['cijenaKvadrataKune']; ?></td><td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Ugovor</td>
    </tr>
    <tr>
       <td width="100">Vrsta</td><td width="200"><?php echo $podaci['vrstaUgovora']; ?></td>
       <td width="100">Datum</td><td width="200"><?php echo $podaci['datum']; ?></td>
       <td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vlasnik / vlasnici</td>
    </tr>
    <tr>
       <td width="100">Ime i prezime</td><td width="600" colspan="5"><?php echo $podaci['vlasnikIme']; ?></td>
    </tr>
    <tr>
       <td width="100">Adresa</td><td width="600" colspan="5"><?php echo $podaci['vlasnikAdresa']; ?></td>
    </tr>
    <tr>
       <td width="100">Telefon</td><td width="600" colspan="5"><?php echo $podaci['vlasnikTelefon']; ?></td>
    </tr>
    <tr>
       <td colspan="6">Prema ZSPNT stranka je: <?php echo $podaci['ZSNPT']; ?></td>
    </tr>
</table>