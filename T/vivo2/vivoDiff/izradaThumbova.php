<?php
// izrada thumbnailova     /

// određivanje dimanzija nove slike da bi se        /
// zadržale proporcije prilikom promjene veličine   /

if ($sirina > $visina) {
    $nova_sirina = 120;
    $nova_visina = $nova_sirina / ( $sirina / $visina );
}
else if ($sirina < $visina) {
    $nova_visina = 90;
    $nova_sirina = ( $sirina * $nova_visina ) / $visina;
}
else if ($sirina == $visina) {
    $nova_sirina = 90;
    $nova_visina = 90;
}

$velika_slika = imagecreatefromjpeg ( "../../slike/".$novoIme ) or die ('1');
$ime = "mala".$novoIme;
$mala_slika = imagecreatetruecolor ( $nova_sirina, $nova_visina ) or die ('2');
imagecopyresampled ( $mala_slika, $velika_slika, 0,0,0,0, $nova_sirina, $nova_visina, $sirina, $visina ) or die ('3');
imagejpeg ( $mala_slika, "../../slike/".$ime ) or die ('4');

// izrada srednjih slika     /

// odre?ivanje dimanzija nove slike da bi se        /
// zadr?ale proporcije prilikom promjene veli?ine   /

if ($sirina > $visina) {
    $nova_sirina = 170;
    $nova_visina = $nova_sirina / ( $sirina / $visina );
}
else if ($sirina < $visina) {
    $nova_visina = 120;
    $nova_sirina = ( $sirina * $nova_visina ) / $visina;
}
else if ($sirina == $visina) {
    $nova_sirina = 120;
    $nova_visina = 120;
}

$velika_slika = imagecreatefromjpeg ( "../../slike/".$novoIme ) or die ('1');
$ime = "srednja".$novoIme;
$mala_slika = imagecreatetruecolor ( $nova_sirina, $nova_visina ) or die ('2');
imagecopyresampled ( $mala_slika, $velika_slika, 0,0,0,0, $nova_sirina, $nova_visina, $sirina, $visina ) or die ('3');
imagejpeg ( $mala_slika, "../../slike/".$ime ) or die ('4');

?>