<div style="padding:10px;">Teritorijalne jedinice označene crvenom zastavicom koriste teritorijalnu podjelu iz sustava.<br><br>Ukoliko želite promijeniti teritorijalnu podjelu unutar pojedine teritorijalne jedinice iz popisa, potrebno je uključiti tu opciju klikom na zastavicu.<br>Zelena zastavica znači da se unutar te županije može urediti teritorijalna podjela prema potrebama.<br><br>OPREZ!! Potrebno je dodjeliti sve postojeće teritorijalne jedinice novima!</div>


<?php

$upit = "SELECT * FROM zupanije ORDER BY idRegije";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

    if ( $i % 2 ) {
        $back = "darkLine";
    } else {
        $back = "lightLine";
    }

    echo '<div class="',$back,' prikazFormLine">
            &nbsp;&nbsp;&nbsp;&nbsp;';

    // on / off                   /
    echo '<a href="" title="definiranje loakcija" ref="',$podaci['id'],'" class="onOffLokacije showTooltip">';


    if ( $podaci['lokacije'] ) {

        echo '<img src="/vivo2/ikone/flag_green.png"> ';

    }  else {

        echo '<img src="/vivo2/ikone/flag_red.png"> ';

    }


    echo '</a>';


    echo '&nbsp;&nbsp;&nbsp;&nbsp;
        ',$podaci['nazivZupanije'];



        echo '</div>';

    $i ++;

}

?>

