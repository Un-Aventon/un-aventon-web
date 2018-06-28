<?php



	$m_viaje = mysqli_query($conexion, "SELECT * from viaje WHERE idViaje = '$vars[0]'") or die (mysqli_error($conexion));
	$d_viaje = mysqli_fetch_array($m_viaje);

	$origen = explode(',', $d_viaje['origen']); 

	$destino = explode(',', $d_viaje['destino']);

	$fecha = explode(' ', $d_viaje['fecha_partida']);


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

	$a_postulacion = mysqli_query($conexion, "SELECT * FROM participacion where idViaje = '$vars[0]' and estado = '2' ") or die (mysqly_error($conexion));
?>
<script src="/js/verificadores_viaje.js"></script>
<!-- Modal Mod Viaje -->
<div class="modal fade" id="ModViaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<?php
			if(mysqli_fetch_array($a_postulacion))
			{
				echo '
				<div class="alert alert-danger">
					Este viaje posee copilotos aceptados, para modifcar los datos debes quitar a los copilotos. 
				</div>';
			}else
			{
			?>
				<form action="" method="post">
					<div class="form-group">
						<label for="prov_origen">Provincia de Origen</label>
						<select class="form-control" onchange="is_valid_location('localidad_origen','prov_origen')" name="prov_origen" id="prov_origen"> 
							<?php
								foreach ($provincias as $each) {
								?>
									<option value="<?php echo $each ?>" <?php if(($origen[1] == $each)){ echo 'selected';} ?>> 	<?php echo 	$each ?></option>
							 		
								<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="loc_origen">Localidad de Origen</label>
						<input onchange="is_valid_location('localidad_origen','prov_origen')" value="<?php echo $origen[0] ?>" type="text" name="localidad_origen" class="	form-control" id="localidad_origen" placeholder="Ingrese la localidad de origen" required>
					</div>
					<div class="form-group">
						<label for="prov_destino">Provincia Destino</label>
						<select class="form-control" onchange="is_valid_location('localidad_destino','prov_destino')" name="prov_destino" id="prov_destino"> 
							<?php
								foreach ($provincias as $each) {
								?>
									<option value="<?php echo $each ?>" <?php if(($destino[1] == $each)){ echo 'selected';} ?>> 	<?php echo 	$each ?></option>
							 		
								<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="loc_destino">Localidad Destino</label>
						<input onchange="is_valid_location('localidad_destino','prov_destino')" value="<?php echo $destino[0] ?>" type="text" name="localidad_destino" class="	form-control" id="localidad_destino" placeholder="Ingrese la localidad de destino" required>
					</div>

					<div class="form-group">
						<label>Fecha de salida</label>
						<input type="date" name="fecha_salida" class="form-control" min="<?php echo date('Y-m-d'); ?>" id="fecha_salida" value="<?php echo $fecha[0] ?>" required>
					</div>
	
					<div class="form-group">
						<label>Hora de salida</label>
						<input type="time" name="hora_salida" class="form-control" id="hora_salida" value="<?php echo $fecha[1] ?>" required>
					</div>

					<?php
						$vehiculos = mysqli_query($conexion,"SELECT * from vehiculo where idPropietario = '$_SESSION[userId]' ");
					?>
	
					<div class="form-group">
						<label for="vehilculos">Selecciona el vehiculo</label>
						<select onchange="mod_asientos()" name="vehiculo" id="vehiculo" class="form-control">
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
						<input type="number" class="form-control" name="asientos" min="1" id="asientos" value="<?php echo  $d_viaje['asientos_disponibles']; ?>" placeholder="Ingrese la cantidad de vacantes que postulará" required>
					</div><?php
						$vehiculos = mysqli_query($conexion,"SELECT * from vehiculo where idPropietario = '$_SESSION[userId]' ");
					?>
	
					<div class="form-group ">
						<label for="precio">Costo total del viaje</label>
						<input type="number" class="form-control" name="precio" id="precio" value="<?php echo $d_viaje['costo'] ?>" placeholder="Ingrese el valor total del viaje" required>
						<small id="priceHelp" class="form-text text-muted">El precio ingresado sera repartido en la cantidad de asientos que compartas.</small>
					</div>
					
					<div class="form-group">
						<label for="tiempo_estimado">Horas estimadas de viaje</label>
						<input type="number" class="form-control" name="tiempo_estimado" value="<?php echo $d_viaje['tiempo_estimado'] ?>" id="tiempo_estimado" min="1" placeholder="Ingrese el tiempo estimado de viaje" required>
					</div>

					<div class="container-fluid" style="margin-top:.5rem; padding: 0">
						<input type="submit" name="registro" value="Cargar!" class="btn btn-success form-control form-control-lg">
					</div>
				</form>
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
			<?php
		}
			?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<!-- End Modal -->