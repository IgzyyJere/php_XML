<?php

if ( $id == 1 OR $id == 2 OR $id == 4  ){

    $popisTabela = array ( 1 => "vivostanovi",
                           2 => "vivoposlovni",
                           3 => "vivokuce",
                           4 => "vivozemljista",
                           5 => "vivoostalo",
                           6 => "vivoturizam" );

    switch ( $id )
    {
        case "1":
        $polje = "imeIPrezime";
        break;

        case "2":
        $polje = "mikrolokacija";
        break;

        case "4":
        $polje = "adresa";
        break;

    }


    foreach ( $popisTabela as $naziv ) {

        $upit = "SELECT id, grupa, mikrolokacija, imeIPrezime, adresa FROM ".$naziv." WHERE ".$polje." LIKE '%".$_POST['upit']."%'";
        $odgovori = mysql_query ( $upit );
        while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
            $uu = "SELECT vrsta FROM grupe WHERE id = '".$podaci['grupa']."'";
            $oo = mysql_query ( $uu );
            $vrsta = mysql_result ( $oo, 0 );

            switch ( $naziv ) {

                case 'vivostanovi':
                $slovo = "s";
                break;

                case 'vivoposlovni':
                $slovo = "p";
                break;

                case 'vivokuce':
                $slovo = "k";
                break;

                case 'vivozemljista':
                $slovo = "z";
                break;

                case 'vivoostalo':
                $slovo = "o";
                break;

                case 'vivoturizam':
                $slovo = "t";
                break;

                }

            switch ( $vrsta ){

            case "stanovi prodaja";
            $link = "/vivo2/prodaja/stan_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "stanovi najam";
            $link = "/vivo2/prodaja/stan_najam/izmjena/".$podaci['id']."/";
            break;

            case "poslovni prodaja";
            $link = "/vivo2/prodaja/posl_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "poslovni najam";
            $link = "/vivo2/prodaja/posl_najam/izmjena/".$podaci['id']."/";
            break;

            case "kuæe prodaja";
            $link = "/vivo2/prodaja/kuce_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "kuæe najam";
            $link = "/vivo2/prodaja/kuce_najam/izmjena/".$podaci['id']."/";
            break;

            case "zemljišta prodaja";
            $link = "/vivo2/prodaja/zem_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "zemljišta najam";
            $link = "/vivo2/prodaja/zem_najam/izmjena/".$podaci['id']."/";
            break;

            case "ostalo prodaja";
            $link = "/vivo2/prodaja/ost_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "ostalo najam";
            $link = "/vivo2/prodaja/ost_najam/izmjena/".$podaci['id']."/";
            break;

            case "turistièki prodaja";
            $link = "/vivo2/prodaja/turizam_prodaja/izmjena/".$podaci['id']."/";
            break;

            case "turistièki najam";
            $link = "/vivo2/prodaja/turizam_najam/izmjena/".$podaci['id']."/";
            break;

            }

            if ( $i % 2 ) {
                $back = "darkLine";
                } else {
                $back = "lightLine";
                }

        echo '<a href="',$link,'" class="',$back,' linkDaljeSearch"><b>',$slovo,$podaci['id'],'</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ulica: <b>',$podaci['mikrolokacija'],'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ime i prezime: <b>',$podaci['imeIPrezime'],'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; adresa (pov): <b>',$podaci['adresa'],'</b></a>';
             $i++;
    }
}
}

if ( $id == 3 ){

    $popisTabela = array ( 1 => "klijentistanovi",
                           2 => "klijentiposlovni",
                           3 => "klijentikuce",
                           4 => "klijentizemljista",
                           5 => "klijentiostalo",
                           6 => "klijentiturizam" );

    foreach ( $popisTabela as $naziv ) {

        $upit = "SELECT id, grupa, imeIPrezime FROM ".$naziv." WHERE imeIPrezime LIKE '%".$_POST['upit']."%'";
        $odgovori = mysql_query ( $upit );
        while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
            switch ( $podaci['grupa'] )
            {
                case "1":
                $vrs = "prodaja";
                break;

                case "2":
                $vrs = "najam";
                break;
            }

            switch ( $naziv ){

            case "klijentistanovi";
            $link = "/vivo2/prodaja/kl_stan_".$vrs."/izmjena/".$podaci['id']."/";
            break;

            case "klijentiposlovni";
            $link = "/vivo2/prodaja/kl_posl_".$vrs."/izmjena/".$podaci['id']."/";
            break;

            case "klijentikuce";
            $link = "/vivo2/prodaja/kl_kuce_".$vrs."/izmjena/".$podaci['id']."/";
            break;

            case "klijentizemljista";
            $link = "/vivo2/prodaja/kl_zem_".$vrs."/izmjena/".$podaci['id']."/";
            break;

            case "klijentiostalo";
            $link = "/vivo2/prodaja/kl_ost_".$vrs."/izmjena/".$podaci['id']."/";
            break;

            case "klijentiturizam";
            $link = "/vivo2/prodaja/kl_turizam_".$vrs."/izmjena/".$podaci['id']."/";
            break;




            }



            if ( $i % 2 ) {
                $back = "darkLine";
                } else {
                $back = "lightLine";
                }

            echo '<a href="',$link,'" class="',$back,' linkDaljeSearch">ime i prezime: <b>',$podaci['imeIPrezime'],'</b></a>';

            $i++;
        }
    }
}
?>