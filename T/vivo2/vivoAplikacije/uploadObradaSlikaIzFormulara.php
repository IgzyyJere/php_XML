<?php

//odredi novo ime za slike, provjera u bazi   /

$upit = "SELECT * FROM slike ORDER BY id DESC LIMIT 0,1";
$odgovori = mysql_query ( $upit ) or die ('hm');
$id = mysql_result ( $odgovori, 0 );
$novoIme = 1000001 + $id.".".ekstenzijaDatoteke ($datoteka);

if ( file_exists( "../../slike/".$novoIme )) {
      $novoIme = generateRandomString().".".ekstenzijaDatoteke ($datoteka);
}


// prebaci datoteku iz /upload u /slike     /
copy ( $targetFile, "../../slike/".$novoIme );
// obriši original, nema potrebe da stoji tamo   /
unlink ( $targetFile );

// dimenzije datoteke         /
list ( $sirina, $visina ) = getimagesize ( "../../slike/".$novoIme );

// aplikacija watermarka    /
if ( file_exists('../vivoDiff/bezwatermarka.php')) {
    require ('../vivoDiff/bezwatermarka.php');
    // provjeri iz kontrolera sa koje stranice se poziva uplaod slika
    $u = "SELECT stranica FROM kontroler WHERE idsess = '".$session."'";
    $o = mysql_query ( $u );
    $str = mysql_result ( $o, 0 );
    // ako nije u popisu, dodaj watermark  /
    // ako je, preskoèi :))))              /
    if ( !in_array ($str, $iskljuciwatermark) ){
        $watermark = imagecreatefrompng ('../vivoDiff/watermark.png');
        $watermark_sirina = imagesx($watermark);
        $watermark_visina = imagesy($watermark);
        $watermark_slika = imagecreatefromjpeg(  "../../slike/".$novoIme );
        imagealphablending($watermark_slika, TRUE);
        $mark_mjesto_x = ( $sirina / 2 )  - ( $watermark_sirina / 2 );
        $mark_mjesto_y = ( $visina / 2 ) - ( $watermark_visina / 2 );
        imagecopy($watermark_slika, $watermark, $mark_mjesto_x, $mark_mjesto_y, 0, 0, $watermark_sirina, $watermark_visina);
        imagejpeg ( $watermark_slika, "../../slike/".$novoIme );
    }
} else {
    $watermark = imagecreatefrompng ('../vivoDiff/watermark.png');
    $watermark_sirina = imagesx($watermark);
    $watermark_visina = imagesy($watermark);
    $watermark_slika = imagecreatefromjpeg(  "../../slike/".$novoIme );
    imagealphablending($watermark_slika, TRUE);
    $mark_mjesto_x = ( $sirina / 2 )  - ( $watermark_sirina / 2 );
    $mark_mjesto_y = ( $visina / 2 ) - ( $watermark_visina / 2 );
    imagecopy($watermark_slika, $watermark, $mark_mjesto_x, $mark_mjesto_y, 0, 0, $watermark_sirina, $watermark_visina);
    imagejpeg ( $watermark_slika, "../../slike/".$novoIme );
}

require ( '../vivoDiff/izradaThumbova.php' );

// upis podataka u bazu podataka    /
    // prvo saznati na kojoj smo stranici   /
    $u = "SELECT * FROM kontroler WHERE idsess = '".$session."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );

    $akcija = $p['akcija'];

    if ( $akcija == "izmjena" ) {
        $stranica = $p['stranica'];
        $id = $p['radniID'];
        require ( "switchTabela.php" );
    }
    if ( $akcija == "unos" ) {
        // tabela je kontroler, pošto podatke privremeno spremamo /
        // do unos klasiènim putem (upravljanje datotekama je dio /
        // formulara)                                             /
        $tabela = "kontroler";

    }

    // upis u tabelu "slike"    /
    $upit = "INSERT INTO `slike`
            ( `datoteka`, `vrsta` )
            VALUES
            ( '".$novoIme."', '".ekstenzijaDatoteke ($datoteka)."' )";
    mysql_query ( $upit );
    $idSlike = mysql_insert_id();

    // provjera jel INSERT ili UPDATE     /
    if ( $akcija == "izmjena" ) {
        $upit = "SELECT slike FROM ".$tabela." WHERE id = '".$p['radniID']."'";
    }
    if ( $akcija == "unos" ){
        $upit = "SELECT uploadGalerija FROM ".$tabela." WHERE idsess = '".$session."'";
    }
    $odgovori = mysql_query ( $upit );
    $galerija = mysql_result ( $odgovori, 0 );
    if ( $galerija ) {
        $slike = $galerija.",".$idSlike;
    } else {
        $slike = $idSlike;
    }

    // konaèno unesi podatke u polje "slike" u tabeli   /
    if ( $akcija == "izmjena" ) {
        $upit = "UPDATE ".$tabela." SET slike = '".$slike."' WHERE `id` = '".$id."'";
    }
    if ( $akcija == "unos" ){
        $upit = "UPDATE ".$tabela." SET uploadGalerija = '".$slike."' WHERE idsess = '".$session."'";
    }
    mysql_query ( $upit );


?>