<?php

//odredi novo ime za datoteke, provjera u bazi   /

$upit = "SELECT * FROM datoteke ORDER BY id DESC LIMIT 0,1";
$odgovori = mysql_query ( $upit ) or die ('hm');
$id = mysql_result ( $odgovori, 0 );
$novoIme = 1000001 + $id.".".ekstenzijaDatoteke ($datoteka);

if ( file_exists( "../../datoteke/".$novoIme )) {
      $novoIme = generateRandomString().".".ekstenzijaDatoteke ($datoteka);
}


// prebaci datoteku iz /upload u /datoteke    /
copy ( $targetFile, "../../datoteke/".$novoIme );
// obriši original, nema potrebe da stoji tamo   /
unlink ( $targetFile );


// upis podataka u bazu podataka    /
    // prvo saznati na kojoj smo stranici   /
    $upit = "SELECT stranica, akcija FROM `kontroler` WHERE idsess = '".$session."'";
    $odgovori = mysql_query ( $upit );
    $p = mysql_fetch_assoc ( $odgovori );
    $stranica = $p['stranica'];
    $akcija = $p['akcija'];

    // saznati tabelu u koju unosimo promjene    /
    require ( 'switchTabela.php' );

    // upis u tabelu "datoteke"    /
    $upit = "INSERT INTO `datoteke`
            ( `datoteka`, `vrsta` )
            VALUES
            ( '".$novoIme."', '".ekstenzijaDatoteke ($datoteka)."' )";
    mysql_query ( $upit );
    $idDatoteke = mysql_insert_id();

    // provjera jel INSERT ili UPDATE     /
    $upit = "SELECT akcija FROM `kontroler` WHERE idsess = '".$session."'";
    $odgovori = mysql_query ( $upit );
    $akcija = mysql_result ( $odgovori, 0 );
    if ( $akcija == "unos" ) {
        $upit = "SELECT lastID FROM `kontroler` WHERE idsess = '".$session."'";
    }
    if ( $akcija == "izmjena" ) {
        $upit = "SELECT radniID FROM `kontroler` WHERE idsess = '".$session."'";
    }
    $odgovori = mysql_query ( $upit );
    $id = mysql_result ( $odgovori, 0);

    // provjeri jel veæ ima datoteka    /
    $upit = "SELECT datoteke FROM ".$tabela." WHERE id = '".$id."'";
    $odgovori = mysql_query ( $upit );
    $popis = mysql_result ( $odgovori, 0 );
    if ( $popis ) {
        $dat = $popis.",".$idDatoteke;
    } else {
        $dat = $idDatoteke;
    }

    // konaèno unesi podatke u polje "datoteke" u tabeli   /
    $upit = "UPDATE `".$tabela."` SET `datoteke` = '".$dat."' WHERE `id` = '".$id."'";
    mysql_query ( $upit );

?>