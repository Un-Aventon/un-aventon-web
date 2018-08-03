<?php

	function render($vars = [])
	{
		?>


		<div class="row" style="padding:10px 10px;">
			<div class="col-md-3" style="background-color: #fafafa; padding: 20px 15px; border-radius: 8px">
				<form action="" method="POST" class="form-inline my-2 my-lg-0">
					<div class="">
						<input class="form-control mr-sm-1" type="search" aria-label="Search" placeholder="Viajo desde..." name="origen" id="origen" required style="width: 75%" <?php if(isset($_POST['origen'])){ echo 'value="'.$_POST['origen'].'"';} ?>><br/>
				      	<input class="form-control mr-sm-1" type="search" aria-label="Search" placeholder="Viajo hacia..." name="destino" id="destino" style="width: 75%" <?php if(isset($_POST['destino'])){ echo 'value="'.$_POST['destino'].'"';} ?>>

					</div>
				      	<input type="date" id="fecha" name="fecha_partida" class="form-control" min="<?php echo date('Y-m-d'); ?>" style="width: 75%" <?php if(isset($_POST['fecha_partida'])){ echo 'value="'.$_POST['fecha_partida'].'"';} else { echo 'value="'.date('Y-m-d').'"'; } ?>><br/>
				      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"> Buscar <img src="https://png.icons8.com/ios-glyphs/2x/search.png" alt="" placeholder="fecha de partida" style="width:20px; margin-top:-3px"> </button>
				</form>
				<br>
				

				<a href="/altaviaje"><img src="img/boton.jpg" alt="" class="img-fluid boton_crear"></a>

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

			include('php/filtro.php');

			$v = viajes_query();
			$viajes=mysqli_query($conexion, $v) or
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
																															where estado=2 and idViaje=$viaje[idViaje]")
																															or die ("problemas en el contador de asientos disponibles");
						  $contador_participaciones = $viaje['asientos_disponibles'] - mysqli_num_rows($contador_participaciones);
							?>

							<div class="card" style="width: 32%; display: inline-block; margin: 4px 1px; box-shadow: 0px 2px 2px #efefef; min-height: 250px">
							  <!--<img class="card-img-top" src="img/prueba_maps.png" alt="Card image cap">-->
							  <div class="card-body">
							    <h5 class="card-title"> <span title="<?php echo $viaje['origen'];?>"><?php echo introtext($viaje['origen']); ?></span> <br> <small style="color:grey">a</small> <br> <span title="<?php echo $viaje['destino']; ?>"><?php echo introtext($viaje['destino']); ?></span> <br> <small>en <?php echo $viaje['tipoVehiculo']; ?></small> </h5>
									<div class="row fluid" style="background-color: #EFEFEF; width: 118%; margin-left: -20px">
										<div class="col-md-12">
											<center><?php echo date_toString($viaje['fecha_partida'],"br"); ?></center>
										</div>
									</div>
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
							    <a href="/viaje/<?php echo $viaje['idViaje'];?>/<?php echo $viaje['origen']."-".$viaje['destino'];?>" class="btn btn-danger" style="width: 100%">Ver mas</a>  <span><?php //echo dias_transcurridos($viaje['fecha_partida'],'partida') ?></span>
							  </div>
							</div>

				 <?php } ?>

			 </div>
		</div>

<?php
	}
