<?php
echo "HOLA :D";
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
	echo "Las Localidades ingresadas no sol validas";
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

$l = $distance['rows']['0']['elements']['0']['status'];

if($l != 'OK'){
	echo "NO SE ENCOTRO RUTA";
	$ok = false;
}

/** FECHA DE SALIDA **/

$salida = $_POST['fecha_salida'];

if(!isset($salida) or ($salida < date("Y-m-d"))){
	echo "FECHA INVALIDA";
	$ok = false;
}

/** INTERVALOS **/
if(isset($_POST['intervalo_rep'])){
	$intervalo = $_POST['intervalo_rep'];
	$cant_intervalos = $_POST['cant_intervalos'];

	if((is_numeric($cant_intervalos)) and (is_numeric($intervalo))){
		$rep = true;
	}
}

/** VEHICULO SELECCIONADO **/
//$vehiculo = mysqli_query($conexion, "");

/** CANTIDAD DE ASIENTOS **/


/** COSTO DEL VIAJE**/

$costo = $_POST['precio'];
if(!is_numeric($costo) or $costo < 0)
{
	echo "PRECIO INVALIDO";
	$ok = false;
}

/** TIEMPO ESTIMADO DEL VIAJE **/
$time_pattern = "/[0-9]{2,3}([:]{1}[0-9]{2}){0,1}/";

$tiempo_estimado = $_POST['tiempo_estimado'];
if(!preg_match($time_pattern, $tiempo_estimado))
{
	echo 'TIEMPO INGRESADO NO ES VALIDO';
}
