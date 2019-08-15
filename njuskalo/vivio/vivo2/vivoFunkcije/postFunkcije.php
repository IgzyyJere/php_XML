<?php

function vivoPOSTunos ( $podaci, $tabela, $izuzeci )
{
    foreach ( $podaci as $key => $value ) {
        if ( !in_array ( $key, $izuzeci ) ) {
            $naziviPolja = $naziviPolja.", ".$key."";
            if ( !$value ){ $value = '0'; }
            $vrijednosti = $vrijednosti.", '".$value."'";
        }
    }
    $u = "SELECT stranica, grupa, lastID FROM kontroler WHERE idsess = '".session_id()."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    $grupa = $p['grupa'];
    if ( $p['stranica'] == "novo_stanovi" OR $p['stranica'] == "novo_poslovni" OR $p['stranica'] == "novo_ostalo" OR $p['stranica'] == "novo_kuce" ) {
        $upit = "INSERT INTO
                ".$tabela."
                ( id ".$naziviPolja.", datumUnosa )
                VALUES
                ( '0' ".$vrijednosti.", '".date(DATE_RSS)."' )";
        } else {
        $upit = "INSERT INTO
                ".$tabela."
                ( id, grupa ".$naziviPolja.", datumUnosa )
                VALUES
                ( '0', '".$grupa."' ".$vrijednosti.", '".date(DATE_RSS)."' )";
        }
        mysql_query ( $upit );
        $id = mysql_insert_id();
        $error = mysql_error();
        napraviLog ( 'unos', $error, $upit );

    $uu = "UPDATE
           kontroler
           SET
           lastID = '".$id."'
           WHERE
           idsess = '".session_id()."'";
    mysql_query ( $uu );
    $uu = "UPDATE
           ".$tabela."
           SET
           poredak = '".$id."'
           WHERE
           id = '".$id."'";
    mysql_query ( $uu );
    return $id;
}





function vivoPOSTunosPass ( $podaci, $tabela, $izuzeci )
{
    foreach ( $podaci as $key => $value ) {
        if ( !in_array ( $key, $izuzeci ) ) {
            if ( $key == "password" ) {
              $naziviPolja = $naziviPolja.", passMD5";
              $vrijednosti = $vrijednosti.", '".md5($value)."'";
            }
            elseif ( $key == "username" ) {
               $naziviPolja = $naziviPolja.", username, userMD5";
               $vrijednosti = $vrijednosti.", '".$value."', '".md5($value)."'";
            } else {
                $naziviPolja = $naziviPolja.", ".$key."";
                $vrijednosti = $vrijednosti.", '".$value."'";
            }
        }
    }
    $upit = "INSERT INTO ".$tabela." ( id ".$naziviPolja." ) VALUES ( '0' ".$vrijednosti." )";
    return $upit;
}




function vivoPOSTizmjena ( $podaci, $tabela, $izuzeci, $id )
{
    foreach ( $podaci as $key => $value ) {
        if ( !in_array ( $key, $izuzeci ) ) {
            $dioUpita = $dioUpita."".$key."='".$value."', ";
        }
    }
    $u = "SELECT radniID FROM kontroler WHERE idsess = '".session_id()."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    $upit = "UPDATE ".$tabela." SET ".$dioUpita." datumIzmjene= '".date(DATE_RSS)."' WHERE id=".$p['radniID'];
    $error = mysql_error();
    napraviLog ( 'izmjena', $error, $upit );
    return $upit;
}




function vivoPOSTizmjenaPass ( $podaci, $tabela, $izuzeci, $id )
{
    foreach ( $podaci as $key => $value ) {
        if ( !in_array ( $key, $izuzeci ) ) {
            if ( $key == "password" ) {
              $dioUpita = $dioUpita."passMD5='".md5($value)."', ";

            }
            elseif ( $key == "username" ) {
               $dioUpita = $dioUpita."".$key."='".$value."', userMD5='".md5($value)."', ";
               $i++;
            } else {
                $dioUpita = $dioUpita."".$key."='".$value."', ";
            }
        }
    }
    $dioUpita = substr_replace ( $dioUpita, "", strlen ($dioUpita) -2 );
    $u = "SELECT radniID FROM kontroler WHERE idsess = '".session_id()."'";
    $o = mysql_query ( $u );
    $p = mysql_fetch_assoc ( $o );
    $upit = "UPDATE ".$tabela." SET ".$dioUpita." WHERE id='".$p['radniID']."'";
    return $upit;
}


function napraviLog ( $akcija, $sqlerror, $upit )
{

    if ( !$akcija ){ $akcija = "0"; }
    if ( !$sqlerror ){ $sqlerror = "0"; }
    $sqlerror = mysql_real_escape_string($sqlerror);
    $upit = mysql_real_escape_string($upit);
    $request = mysql_real_escape_string(var_export($_REQUEST, true));
    $u = "SELECT korisnik FROM kontroler WHERE idsess = '".session_id()."'";
    $o = mysql_query ( $u );
    $korisnik = mysql_result ( $o, 0 );
    $ipadresa = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];

    $u = "INSERT INTO log ( korisnik, stranica, akcija, vrijeme, ipadresa, browser, sqlerror, request, upit )
        VALUES
        ( '".$korisnik."', '".$stranica."', '".$akcija."', NOW(), '".$ipadresa."', '".$browser."', '".$sqlerror."', '".$request."', '".$upit."' )";
    mysql_query ( $u );
}

    
?>