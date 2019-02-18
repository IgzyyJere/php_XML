<?php

$tabela = "popiszaslanje";

// odredi osnovne varijable koje se čitaju iz   /
// vivoDiff foldera za svaku agenciju posebno   /
include ( 'vivoDiff/ponuda.php');


// pdredi osnovne varijable servera, za linkove /
// na stranice i da se mogu učitati slike       /
$domena = "http://".$_SERVER['SERVER_NAME'];


//                                     /
//     GORNJI DIO (sa headerom)        /
//                                     /

// odredi dimenzije logotipa koji se pokazuje /
list($width, $height) = getimagesize('../elementi/logomail.jpg');
$gornjidio = '<html>
<body>
    <table width="100%" cellpadding="10" cellspacing="0" class="backgroundTable" bgcolor="#'.$pozadinamaila.'">
        <tr>
            <td valign="top" align="center"><font face="font-family: Arial, Helvetica Neue, Helvetica, sans-serif;" color="#'.$bojateksta.'">

<table width="550" cellpadding="10" cellspacing="0">
    <tr>
        <td style="background-color:#FFFFFF; height:100px;" width="250"><a href="'.$domena.'"><img src="'.$domena.'/elementi/logomail.jpg" style="border: none;" width="'.$width.'" height="'.$height.'"></a>
        </td>
        <td style="background-color:#FFFFFF; height:100px;" width="300"><center>'.$headermaila.'</center>
        </td>
    </tr>
</table>';

$donjidio = '<table width="550" height="100" cellpadding="10" bgcolor="#'.$pozadinafootera.'">
                <tr>
                    <td valign="top"><center> '.$footermaila.' </center>
                    </td>
                </tr>
            </table><br>
            </font>
            </td>
        </tr>
    </table>
</body>
</html>';
$poruka = "";

//   PROVJERIT JEL UNESEN ID klijenta u popisZaSlanje          /
// ako je - onda se šalje njemu, ne treba unosit e-mail adrese /
// ako nije, treba unjeti pe-mail adresu / dohvatit iz baze    /

$upit = "SELECT idKlijenta FROM popiszaslanje ORDER BY id DESC LIMIT 0,1";
$odgovori = mysql_query ( $upit );
$izbor = mysql_result ( $odgovori, 0 );

