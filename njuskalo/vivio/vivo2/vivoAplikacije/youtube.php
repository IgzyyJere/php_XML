<div class="formTitle">Youtube video</div>
<form name="youtubeForm" id="youtubeForm" method="POST">
<strong>unesite youtube link:</strong><input type="text" name="youtube" size="40">
<button type="submit" class="buttonSubmit greenButton">Pošalji</button>
</form>
<div id="youtubePlayer">
<?php

$upit = "SELECT youtube FROM ".$tabela." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$youtube = mysql_result ( $odgovori, 0 );

if ( $youtube ) {

?>

<object width="580" height="360"><param name="movie" value="http://www.youtube.com/v/<?php echo $youtube;  ?>&hl=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?php echo $youtube;  ?>=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="580" height="360"></embed></object>

<?php

}

?>
</div>