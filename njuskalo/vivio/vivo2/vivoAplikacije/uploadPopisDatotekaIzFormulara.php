<?php
if ( !$tabela ) {
    session_start();
    include ( '../vivoFunkcije/baza.php');
}
// pokupi glavne podatke, saznaj ID          /
// (id je neka definira, nekad ne, pa je ovo /
// jedini siguran način da se bude siguran)  /
$u = "SELECT * FROM kontroler WHERE idsess = '".session_id()."'";
$o = mysql_query ( $u );
$p = mysql_fetch_assoc ( $o );

if ( $p['akcija'] == "izmjena" ) {
    $akcija = $p['akcija'];
    $id = $p['radniID'];
    $stranica = $p['stranica'];
    require ( "switchTabela.php" );
}
if ( $p['akcija'] == "unos" ) {
    // tabela je kontroler, pošto podatke privremeno spremamo /
    // do unos klasičnim putem (upravljanje datotekama je dio /
    // formulara)                                             /
    $tabela = "kontroler";
    $akcija = $p['akcija']; 

}

?>
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){

// provjera za brisanje datoteka       /
// koristi impromptu.js jqUery plugin  /
    $("a.deleteFile").unbind('click').click(function (){

        var id = $(this).attr('idDatoteke');
        var akcija = "brisanjeDatoteke";
        function mycallbackfunc(v){
            if ( v ) {
                $.post ('/vivo2/vivoAplikacije/uploadPopisDatotekaIzFormulara.php', { akcija: akcija, id: id }, function(data){
                    $("#upDatPopis").html(data);
                });
            }

            }

        $.prompt('Potvrda brisanja datoteke sa servera. Ova akcije se ne može vratiti',{ buttons: { Obriši: true, Odustani: false }, prefix:'cleanblue', callback: mycallbackfunc });
        return false;

        });

    $("a.deletePicture").unbind('click').click(function (){

        var id = $(this).attr('idSlike');
        var akcija = "brisanjeSlike";
        function mycallbackfunc(v){
            if ( v ) {
                $.post ('/vivo2/vivoAplikacije/uploadPopisDatotekaIzFormulara.php', { akcija: akcija, id: id }, function(data){
                    $("#upDatPopis").html(data);
                });
            }

            }

        $.prompt('Potvrda brisanja slike sa servera. Ova akcije se ne može vratiti.',{ buttons: { Obriši: true, Odustani: false }, prefix:'cleanblue', callback: mycallbackfunc });
        return false;

        });

});

</script>

<?php

// BRISANJE DATOTEKA    /
if ( $_POST['akcija'] == "brisanjeDatoteke" ) {
    $datotekaZaBrisanje = $_POST['id'];
    // ovisno o akciji, pitaj kontroler ili tabelu /
    // u kojoj je podatak za popis datoteka        /
    if ( $akcija == "unos" ) {
        $u = "SELECT uploadDatoteke FROM ".$tabela." WHERE idsess = '".session_id()."'";
    } else {
        $u = "SELECT datoteke FROM ".$tabela." WHERE id = '".$id."'";
    }
    $o = mysql_query ( $u );
    $dat = mysql_result ( $o, 0 );
    $dat = explode ( ",", $dat );
    // nađi key koji treeba obrisati    /
    $keyArr = array_keys($dat, $datotekaZaBrisanje );
    // obriši podatak  /
        // za slučaj (malo vjerojatan) da je neka datoteka navedena više puta u popisu /
        foreach ( $keyArr as $value ) {
            unset ( $dat[$value] );
        }
    $dat = implode ( ",", $dat );
    // izmjena popisa u bazi
    if ( $akcija == "unos" ) {
        $u = "UPDATE ".$tabela." SET uploadDatoteke = '".$dat."' WHERE idsess = '".session_id()."'";
    } else {
        $u = "UPDATE ".$tabela." SET datoteke = '".$dat."' WHERE id = '".$id."'";
    }
    mysql_query ( $u );
    // fizičko brisanje datoteke sa servera  /
        // doznaj ime datoteke  /
        $u = "SELECT datoteka FROM datoteke WHERE id = '".$datotekaZaBrisanje."'";
        $o = mysql_query ( $u );
        $datoteka = mysql_result ( $o, 0 );
        // samo brisanje  /
        unlink ( "../../datoteke/".$datoteka );
        // sad još izbrisati podatke iz tabela "datoteke"  /
        $u = "DELETE FROM datoteke WHERE id = '".$datotekaZaBrisanje."'";
        mysql_query ( $u );
}

