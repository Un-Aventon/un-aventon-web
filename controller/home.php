<?php

	function render($vars = [])
	{
		?>
		<div class="row">
			<?php
			// incluyo la conexion.
			include('php/conexion.php');

			$viajes=mysqli_query($conexion,"select *
											from viaje
											inner join usuario on viaje.idPiloto = usuario.idUser
											where fecha_partida > now() and estado = 1") or
											die("Problemas en el select:".mysqli_error($conexion));

						while ($viaje=mysqli_fetch_array($viajes)){
							?>

							<div class="card" style="width: 49%; display: inline-block; margin: auto; margin-bottom: 4px; margin-top:4px">
  							<img class="card-img-top" src="img/prueba_maps.png" alt="Card image cap">
  							<div class="card-body">
									<div class="row">
										<div class="col-md-6" style="text-align:center">
											<?php echo $viaje['origen']; ?> <br>
											a <br>
											<?php echo $viaje['destino']; ?>
										</div>
										<div class="col-md-4">
											<small>
											<b style="color:grey">Piloto </b> <?php echo $viaje['nombre']." ".$viaje['apellido'] ?> <br>
											<?php echo $viaje['asientos_disponibles'] ?> asientos disponibles <br>
											publicado <?php echo dias_transcurridos($viaje['fecha_publicacion']); ?> <br>
											</small>
										</div>
										<div class="col-md-2">
											<button class="btn btn-danger centrado" type="button" name="button">Ver mas!</button>
										</div>
									</div>
  							</div>
							</div>


				 <?php } ?>
		</div>

		<br><br><br><br><br><br><br><br><br><br>

<?php
	}
