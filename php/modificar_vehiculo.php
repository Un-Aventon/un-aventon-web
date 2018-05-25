<?php

	$pattern_old = '/^[a-zA-Z]{3}[0-9]{3}/';
	$pattern_new = '/^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}/';
	$text_pattern = '/^[a-zA-Z0-9 ]{3,50}$/';

			$ok = true;
		 	$marca = $_POST['marca'];
		 	if(!preg_match($text_pattern, $marca))
		 	{
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    La marca ingresada no es válida.
              </div>';
		 		$ok = false;
		 	}

		 	$modelo = $_POST['modelo'];
		 	if(!preg_match($text_pattern, $modelo))
		 	{
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El modelo ingresado no es válido.
              </div>';
		 		$ok = false;
		 	}

		 	$cant_asientos = $_POST['cant_asientos'];
		 	if($cant_asientos < 1)
		 	{
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Debe tener al menos 1 asiento.
              </div>';
		 		$ok = false;
		 	}

		 	$tipo = $_POST['tipo'];
		 	if($tipo < 0)
		 	{
		 		echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El tipo ingresado no es válido.
              </div>';
            	$ok = false;
		 	}

		 	$color = $_POST['color'];
		 	if(!preg_match($text_pattern, $color))
		 	{
	                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El color ingresado no es válido.
              </div>';
		 		$ok = false;
		 	}

		 	if($ok)
		 	{

		 		$consulta = "UPDATE vehiculo
		 					 SET cant_asientos = '$cant_asientos', marca = '$marca', modelo = '$modelo', color = '$color', tipo = '$tipo'
		 					 WHERE idVehiculo = '$_POST[idVehiculo]' ";
		 		mysqli_query($conexion, $consulta) or
		 										   die("error en la modificacion".mysqli_error($conexion));

		 		echo '<div class="alert alert-success" role="alert"> El vehiculo se modifico exitosamente</div>';

		 		setcookie("modifica_vehiculo",true);
		 		$r = new Router;
		 		$file = $r->get_file();
		 		header('Location: /' . $file);
		 	}
