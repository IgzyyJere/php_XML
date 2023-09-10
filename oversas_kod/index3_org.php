<html>
	<head>
		

			<style> 
				input[type=button], input[type=submit], input[type=reset] {
					background-color: #f58220;
					border: none;
					color: white;
					padding: 8px 32px;
					text-decoration: none;
					margin: 4px 2px;
					cursor: pointer;
				}
			
				input[type=text] {
					border:none;
					border-bottom: 2px solid #f58220;
					outline: none;
					width: 15%;
					height: 40px;
					font-size: 18px;
				}
				iframe {
					box-shadow: -1px 3px 28px -4px rgba(0,0,0,0.76);
					float: left;
					width: 100%;
					height: 100%;
					border-top-width: 0px;
					border-right-width: 0px;
					border-bottom-width: 0px;
					border-left-width: 0px;
					border-style: inset;
					border-color: initial;
					border-image: initial;
				}
				.button11 {
					border: none;
					color: white;
					padding: 15px 32px;
					text-align: center;
					text-decoration: none;
					display: inline-block;
					font-size: 16px;
					margin: 4px 2px;
					cursor: pointer;
				}

					.button1 {background-color: #ED7F02;} 
					.button2 {background-color: #ED7F02;}
			</style>
		
		
        <form action="" method="post">
            <input type=text name="textBox" placeholder="Broj pošiljke">
            <input type=submit name="gumb" value="Traži">
			<br>
            <br>
  <body onload="initialize_map(); add_map_point(-33.8688, 151.2093);">
  <div id="map" style="width: 40vw; height: 40vh;"></div>
<?php
			

if(isset($_POST['gumb']))
{
$brojPosiljke=$_POST['textBox']; //broj pošiljke

if (empty($brojPosiljke)) {exit('Unesi broj pošiljke!');}
	
$brojPosiljke1 = str_replace(' ', '', $brojPosiljke); // ako ima razmake

if (substr ($brojPosiljke1,0,3)==="001") {$brojPosiljke1='191'.$brojPosiljke1;} //ako ima samo 001 dodaj 191 na početak php 7

//if (str_starts_with($brojPosiljke1, '001')) {$brojPosiljke1='191'.$brojPosiljke1;} //ako ima samo 001 dodaj 191 na početak
	
$prefiksURL='http://10.0.37.20:8080/shipment/?apikey=efbe8fb590c44b5693090689d6d9272a&include=FullCargoId,Attachments[2].*,Events.StatusID,Events.Location.Lat,Events.Location.Long,Events.TimeOfScan&sdglfdnr=';
	
$URLstring=$prefiksURL.$brojPosiljke1;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $URLstring,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: Morty_SessionId=lmnabbgqvbavnyb1stwrtwq6'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$rezultat = json_decode($response,true);

print_r($rezultat);
if (empty($rezultat ["data"]["Attachments"][0]["Data"])) {exit('Pošiljka nema fotografiju!');} else {
	
	$rez1=$rezultat ["data"]["Attachments"][0]["Data"];
	
	$vrijeme=$rezultat ["data"]["Events"][2]["TimeOfScan"];
	echo 'Datum i vrijeme statusa: '.$vrijeme;
	echo "<br>";
	echo "<br>";
	//print_r ($rezultat);
	

$filter = "130"; 

$new = array_filter($rezultat ["data"]["Events"], function ($var) use ($filter) {
    return ($var["StatusID"] == $filter);
},ARRAY_FILTER_USE_BOTH);

print_r ($new);
$new1=array_search("Lat",$new);
echo $new1;
echo $new[5]["Lat"];
	
	
	} 

	

//print_r ($rezultat);
//echo $rezultat["data"]["Attachments"][0]["Data"];

echo '<img alt="Embedded Image" src="data:image/png;base64,' . $rez1 .  '"/>';
	
}
	?>
	


	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
  
  <script>
    /* OSM & OL example code provided by https://mediarealm.com.au/ */
    var map;
    var mapLat = -33.829357;
		var mapLng = 150.961761;
    var mapDefaultZoom = 10;
    
    function initialize_map() {
      map = new ol.Map({
        target: "map",
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM({
                      url: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
                })
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([mapLng, mapLat]),
            zoom: mapDefaultZoom
        })
      });
    }

    function add_map_point(lat, lng) {
      var vectorLayer = new ol.layer.Vector({
        source:new ol.source.Vector({
          features: [new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
            })]
        }),
        style: new ol.style.Style({
          image: new ol.style.Icon({
            anchor: [0.9, 0.5],
            anchorXUnits: "fraction",
            anchorYUnits: "fraction",
            src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
          })
        })
      });

      map.addLayer(vectorLayer); 
    }


  </script>
	
			</form>
		</body>
	</head>
</html>