<?php

// privremeno isključivanje video uploada svima   /
$iskljuciVideo = 1;

// postavi varijable ako nisu postavljene, da /
// ne baca warning                            /
if ( !isset($iskljuciVideo)) {
    $iskljuciVideo = 0;
}
if ( !isset($iskljuciSlike)) {
    $iskljuciSlike = 0;
}
if ( !isset($iskljuciDatoteke)) {
    $iskljuciDatoteke = 0;
}
if ( !isset($izFormulara)) {
    $izFormulara = 0;
}

// treba poništiti polja uploadGalerija i uploadDatotek   /
// u kontroleru, da bi se tamo moglo spremati IDove slika /
// i datoteka koje se šalje na server                     /
if ( $izFormulara ) {
    $upit = "UPDATE kontroler SET uploadGalerija = NULL, uploadDatoteke = NULL WHERE idsess = '".session_id()."'";
    mysql_query ( $upit );
    $uploadKontroler = "uploadPopisDatotekaIzFormulara.php";

} else {

    $uploadKontroler = "uploadPopisDatoteka.php";

}

?>
<div class="formTitle">Upravljanje datotekama</div>

<div id="upDatPopis">

<?php

include ( $uploadKontroler );

?>

</div>


<div class="uploadButton">
    <div id="extraupload">Upload</div>
    <div id="extrabutton" class="ajax-file-upload-green">Start Upload</div>
</div>

<script type="text/javascript" src="/vivo2/js/jquery.uploadfile.min.js"></script>
<link href="/vivo2/css/uploadfile.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function() {
    var extraObj = $("#extraupload").uploadFile({
        url:'/vivo2/vivoAplikacije/<?php
        if ( $izFormulara ) {
            echo 'uploadIzFormulara.php';
        } else {
            echo 'upload.php';
            }
            ?>',
        fileName:"myfile",
        dragDrop: false,
        formData: { session: '<?php echo session_id(); ?>' },
        afterUploadAll:function(obj)
        {
            $("#upDatPopis").load("/vivo2/vivoAplikacije/<?php echo $uploadKontroler ?>");
        },
        autoSubmit:false
    });
    
    $("#extrabutton").click(function(){
        extraObj.startUpload();
    });

});
</script>