<?php

function render($vars = [])
{
	include('php/conexion.php');

	//Si el usuario no esta logeado, no le permite ingresar.
	isset($_SESSION['userId'])?: header('Location: /home');

	//Cuando recive el formulario cargado
	if(true)
	{
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

		//echo "HOLA :D";
?>

		</div>
	<script type="text/javascript">
		function is_valid_location(loc,prov)
		{
				console.log(loc)
				console.log(prov)
				let localidad = document.getElementById(loc).value;
				let provincia = document.getElementById(prov).value;
				console.log(localidad);
				console.log(provincia);

				return(
					fetch('https://maps.googleapis.com/maps/api/geocode/json?address='+localidad+','+provincia+',+AR&key=AIzaSyBCmsUIxdjkHChho9s5V1T7Xl4axSmR3-w',{method: 'GET'})
						.then(function(response) {
						console.log(response);
						response.json().then(function(data){
							console.log(data);
							if(data['status'] == 'OK'){
								if(data['results']['0']['types']['0'] == 'locality')
								{
									document.getElementById(loc).setCustomValidity('');
									return true;
								}
							}
							document.getElementById(loc).setCustomValidity('Localidad no encontrada :(');
							console.log(document.getElementById(loc).checkValidity());
							return false
						})
					})
				);
		}

	</script>

	<div class="container h-100">
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
										echo '<option value="' . $each . '">' . $each . '</option>';
									}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="loc_origen">Localidad de Origen</label>
							<input onchange="is_valid_location('localidad_origen','prov_origen')" type="text" name="localidad_origen" class="form-control" id="localidad_origen" placeholder="Ingrese la localidad de origen" required>
						</div>
						<div class="form-group">
							<label for="prov_destino">Provincia de Destino</label>
							<select class="form-control" onchange="is_valid_location('localidad_destino','prov_destino')" name="prov_destino" id="prov_destino"> 
								<?php
									foreach ($provincias as $each) {
										echo '<option value="' . $each . '">' . $each . '</option>';
									}
								?>
							</select>
						</div>
						
						<div class="form-group ">
							<label for="localidad_destino">Localidad de Destino</label>
							<input onchange="is_valid_location('localidad_destino','prov_destino')" type="text" name="localidad_destino" class="form-control" id="localidad_destino" placeholder="Ingrese la localidad de origen" required>
						</div>


						<div class="form-group">
							<label>Fecha de salida</label>
							<input type="date" name="fecha_salida" class="form-control" min="<?php echo date('Y-m-d') ?>" id="fecha_salida" <?php if(isset($fecha_salida)){ echo 'value="' . $fecha_salida . '"';}?> required>
						</div>

						<?php
							$vehiculos = mysqli_query($conexion,"SELECT * from vehiculo where idPropietario = '$_SESSION[userId]' ");
						?>

						<div class="form-group">
							<label for="vehilocs">Selecciona el vehiculo</label>
							<select class="form-control">
								<?php
									while ($v = mysqli_fetch_array($vehiculos)) {
										echo '<option value="' . $v['idVehiculo'] . '" >' . $v['marca'] . ' ' . $v['modelo'] . ', ' . $v['patente'] . "</option>";
									}
								?>
							</select>
						</div>

						<div class="form-group ">
							<label for="precio">Costo total del viaje</label>
							<input type="number" class="form-control" name="precio" id="precio" placeholder="Ingrese el valor total del viaje" required>
							<small id="priceHelp" class="form-text text-muted">El precio ingresado sera repartido en la cantidad de asientos que compartas.</small>
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


<?php


	}
}