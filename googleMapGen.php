<?php







//echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now
echo '<br/>';
//echo $b; // I'll "walk" the <b>dog</b> now
//https://stackoverflow.com/questions/14331525/how-to-check-if-any-fields-in-a-form-are-empty-in-php


echo '<br/><br/><hr/>';

$mapa = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=";
$ulica_naziv = "horvaćanska 122";

$brojulica = "";
$grad = "Zagreb";
$drzava = "Croatia";
$part = "()&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed";

$mapa = $mapa.$ulica_naziv."%20".$brojulica."%20".$grad."%2C%20".$drzava.$part; //ne vide se brojevi
$mapa1 = $mapa.$ulica_naziv.$grad.$drzava.$part;



$mapaView = 0; // kontrola mape po $ulici
$mapaViewCord = 0;


//----------------------------------------------------------
function mapa($ulicaNaziva_, $broj_, $grad_)
{
        $mapa = "https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=";
        $ulica_naziv = $ulicaNaziva_;
        if($broj_ == ""){
          $brojulica='';
        }else{
          $brojulica = $broj_;
        }

        $grad =  $grad_;
        $drzava = "Croatia";
        $part = "()&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed";
        $mapa_emb = $mapa.$ulica_naziv."%20".$brojulica."%20".$grad."%2C%20".$drzava.$part;

if(isset($ulicaNaziva_) && trim($ulicaNaziva_) != ''){
    return $mapa_emb;
    $mapaView = 1;
      }elseif(!isset($broj_) || trim($broj_) == '' || is_null($broj_) && is_null($grad_) || trim($grad_) == '' || !isset($grad_)){
          return '';
        }elseif (!isset($ulicaNaziva_) || trim($ulicaNaziva_) === '' || is_numeric($ulicaNaziva_) || trim($ulicaNaziva_) == '0') {
          return '';
        }else{
          return $mapa_emb;
          $mapaView = 1;
      }
}






function mapaLtd($lat_, $lon_)
{

        $mapa = "https://maps.google.com/maps?q=";
        $lat = $lat_;
        $lon = $lon_;
        $part = "&hl=es;z=14&amp;output=embed";
        $mapa_emb = $mapa.$lat.",".$lon.$part;




      if(!isset($lat) || is_null($lat) || trim($lat) == '' && !isset($lon)  || is_null($lon) || trim($lat) == ''){
          return ''; //ako je prazno
      }
      elseif ($lat < 1 && $lon < 1){
        return ''; //ako je prazno

     }
      else{
        return $mapa_emb; //ako je puno
        $mapaViewCord = 1;
      }

}
 ?>


<div style="width: 100%"><iframe width="100%" height="600" src="<?php print mapa('Vinogradi 36, Zagreb', '', '')?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed Google Map</a></iframe></div><br />
<!-- <?php print $mapa?> -->

<?php print 'embaded :'. mapa('Horvacanska', '122', 'Zagreb') ?>


<h1>generirani s kordinatama</h1>

<iframe
src="<?php print mapaLtd('43.789049229', '15.890364819')?>"
width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
</iframe>
<br/>
<h1>sa html fun</h1>
<?php  print  htmlEntities(mapaLtd('44.241509349', '15.180647589'))?>
<br/>
<h1>bez</h1>
<?php  print mapaLtd('44.241509349', '15.180647589')?>



</div>
