<?php

/** ORIGEN Y DESTINO **/
$origen = [
	'localidad' => $_POST['localidad_origen'],
	'provincia' => $_POST['prov_origen']
];

$destino = [
	'localidad' => $_POST['localidad_destino'],
	'provincia' => $_POST['prov_destino']
];

if(!($origen['localidad']) || !($origen['provincia']) || !($destino['localidad']) || !($destino['provincia']))
{
	$ok = false;
	echo "Las Localidades ingresadas no son validas";
}


/** GOOGLE API **/
$GOOGLE_API_KEY = 'AIzaSyBCmsUIxdjkHChho9s5V1T7Xl4axSmR3-w';

$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);

$query = http_build_query([
	'origins' => $origen['localidad'].'|'.$origen['provincia'],
	'destinations' => $destino['localidad'].'|'.$destino['provincia'],
	'mode' => 'driving',
	'key' => $GOOGLE_API_KEY 
]);

$json_distance = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?'.$query, false, stream_context_create($arrContextOptions));
$distance = json_decode($json_distance, true);

//echo ($json_distance);


$l = $distance['rows']['0']['elements']['0']['status'];

if($l != 'OK' or ($distance['origin_addresses']['0'] == $distance['destination_addresses']['0'])){
	echo "NO SE ENCOTRO RUTA";
	$ok = false;
}

/** FECHA DE SALIDA **/

$fecha_salida = $_POST['fecha_salida'];

if(!(isset($fecha_salida)) or ($fecha_salida < date("Y-m-d h:m:s"))){
	echo "FECHA INVALIDA";
	$ok = false;
}

/** HORA DE SALIDA **/
$hora_salida = $_POST['hora_salida'];
if(!isset($hora_salida) or (($fecha_salida == date("Y-m-d") and ($hora_salida <= date("H:m")))))
{
	echo "nope";
}else
{
	$fecha_partida = date($fecha_salida . ' ' . $hora_salida . ':00');
}


/** INTERVALOS **/
$cant_intervalos = 0;
$intervalo = 0;
if(isset($_POST['intervalo_rep'])){
	$aux_intervalo = $_POST['intervalo_rep'];
	$aux_cant_intervalos = $_POST['cant_intervalos'];

	if((is_numeric($aux_cant_intervalos)) and (is_numeric($aux_intervalo))){
		$cant_intervalos = $aux_cant_intervalos;
		$intervalo = $aux_intervalo;
	}
}

/** TIEMPO ESTIMADO DEL VIAJE **/

$tiempo_estimado = $_POST['tiempo_estimado'];
if(!is_numeric($tiempo_estimado) or ($tiempo_estimado < 1))
{
	echo 'TIEMPO INGRESADO NO ES VALIDO';
	$ok = false;
}

/** VEHICULO SELECCIONADO **/
$id_vehiculo = $_POST['vehiculo'];
$vehiculo = mysqli_query($conexion, "
	SELECT *
	from vehiculo v, viaje v2 
	where v.idVehiculo = '$id_vehiculo'
	and v.idVehiculo = v2.idVehiculo
	and(
		('$fecha_partida' BETWEEN v2.fecha_partida AND DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR))
	    or (DATE_ADD('$fecha_partida', INTERVAL $tiempo_estimado HOUR) BETWEEN v2.fecha_partida AND DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR))
	    or (v2.fecha_partida BETWEEN 'fecha_partida' AND DATE_ADD('fecha_partida', INTERVAL v2.tiempo_estimado HOUR))
	    or (DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR) BETWEEN 'fecha_partida' AND DATE_ADD('fecha_partida', INTERVAL v2.tiempo_estimado HOUR))
	)
");

if($viaje_postulado = mysqli_fetch_array($vehiculo))
{
	echo "EL VEHICULO ESTA POSTULADO en el viaje de " . $viaje_postulado['origen'] . ' a ' . $viaje_postulado['destino'] . ' de la misma fecha';
	$ok = false;
}


/** CANTIDAD DE ASIENTOS **/
$cant_asientos = $_POST['asientos'];
if(!$cant_asientos > 0){ 
	echo "La cantidad de asientos debe ser mayor a 1";
	$ok = false;
}

$verif_asientos = mysqli_query($conexion, "SELECT cant_asientos from vehiculo where idVehiculo = '$id_vehiculo'");

if($asientos_total = mysqli_fetch_array($verif_asientos) < $cant_asientos)
{
	echo "La cantidad de asientos a postular para este vehiculo debe ser menor a " . $asientos_total;
	$ok = false;
}

/** COSTO DEL VIAJE**/

$costo = $_POST['precio'];
if(!is_numeric($costo) or $costo < 0)
{
	echo "PRECIO INVALIDO";
	$ok = false;
}

if($ok)
{
	for ($i=0; $i < $cant_intervalos +1; $i++) { 
		echo "al touch / ";

	}
}
