<?php

header('Content-type: application/json');
$terremotos = simplexml_load_file('http://www.ign.es/ign/RssTools/sismologia.xml');
$datosTerremotos = $terremotos->channel->item; 
$quake = [];
$geos = $terremotos->getNamespaces(true);
foreach ($datosTerremotos as $datos) {
    $patterns = ['/\d+\/\d+\/\d{4}/','/\d+\:\d+\:\d+/','/[[:digit:]].\d/','/terremoto/'];
    preg_match($patterns[0], $datos->title, $fecha);
    preg_match($patterns[1], $datos->title, $hora);
    preg_match($patterns[2], $datos->description, $magnitud);
    preg_match($patterns[3], $datos->title, $titulo);
    $geo = $datos->children($geos["geo"]);
    array_push($quake, [
        'titulo' => $titulo[0],
        'link' => $datos->link[0],
        'fecha' => $fecha[0],
        'hora' => $hora[0],
        'magnitud' => $magnitud[0],
        'lat' => (string)$geo->lat,
        'long' => (string)$geo->long
    ]);
}
echo json_encode($quake);
?>
