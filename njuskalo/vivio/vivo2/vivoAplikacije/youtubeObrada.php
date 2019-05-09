<?php

session_start();

include ( '../vivoFunkcije/baza.php' );
mysql_query ("set names utf8");

$url = parse_url ( $_POST['youtube'] );

$youtube = explode ( "&", $url['query'] );
$youtube = substr ( $youtube[0], 2 );

// upis podataka u bazu podataka    /
    // prvo saznati na kojoj smo stranici   /
    $upit = "SELECT stranica FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $stranica = mysql_result ( $odgovori, 0 );

    // saznati tabelu u koju unosimo promjene    /
    require ( 'switchTabela.php' );

    // vrati aktivni ID         /
    $upit = "SELECT akcija FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $akcija = mysql_result ( $odgovori, 0 );
    if ( $akcija == "unos" ) {
        $upit = "SELECT lastID FROM `kontroler` WHERE idsess = '".session_id()."'";
    }
    if ( $akcija == "izmjena" ) {
        $upit = "SELECT radniID FROM `kontroler` WHERE idsess = '".session_id()."'";
    }
    $odgovori = mysql_query ( $upit );
    $id = mysql_result ( $odgovori, 0);

    // konačno unesi podatke u polje "youtube" u tabeli   /
    $upit = "UPDATE `".$tabela."` SET `youtube` = '".$youtube."' WHERE `id` = '".$id."'";
    mysql_query ( $upit );

?>

<object width="580" height="360"><param name="movie" value="http://www.youtube.com/v/<?php echo $youtube;  ?>&hl=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?php echo $youtube;  ?>&hl=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="580" height="360"></embed></object>
