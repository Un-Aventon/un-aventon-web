<?php

	$id = $_POST['idBaja'];
	if(preg_match('/[0-9]/', $id))
	{

		$c = mysqli_query($conexion, "SELECT * from vehiculo where idVehiculo = $id");
		$cant = mysqli_num_rows($c);
		$c = mysqli_fetch_array($c);
		if($cant == 0 || $c['idPropietario'] != $_SESSION['userId'])
		{
			//no se encontro el vehiculo
			echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    No se encotro el vehiculo.
              </div>';

		}else
		{
			$c = mysqli_query($conexion, "SELECT * from viaje where idVehiculo=$id");
			if(mysqli_num_rows($c) > 0)
			{
				echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El vehiculo se encuentra postulado a viajes.
              </div>';

			}else
			{
				mysqli_query($conexion, "DELETE FROM vehiculo where idVehiculo=$id")or die('error '.mysqli_error($conexion));
				echo '<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El vehiculo elimino correctamente.
              </div>';
			}

		}
	}