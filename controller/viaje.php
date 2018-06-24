<?php

	function render($vars = [])
	{
    // incluyo la conexion.
    include('php/conexion.php');

    $viaje=mysqli_query($conexion,"SELECT *
                                   from viaje
                                   inner join vehiculo on viaje.idVehiculo=vehiculo.idVehiculo
                                   inner join tipo_vehiculo on vehiculo.tipo=tipo_vehiculo.idTipo
                                   inner join usuario on viaje.idPiloto=usuario.idUser
                                   where idViaje = $vars[0]")
                                   or die ("problemas con el selectttt".mysqli_error($conexion));
    $viaje=mysqli_fetch_array($viaje);

		$contador_participaciones=mysqli_query($conexion,"SELECT *
																										from participacion
																										where estado=2 and idViaje=$viaje[idViaje]")
																										or die ("problemas en el contador de asientos disponibles");
		$contador_participaciones = $viaje['asientos_disponibles'] - mysqli_num_rows($contador_participaciones);

		//parche ARREGLAR
		if (isset($_SESSION['userId'])){
		if ($_SESSION['userId'] != $viaje['idPiloto']) {
		!isset($_POST['carga_participacion'])?:include('php/alta_participacion.php');
		if(isset($_COOKIE["carga_participacion"]) && $_COOKIE["carga_participacion"])
	  {
	      setcookie("carga_participacion",false);
	  }
	}
}

		!isset($_POST['baja_participacion'])?:include('php/baja_participacion.php');
		if(isset($_COOKIE["baja_participacion"]) && $_COOKIE["baja_participacion"]){
			setcookie("baja_participacion",false);
		}

		!isset($_POST['aceptar_postulacion'])?:include('php/aceptar_participacion.php');
		if(isset($_COOKIE["aceptar_postulacion"]) && $_COOKIE["aceptar_postulacion"]){
			setcookie("aceptar_postulacion",false);
		}

		!isset($_POST['rechazar_postulacion'])?:include('php/rechazar_participacion.php');
		if(isset($_COOKIE["rechazar_postulacion"]) && $_COOKIE["rechazar_postulacion"]){
			setcookie("rechazar_postulacion",false);
		}

    ?>
    <div class="row" style="padding: 5px 0px;">
      <div class="col-md-6" style="">
        <style>
			#map {
				width: 103%;
				height: 100%;
				background-color: grey;
			}
		</style>
		<div id="map" style="border-radius: 4px; margin-top: 5px; margin-left: -5px"></div>
		<script>
			function initMap() {
				var directionsService = new google.maps.DirectionsService;
				var directionsDisplay = new google.maps.DirectionsRenderer;


				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 4.5,

				});

				directionsDisplay.setMap(map);

				directionsService.route({
				  origin: '<?php echo $viaje["origen"] ?>',
				  destination: '<?php echo $viaje["destino"] ?>',
				  travelMode: 'DRIVING'
				}, function(response, status) {
				  if (status === 'OK') {
				    directionsDisplay.setDirections(response);
				  } else {
				    window.alert('Directions request failed due to ' + status);
				  }
				});


			}
		 </script>

		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCmsUIxdjkHChho9s5V1T7Xl4axSmR3-w&callback=initMap">
		</script>
      </div>
      <div class="col-md-6">
				<div class="row" style="min-height: 130px">
					<div class="col-md-10 col-sm-12">
						<h1><?php echo $viaje['origen'] ?> a <?php echo $viaje['destino']; ?></h1>
						<span title="<?php echo $viaje['fecha_publicacion'] ?>">Publicado <?php echo dias_transcurridos($viaje['fecha_publicacion'],'publicacion');?>
							por <a href="/usuario/<?php echo $viaje['idPiloto'];?>"><?php echo $viaje['nombre']." ".$viaje['apellido']; ?></a> <small>(<?php echo calificacion($viaje['idPiloto']); ?> pts.)</small>
						</span>
					</div>
					<div class="col-md-2">
						<div class="contenedorUno centrado" style="border: 1px solid #fff; border-radius: 4px; padding: 4px 4px; background-color: #f0f0f0; margin-top: 8px">
							<?php if ((isset($_SESSION['userId'])) && ($viaje['idPiloto'] == $_SESSION['userId']))
												{echo "<center> <img src='/img/sys/volante.png' style='width:30px'> <br> <small>soy piloto</small> <hr>";}
						 	?>
							<h6 class="" style="text-align:center"><?php if($contador_participaciones>0){echo $contador_participaciones;}else{echo "sin";}; ?><br>vacantes</h6>
						</div>

					</div>
				</div>
        <hr>
        <div class="row">
          <div class="col-md-3">
            <img src="<?php echo $viaje['icono']; ?>" alt="" class="img-fluid">
          </div>
          <div class="col-md-9">
            <br>
            <span><?php echo $viaje['marca']." / ".$viaje['modelo'] ?></span> <span class="badge badge-secondary float-right"><?php echo $viaje['patente'] ?></span> <br>
            <span><?php echo $viaje['color'] ?></span> <span class="float-right"><?php echo $viaje['cant_asientos'] ?> asientos</span>
          </div>
        </div>

        <hr>

				<div class="row">
					<div class="col-md-6">
									<h6 class="" style="text-align: center">
											<small>partida</small> <br>
											<?php
														$dias = array("...","lunes","martes","miercoles","jueves","viernes","sábado","domingo");
														$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
														$date = date_create($viaje['fecha_partida']);
														echo $dias[date_format($date, 'N')]." ".date_format($date, 'd')." de ".$meses[date_format($date, 'm')-1] ;
														echo " - ";
														echo date_format($date, 'G:ia');
											?>
									</h6>


					</div>
					<div class="col-md-6">
						<h3 style="text-align: center; color: #53b842">$<?php echo $viaje['costo']/($viaje['asientos_disponibles']+1); ?> <small> / por persona</small></h3>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6" style="text-align: center">
						<h6><?php echo "$".$viaje['costo']?></h6>
						<small> costo total del viaje</small>
					</div>
					<div class="col-md-6">
							<button type="button" class="btn btn-dark centrado" title="Una vez que el viaje termine podras pagarlo" disabled>Pago pendiente</button>
					</div>
				</div>
				<hr>
				<form action="/viaje/<?php echo $vars[0] ?>" method="post">
					<input type="hidden" name="carga_participacion" value="<?php echo $vars[0] ?>">
				<?php



				if (!isset($_SESSION['userId'])) {
					echo '<a class="btn btn-outline-secondary" href="../../login" style="width:100%">Tenes que estar logeado para poder participar</a>';
				}
				elseif ($_SESSION['userId'] != $viaje['idPiloto']) {
				echo '<div class="btn-group" role="group" aria-label="..." style="width: 100%">';
				$participacion=mysqli_query($conexion,"SELECT *
																							 from participacion
																							 where idViaje='$viaje[idViaje]' and idUsuario='$_SESSION[userId]'
																							 order by idParticipacion ASC")
																							 or die ("error participacion".mysqli_error($conexion));
				$participacion=mysqli_fetch_array($participacion);

				switch ($participacion['estado']) {
					case 1:
						echo '<button type="" class="btn btn-primary" style="width:100%" disabled>Postulacion pendiente de aprobacion</button>';
						break;
					case 2:
						echo '<button type="" class="btn btn-success" style="width:100%" disabled>Participacion aprobada</button>';
						break;
					case 3:
						echo '<button type="submit" class="btn btn-warning" style="width:100%" disabled>Cancelaste una postulacion</button>';
						break;
					case 4:
						echo '<button type="" class="btn btn-danger" style="width:100%" disabled>Participacion rechazada</button>';
						break;
					default:
						echo '<button type="submit" class="btn btn-outline-danger" style="width:100%">Participar</button>';
						break;
					}

			?>
			</form>
			<?php

				if (($participacion['estado'] == 2) || ($participacion['estado']==1)) {
					echo '<center>
										<form action="/viaje/'.$vars[0].'" method="post">
													<input type="hidden" name="idParticipacion" value="'.$participacion['idParticipacion'].'">
													<input type="hidden" name="baja_participacion" value="'.$vars[0].'">
													<input type="hidden" name="estado" value="'.$participacion['estado'].'">
													<button type="submit" class="btn btn-light">cancelar participacion</button>
										</form>
								</center>';
				}
				elseif ($participacion['estado'] == 3){
						echo '<form action="/viaje/'.$vars[0].'" method="post">
												<input type="hidden" name="carga_participacion" value="'.$vars[0].'">';

						echo '<center><button type="submit" class="btn btn-light">Volver a postularme</button></center>';
						echo '</form>';
				}

				echo "</div>";
			}
			else {
				$participaciones_copiloto=mysqli_query($conexion,"SELECT *
																								 from participacion
																								 inner join usuario on participacion.idUsuario=usuario.idUser
																								 where idViaje='$viaje[idViaje]'")
																								 or die ("problemas con el listado de participaciones del piloto");
				echo '<button type="button" class="btn btn-light btn-sm" style="margin-bottom: 10px; width: 100%">
  								Postulaciones/Participaciones totales <span class="badge badge-danger">'.mysqli_num_rows($participaciones_copiloto).'</span>
							</button>';
				echo '<div class="mCustomScrollbar" data-mcs-theme="minimal-dark" style="max-height: 300px; overflow: auto;">';
				if(mysqli_num_rows($participaciones_copiloto)==0)
						 {echo "<br><small>(no hay participaciones todavia)</small>";}
				while ($participacion_copiloto=mysqli_fetch_array($participaciones_copiloto)){
					echo '<div class="postulacion">';
					echo '<a href="/usuario/'.$participacion_copiloto["idUsuario"].'"> '.$participacion_copiloto["nombre"].' '.$participacion_copiloto["apellido"].'</a> <small>| '.calificacion($participacion_copiloto['idUsuario']).' puntos</small><br>';
					$calificaciones = calificacion_grafica_simple($participacion_copiloto['idUser']);
					echo "<div class='progress' style='height: 2px; width: 50%; margin-bottom: 10px'>
									<div class='progress-bar bg-success' role='progressbar' style='width: ".$calificaciones['porcentaje_pos']."%;' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
									<div class='progress-bar bg-warning' role='progressbar' style='width: ".$calificaciones['porcentaje_neu']."%; background-color: #ffd000!important' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
									<div class='progress-bar bg-danger' role='progressbar' style='width: ".$calificaciones['porcentaje_neg']."%; background-color: #ff8080!important' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
								</div>";
					switch ($participacion_copiloto['estado']) {
						case 1:
							echo '<div class="row"><div class="col-md-9">';
							echo '<img src="/img/sys/hand.png" style="width:20px">';
							echo ' Pendiente de aprobacion';


							// boton aceptar
							echo '<form action="/viaje/'.$vars[0].'" method="post" style="display: inline-block">
													<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
													<input type="hidden" name="estado" value="'.$participacion_copiloto['estado'].'">
													<input type="hidden" name="aceptar_postulacion" value="'.$vars[0].'">
													</div>

													<div class="col-3">
													<div class="btn-toolbar" role="toolbar" aria-label="">
  														<div class="btn-group" role="group" aria-label="group">
													<button type="submit" class="buttonText buttonTextVerde">aprobar</button>
										</form>';
										// boton rechazar
										echo '<form action="/viaje/'.$vars[0].'" method="post" style="display: inline-block">
																	<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
																	<input type="hidden" name="estado" value="'.$participacion_copiloto['estado'].'">
																	<input type="hidden" name="rechazar_postulacion" value="'.$vars[0].'">


															<button type="submit" class="buttonText buttonTextRojo float-right">rechazar </button>
													</form></div>
											</div>
													</div>';
							echo '</div>';
							break;
						case 2:
						echo '<div class="row"><div class="col-md-8">';
						echo '<img src="/img/sys/ok.png" style="width:20px">';
						echo ' | Participacion aprobada';
						echo '<form action="/viaje/'.$vars[0].'" method="post" style="display: inline-block">
													<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
													<input type="hidden" name="estado" value="'.$participacion_copiloto['estado'].'">
													<input type="hidden" name="rechazar_postulacion" value="'.$vars[0].'">
													</div><div class="col-4">
											<button type="submit" class="buttonText buttonTextRojo float-right">rechazar participacion</button>
									</form>';
						echo '</div></div>';
							break;
						case 3:

								echo '<img src="/img/sys/private.png" style="width:20px">';
								echo ' Participacion cancelada por el copiloto';

							break;
						case 4:
								echo '<img src="/img/sys/private.png" style="width:20px">';
								echo ' Participacion cancelada por mi';
						break;
							break;
						default:
							echo "default";
							break;
						}
						echo '</div>';
				}
				echo '</div>';
			}
			?>
      </div>

    </div>
		<hr>
		<div class="row">
			<div class="col-md-12" style="padding: 0px 13px">
				<h5>Pregunta! <small>sacate las dudas</small> </h5>
				<div class="row">
					<div class="col-md-10">
						<textarea class="form-control" name="name" cols="80" style="width: 100%; min-height: 50px" placeholder="Ej: puedo llevar a mi perrito?, mate dulce o amargo?"></textarea>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-light" style="width:100%; height: 100%">Enviar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="height: 10px">
		</div>


    <?php
  }
