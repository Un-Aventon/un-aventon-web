<?php

	$pattern_old = '/^[a-zA-Z]{3}[0-9]{3}/';
	$pattern_new = '/^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}/';
	$text_pattern = '/^[a-zA-Z0-9 ]{3,50}$/';


	if((!preg_match($pattern_old, $_POST['patente'])) and (!preg_match($pattern_new, $_POST['patente'])))
	{
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    La patente ingresada no es válida.
              </div>';
	}else
	{
		$ok = true;

		$patente = $_POST['patente'];
		isset($user)? $u = $user['idUser'] : $u = $_SESSION['userId'];

		$rec=mysqli_query($conexion,"SELECT * FROM vehiculo WHERE patente='$patente' and idPropietario = '$u' and eliminado = 0 ");

		if(mysqli_fetch_array($rec))
		{
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                   La patente ya se encuentra registrada.
              </div>';
		 	$ok = false;
		}else
		{
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
                    Debe tener almenos 1 asiento.
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


		 		//echo $u;

		 		mysqli_query($conexion,"INSERT into vehiculo (idPropietario,cant_asientos,modelo,marca,color,patente,tipo,eliminado) VALUES ('$u','$cant_asientos','$modelo','$marca','$color','$patente','$tipo' , 0 )") or die ('error '.mysqli_error($conexion));

		 		echo '<div class="alert alert-success" role="alert"> El vehiculo se cargo exitosamente</div>';

		 		setcookie("carga_vehiculo",true);
		 		$r = new Router;
		 		$file = $r->get_file();
		 		header('Location: /' . $file);
		 	}

		 }
	}
