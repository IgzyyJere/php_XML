<?php


$upit = "SELECT * FROM novogalerije WHERE id='".$_POST['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );


?>

<form name="testForm" method="POST" id="mainForm">

<?php

formUpdate ( "Naslov", "naslov", $podaci['naslov'] );
selectUpdate ( "Vrsta galerije", "vrstaGalerije", $podaci['vrstaGalerije'] );

?>

    <div id="unosGalerijePrikazNovo">

    <?php


echo '<br />popis slika :<input name="slike" type="text" value="',$podaci['slike'],'" size="70"><br />';

    $daj = explode ( ",", $podaci['slike'] );

    if ( $daj[0] ) {

        for ( $i = 0 ; $i < count ( $daj ); $i ++ ){

            $upit2 = "SELECT id, datoteka FROM slike WHERE id='".$daj[$i]."'";
            $odgovori2 = mysql_query ( $upit2 );
            $podaci2 = mysql_fetch_assoc ( $odgovori2 );
            echo '<div class="formPicture">',$podaci2['id'],'<br /><img src="../slike/mala',$podaci2['datoteka'],'"><br />
            <a href="" alt="',$_POST['id'],'" ref="',$podaci2['id'],'" action="novo"><img src="ikone/delete.png" class="deletePic"></a></div>';

            }

    }

    ?>

    </div>

<div class="buttonsDown">
<button class="buttonClear" name="reset" type="reset"><img src="ikone/delete.png">Isprazni</button>
<button class="buttonSubmitBack" name="submit" type="submit" ref="<?php echo $_POST['id']; ?>" value="submit"><img src="ikone/accept.png">Unesi</button>
</div>
</form>
<div id="unosGalerije">

    <span class="naslovOpisa">Unos galerije</span>

    <div id="unosGalerijeDiv">

        <form id="uploadFormGalerijaNovo" action="vivoAplikacije/unosGalerijeObradaNovo.php" method="post" enctype="multipart/form-data">

                 <input name="nid" value="<?php echo $_POST['id']; ?>" type="hidden">
                Datoteka : <input name="datoteka" type="file">
                <input value="Submit" type="submit" class="buttonSubmitTlocrt">
            </form>

    </div>




</div>