// BRISANJE SLIKA   /
if ( $_POST['akcija'] == "brisanjeSlike" ) {
    $slikaZaBrisanje = $_POST['id'];
    // ovisno o akciji, pitaj kontroler ili tabelu /
    // u kojoj je podatak za popis slika           /
    if ( $akcija == "unos" ) {
        $u = "SELECT uploadGalerija FROM ".$tabela." WHERE idsess = '".session_id()."'";
    } else {
        $u = "SELECT slike FROM ".$tabela." WHERE id = '".$id."'";
    }
    $o = mysql_query ( $u );
    $dat = mysql_result ( $o, 0 );
    $dat = explode ( ",", $dat );
    // nađi key koji treeba obrisati    /
    $keyArr = array_keys($dat, $slikaZaBrisanje );
    // obriši podatak  /
        // za slučaj (malo vjerojatan) da je neka slika navedena više puta u popisu /
        foreach ( $keyArr as $value ) {
            unset ( $dat[$value] );
        }
    $dat = implode ( ",", $dat );
    // izmjena popisa u bazi
    if ( $akcija == "unos" ) {
        $u = "UPDATE ".$tabela." SET uploadGalerija = '".$dat."' WHERE idsess = '".session_id()."'";
    } else {
        $u = "UPDATE ".$tabela." SET slike = '".$dat."' WHERE id = '".$id."'";
    }
    mysql_query ( $u );
    // fizičko brisanje slika (thumb + original) sa servera  /
        // doznaj ime slike  /
        $u = "SELECT slika FROM slike WHERE id = '".$slikaZaBrisanje."'";
        $o = mysql_query ( $u );
        $slika = mysql_result ( $o, 0 );
        // samo brisanje  /
        unlink ( "../../slike/".$slika );
        unlink ( "../../slike/mala".$slika );
        // sad još izbrisati podatke iz tabela "datoteke"  /
        $u = "DELETE FROM slike WHERE id = '".$slikaZaBrisanje."'";
        mysql_query ( $u );

}
// poništi $dat za daljnju upotrebu  /
$dat = NULL;


//                                    /
// provjera jesu video ili datoteke   /
// isključeni prije include()         /
//                                    /


if ( !$iskljuciDatoteke ) {

    //      POPIS DATOTEKA          /
    // (sa mogućim izmjenama)       /
    if ( $akcija == "unos" ) {
        $u = "SELECT uploadDatoteke FROM ".$tabela." WHERE idsess = '".session_id()."'";
    } else {
        $u = "SELECT datoteke FROM ".$tabela." WHERE id = '".$id."'";
    }
    $o = mysql_query ( $u );
    $dat = mysql_result ( $o, 0 );

    // ubaci formular u kojem je popis datoteka   /
    // i gdje se mogu mjenjati datoteke koje su   /
    // povezana na ovaj podatak                   /

?>

<div class="naslovPopisaDatoteka">Popis datoteka:
    <input type="text" name="inputPopisDatoteka" value="<?php echo $dat; ?>">
</div>

<?php

    if ( $dat ) {
        $popis = explode ( ",", $dat);
        $broj = count ( $popis );
    }

    if ( $broj ) {
        for ( $i = 0; $i < $broj; $i ++ ) {
            $uu = "SELECT * FROM datoteke WHERE id = '".$popis[$i]."'";
            $oo = mysql_query ( $uu );
            $pp = mysql_fetch_assoc ( $oo );
            echo '<div class="popisDatoteka"><a href="" idDatoteke="',$pp['id'],'" class="smallButton smallRed deleteFile"> obriši</a>&nbsp;&nbsp;&nbsp; <img src="/vivo2/elementi/',$pp['vrsta'],'.png"> naziv:',$pp['datoteka'],' &nbsp;&nbsp;&nbsp;<strong>id</strong>:',$pp['id'],'</div>';
        }
    }
    // poništi $dat za daljnju upotrebu  /
    $dat = NULL;
    $popis = NULL;

}

?>

<?php

//                                    /
// provjera jesu slike                /
// isključeni prije include()         /
//                                    /

if ( !$iskljuciSlike ) {

    //      POPIS SLIKA          /
    // (sa mogućim izmjenama)    /
    if ( $akcija == "unos" ) {
        $u = "SELECT uploadGalerija FROM ".$tabela." WHERE idsess = '".session_id()."'";
    } else {
        $u = "SELECT slike FROM ".$tabela." WHERE id = '".$id."'";
    }
    $o = mysql_query ( $u );
    $dat = mysql_result ( $o, 0 );

    // ubaci formular u kojem je popis slika      /
    // i gdje se mogu mjenjati slike koje su      /
    // povezana na ovaj podatak                   /

?>     

<div class="naslovPopisaSlika">Popis slika:
    <input type="text" name="inputPopisSlika" value="<?php echo $dat; ?>">
</div>

<div class="popisSlika">

<?php

    if ( $dat ) {
        $popis = explode ( ",", $dat);
        $broj = count ( $popis );
    }
    if ( $popis[0] ) {

        for ( $i = 0; $i < $broj; $i ++ ) {

            $uu = "SELECT * FROM slike WHERE id = '".$popis[$i]."'";
            $oo = mysql_query ( $uu );
            $slika = mysql_fetch_assoc ( $oo );

            echo '<div class="popisDatotekaSlikaOkvir"><div class="popisDatotekaSlika"><img src="/slike/mala',$slika['datoteka'],'"></div><a href="" idSlike="',$slika['id'],'" class="smallButtonPicture smallRed deletePicture"> obriši</a>&nbsp;&nbsp;<strong>id</strong>:',$slika['id'],'</div>';

        }

    }

}

?>
</div>