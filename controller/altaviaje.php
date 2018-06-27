</div>
	<div class="container h-100">

<?php

function render($vars = [])
{
	include('php/conexion.php');

	//parchaso
	echo "<br/>";

	//Si el usuario no esta logeado, no le permite ingresar.
	isset($_SESSION['userId'])?: header('Location: /login');

	//El usuario tiene vehiculos

	$tiene_ve = mysqli_query($conexion, "SELECT * from vehiculo where idPropietario = $_SESSION[userId]") or die(mysqli_error($conexion));
	if(!mysqli_fetch_array($tiene_ve))
	{
		echo '<div class="alert alert-danger alert-dismissable"><h2> Para postular un viaje, primero debe cargar un vehiculo. </h3><br/>';
		echo "<h4><a href='/perfil'> Ir al perfil </a></h4> </div>";
		return 0;
	}


	//Cuando recive el formulario cargado
	$rep = false;
	$form = true;


	//verifico que el usuario no adeude pagos ni le falte calificar

	$calificaciones_p = mysqli_query($conexion, 
	"SELECT * from calificacion 
		where idCalificador = '$_SESSION[userId]' 
		AND calificacion is null
	") or die (mysqli_error($conexion));
	
	if(mysqli_fetch_array($calificaciones_p) > 0)
	{	
		echo '	<div class="alert alert-danger" role="alert">
						<p>Tienes calificaciones pendientes de realizar.</p>
							<hr>
							<p class="mb-0">
						</p>
					<a href="/perfil"> Ir a calificar </a>
				</div>';
		$form = false;
	}

	$pagos_p = mysqli_query($conexion, 
	"SELECT * from viaje v
		WHERE v.idPiloto = '$_SESSION[userId]'
		and v.estado = 3
		and not EXISTS ( SELECT null from pago where idViaje = v.idViaje )
	") or die (mysqli_error($conexion));

	if($form and (mysqli_fetch_array($pagos_p) > 0))
	{
		echo '	<div class="alert alert-danger" role="alert">
				<p>Tienes pagos pendientes de realizar.</p>
					<hr>
					<p class="mb-0">
				</p>
			<a href="#"> Pagar </a>
		</div>';
		$form = false;
	}

	!isset($_POST['localidad_origen'])?:include('php/alta_viaje.php');


	{
		$asientos = array();
		$provincias = [
			'Buenos Aires',
			'Catamarca',
			'Chaco',
			'Chubut',
			'Córdoba',
			'Corrientes',
			'Entre Ríos',
			'Formosa',
			'Jujuy',
			'La Pampa',
			'La Rioja',
			'Mendoza',
			'Misiones',
			'Neuquén',
			'Río Negro',
			'Salta',
			'San Juan',
			'San Luis',
			'Santa Cruz',
			'Santa Fe',
			'Santiago del Estero',
			'Tierra del Fuego',
			'Tucumán'	
		];

	if ($form) {
?>
			<script type="text/javascript" src="js/verificadores_viaje.js"></script>
	
			<div class="row h-100 justify-content-center align-items-center">
				<div class="card bg-white" style="max-width: 600px; margin-top: 20px; margin-bottom: 20px">
					<div class="card-header"><h2 class="text-center">Nuevo Viaje!</h2></div>
					<div class="card-body">
						<form action="/altaviaje" method="post">
							<div class="form-group">
								<label for="prov_origen">Provincia de Origen</label>
								<select class="form-control" onchange="is_valid_location('localidad_origen','prov_origen')" name="prov_origen" id="prov_origen"> 
									<?php
										foreach ($provincias as $each) {
										?>
											<option value="<?php echo $each ?>"<?php if((isset($origen['provincia'])) and ($origen['provincia'] == $each)){ echo 'selected';} ?>> 	<?php echo $each ?></option>
									 		
										<?php
										}
									?>
								</select>
							</div>
							

							<div class="form-group">
								<label for="loc_origen">Localidad de Origen</label>
								<input onchange="is_valid_location('localidad_origen','prov_origen')" <?php if(isset($origen['localidad'])){echo 'value="'.$origen['localidad'].'"';} 	?> type="text" name="localidad_origen" class="form-control" id="localidad_origen" placeholder="Ingrese la localidad de origen" required>
							</div>
							<div class="form-group">
								<label for="prov_destino">Provincia de Destino</label>
								<select class="form-control" onchange="is_valid_location('localidad_destino','prov_destino')" name="prov_destino" id="prov_destino"> 
									<?php
	
										foreach ($provincias as $each) {
										?>
											<option value="<?php echo $each ?>" <?php if((isset($destino['provincia'])) and ($destino['provincia']) == $each){ echo 'selected';} ?>> 	<?php echo $each ?></option>
											
										<?php
										}
									?>
								</select>
							</div>
							
							<div class="form-group ">
								<label for="localidad_destino">Localidad de Destino</label>
								<input onchange="is_valid_location('localidad_destino','prov_destino')" <?php if(isset($destino['localidad'])){echo 'value="'.$destino['localidad'].'"	';} ?> type="text" name="localidad_destino" class="form-control" id="localidad_destino" placeholder="Ingrese la localidad de destino" required>
							</div>
	
	
							<div class="form-group">
								<label>Fecha de salida</label>
								<input type="date" name="fecha_salida" class="form-control" min="<?php echo date('Y-m-d'); ?>" id="fecha_salida" <?php if(isset($fecha_salida)){ echo 'value="' . $fecha_salida . '"';}?>	 required>
							</div>
	
							<div class="form-group">
								<label>Hora de salida</label>
								<input type="time" name="hora_salida" class="form-control" min="<?php echo date('Y-m-d') ?>" id="hora_salida" <?php if(isset($hora_salida)){ echo '	value="' . $hora_salida . '"';}?> required>
							</div>
	
							<div class="checkbox">
	  							<label><input type="checkbox" id='recurrente' name="recurrente" value="" onchange="swtich('interval_div') "> Viaje Recurrente</label>
							</div>
	
							<div class="form-group" id="interval_div" hidden="">
								<label for="dias">Qué días de la semana se repetirá?</label>
								<div id="dias" name="dias">
									<label for="lun">Lun</label>
									<input type="checkbox" value="" name="lun" id="lun">
									<label for="mar" value="">Mar</label>
									<input type="checkbox" name="mar" id="mar">
									<label for="mie" value="">Mie</label>
									<input type="checkbox" name="mie" id="mie">
									<label for="jue" value="">Jue</label>
									<input type="checkbox" name="jue" id="jue">
									<label for="vie" value="">Vie</label>
									<input type="checkbox" name="vie" id="vie">
									<label for="sab" value="">Sab</label>
									<input type="checkbox" name="sab" id="sab">
									<label for="dom" value="">Dom</label>
									<input type="checkbox" name="dom" id="dom">
								</div>

								<label for="intervalo_rep" >Cada cuántas semanas?</label>
								<input type="number" id="intervalo_rep" name="intervalo_rep" class="form-control" placeholder="Ingrese de cuantos días será el intervalo" min="1" >
								<label for="cant_intervalos">Cuantas veces se repetirá?</label>
								<input type="number" name="cant_intervalos" id="cant_intervalos" class="form-control" min="0" placeholder="Ingrese la cantidad de veces que se 	repetira el viaje">
							</div>
	
	
							<?php
								$vehiculos = mysqli_query($conexion,"SELECT * from vehiculo where idPropietario = '$_SESSION[userId]' ");
							?>
	
							<div class="form-group">
								<label for="vehilculos">Selecciona el vehiculo</label>
								<select onchange="mod_asientos()"name="vehiculo" id="vehiculo" class="form-control">
									<?php
										while ($v = mysqli_fetch_array($vehiculos)) {
											echo '<option value="' . $v['idVehiculo'] . '" >' . $v['marca'] . ' ' . $v['modelo'] . ', ' . $v['patente'] . " ( " . $v['cant_asientos'] 	. " Asientos ) </option>";
											$asientos[$v['idVehiculo']] = $v['cant_asientos'];
										}
	
									?>
								</select>
							</div>
	
							<div class="form-group ">
								<label for="asientos">Cantidad de asientos a postular</label>
								<input type="number" class="form-control" name="asientos" min="1" id="asientos" <?php if (isset($cant_asientos)): echo 'value="' . $cant_asientos . '"	'; ?>
									
								<?php endif ?> placeholder="Ingrese la cantidad de vacantes que postulará" required>
							</div>
	
							<div class="form-group ">
								<label for="precio">Costo total del viaje</label>
								<input type="number" class="form-control" name="precio" id="precio" <?php if (isset($costo)): echo 'value="'. $costo .'"'; ?>
									
								<?php endif ?> placeholder="Ingrese el valor total del viaje" required>
								<small id="priceHelp" class="form-text text-muted">El precio ingresado sera repartido en la cantidad de asientos que compartas.</small>
							</div>
							
							<div class="form-group">
								<label for="tiempo_estimado">Horas estimadas de viaje</label>
								<input type="number" class="form-control" name="tiempo_estimado" <?php if(isset($tiempo_estimado)){ echo 'value="' . $tiempo_estimado .'"';} ?>  id="tiempo_estimado" min="1" placeholder="Ingrese el tiempo estimado de viaje" required>
							</div>
	
							<div class="container-fluid" style="margin-top:.5rem; padding: 0">
								<input type="submit" name="registro" value="Registrar!" class="btn btn-success form-control form-control-lg" >
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	
	<!-- fin parche = abro container -->
	<div class="container">
	<script type="text/javascript">
			var aux = [];
			<?php
				foreach ($asientos as $key => $value)
				{
					echo "aux['". $key ."'] = '" . $value ."';" ;
				}
			?>
	
			mod_asientos();
	</script>
	<script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8A8hlojftFLpwPtwrcFQ5LtSl-o_s2OU">
	    </script>
<?php		
		}		
	}
}