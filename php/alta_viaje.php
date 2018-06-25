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
$GOOGLE_API_KEY = 'AIzaSyBCmsUIxdjkHChho9s5V1T7Xl4axSmR3-w';

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

//echo ($json_distance);



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
	$fecha_partida = date($fecha_salida . ' ' . $hora_salida . ':00');
}


/** INTERVALOS **/
$semana = array('lun', 'mar', 'mie', 'jue', 'vie', 'sab', 'dom');

$cant_intervalos = 1;
$intervalo = 0;
$tipo = 'unico';
$dias_interv = array();
$recurrente = false;
if(isset($_POST['recurrente'])){

	!isset($_POST['lun'])?: array_push($dias_interv, 'lun');
	!isset($_POST['mar'])?: array_push($dias_interv, 'mar');
	!isset($_POST['mie'])?: array_push($dias_interv, 'mie');
	!isset($_POST['jue'])?: array_push($dias_interv, 'jue');
	!isset($_POST['vie'])?: array_push($dias_interv, 'vie');
	!isset($_POST['sab'])?: array_push($dias_interv, 'sab');
	!isset($_POST['dom'])?: array_push($dias_interv, 'dom');

	$aux_intervalo = $_POST['intervalo_rep'];
	$aux_cant_intervalos = $_POST['cant_intervalos'];

	if((is_numeric($aux_cant_intervalos)) and (is_numeric($aux_intervalo) and $aux_intervalo > 0))
	{
		$cant_intervalos = $aux_cant_intervalos;
		$intervalo = $aux_intervalo;
		$tipo = 'recurrente';
		$recurrente = true;
	}else
	{
		echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				El viaje se debe repetir almenos cada una semana.
		</div>';
		$ok = false;
	}
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

	$piloto = $_SESSION['userId'];
	$c_origen = $origen['localidad'] . ',' . $origen['provincia'];
	$c_destino = $destino['localidad'] . ',' . $destino['provincia'];
	$cargados = 0;
	$errores = 0;
	$fechas_cargadas = [];
	$fechas_erroneas = [];

	//echo $fecha_partida;
	if($recurrente)
	{

		foreach ($semana as $key) {
			$aux_fecha = $fecha_partida; 
			if(in_array($key, $dias_interv))
			{
				for ($i=0; $i < $cant_intervalos+1; $i++) 
				{ 
					
					if(es_fecha_valida($conexion, $id_vehiculo, $aux_fecha, $tiempo_estimado) < 1 )
					{
						$carga = mysqli_query($conexion, "INSERT into viaje (idPiloto, idVehiculo, fecha_publicacion, fecha_partida, tiempo_estimado,  origen, destino, asientos_disponibles, costo, tipo) values ('$piloto', '$id_vehiculo', now(), '$aux_fecha', '$tiempo_estimado' ,'$c_origen' , '$c_destino', '$cant_asientos', '$costo','$tipo') ") or die ('nope ' . mysqli_error($conexion));
	

						$last_id = mysqli_query($conexion, "SELECT MAX(idViaje) AS id FROM viaje") or die(mysqli_error($conexion));
						$l_id = mysqli_fetch_array($last_id);

						array_push($fechas_cargadas, array(
							'fecha' => $aux_fecha,
							'id' => $l_id['id']
						));

						$cargados++;
					}else
					{
						$errores++;
						array_push($fechas_erroneas, $aux_fecha);
					}
					
					$aux_fecha = date(sum_days($aux_fecha, '+7') . " " . $hora_salida . ':00');


				}
			}
			$fecha_partida = date(sum_days($fecha_partida, '+1') . " " . $hora_salida . ':00');
		}
	}else
	{
		
		if(es_fecha_valida($conexion, $id_vehiculo, $fecha_partida, $tiempo_estimado) < 1 )
		{
		
			$carga = mysqli_query($conexion, "INSERT into viaje (idPiloto, idVehiculo, fecha_publicacion, fecha_partida, tiempo_estimado,  origen, destino, asientos_disponibles, costo, tipo) values ('$piloto', '$id_vehiculo', now(), '$fecha_partida', '$tiempo_estimado' ,'$c_origen' , '$c_destino', '$cant_asientos', '$costo','$tipo') ") or die ('nope ' . mysqli_error($conexion));
		

			$last_id = mysqli_query($conexion, "SELECT MAX(idViaje) AS id FROM viaje") or die(mysqli_error($conexion));
			$l_id = mysqli_fetch_array($last_id);

			array_push($fechas_cargadas, array(
				'fecha' => $fecha_partida,
				'id' => $l_id['id']
			));
			$cargados++;
		}
		else
		{
			$errores++;
			array_push($fechas_erroneas, $fecha_partida);
		}

	}


	if($cargados > 0)
	{	
		echo '	<div class="alert alert-success" role="alert">
					<p>Los siguientes viajes fueron cargados correctamente.</p>
					<hr>
					<p class="mb-0">';
		 			 	foreach ($fechas_cargadas as $key) {
					 		echo '<a href="/viaje/' . $key['id'] . '">' . $key['fecha'] . '</a><br/>';
					 	}
		echo '		</p>
				</div>';

	}
	

		if($errores > 0)
		{	
			if($cargados > 1)
			{
				echo '	<div class="alert alert-danger" role="alert">
							<p>Los siguientes viajes no pudieron ser cargados por que el vehiculo se encuentra postulado a otro viaje en esas fechas.</p>
							<hr>
							<p class="mb-0">';
				 			 	foreach ($fechas_erroneas as $key) {
							 		echo $key . '<br/>';
							 	}
				echo '		</p>
							<a href="/altaviaje"> Cargar en otra fecha </a>
						</div>';
			}
			else
			{
				echo '<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
							El vehiculo se encuentra postulado en otro viaje para esas fechas.
					</div>';
			}
		};
	if($cargados > 0)
	{
		$form = false;
	}
}
