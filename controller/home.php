<?php

	function render($vars = [])
	{
		?>

		<div class="row">
			<div class="col-md-12">
				<h3>Viajes</h3>
			</div>
		</div>
		<div class="row">
			<?php
			//parche
      $conexion=mysqli_connect("localhost","root","","base") or
    		die("Problemas con la conexión a la base de datos");

			$viajes=mysqli_query($conexion,"select *
																						from viaje
																						inner join usuario on viaje.idPiloto = usuario.idUser") or
																						die("Problemas en el select:".mysqli_error($conexion));

						while ($viaje=mysqli_fetch_array($viajes)){
							?>
							<div class='col-md-6'>
								<div class="contenedor_viaje">
									<div class="row">

									<div class="col-md-4">
										<h5 style="text-align: center"><?php echo$viaje['origen']; ?><br> a <br> <?php echo$viaje['destino']; ?> </h5>
									</div>
									<div class="col-md-8">
										<i>piloto <?php echo$viaje['apellido']." ".$viaje['nombre']; ?></i>
										<br>
										partida: <?php echo$viaje['fecha_partida']; ?>
										<br>
										<b class="float-right">$<?php echo$viaje['costo']; ?></b>
									</div>
									</div>
								</div>
							</div>
							<?php
						}
			?>
		</div>

		<br><br><br><br><br><br><br><br><br><br>

		<?php
	}
