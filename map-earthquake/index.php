<?php
header("Content-Type: text/html;charset=utf-8");

?>
<!DOCTYPE html>
<html lang=es" xml:lang="es">
<head>
	
	<title>Quick Start - Leaflet</title>

	<meta charset="UTF-8" />
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>


	
</head>
<body>



<div id="mapid" style="width: 600px; height: 400px;"></div>
<script>

	var mymap = L.map('mapid').setView([51.505, -0.09], 13);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);
	<?php
		
		$xml = simplexml_load_file('sismologia.xml');
		$data = $xml->channel;
		foreach ($data->item as $quake) {
			$geo = $quake->children("http://www.w3.org/2003/01/geo/wgs84_pos#");
			$date = $quake->title;
			$descripcion = $quake->description ;
			$pattern_sigm = "/[[:digit:]].\d/";
			$sigm = preg_match($pattern_sigm, $descripcion, $matches);
			$pattern_location = "/.[[:upper:]]+\p{L}/";
			$location = preg_match_all($pattern_location, $descripcion, $output);
			
			
			?>

			L.marker(
				<?php 
					echo ('['.$geo->lat.','.$geo->long.']');
				?>
				).addTo(mymap).bindPopup("<?php echo str_replace('-Info.terremoto:','', $date)?><br><br>"+'<a href="#" title="<?php echo $geo->lat.','.$geo->long?>"><?php foreach($output as $localizacion){ 
					$count = count($localizacion);
					for($i = 0; $i<$count; $i++){
						print($localizacion[$i]); 
						
					}
					
					} ?>
				</a>'+"<?php foreach ($matches as $valor){echo '('.$valor.')';}?>").openPopup();
			
			<?php
			
		}
		
	?>
</script>



</body>
</html>