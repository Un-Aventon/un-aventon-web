<?php

	function render($vars = [])
	{
		if (!isset($vars[1])){
			$vars[1] = "coso";
		}
    // incluyo la conexion.
    include('php/conexion.php');

    !isset($_POST['localidad_origen'])?:include('php/modificar_viaje_control.php');

    $viaje=mysqli_query($conexion,"SELECT *
                                   from viaje
                                   inner join vehiculo on viaje.idVehiculo=vehiculo.idVehiculo
                                   inner join tipo_vehiculo on vehiculo.tipo=tipo_vehiculo.idTipo
                                   inner join usuario on viaje.idPiloto=usuario.idUser
                                   where idViaje = '$vars[0]'")
                                   or die ("problemas con el select de viaje".mysqli_error($conexion));
    $viaje=mysqli_fetch_array($viaje);

		// verifica que el viaje este activo o no
		if ($viaje['estado'] !=1 ){
			?>
				<center>
				<h1><?php echo $viaje['origen']; ?> ----> <?php echo $viaje['destino']; ?><br>
				<small><?php echo $viaje['fecha_partida']; ?></small></h1>
				</center>
			<?php
		}
		if ($viaje['estado'] == 2){
			echo "<center> <b> este viaje fue cancelado por su piloto </b> </center>";
		}
		elseif ($viaje['estado'] == 3){
			echo "<center> <b> este viaje ya termino </b> </center>";
		}
		else{

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

		!isset($_POST['responder'])?:include('php/responder_pregunta.php');
		if(isset($_COOKIE['responder_pregunta']) && $_COOKIE['responder_pregunta']){
			setcookie("responder_pregunta",false);
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
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8A8hlojftFLpwPtwrcFQ5LtSl-o_s2OU&callback=initMap">
		</script>
      </div>

      <div class="col-md-6">
				<div class="row" style="min-height: 130px">
					<div class="col-md-10 col-sm-12">
						<h1><?php echo $viaje['origen'] ?> a <?php echo $viaje['destino']; ?></h1>
						<?php
							//Traigo el modal de modificacion de viaje
							if((isset($_SESSION['userId'])) and ($viaje['idPiloto'] == $_SESSION['userId']))
							{
								include 'php/modificar_viaje_vista.php';
								echo '<a href="" data-toggle="modal" data-target="#ModViaje">Modificar el Viaje</a>';
							}
							else{
								echo '<a href="/usuario/'.$viaje['idPiloto'].'"> '.$viaje["nombre"].' '.$viaje["apellido"].'</a> <small>| '.calificacion($viaje['idPiloto']).' puntos</small> <i style="color: grey" class="float-right">piloto</i>';
								$calificaciones = calificacion_grafica_simple($viaje['idPiloto']);
								echo "<div class='progress' style='height: 2px; width: 100%; margin-bottom: 10px'>
												<div class='progress-bar bg-success' role='progressbar' style='width: ".$calificaciones['porcentaje_pos']."%;' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
												<div class='progress-bar bg-warning' role='progressbar' style='width: ".$calificaciones['porcentaje_neu']."%; background-color: #ffd000!important' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
												<div class='progress-bar bg-danger' role='progressbar' style='width: ".$calificaciones['porcentaje_neg']."%; background-color: #ff8080!important' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
											</div>";
							}
						?>
						<span class="float-right" title="<?php echo $viaje['fecha_publicacion'] ?>">Publicado <?php echo dias_transcurridos($viaje['fecha_publicacion'],'publicacion');?>
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
											<?php echo date_toString($viaje['fecha_partida'],"n");?>
									</h6>


					</div>
					<div class="col-md-6">
						<h3 style="text-align: center; color: #53b842">$<?php echo round($viaje['costo']/($viaje['asientos_disponibles']+1)); ?> <small> / por persona</small></h3>
					</div>
				</div>
				<hr>
				<?php if(isset($_SESSION['userId']) and $viaje['idPiloto'] == $_SESSION['userId']) {
					?>
				<div class="row">
					<div class="col-md-6" style="text-align: center">
						<h6><?php echo "$".$viaje['costo']?></h6>
						<small> costo total del viaje a pagar por mi</small>
					</div>
					<div class="col-md-6">
							<button type="button" class="btn btn-dark centrado" title="Una vez que el viaje termine podras pagarlo" disabled>Pago pendiente</button>
					</div>
				</div>
				<hr>
			<?php } ?>
				<form action="/viaje/<?php echo "$vars[0]/$vars[1]" ?>" method="post">
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
						$pagos_noRealizados=mysqli_query($conexion,"SELECT * from viaje
																												where idPiloto = '$_SESSION[userId]'
																												and estado = 3
																												AND idViaje NOT IN (SELECT idViaje from pago)")
																												or die ("error consulta pagos --> ".mysqli_error($conexion));
						$pagosOk = mysqli_num_rows($pagos_noRealizados) == 0;

						$calificaciones_pendientes=mysqli_query($conexion,"SELECT * from calificacion
																															 where idCalificador = '$_SESSION[userId]'
																															 and calificacion IS null
																															 and fecha < date_sub(NOW(), INTERVAL 30 DAY)")
																															 or die ("error consula calificaciones pendientes --> ".mysqli_error($conexion));
						$calificacionesOk = mysqli_num_rows($calificaciones_pendientes) == 0;

						if (!$pagosOk && !$calificacionesOk){
							echo '<button type="" class="btn btn-outline-secondary" style="width:100%" disabled>Tenes pagos y calificaciones pendientes</button>';
						}
						elseif(!$pagosOk) {
							echo '<button type="" class="btn btn-outline-secondary" style="width:100%" disabled>Tenes pagos pendientes</button>';
						}
						elseif(!$calificacionesOk) {
							echo '<button type="" class="btn btn-outline-secondary" style="width:100%" disabled>Tenes calificaciones pendientes</button>';
						}
						else{
							echo '<button type="submit" class="btn btn-outline-danger" style="width:100%">Participar</button>';
						}
						break;
					}

			?>
			</form>
			<?php

				if (($participacion['estado'] == 2) || ($participacion['estado']==1)) {
					echo '<center>
										<form action="/viaje/'.$vars[0].'/'.$vars[1] . '" method="post">
													<input type="hidden" name="idParticipacion" value="'.$participacion['idParticipacion'].'">
													<input type="hidden" name="baja_participacion" value="'.$vars[0].'">
													<input type="hidden" name="estado" value="'.$participacion['estado'].'">';

													if ($participacion['estado'] == 2){

													echo '<!-- Modal Alert cancelar participacion -->
													<button type="button" class="btn btn-light"  data-toggle="modal" data-target="#modalAlertCancelarPostulacion">cancelar participacion</button>

													<div class="modal fade" id="modalAlertCancelarPostulacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
													  <div class="modal-dialog modal-dialog-centered" role="document">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h5 class="modal-title" id="exampleModalCenterTitle">Cuidado</h5>
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span>
													        </button>
													      </div>
													      <div class="modal-body">
																	Tu postulacion ya fue aprobada, si solicitas la baja de este viaje se restara 1 punto de tu calificacion.<br> Estas seguro de querer cancelar tu postulacion?
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Volver atras</button>
													        <button type="submit" class="btn btn-warning btn-sm">Si, cancelar</button>
													      </div>
													    </div>
													  </div>
													</div>';
													}
													else{
														echo '<button type="submit" class="btn btn-light"  data-dismiss="modalAlertCancelarPostulacion" aria-label="cancelar postulacion">cancelar participacion</button>';
													}

									echo '</form>
								</center>';
				}
				elseif ($participacion['estado'] == 3){
						echo '<form action="/viaje/'.$vars[0].'/'.$vars[1] .'" method="post">
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
							if(mysqli_num_rows($participaciones_copiloto)==0)
							{echo "<center><small>~ no hay participaciones todavia ~</small></center>";}
				echo '<div class="mCustomScrollbar" data-mcs-theme="minimal-dark" style="max-height: 300px; overflow: auto;">';
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
							echo '<form action="/viaje/'.$vars[0].'/'.$vars[1].'" method="post" style="display: inline-block">
													<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
													<input type="hidden" name="estado" value="'.$participacion_copiloto['estado'].'">
													<input type="hidden" name="aceptar_postulacion" value="'.$vars[0].'">
													</div>

													<div class="col-3">
													<div class="btn-toolbar" role="toolbar" aria-label="">
  														<div class="btn-group" role="group" aria-label="group">';

													$participaciones_aprobadas=mysqli_query($conexion,"SELECT *
																																			 from participacion
																																			 where idViaje='$viaje[idViaje]'
																																			 and estado = 2")
																																			 or die ("problemas con el listado de participaciones del piloto");
													if (mysqli_num_rows($participaciones_aprobadas) == $viaje['asientos_disponibles']){
														echo "<button type='button' class='buttonText' title='no hay vacantes disponibles'>aprobar</button>";
													}
													else{
														echo "<button type='submit' class='buttonText buttonTextVerde'>aprobar</button>";
													}
													echo '
										</form>';
										// boton rechazar
										echo '<form action="/viaje/'.$vars[0].'/'.$vars[1].'" method="post" style="display: inline-block">
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
						echo '<form action="/viaje/'.$vars[0].'/'.$vars[1].'" method="post" style="display: inline-block">
													<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
													<input type="hidden" name="estado" value="'.$participacion_copiloto['estado'].'">
													<input type="hidden" name="rechazar_postulacion" value="'.$vars[0].'">
													</div><div class="col-4">
											<button type="button" class="buttonText buttonTextRojo float-right" data-toggle="modal" data-target="#modalAlertRechazarPostulacion'.$participacion_copiloto['idParticipacion'].'">rechazar participacion</button>';

						echo '<!-- Modal Alert rechazar participacion -->
											<div class="modal fade" id="modalAlertRechazarPostulacion'.$participacion_copiloto['idParticipacion'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalCenterTitle">Cuidado</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															La participacion de '.$participacion_copiloto["nombre"].' '.$participacion_copiloto["apellido"].' ya fue aprobada, si queres rechazarla se restara un punto de tu calificacion. <br>
															Estas seguro de querer rechazarla?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Volver atras</button>
															<button type="submit" class="btn btn-warning btn-sm">Si, rechazar participacion</button>
														</div>
													</div>
												</div>
											</div>';

						echo '</form>';
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
			<?php
			$preguntas = mysqli_query($conexion,"SELECT *
																						from pregunta
																						inner join usuario on pregunta.idPreguntante=usuario.idUser
																						where idViaje = '$viaje[idViaje]'");
			 ?>
			<div class="col-md-12" style="padding: 0px 13px">
				<center><span id="botonPreguntas" style="cursor: pointer"> ~ Preguntas <span id="detallePreguntas">(<?php echo mysqli_num_rows($preguntas); ?>)</span> ~ </span></center>
				<div class="" id="preguntas" style="display: none">

				<?php
					while ($pregunta=mysqli_fetch_array($preguntas)){
						?>
						<small style="color: grey"><?php echo date_toString($pregunta['fecha'],"n"); ?></small>
						<div class="contenedorPyR">
							<?php echo $pregunta['nombre']." ".$pregunta['apellido'].": ".$pregunta['pregunta'];?>
						</div>

						<?php if ($pregunta['respuesta'] != ''){?>
						<div class="contenedorPyR float-right" style="background-color: #eccbdc">
							<?php echo "Piloto: ".$pregunta['respuesta'] ?>
						</div>
						<?php }
						elseif(isset($_SESSION['userId'])){
							if($viaje['idPiloto']==$_SESSION['userId']){
							echo '<div class="form-group float-right" style="widht: 49%">
										<form action="/viaje/'.$vars[0].'/'.$vars[1] . '" method="post">
    										<textarea class="form-control" id="" name="respuesta" rows="1" cols="70" placeholder="responde a '.$pregunta['nombre'].'" style="display: inline-block"></textarea>
    										<br><input type="hidden" name="idPregunta" value="'.$pregunta['idPregunta'].'">
    										<button type="submit" name="responder" class="btn btn-info float-right"> Enviar </button>
    									</form>
  									</div>';
						}
						} ?>

						<br>
						<br>

						<?php
					}
				 ?>
			 	</div>

					<?php 
					if(isset($_SESSION['userId'])){
						if ($viaje['idPiloto']!=$_SESSION['userId']){?>
				 <hr>
				 <h5>Pregunta! <small>sacate las dudas</small> </h5>
 				<div class="row">
 					<div class="col-md-10">
 						<textarea class="form-control" name="name" cols="80" style="width: 100%; min-height: 50px" placeholder="Ej: puedo llevar a mi perrito?, mate dulce o amargo?"></textarea>
 					</div>
 					<div class="col-md-2">
 						<button type="button" class="btn btn-light" style="width:100%; height: 100%">Enviar</button>
 					</div>
 				</div>
			<?php }	
			} ?>
			</div>
		</div>
		<div class="row" style="height: 10px">
		</div>

		<script type="text/javascript">
		$(document).ready(function() {
				$('#botonPreguntas').click(function(){
					$('#preguntas').toggle();
					$('#detallePreguntas').toggle();
				});

			});
		</script>

    <?php
		}
  }
