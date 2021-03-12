<?php

header('Content-type: application/json');

$terremotos = simplexml_load_file('http://www.ign.es/ign/RssTools/sismologia.xml');

$datosTerremotos = $terremotos->channel->item; 

$array = [];


$geos = $terremotos->getNamespaces(true);

foreach ($datosTerremotos as $datos) {

    preg_match("/\d+\/\d+\/\d{4}/", $datos->title, $fecha);
    preg_match("/\d+\:\d+\:\d+/", $datos->title, $hora);
    preg_match("/[[:digit:]].\d/", $datos->description, $magnitud);
    preg_match("/terremoto/", $datos->title, $titulo);

    $geo = $datos->children($geos["geo"]);

    array_push($array, [
        'titulo' => (string)$titulo[0],
        'link' => (string)$datos->link[0],
        'fecha' => (string)$fecha[0],
        'hora' => (string)$hora[0],
        'magnitud' => (string)$magnitud[0],
        'lat' => (string)$geo->lat,
        'long' => (string)$geo->long
    ]);
}

echo json_encode($array);
?>