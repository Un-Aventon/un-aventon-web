<?php
function render($vars = [])
{
	//parche
	echo '</div>
			<div class="container h-100" style="background-repeat:no-repeat; background-size: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;">
			<br/>
			';

	if(!isset($_SESSION['userId']))
	{
		header('location: /');
	}
	$ok = false;
	if(isset($_POST['pass']))
	{
		$ok = true;
		include('php/conexion.php');
		$u_id = $_SESSION['userId'];

		// verifico la contraseña
		$user = mysqli_query($conexion, "SELECT * FROM usuario where idUser = $u_id ");
		if ($u = mysqli_fetch_array($user) and $u['clave'] != $_POST['pass']) {
			echo '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
						La contraseña ingresada no es correcta.
				</div>';
			$ok=false;
		}
		else {
			$pagosPendientes = mysqli_query($conexion, "SELECT * FROM pago
																									INNER JOIN viaje ON viaje.idViaje = pago.idViaje
																									WHERE (viaje.estado = 3) AND (viaje.idPiloto = $u_id) AND (pago.estado IS NULL)");
			if(mysqli_num_rows($pagosPendientes) > 0)
			{
				echo '<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
							Para darte de baja primero debes efectuar los pagos que tienes pendientes.
					</div>';
				$ok=false;
			}
			else {

						//postulaciones no aceptadas
						$postulaciones_na = mysqli_query($conexion, "DELETE from participacion where idUsuario = $u_id and estado=1 ");

						//postulaciones aceptadas
						$postulaciones_ac = mysqli_query($conexion, "UPDATE participacion SET estado = 3 where idUsuario = $u_id and estado = 2");

						//Viajes activos SOLO con sus respectivas postulaciones
						$vp = mysqli_query($conexion,
							"UPDATE participacion as p
							 INNER JOIN viaje as v ON p.idViaje = v.idViaje
							 set p.estado = 4, v.estado = 2
							 where v.idPiloto = $u_id
							 and v.estado = 1
							") or die("viajes con postulaciones". mysqli_error($conexion));

							// VIAJES QUE NO TIENEN POSTULANTES y no son alcanzables desde la actualizacion anterior
							$v = mysqli_query($conexion,
								"UPDATE viaje as v
								 set v.estado = 2
								 where v.idPiloto = $u_id
								 and v.estado = 1
								") or die("viajes solos".mysqli_error($conexion));



						$usuario = mysqli_query($conexion, "UPDATE usuario SET estadoUsuario = 2 where idUser = '$u_id'") or die (mysqli_error($conexion));

						if($ok and $postulaciones_ac and $vp and $v and $usuario)
						{
							session_destroy();
							echo '<div class="alert alert-success">
										La cuenta se elimino correctamente.<br/>
										<a href="/"> Ir al inicio</a>
								</div>';
							$ok = true;
						}
			}

		}
		}
	if(!$ok)
	{
		//Formulario de baja
		?>

	  	<div class="row h-50 justify-content-center align-items-center">
			<div class="card bg-white" style="max-width: 600px; height: 240px; margin-top: 20px; margin-bottom: 20px">
  			<div class="card-header"><h2 class="text-center">Eliminar cuenta</h2></div>
  			<div class="card-body">
    			<form action="/del_account" method="post">
				  <div class="form-group">
				    <label for="exampleInputPassword1">Ingresa tu contraseña para realizar la eliminacion</label>
				    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Ingresa una contraseña">
				  </div>

				  <div class="container-fluid" style="margin-top:.5rem; padding: 0">
						<input type="submit" onclick="return confirm('Esta seguro que desea eliminar su cuenta? \n esta accion es irreversible')" name="login" value="Eliminar cuenta" class="btn btn-danger form-control form-control-lg">
				  </div>
				</form>
 			 </div>
		</div>
	</div>
</div>

<!-- fin parche = abro container -->
<div class="container" style="border-radius: 5px">

		<?php
	}


}
