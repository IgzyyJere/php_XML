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
echo '&nbsp;';
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

echo '<form name="posrednicki" method="POST" id="posrednicki" action="/vivo2/0/0/prikaz/0/napravi=izmjeni&id=',$id,'">';

?>

<table width="800" cellpadding="0" cellspacing="0" border="0" class="posrednckiDetalji">
    <tr>
        <td colspan="2">Oznaka (redni broj) posredničkog dnevnika</td>
        <td colspan="4"><input type="text" name="oznaka" value="<?php echo $podaci['oznaka']; ?>"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Lokacija nekretnine</td>
    </tr>
    <tr>
        <td width="100">Županija</td><td width="200"><input type="text" name="zupanija" value="<?php echo $podaci['zupanija']; ?>"></td>
        <td width="100">Grad</td><td width="200"><input type="text" name="grad" value="<?php echo $podaci['grad']; ?>"></td>
        <td width="100"></td><td width="100"></td>
    </tr>
    <tr>
       <td width="100">Kvart</td><td width="200"><input type="text" name="kvart" value="<?php echo $podaci['kvart'];  ?>"></td>
       <td width="100">Ulica</td><td width="200"><input type="text" name="ulica" value="<?php echo $podaci['ulica'] ?>"></td>
       <td width="100">Kućni broj</td><td width="100"><input type="text" name="kucniBroj" size="4"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vrsta nekretnine: <input type="text" name="vrstaNekretnine" value="<?php echo $podaci['vrstaNekretnine']; ?>" size="30"></td>
    </tr>
    <tr>
       <td width="100">Površina</td><td width="200"><input type="text" name="povrsina" value="<?php echo $podaci['povrsina']; ?>"></td>
       <td width="100">Kat</td><td width="200"><input type="text" name="kat" value="<?php echo $podaci['kat']; ?>"></td>
       <td width="100">Sobnost</td><td width="100"><input type="text" name="sobnost" size="4" value="<?php echo $podaci['sobnost']; ?>"></td>
    </tr>
    <tr>
       <td width="100">Kat. čestica</td><td width="200"><input type="text" name="katastarskaCestica" value="<?php echo $podaci['katastarskaCestica'] ?>"></td>
       <td width="100">Vrsta vlasništa</td><td width="200"><input type="text" name="vrstaVlasnistva" value="<?php echo $podaci['vrstaVlasnistva'] ?>"></td>
       <td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Ukupna cijena</td><td width="200">Euro <input type="text" name="cijenaUkupnaEuro" value="<?php echo $podaci['cijenaUkupnaEuro']; ?>"></td><td width="100"></td><td width="200">Kune <input type="text" name="cijenaUkupnaKune" value="<?php echo $podaci['cijenaUkupnaKune']; ?>"></td><td colspan="2"></td>
    </tr>
    <tr>
        <td width="100">Po kvadratu</td><td width="200">Euro <input type="text" name="cijenaKvadrataEuro" value="<?php echo $podaci['cijenaKvadrataEuro']; ?>"></td><td width="100"></td><td width="200">Kune <input type="text" name="cijenaKvadrataKune" value="<?php echo $podaci['cijenaKvadrataKune']; ?>"></td><td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Ugovor</td>
    </tr>
    <tr>
       <td width="100">Vrsta</td><td width="200"><select name="vrstaUgovora">
                                                    <option value="prodaja" <?php if ( $podaci['vrstaUgovora'] == "prodaja" ) echo ' selected'; ?>>prodaja</option>
                                                    <option value="najam" <?php if ( $podaci['vrstaUgovora'] == "najam" ) echo ' selected'; ?>>najam</option>
                                                    <option value="zakup" <?php if ( $podaci['vrstaUgovora'] == "zakup" ) echo ' selected'; ?>>zakup</option>
                                                </select></td>
       <td width="100">Datum</td><td width="200"><input type="text" name="datum" value="<?php echo $podaci['datum']; ?>"></td>
       <td colspan="2"></td>
    </tr>
     <tr>
        <td colspan="6"><hr width="750"></td>
    </tr>
     <tr>
        <td colspan="6">Vlasnik / vlasnici</td>
    </tr>
    <tr>
       <td width="100">Ime i prezime</td><td width="600" colspan="5"><input type="text" name="vlasnikIme" value="<?php echo $podaci['vlasnikIme']; ?>" size="100"></td>
    </tr>
    <tr>
       <td width="100">Adresa</td><td width="600" colspan="5"><input type="text" name="vlasnikAdresa" value="<?php echo $podaci['vlasnikAdresa']; ?>" size="100"></td>
    </tr>
    <tr>
       <td width="100">Telefon</td><td width="600" colspan="5"><input type="text" name="vlasnikTelefon" value="<?php echo $podaci['vlasnikTelefon']; ?>" size="100"></td>
    </tr>
    <tr>
       <td colspan="6">Prema ZSPNT stranka je:
        <select name="ZSPNT">
            <option value="visoko rizična" <?php if ( $podaci['ZSPNT'] == "visoko rizična" ) echo ' selected'; ?>>visoko rizična</option>
            <option value="srednje rizična" <?php if ( $podaci['ZSPNT'] == "srednje rizična" ) echo ' selected'; ?>>srednje rizična</option>
            <option value="nisko rizična" <?php if ( $podaci['ZSPNT'] == "nisko rizična" ) echo ' selected'; ?>>nisko rizična</option>
        </select></td>
    </tr>
</table>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset">Isprazni</button>
<button class="greenButton" name="submit" type="submit" value="submit">Unesi</button>
</div>
</form>