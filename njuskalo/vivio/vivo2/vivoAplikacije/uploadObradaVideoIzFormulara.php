<?php

//odredi novo ime za datoteke, provjera u bazi   /

$upit = "SELECT * FROM datoteke ORDER BY id DESC LIMIT 0,1";
$odgovori = mysql_query ( $upit ) or die ('hm');
$id = mysql_result ( $odgovori, 0 );
$novoIme = 1000001 + $id.".".ekstenzijaDatoteke ($datoteka);

if ( file_exists( "../../video/".$novoIme )) {
      $novoIme = generateRandomString().".".ekstenzijaDatoteke ($datoteka);
}


// prebaci datoteku iz /upload u /video   /
copy ( $targetFile, "../../video/".$novoIme );
// obri�i original, nema potrebe da stoji tamo   /
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
        // tabela je kontroler, po�to podatke privremeno spremamo /
        // do unos klasi�nim putem (upravljanje datotekama je dio /
        // formulara)                                             /
        $tabela = "kontroler";

    }

    // upis u tabelu "datoteke"    /
    $upit = "INSERT INTO `video`
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
        $upit = "SELECT uploadVideo FROM ".$tabela." WHERE idsess = '".$session."'";
    }
    $odgovori = mysql_query ( $upit );
    $popis = mysql_result ( $odgovori, 0 );
    if ( $popis ) {
        $dat = $popis.",".$idDatoteke;
    } else {
        $dat = $idDatoteke;
    }

    // kona�no unesi podatke u polje "video" u tabeli   /
    if ( $akcija == "izmjena" ) {
        $upit = "UPDATE ".$tabela." SET video = '".$dat."' WHERE `id` = '".$id."'";
    }
    if ( $akcija == "unos" ){
        $upit = "UPDATE ".$tabela." SET uploadVideo = '".$dat."' WHERE idsess = '".$session."'";
    }
    mysql_query ( $upit );


?>