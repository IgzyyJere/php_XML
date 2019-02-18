<?php

session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: VIVOcms ::</title>
<link href="vivoprint.css" rel="stylesheet" type="text/css" media="all">
</head>
<body onLoad="window.print()">

<?php

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL ^ E_NOTICE);

include ( "../vivoFunkcije/baza.php" );
include ( "../vivoFunkcije/definicijePolja.php" );
mysql_query ("set names utf8");


$upit = "SELECT * FROM kontroler WHERE idsess='".session_id()."'";
$odgovori = mysql_query ( $upit );
$tabla = mysql_fetch_assoc ( $odgovori );

include ( "../vivoAplikacije/switchTabela.php" );

if ( $tabela == "vivozemljista" OR $tabela == "vivoostalo" ) {

    $upit = "SELECT id, mikrolokacija, povrsina, cijena, aktivno, kvart
            FROM ".$tabela."
            WHERE grupa = '".$tabla['grupa']."'
            AND ( obrisano IS NULL OR obrisano = '0' )
            AND ( arhiva IS NULL OR arhiva = '0' )
            ORDER BY id DESC";

} else {

    $upit = "SELECT glavno.id, glavno.mikrolokacija, glavno.ukupnaPovrsina, glavno.cijena, glavno.aktivno, glavno.kvart, glavno.lift, glavno.balkonOption, glavno.grijanje, glavno.parking, glavno.brojSoba, kvart.naziv
            FROM ".$tabela." glavno
            INNER JOIN kvartovi kvart
            ON glavno.kvart = kvart.id
            WHERE glavno.grupa = '".$tabla['grupa']."'
            AND ( glavno.obrisano IS NULL OR glavno.obrisano = '0' )
            AND ( glavno.arhiva IS NULL OR glavno.arhiva = '0' )
            ORDER BY id DESC";

}

echo '<div id="listaZaIspis">';

echo '<table width="900" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="250">Lokacija</td>
        <td width="90">Površina</td>
        <td width="90">Cijena</td>
        <td width="90">Broj soba</td>
        <td width="90">Balkon</td>
        <td width="90">Parking</td>
        <td width="90">Grijanje</td>
        <td width="90">Lift</td>
        </tr>';

$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    echo '<tr>';

    echo '<td>';
    echo $podaci['mikrolokacija'],' / ',$podaci['naziv'];
    echo '</td>';

    echo '<td>';
    if ( $podaci['ukupnaPovrsina'] ) {

        echo $podaci['ukupnaPovrsina'],' m<sup>2</sup>';

    }

    if ( $podaci['povrsina'] ) {

        echo $podaci['povrsina'],' m<sup>2</sup>';

    }
    echo '</td>';

    echo '<td>';
    if ( $podaci['cijena'] ) {

        echo $podaci['cijena'],' &euro;';

    } else {

    echo '-';

    }
    echo '</td>';

    echo '<td>';
    if ( $podaci['brojSoba'] ) {

        echo $podaci['brojSoba'];

    } else {

    echo '-';

    }
    echo '</td>';

    echo '<td>';
    if ( $podaci['balkonOption'] ) {

        echo '+';

    } else {

    echo '-';

    }
    echo '</td>';

    echo '<td>';
    if ( $podaci['parking'] ) {

        multiRadioPrikaz ( "Parking", $podaci['parking'], 1 );

    } else {

    echo '-';

    }
    echo '</td>';


    echo '<td>';
    if ( $podaci['grijanje'] ) {

        selectPrikaz ( "Grijanje", $podaci['grijanje'], 1 );

    } else {

    echo '-';

    }
    echo '</td>';

    echo '<td>';
    if ( $podaci['lift'] ) {

        echo '+';

    } else {

    echo '-';

    }
    echo '</td>';


    echo'</tr>';

}

echo '</table>';

function multiRadioPrikaz ( $naziv, $podaci, $br )

{

    $opcije = dajPolje ( $naziv );

    if ( $podaci ) {

        if ( $podaci == 1 AND ( $opcije[1] == "ima" OR $opcije[1] == "Ima" ) ) {

        if ( $br == 1 ) {

            echo '<br />';

        } else if ( $br == 0 ) {

            echo ', ';

        }

        } else {

            echo $opcije[$podaci];

        if ( $br == 1 ) {

            echo '<br />';

        } else if ( $br == 0 ) {

            echo ', ';

        }

        }

    }

}

function selectPrikaz ( $naziv, $podaci, $br )

{

    $array = dajPolje ( $naziv );

    if ( $podaci ) {



        echo  $array[$podaci];

        if ( $br == 1 ) {

            echo '<br />';

        } else if ( $br == 0 ) {

            echo ', ';

        }

    }


}

session_write_close();

?>
</div>
</body>
</html>

