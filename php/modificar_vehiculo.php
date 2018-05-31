<?php

	$pattern_old = '/^[a-zA-Z]{3}[0-9]{3}/';
	$pattern_new = '/^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}/';
	$text_pattern = '/^[a-zA-Z0-9 ]{3,50}$/';

			$consulta = "SELECT * FROM vehiculo where idVehiculo = '$_POST[idVehiculo]'";

			$vehiculos = mysqli_query($conexion, $consulta) or die("Error en la busqueda de un vehiculo" . mysqli_error($conexion));

			$vehiculo = mysqli_fetch_array($vehiculos);

			$ok = true;

			$stringErrores="";

			$marca = $_POST['marca'];
			if(!($vehiculo['marca'] == $_POST['marca'])){
				if(!preg_match($text_pattern, $marca))
				{
					$stringErrores.='+ La marca no es valida <br>';
					$ok = false;
				}
			}

			$modelo = $_POST['modelo'];
			if(!($vehiculo['modelo'] == $_POST['modelo'])){
				if(!preg_match($text_pattern, $modelo))
				{
					$stringErrores.='+ El modelo ingresado no es válido. <br>';
					$ok = false;
				}
			}

			$cant_asientos = $_POST['cant_asientos'];
			if(!($vehiculo['cant_asientos'] == $_POST['cant_asientos'])){
				if($cant_asientos < 1)
				{
					$stringErrores.='+ Debe tener al menos 1 asiento. <br>';
					$ok = false;
				}
			}

			$tipo = $_POST['tipo'];
			if(!($vehiculo['tipo'] == $_POST['tipo'])){
				if($tipo < 0)
				{
					$stringErrores.='+ El tipo de vehiculo ingresado no es valido. <br>';
					$ok = false;
				}
			}

			$color = $_POST['color'];
			if(!($vehiculo['color'] == $_POST['color'])){
				if(!preg_match($text_pattern, $color))
				{
					$stringErrores.='+ El color no es valido. <br>';
					$ok = false;
				}
			}

			if(!$ok){
				echo '	<div class="alert alert-warning alert-dismissible fade show centrado" role="alert" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.5)">
				  		<h4 class="alert-heading">Algo salio mal
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    					<span aria-hidden="true">&times;</span>
				  				</button>
							</h4>
							'.$stringErrores.'
				  		<hr>
				  		<p class="mb-0">modifica los datos y volve a intentarlo ;)</p>
					</div>';
			}

		 	if($ok)
		 	{

		 		$consulta = "UPDATE vehiculo
		 					 SET cant_asientos = '$cant_asientos', marca = '$marca', modelo = '$modelo', color = '$color', tipo = '$tipo'
		 					 WHERE idVehiculo = '$_POST[idVehiculo]' ";
		 		mysqli_query($conexion, $consulta) or
		 										   die("error en la modificacion".mysqli_error($conexion));
													 
		 		setcookie("modifica_vehiculo",true);
		 		$r = new Router;
		 		$file = $r->get_file();
		 		header('Location: /' . $file);
		 	}
