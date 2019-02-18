<?php
// odredi lon i lat ako postoje   /

    // prvo saznati na kojoj smo stranici   /
    $upit = "SELECT stranica FROM `kontroler` WHERE idsess = '".session_id()."'";
    $odgovori = mysql_query ( $upit );
    $stranica = mysql_result ( $odgovori, 0 );

    // saznati tabelu u koju unosimo promjene    /
    require ( 'switchTabela.php' );

$upit = "SELECT lon, lat FROM ".$tabela." WHERE id = '".$id."'";
$odgovori = mysql_query ( $upit );
$googleMap = mysql_fetch_assoc ( $odgovori );

?>
<div class="formTitle">Google Maps</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

$(document).ready(function() {

	var geocoder = new google.maps.Geocoder();
	var map;

<?php

if ( !$googleMap['lon'] ) {

?>

geoKodiraj ('<?php echo $googleMapCentar; ?>');

<?php

}

?>

	function geoKodiraj(podaci) {

			geocoder.geocode({ 'address': podaci}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {

                    //alert ( results[0].address_components[0].long_name + '  ' + results[0].address_components[1].long_name + '  ' + results[0].address_components[2].long_name + '  ' +  results[0].address_components[3].long_name  );

                    latLng = results[0].geometry.location;
					napraviMapu(latLng);
				}
			});

	}

	function napraviMapu(latLng) {

		var myOptions = {
			zoom: 14,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("googleMap"), myOptions);

		var marker = new google.maps.Marker({
			position: latLng,
			map: map,
			draggable: true
		});

		updateMarkerPosition(latLng);

		google.maps.event.addListener(marker, 'drag', function() {
			updateMarkerPosition(marker.getPosition());
		});


	}


	function updateMarkerPosition(latLng) {

		$('#latitude').val(latLng.lat());
		$('#longitude').val(latLng.lng());
	}



	$("#gMapMapa").click( function () {

		var country = $('#country').val();
		var city = $('#city').val();
		var street = $('#street').val();

		var adresa = street + " " + city + " " + country;

		geoKodiraj(adresa);

			return false;
	});

var googleMapSlanje = {
    target: '#googleMapReturn',
    url: '/vivo2/vivoAplikacije/googleMapObrada.php'
};
$('#formKoordinate').ajaxForm(googleMapSlanje);

});

<?php

if ( $googleMap['lon'] ) {

?>

  function osnovnaMapa() {
    var latlng = new google.maps.LatLng(<?php echo $googleMap['lat']; ?>, <?php echo $googleMap['lon']; ?>);
    var myOptions = {
      zoom: 14,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), myOptions);

	var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			draggable: true
		});

	updateMarkerPosition(latlng);

	google.maps.event.addListener(marker, 'drag', function() {
	    updateMarkerPosition(marker.getPosition());
	});

	function updateMarkerPosition(latlng) {

		$('#latitude').val(latlng.lat());
		$('#longitude').val(latlng.lng());
	}

  }

$(window).load( function() {

    osnovnaMapa();

});


<?php

}

?>
</script>
<div id="googleMapContainer">
	<div id="googleMapKoordinate">
		<form name="formKoordinate" id="formKoordinate" method="POST">
			<input type="text" name="latitude" id="latitude" <?php
if ( $googleMap['lat'] ) {
  echo ' value="',$googleMap['lat'],'" ';
}
?>/>
			<input type="text" name="longitude" id="longitude" <?php
if ( $googleMap['lon'] ) {
  echo ' value="',$googleMap['lon'],'" ';
}
?>/>
			<button name="submit" id="googleMapSubmit" value="submit" class="buttonSubmit greenButton">Spremi</button>
		</form>

	</div>

    <div id="googleMapReturn"></div>

	<div id="unosPodataka">

		<form method="post" name="unosMjesta">

			<div class="GMformPart">
				<label for="country">Žup.</label>
				<input type="text" name="country" id="country" />
			</div>

			<div class="GMformPart">
				<label for="city">Grad</label>
				<input type="text" name="city" id="city" />
			</div>

			<div class="GMformPart">
				<label for="street">Ulica</label>
				<input type="text" name="street" id="street" />
			</div>

			<div id="gumbi">
				<button name="gMapMapa" type="submit" id="gMapMapa" class="buttonSubmit greenButton">Odredi</button>
			</div>


		</form>

	</div>
	<div id="googleMap" style="width: 100%; height: 500px;"></div>

</div>
