<?php

	function render($vars = [])
	{
		?>


		<div class="row" style="padding:10px 10px;">
			<div class="col-md-3" style="background-color: #fafafa; padding: 20px 15px; border-radius: 8px">
				<form class="form-inline my-2 my-lg-0">
				      <input class="form-control mr-sm-1" type="search" aria-label="Search" placeholder="Quiero viajar a..." style="width: 75%">
				      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"> <img src="https://png.icons8.com/ios-glyphs/2x/search.png" alt="" style="width:20px; margin-top:-3px"> </button>
				</form>
				<br>
				<div class="strike">
   				<span>filtros</span>
				</div>
				<nav class="nav flex-column">
				  <a class="nav-link active" style="color: #333!important" href="#">viajes menores a 2000 km</a>
				  <a class="nav-link" href="#" style="color: #333!important">viajes recurrentes</a>
				  <a class="nav-link" href="#" style="color: #333!important">+ de 1 asientos disponibles</a>
				</nav>
				<center><button type="button" class="btn btn-outline-danger" style="width:100%">Aplicar</button></center>
				<br>

				<div class="strike">
   				<span>orden</span>
				</div>
				<nav class="nav flex-column">
				  <a class="nav-link active" style="color: #333!important" href="#">mejor puntaje piloto</a>
				  <a class="nav-link" href="#" style="color: #333!important">menor recorrido</a>
				  <a class="nav-link" href="#" style="color: #333!important">mayor recorrido</a>
				</nav>
				<center><button type="button" class="btn btn-outline-danger" style="width:100%">Aplicar</button></center>
				<hr>

				<a href="#"><img src="img/boton.jpg" alt="" class="img-fluid boton_crear"></a>

				<hr>

				<h3 style="text-align: center">
				<?php
					include('php/conexion.php');
					$contador=mysqli_query($conexion,"SELECT *
																						from viaje
																						where estado=3")
																						or die ("problmas con el contador");
					echo mysqli_num_rows($contador);
					?>
					<br>
					<small>viajes exitosos</small>
					</h3>

 			</div>
			<div class="col-md-9">
			<?php
			$viajes=mysqli_query($conexion,"SELECT *, tipo_vehiculo.tipo as tipoVehiculo
											from viaje
											inner join usuario on viaje.idPiloto = usuario.idUser
											inner join vehiculo on viaje.idVehiculo = vehiculo.idVehiculo
											inner join tipo_vehiculo on vehiculo.tipo = tipo_vehiculo.idTipo
											where fecha_partida > now() and estado = 1
											order by fecha_partida") or
											die("Problemas en el select:".mysqli_error($conexion));

											// to do: meterle un poco de color
											if (mysqli_num_rows($viajes) == 0){
							            echo "<div class='alert alert-light' role='alert'>
  																	Parece que no hay viajes disponibles <a href='#' class='alert-link'>:(</a>
																</div>";
							        }

						while ($viaje=mysqli_fetch_array($viajes)){

							$contador_participaciones=mysqli_query($conexion,"SELECT *
																															from participacion
																															where estado=1 and idViaje=$viaje[idViaje]")
																															or die ("problemas en el contador de asientos disponibles");
						  $contador_participaciones = $viaje['asientos_disponibles'] - mysqli_num_rows($contador_participaciones);
							?>

							<div class="card" style="width: 32%; display: inline-block; margin: 4px 1px; box-shadow: 2px 2px 10px #f0f0f0; min-height: 250px">
							  <!--<img class="card-img-top" src="img/prueba_maps.png" alt="Card image cap">-->
							  <div class="card-body">
							    <h5 class="card-title"> <span title="<?php echo $viaje['origen'];?>"><?php echo introtext($viaje['origen']); ?></span> <br> <small style="color:grey">a</small> <br> <span title="<?php echo $viaje['destino']; ?>"><?php echo introtext($viaje['destino']); ?></span> <br> <small>en <?php echo $viaje['tipoVehiculo']; ?></small> </h5>
							    <p class="card-text">
										<div class="strike">

											<span><h6><?php if ($contador_participaciones > 0) {
																						echo $contador_participaciones."<small> asientos disponible/s </small>";
																					}
																			else{
																						echo "<small>No quedan asientos</small>";
																			}
											?> </h6></span>
										</div>
										<h4 style="text-align: center; color: #53b842">$<?php    // parche para la primera demo unicamente
										 																														if ($viaje['asientos_disponibles'] > 0) {echo round($viaje['costo']/$viaje['asientos_disponibles']);}
										 																														else {echo $viaje['costo'];}?></h4>
									</p>
							    <a href="/viaje/<?php echo $viaje['idViaje'];?>/<?php echo $viaje['origen']."-".$viaje['destino'];?>" class="btn btn-danger">Ver mas</a>  <span><?php echo dias_transcurridos($viaje['fecha_partida'],'partida') ?></span>
							  </div>
							</div>

				 <?php } ?>

			 </div>
		</div>

<?php
	}
