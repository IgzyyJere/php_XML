<?php

ini_set('display_errors','1');

ini_set('display_startup_errors','1');

error_reporting (E_ALL ^ E_NOTICE);


//odredi novo ime za slike, provjera u bazi   /

$session = $_POST['session'];


$upit = "SELECT * FROM slike ORDER BY id DESC LIMIT 0,1";

$odgovori = mysql_query ( $upit ) or die ('hm');

$id = mysql_result ( $odgovori, 0 );

$novoIme = 1000001 + $id.".".ekstenzijaDatoteke ($datoteka);



if ( file_exists( "../../slike/".$novoIme )) {

      $novoIme = generateRandomString().".".ekstenzijaDatoteke ($datoteka);

}



// prebaci datoteku iz /upload u /slike     /

copy ( "../../upload/".$datoteka, "../../slike/".$novoIme ) or die ( 'Prebacivanje slika nije uspijelo');

// obriši original, nema potrebe da stoji tamo   /

unlink ( "../../upload/".$datoteka );



// dimenzije datoteke         /

list ( $sirina, $visina ) = getimagesize ( "../../slike/".$novoIme );


print_r($list);


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

    $upit = "SELECT stranica, akcija FROM kontroler WHERE idsess = '".$session."'";

    $odgovori = mysql_query ( $upit );

    $p = mysql_fetch_assoc ( $odgovori );

    $stranica = $p['stranica'];

    $akcija = $p['akcija'];



    // saznati tabelu u koju unosimo promjene    /

    require ( 'switchTabela.php' );



    // upis u tabelu "slike"    /

    $upit = "INSERT INTO slike

            ( datoteka, vrsta )

            VALUES

            ( '".$novoIme."', '".ekstenzijaDatoteke ($datoteka)."' )";

    mysql_query ( $upit );

    $idSlike = mysql_insert_id();



    // provjera jel INSERT ili UPDATE     /

    $upit = "SELECT akcija FROM kontroler WHERE idsess = '".$session."'";

    $odgovori = mysql_query ( $upit );

    $akcija = mysql_result ( $odgovori, 0 );
    echo $upit;

    if ( $akcija == "unos" ) {

        $upit = "SELECT lastID FROM kontroler WHERE idsess = '".$session."'";

    }

    if ( $akcija == "izmjena" ) {

        $upit = "SELECT radniID FROM kontroler WHERE idsess = '".$session."'";

    }

    $odgovori = mysql_query ( $upit );

    $id = mysql_result ( $odgovori, 0);



    // provjeri jel veæ ima slika     /

    $upit = "SELECT slike FROM ".$tabela." WHERE id = '".$id."'";

    $odgovori = mysql_query ( $upit );

    $galerija = mysql_result ( $odgovori, 0 );

    if ( $galerija ) {

        $slike = $galerija.",".$idSlike;

    } else {

        $slike = $idSlike;

    }



    // konaèno unesi podatke u polje "slike" u tabeli   /

    $upit = "UPDATE ".$tabela." SET slike = '".$slike."' WHERE id = '".$id."'";

    mysql_query ( $upit );

?>