<?php

$ok = true;
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
$GOOGLE_API_KEY = 'AIzaSyD8A8hlojftFLpwPtwrcFQ5LtSl-o_s2OU';

$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);

$query = http_build_query([
	'origins' => $origen['localidad'].'|'.$origen['provincia'].',arentina',
	'destinations' => $destino['localidad'].'|'.$destino['provincia'].',argentina',
	'mode' => 'driving',
	'key' => $GOOGLE_API_KEY 
]);

$json_distance = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?'.$query, false, stream_context_create($arrContextOptions));
$distance = json_decode($json_distance, true);



$l = $distance['rows']['1']['elements']['0']['status'];
if($l == 'OK'){
	$aux_origin = [
		'loc' => $distance['origin_addresses']['0'],
		'prov' => $distance['origin_addresses']['1']
	];

	$aux_destination = [
		'loc' =>  $distance['destination_addresses']['0'],
		'prov' =>  $distance['destination_addresses']['1']
	];
}

if($l != 'OK' or (($aux_origin['loc'] == $aux_destination['loc']) and ($aux_origin['prov'] == $aux_destination['prov'])))
{
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				No se encontró ruta.
		</div>';
	$ok = false;
}

/** FECHA DE SALIDA **/

$fecha_salida = $_POST['fecha_salida'];

if(!(isset($fecha_salida)) or ($fecha_salida <= date("Y-m-d"))){
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				La fecha ingresada no es válida.
		</div>';
	$ok = false;
}

/** HORA DE SALIDA **/
$hora_salida = $_POST['hora_salida'];
if(!isset($hora_salida) or (($fecha_salida == date("Y-m-d") and ($hora_salida <= date("H:m")))))
{
	echo '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
			La hora de salida ingresada no es válida.
	</div>';
	$ok = false;
}else
{
	$fecha_partida = date($fecha_salida . ' ' . $hora_salida);
}



/** TIEMPO ESTIMADO DEL VIAJE **/

$tiempo_estimado = $_POST['tiempo_estimado'];
if(!is_numeric($tiempo_estimado) or ($tiempo_estimado < 1))
{
	echo '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
			El tiempo estimado ingresado no es válido.
	</div>';
	$ok = false;
}

/** VEHICULO SELECCIONADO **/
$id_vehiculo = $_POST['vehiculo'];
$v = mysqli_query($conexion, "SELECT * from vehiculo where idVehiculo = '$id_vehiculo' ");
if(!($v = mysqli_fetch_array($v)) or $v['idPropietario'] != $_SESSION['userId'])
{
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				El vehiculo ingresado no es válido.
		</div>';
	$ok = false;
}

/** CANTIDAD DE ASIENTOS **/
$cant_asientos = $_POST['asientos'];
if(!is_numeric($cant_asientos) or ($cant_asientos < 1))
{
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				La cantidad de asientos a postular debe ser mayor a 1.
		</div>';
	$ok = false;
}

$verif_asientos = mysqli_query($conexion, "SELECT cant_asientos from vehiculo where idVehiculo = '$id_vehiculo'");

if($asientos_total = mysqli_fetch_array($verif_asientos) < $cant_asientos)
{
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				La cantidad de asientos a postular para este vehiculo debe ser menor a ' . $asientos_total .'
		</div>';	
	$ok = false;
}

/** COSTO DEL VIAJE**/

$costo = $_POST['precio'];
if(!is_numeric($costo) or $costo < 1)
{
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				El precio ingresado es inválido.
		</div>';
	$ok = false;
}

if($ok)
{

	$viaje = mysqli_query($conexion,"SELECT * FROM viaje where idViaje = $vars[0]");
	$viaje = mysqli_fetch_array($viaje);
	
	$origen = $origen['localidad'].','.$origen['provincia'];
	$destino = $destino['localidad'].','.$destino['provincia'];

	if(
		$origen != $viaje['origen']
		or 	$destino != $viaje['destino']
		or 	$fecha_partida != $viaje['fecha_partida']
		or 	$tiempo_estimado != $viaje['tiempo_estimado']
		or 	$id_vehiculo != $viaje['idVehiculo']
		or 	$cant_asientos != $viaje['asientos_disponibles']
		or 	$costo != $viaje['costo']
	 )
	{
		if($fecha_partida == $viaje['fecha_partida'] or (es_fecha_valida($conexion, $id_vehiculo, $fecha_partida, $tiempo_estimado, $_SESSION['userId'] , $vars[0]) < 1 ))
		{
			mysqli_query($conexion, 
				"UPDATE viaje 
				set 
				idVehiculo = '$id_vehiculo',
				fecha_partida = '$fecha_partida',
				tiempo_estimado = '$tiempo_estimado',
				origen = '$origen',
				destino = '$destino',
				asientos_disponibles = '$cant_asientos',
				costo = '$costo',
				tipo = 'unico'
				where idViaje = '$vars[0]'
				") or die(mysqli_error($conexion));
			
		}
	}

}