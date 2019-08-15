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
    $u = "SELECT * FROM kontroler WHERE idsess = '".$session."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );

    if ( $p['akcija'] == "izmjena" ) {
        $stranica = $p['stranica'];
        $akcija = $p['akcija'];
        $id = $p['radniID'];
        require ( "switchTabela.php" );
    }
    if ( $p['akcija'] == "unos" ) {
        // tabela je kontroler, pošto podatke privremeno spremamo /
        // do unos klasiènim putem (upravljanje datotekama je dio /
        // formulara)                                             /
        $tabela = "kontroler";

    }

    // upis u tabelu "datoteke"    /
    $upit = "INSERT INTO `datoteke`
            ( `datoteka`, `vrsta` )
            VALUES
            ( '".$novoIme."', '".ekstenzijaDatoteke ($datoteka)."' )";
    mysql_query ( $upit );
    $idDatoteke = mysql_insert_id();

    // provjera jel INSERT ili UPDATE     /
    if ( $akcija == "izmjena" ) {
        $upit = "SELECT datoteke FROM ".$tabela." WHERE id = '".$p['radniID']."'";
    }
    if ( $akcija == "unos" ){
        $upit = "SELECT uploadDatoteke FROM ".$tabela." WHERE idsess = '".$session."'";
    }
    $odgovori = mysql_query ( $upit );
    $popis = mysql_result ( $odgovori, 0 );
    if ( $popis ) {
        $dat = $popis.",".$idDatoteke;
    } else {
        $dat = $idDatoteke;
    }

    // konaèno unesi podatke u polje "datoteke" u tabeli   /
    if ( $akcija == "izmjena" ) {
        $upit = "UPDATE ".$tabela." SET datoteke = '".$dat."' WHERE `id` = '".$id."'";
    }
    if ( $akcija == "unos" ){
        $upit = "UPDATE ".$tabela." SET uploadDatoteke = '".$dat."' WHERE idsess = '".$session."'";
    }
    mysql_query ( $upit );

?>