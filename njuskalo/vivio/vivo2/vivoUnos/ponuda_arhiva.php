<?php


$tabela = "popiszaslanje";

//                        /
//određivanje paginacije  /
//                        /

$poStranici = 50;
$padding = 3;
$sqlUkupno = "SELECT COUNT(DISTINCT email) FROM ".$tabela." ORDER BY id DESC";
$sqlOdgovor = mysql_query ( $sqlUkupno );
$ukupnoPodataka = mysql_result ( $sqlOdgovor, 0 );
$paginacija = ( $ukupnoPodataka > $poStranici ) ? true : false;

if ( $_GET['kreni'] ) {
    $startIndex = ($_GET['kreni'] * $poStranici) - $poStranici;
} else {
  $startIndex = 0;
  $_GET['kreni'] = 1;
}

include ( 'vivoIncludes/pagination.php' );

$upit = "SELECT DISTINCT email FROM ".$tabela." ORDER BY datum DESC LIMIT ".$startIndex.",".$poStranici."";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }

    $uu = "(SELECT imeIPrezime FROM klijentikuce WHERE email ='".$podaci['email']."')
        UNION (SELECT imeIPrezime FROM klijentiposlovni WHERE email ='".$podaci['email']."')
        UNION (SELECT imeIPrezime FROM klijentistanovi WHERE email ='".$podaci['email']."')
        UNION (SELECT imeIPrezime FROM klijentizemljista WHERE email ='".$podaci['email']."')
        UNION (SELECT imeIPrezime FROM klijentiostalo WHERE email ='".$podaci['email']."')
        UNION (SELECT imeIPrezime FROM klijentiturizam WHERE email ='".$podaci['email']."')";
    $oo = mysql_query ( $uu );
    $podi = mysql_fetch_assoc ( $oo );


    echo '<div class="',$back,' prikazFormLine">
            <div class="prikazLineLeft">
                <a href="/vivo2/0/0/detalji/0/mail=',$podaci['email'],'" class="smallButton smallBlue">Prikaži</a>
            </div>

            <div class="prikazLineRight">',$podi['imeIPrezime'],' - ',$podaci['email'],'</div>';
    echo '</div>
            ';

    $tabela = 0;
    $ime = '';

    $i++;

}


?>
