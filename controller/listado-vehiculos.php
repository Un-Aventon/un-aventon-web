<?php

function render($vars = []){

	include('php/conexion.php');
	// si hay vehiculo para cargar, incluyo el algoritmo.
	!isset($_POST['marca'])?:include('php/alta_vehiculo.php');
	 if(isset($_COOKIE["carga_vehiculo"]) && $_COOKIE["carga_vehiculo"])
 	 {
      echo '<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    La carga del vehiculo se realizó correctamente!
              </div>';
      setcookie("carga_vehiculo",false);
 	 }
	?>


		<!-- Modal -->
		<div class="modal fade" id="CargarAuto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Registrar un Vehiculo</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form action="/listado-vehiculos" method="post">
		          <div class="form-group">
		            <label for="exampleInputEmail1">Marca</label>
		            <input type="text" name="marca" class="form-control" id="marca" aria-describedby="emailHelp" placeholder="Ingresa la marca">
		          </div>
		          <div class="form-group">
		            <label for="exampleInputPassword1">Modelo</label>
		            <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Ingrese el modelo">
		          </div>
		          <div class="form-group">
		            <label for="exampleInputPassword1">Patente</label>
		            <input type="text" name="patente" class="form-control" id="patente" placeholder="Ingresa la patente">
		          </div>
		          <div class="form-group">
		            <label for="exampleInputPassword1">Cantidad de Asientos (sin contar el del conductor)</label>
		            <input type="number" name="cant_asientos" class="form-control" id="cant_asientos" placeholder="Ingrese la cantidadde asientos">
		          </div>
		          <div class="form-group">
		            <label for="exampleInputPassword1">Color</label>
		            <input type="text" name="color" class="form-control" id="color" placeholder="Ingresa el color">
		          </div>

		          <div class="container-fluid" style="margin-top:.5rem; padding: 0">
		            <input type="submit" name="registro" value="Cargar!" class="btn btn-success form-control form-control-lg">
		          </div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- End Modal -->
	<!-- PARCHE: Cierro container superior -->
		</div>
	<!-- Abro nuevo container -->
		<div class="container" style="width:200rem; padding-left: 3rem">
		<div class="row">
		    <div class="col-md-3" style="text-align: center">
		      <img src="img/user.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
		    </div>
		    <div class="col-md-8" style="margin-top: 1.5rem">
		      <h1 class="display-4" style="font-family: helvetica;">Mis vehículos</h1>
		      <p> El listado completo de los vehículos que has registrado con anterioridad. </p>
		    </div>
		</div>
		<div class="row">
			<div class="offset-10">
				<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#CargarAuto">Agregar vehículo</button>
			</div>
		</div>
		 <hr>
	<?php

	$consulta = "select *, vehiculo.tipo as 'vehiculotipo' 
							from vehiculo
							INNER JOIN tipo_vehiculo on vehiculo.tipo=tipo_vehiculo.idTipo
						  where idPropietario='$_SESSION[userId]'";

	$vehiculos=mysqli_query($conexion, $consulta)
			or die("error de la consulta:".mysqli_error($conexion));

	$elementosEnFila;

	$vehiculo = mysqli_fetch_array($vehiculos);
	while($vehiculo){
		?>
		<div class="row" style="margin-top: 2rem">
			<div class="card-deck">
		<?php

		// Muestra los elementos en filas de a 3 vehiculos
		$elementosEnFila = 1;
		while(($vehiculo) &&($elementosEnFila <= 3)){
			// Incluye todo el contenido html de un vehiculo
?>
				<div class="card" style="width: 20rem;">
							    <div class="card-header bg-dark text-white">
								    	<div class="profile-header-container">
								  			<div class="row" style="margin-top: -.5rem; margin-left: -1rem;">
								  				<div class="col col-md-4 profile-header-img">
											     	<img class="img-circle" src="img/icono_coche.jpg"/>
												</div>
												<div class="col col-md-8" style="margin-top: 1.5rem; margin-left: -1.7rem;">
											   		<p class="text-left tipo" style="font-family: helvetica; font-size: 1.3rem"> <?php echo $vehiculo['tipo'];?></p>
												</div>
								  			</div>
										</div>
								    </div>
							    <div class="card-body">
							      <h5 class="card-title text-center" style="font-family: sans-serif;font-size: 1.3rem;color: #575656; margin-top: .3rem; margin-bottom: 1.3rem;">Detalles del vehículo</h5>
									<table class="table">
									  <tbody>
									    <tr>
									      <th scope="row">Modelo</th>
									      <td><?php echo "$vehiculo[marca] $vehiculo[modelo]"; ?></td>
									    </tr>
									    <tr>
									      <th scope="row">Patente</th>
									      <td><?php echo $vehiculo['patente']; ?></td>
									    </tr>
									    <tr>
									      <th scope="row">Color</th>
									      <td style=""><?php echo $vehiculo['color']; ?></td>
									    </tr>
									    <tr>
									      <th scope="row">Cantidad<br>Asientos</th>
									      <td><?php echo $vehiculo['cant_asientos']; ?></td>
									    </tr>
									  </tbody>
									</table>
							    </div>
							    <div class="card-footer">
							      <div class="row">
							      	<div class="col col-md-6">
							      			<button type="button" class="btn btn-outline-dark btn-block">Modificar</button>
							      		</div>
							      		<div class="col col-md-6">
							      			<button type="button" class="btn btn-outline-danger btn-block">Eliminar</button>
							      		</div>
							      </div>
							    </div>
							  </div>
							  <?php

			// Nuevo elemento en la fila
			$elementosEnFila++;

			// Nos traemos el proximo vehiculo, si existe
			$vehiculo = mysqli_fetch_array($vehiculos);
		}
		?>
		</div> <!-- Fin div "card-deck" -->
	</div>	<!-- Fin div "row" -->
		<?php
	}
	?>
	<!-- PARCHE fin -->
	</div>

	<!-- Abro container para el footer -->
	<div class="container">
	<?php
}
