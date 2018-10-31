<?php

$orig = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street%2C%20Dublin%2C%20Ireland";



$a = htmlentities($orig);
$b = html_entity_decode($a);


//echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now
echo '<br/>';
//echo $b; // I'll "walk" the <b>dog</b> now


echo '<br/><br/><hr/>';

$mapa = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=";
$ulica_naziv = "horvaćanska 122";

$brojulica = "";
$grad = "Zagreb";
$drzava = "Croatia";
$part = "()&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed";

$mapa = $mapa.$ulica_naziv."%20".$brojulica."%20".$grad."%2C%20".$drzava.$part; //ne vide se brojevi
$mapa1 = $mapa.$ulica_naziv.$grad.$drzava.$part;

//$karta1 = htmlentities($mapa1);
//$karta1 = html_entity_decode($mapa1);
//echo $mapa;

 ?>


<div style="width: 100%"><iframe width="100%" height="600" src="<?php print $mapa?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed Google Map</a></iframe></div><br />
<?php print $mapa?>

<h1>orginal s ulicom</h1>
<div style="width: 100%"><iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=%20%20Supetar%2C%20Croatia()&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed Google Map</a></iframe></div><br />

<h1>generirani s kordinatama</h1>
<iframe
src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=44.241509349,15.180647589&amp;q=+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed"
width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
</iframe>


<h1>orginal s koridnatama</h1>
<div style="width: 100%"><iframe width="100%" height="600" src="https://maps.google.com/maps/api/staticmap?center=51.49,-0.12&zoom=8&size=400x300&sensor=false" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed Google Map</a></iframe></div><br />


</div>
<br/>
<br/>
<h1>ovo stavljaj u pattern </h1>
{tekst[1]}

&nbsp;

&nbsp;

&nbsp;
<div class="google-maps">
<iframe src="{kartaKord[1]}" width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
</iframe>
</div>
