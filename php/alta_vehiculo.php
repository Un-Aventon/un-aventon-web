<?php

	$pattern_old = '/^[a-zA-Z]{3}[0-9]{3}/';
	$pattern_new = '/^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}/';
	$text_pattern = '/^[a-zA-Z0-9]{3,50}$/';

	if((!preg_match($pattern_old, $_POST['patente'])) and (!preg_match($pattern_new, $_POST['patente'])))
	{
		echo '<div class="alert alert-danger" role="alert"> La patente ingresada no es válida </div>';
	}else
	{
		$ok = true;

		$patente = $_POST['patente'];

		 $rec=mysqli_query($conexion,"SELECT * FROM vehiculo WHERE patente='$patente'");

		 if(mysqli_fetch_array($rec))
		 {
		 	echo '<div class="alert alert-danger" role="alert"> La patente se encuentra registrada </div>';
		 	$ok = false;
		 }else
		 {
		 	$marca = $_POST['marca'];
		 	if(!preg_match($text_pattern, $marca))
		 	{
		 		echo '<div class="alert alert-danger" role="alert"> La marca ingresada no es válida </div>';
		 		$ok = false;
		 	}

		 	$modelo = $_POST['modelo'];
		 	if(!preg_match($text_pattern, $marca))
		 	{
		 		echo '<div class="alert alert-danger" role="alert"> El modelo ingresado no es válido </div>';
		 		$ok = false;
		 	}

		 	$cant_asientos = $_POST['cant_asientos'];
		 	if($cant_asientos < 2)
		 	{
		 		echo '<div class="alert alert-danger" role="alert"> El vehiculo debe tener almenos 1 asiento</div>';
		 		$ok = false;
		 	}

		 	$color = $_POST['color'];
		 	if(!preg_match($text_pattern, $color))
		 	{
		 		echo '<div class="alert alert-danger" role="alert"> color ingresado no es válido</div>';
		 		$ok = false;
		 	}

		 	if($ok)
		 	{
		 		$rec=mysqli_query($conexion,"INSERT into vehiculo (idPropietario,cant_asientos,modelo,marca,color,patente,estado) VALUES ('$user[idUser]','$cant_asientos','$modelo','$marca','$color','$patente','re piola' )") or die ('error '.mysqli_error($conexion));

		 		echo '<div class="alert alert-success" role="alert"> El vehiculo se cargo exitosamente</div>';

		 		setcookie("carga_vehiculo",true);
		 		
		 		header('Location: /perfil');
		 	}

		 }
	}