// ako je unesen ID klijenta, šalje se klijentu   /
if ( $izbor ) {

    if ( !$_GET['slanje'] ) {

    ?>
    <form id="formSlanjePonude" name="formSlanjePonude" method="POST" action="/vivo2/0/0/0/0/slanje=1">
    <div><label for="subject">tema / naslov poruke</label><input name="subject" type="text" size="30"></div>
    <div><label for="tekst">tekst poruke</label><textarea name="tekst" class="dodajEditor"></textarea></div>
    <button type="submit" class="submitButton greenButton">pošalji</button>
    </form>
    <?php

    }

if ( $_GET['slanje'] ) {

    $upit = "SELECT * FROM ".$tabela." WHERE email = '0' AND idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );

        while ( $popis = mysql_fetch_assoc ( $odgovori )) {

        $tbl = $popis['tabela'];

        // upit o nekretnini       /
        if ( $tbl == "vivozemljista" OR $tbl == "vivoostalo" ) {
            $uu = "SELECT id, mikrolokacija, povrsina AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
                    WHERE id = '".$popis['idNekretnine']."'";
        } else if ( $tbl = "vivoturizam" ) {
            $uu = "SELECT id, mikrolokacija, povrsina, cvrstiObjektm2 AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
                WHERE id = '".$popis['idNekretnine']."'";
        }else {
            $uu = "SELECT id, mikrolokacija, povrsina, ukupnaPovrsina AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
                WHERE id = '".$popis['idNekretnine']."'";
        }
        $oo = mysql_query ( $uu );
        $pp = mysql_fetch_assoc ( $oo );

        //ovdi ide slika

        if ( $pp['slike'] ) {
            $slika = explode ( ",", $pp['slike'] );
            $uus = "SELECT datoteka FROM slike WHERE id = '".$slika[0]."'";
            $oos = mysql_query ( $uus );
            $slika = mysql_result ( $oos, 0 );

            // provjeri širinu sliku, ako je srednja šira od 150px, koristi malu  /

            list($width, $height) = getimagesize('../slike/srednja'.$slika);
            if ( $width < 150 ) {
                    $slika = '<img src="'.$domena.'/slike/srednja'.$slika.'" width="'.$width.'" height="'.$height.'">';
                } else {
                    $slika = '<img src="'.$domena.'/slike/mala'.$slika.'" width="'.$width.'" height="'.$height.'">';
                }
        }

        // županija         /

        $u = "SELECT nazivZupanije FROM zupanije WHERE id = '".$pp['zupanija']."'";
        $o = mysql_query ( $u );
        $zupanija = mysql_result ( $o, 0 );

        // grad             /
        $u = "SELECT naziv FROM gradovi WHERE id = '".$pp['grad']."'";
        $o = mysql_query ( $u );
        $grad = mysql_result ( $o, 0 );

        // kvart            /
        $u = "SELECT naziv FROM kvartovi WHERE id = '".$pp['kvart']."'";
        $o = mysql_query ( $u );
        $kvart = mysql_result ( $o , 0 );

        //napravi link na stranicu   /

        $dijelovi = explode ( " ", $grupa['vrsta'] );

            // switch za vrstu ponudu  /

            switch ( $dijelovi[0] )
            {
                case 'stanovi';
                $linkObjekt = "stan";
                break;

                case 'kuće';
                $linkObjekt = "kuca";
                break;

                case 'poslovni';
                $linkObjekt = "poslovni";
                break;

                case 'zemljišta';
                $linkObjekt = "zemljiste";
                break;

                case 'ostalo';
                $linkObjekt = "ostalo";
                break;

                case 'turistički';
                $linkObjekt = "turizam";
                break;

            }

            $link = '<a href="'.$domena.'/hr/'.$dijelovi[1].'/'.$linkObjekt.'/detalji_'.$pp['id'].'.html" style="background-color: #'.$pozadinalinka.'; color: #'.$bojalinka.'; padding: 5px; text-decoration: none;"><b>kliknite na link</b></a>';


        //                  /
        //   složi poruku   /
        //                  /

        $sredina = $sredina.'
        <table width="550" cellspacing="0" cellpadding="10" border="0" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td width="150">'.$slika.'
                            </td>
                            <td width="400">
                            '.$zupanija.' / '.$grad.' / '.$kvart.'<br>
                            '.$grupa['vrsta'].' / '.$grupa['naziv'].'<br>
                            '.$pp['povrsina'].' m2<br>
                            '.$pp['cijena'].' &euro;<br><br>
                            '.$link.'<br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr width="500"></td>
                        </tr>
                    </tbody>
                    </table>';

                    }



        $poruka = $gornjidio.$sredina.$donjidio;

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8 ' . "\r\n";
        $headers .= 'From: '.$frommaila. "\r\n";
        $headers .= 'Reply-to: '.$replytomaila . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion()."\r\n";
        $headers .= "date: ".date("D, d M Y H:i:s") . " UT\r\n";

        $uuK = "SELECT email FROM ".$klTabela." WHERE id = '".$popis['idKlijenta']."'";
        $ooK = mysql_query ( $uuK );
        $klijent = mysql_result ( $ooK, 0 );

        mail ( $klijent, $_POST['subject'], $poruka, $headers );

        $upitKraj = "UPDATE ".$tabela." SET email = '".$klijent."', datum = NOW() WHERE  id = '".$popis['id']."'";
        mysql_query ( $upitKraj ) or die ( '+' );

        echo 'Ponuda poslana klijentu id:',$popis['idKlijenta'],' (',$klijent,')<br>';

    }



} else {


// izvadi radniID iz kontrolera, pa uhvati mail adresu klijenta  /
$upit = "SELECT radniID, pomocni FROM kontroler WHERE idsess = '".session_id()."'";
$odgovori = mysql_query ( $upit );
$kl = mysql_fetch_assoc ( $odgovori );

// ovaj IF u suradnji sa poništavanjem polja "pomoci" dole  /
// bi trebao sprječiti da puni email polje kod dolazi sa    /
// popisa nekretnina                                        /

if ( $kl['pomocni'] ) {
    $upit = "SELECT email FROM ".$kl['pomocni']." WHERE id = '".$kl['radniID']."'";
    $odgovori = mysql_query ( $upit );
    $email = mysql_result ( $odgovori, 0 );
}
$upit = "UPDATE kontroler SET pomocni = '0' WHERE idsess = '".session_id()."'";
mysql_query ( $upit );

// unošenje e-mail adrese za slanje   /
?>

    <form id="formSlanjePonude" name="formSlanjePonude" method="POST" action="/vivo2/0/0/0/0/slanje=1">
    <div id="dohvatiEmailKlijenata"><label for="email">e-mail adresa</label><input name="email" type="text" size="30" value="<?php echo $email; ?>">    <a href="">dohvati e-mail adrese klijenata</a></div>
    <div><label for="subject">tema / naslov poruke</label><input name="subject" type="text" size="30"></div>
    <div><label for="tekst">tekst poruke</label><textarea name="tekst" class="dodajEditor"></textarea></div>
    <button type="submit" class="submitButton greenButton">pošalji</button>
    </form>

<?php

// obrada mail poruke i slanje      /

if ( $_GET['slanje'] ) {

$sredina = '<table width="550" cellspacing="0" cellpadding="10" border="0" bgcolor="#ffffff">
                <tbody>
                        <tr>
                            <td>'.$_POST['tekst'].'
                            <hr width="500">
                            </td>
                        </tr>
                    </tbody>
                    </table>';

$upit = "SELECT * FROM ".$tabela." WHERE email = '0' AND idsess = '".session_id()."'";
$odgovori = mysql_query ( $upit );
while ( $popis = mysql_fetch_assoc ( $odgovori )) {

    $tbl = $popis['tabela'];

    // upit o nekretnini       /
    if ( $tbl == "vivozemljista" OR $tbl == "vivoostalo" ) {
            $uu = "SELECT id, mikrolokacija, povrsina AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
            WHERE id = '".$popis['idNekretnine']."'";
        } else if ( $tbl == "vivoturizam" ) {
            $uu = "SELECT id, mikrolokacija, povrsina, cvrstiObjektm2 AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
                WHERE id = '".$popis['idNekretnine']."'";
        }else {
            $uu = "SELECT id, mikrolokacija, povrsina, ukupnaPovrsina AS povrsina, cijena, zupanija, kvart, grad, slike, grupa FROM ".$tbl."
                WHERE id = '".$popis['idNekretnine']."'";
        }
        $oo = mysql_query ( $uu );
        $pp = mysql_fetch_assoc ( $oo );

        //ovdi ide slika

        if ( $pp['slike'] ) {
            $slika = explode ( ",", $pp['slike'] );
            $uus = "SELECT datoteka FROM slike WHERE id = '".$slika[0]."'";
            $oos = mysql_query ( $uus );
            $slika = mysql_result ( $oos, 0 );

            // provjeri širinu sliku, ako je srednja šira od 150px, koristi malu  /

            list($width, $height) = getimagesize('../slike/srednja'.$slika);
            if ( $width < 150 ) {
                    $slika = '<img src="'.$domena.'/slike/srednja'.$slika.'" width="'.$width.'" height="'.$height.'">';
                } else {
                    $slika = '<img src="'.$domena.'/slike/mala'.$slika.'" width="'.$width.'" height="'.$height.'">';
                }
        }             

        // županija         /
        $u = "SELECT nazivZupanije FROM zupanije WHERE id = '".$pp['zupanija']."'";
        $o = mysql_query ( $u );
        $zupanija = mysql_result ( $o, 0 );

        // grad             /
        $u = "SELECT naziv FROM gradovi WHERE id = '".$pp['grad']."'";
        $o = mysql_query ( $u );
        $grad = mysql_result ( $o, 0 );

        // kvart            /
        $u = "SELECT naziv FROM kvartovi WHERE id = '".$pp['kvart']."'";
        $o = mysql_query ( $u );
        $kvart = mysql_result ( $o , 0 );

        // provjeri grupu i prema njoj odredi stranicu
        $uuu = "SELECT * FROM grupe WHERE id = '".$pp['grupa']."'";
        $ooo = mysql_query ( $uuu );
        $grupa = mysql_fetch_assoc ( $ooo );

        //napravi link na stranicu   /

        $dijelovi = explode ( " ", $grupa['vrsta'] );

            // switch za vrstu ponudu  /

            switch ( $dijelovi[0] )
            {
                case 'stanovi';
                $linkObjekt = "stan";
                break;

                case 'kuće';
                $linkObjekt = "kuca";
                break;

                case 'poslovni';
                $linkObjekt = "poslovni";
                break;

                case 'zemljišta';
                $linkObjekt = "zemljiste";
                break;

                case 'ostalo';
                $linkObjekt = "ostalo";
                break;

                case 'turistički';
                $linkObjekt = "turizam";
                break;

            }

            $link = '<a href="'.$domena.'/hr/'.$dijelovi[1].'/'.$linkObjekt.'/detalji_'.$pp['id'].'.html" style="background-color: #'.$pozadinalinka.'; color: #'.$bojalinka.'; padding: 5px; text-decoration: none;"><b>kliknite na link</b></a>';


        //                  /
        //   složi poruku   /
        //                  /

        $sredina = $sredina.'
        <table width="550" cellspacing="0" cellpadding="10" border="0" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td width="150">'.$slika.'
                            </td>
                            <td width="400">
                            '.$zupanija.' / '.$grad.' / '.$kvart.'<br>
                            '.$grupa['vrsta'].' / '.$grupa['naziv'].'<br>
                            '.$pp['povrsina'].' m2<br>
                            '.$pp['cijena'].' &euro;<br><br>
                            '.$link.'<br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr width="500"></td>
                        </tr>
                    </tbody>
                    </table>';

                    }


    $poruka = $gornjidio.$sredina.$donjidio;

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8 ' . "\r\n";
    $headers .= 'From: '.$frommaila. "\r\n";
    $headers .= 'Reply-to: '.$replytomaila . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion()."\r\n";
    $headers .= "date: ".date("D, d M Y H:i:s") . " UT\r\n";

    mail ( $_POST['email'], $_POST['subject'], $poruka, $headers );

    $mysqltime = date ("Y-m-d H:i:s", $phptime);
    $upit = "UPDATE ".$tabela." SET email = '".$_POST['email']."', datum = NOW() WHERE  email = '0' AND idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );

    }

    }

?>

