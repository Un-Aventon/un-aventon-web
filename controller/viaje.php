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
																										where estado=1 and idViaje=$viaje[idViaje]")
																										or die ("problemas en el contador de asientos disponibles");
		$contador_participaciones = $viaje['asientos_disponibles'] - mysqli_num_rows($contador_participaciones);

		//parche ARREGLAR
		if ($_SESSION['userId'] != $viaje['idPiloto']) {
		!isset($_POST['carga_participacion'])?:include('php/alta_participacion.php');
		if(isset($_COOKIE["carga_participacion"]) && $_COOKIE["carga_participacion"])
	  {
	      setcookie("carga_participacion",false);
	  }
	}

		!isset($_POST['baja_participacion'])?:include('php/baja_participacion.php');
		if(isset($_COOKIE["baja_participacion"]) && $_COOKIE["baja_participacion"]){
			setcookie("baja_participacion",false);
		}

		!isset($_POST['aceptar_postulacion'])?:include('php/aceptar_participacion.php');
		/*if(isset($_COOKIE["baja_participacion"]) && $_COOKIE["baja_participacion"]){
			setcookie("baja_participacion",false);
		}*/

    ?>
    <div class="row">
      <div class="col-md-6" style="padding: 5px 5px;">
        <img src="/img/prueba_maps2.png" alt="mapa" class="img-fluid rounded">
      </div>
      <div class="col-md-6">
				<div class="row">
					<div class="col-md-10 col-sm-12">
						<h1><?php echo $viaje['origen'] ?> a <?php echo $viaje['destino']; ?></h1>
						<span title="<?php echo $viaje['fecha_publicacion'] ?>">Publicado <?php echo dias_transcurridos($viaje['fecha_publicacion'],'publicacion');?>
							por <a href="#"><?php echo $viaje['nombre']." ".$viaje['apellido']; ?></a> (3.4pts)
						</span>
					</div>
					<div class="col-md-2">
						<div class="contenedorUno centrado" style="border: 1px solid #fff; border-radius: 4px; padding: 4px 4px; background-color: #f0f0f0">
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
														$dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sábado");
														$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
														$date = date_create($viaje['fecha_partida']);
														echo $dias[date_format($date, 'N')]." ".date_format($date, 'd')." de ".$meses[date_format($date, 'm')-1] ;
														echo " - ";
														echo date_format($date, 'G:ia');
											?>
									</h6>


					</div>
					<div class="col-md-6">
						<h3 style="text-align: center; color: #53b842">$<?php echo $viaje['costo']; ?> <small> / por persona</small> </h3>
					</div>
				</div>
				<hr>
				<form action="/viaje/<?php echo $vars[0] ?>" method="post">
					<input type="hidden" name="carga_participacion" value="<?php echo $vars[0] ?>">
				<?php



				if (!isset($_SESSION['userId'])) {
					echo '<button type="submit" class="btn btn-outline-secondary" style="width:100%">Tenes que estar logeado para poder participar</button>';
				}
				elseif ($_SESSION['userId'] != $viaje['idPiloto']) {
				$participacion=mysqli_query($conexion,"SELECT *
																							 from participacion
																							 where idViaje='$viaje[idViaje]' and idUsuario='$_SESSION[userId]'
																							 order by idParticipacion ASC")
																							 or die ("error participacion".mysqli_error($conexion));
				$participacion=mysqli_fetch_array($participacion);

				switch ($participacion['estado']) {
					case 1:
						echo '<button type="" class="btn btn-primary" style="width:100%" disabled>Participacion pendiente</button>';
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
						if ($contador_participaciones>0){echo '<button type="submit" class="btn btn-outline-danger" style="width:100%">Participar</button>';}
						else {echo '<button type="submit" class="btn btn-outline-secondary" style="width:100%" disabled>No quedan vacantes</button>';}
						break;
					}

			?>
			</form>
			<?php

				if (($participacion['estado'] == 1) || ($participacion['estado'] == 2)) {
					echo '<center>
										<form action="/viaje/'.$vars[0].'" method="post">
													<input type="hidden" name="idParticipacion" value="'.$participacion['idParticipacion'].'">
													<input type="hidden" name="baja_participacion" value="'.$vars[0].'">
													<input type="hidden" name="estado" value="'.$participacion['estado'].'">
													<button type="submit" class="btn btn-light btn-sm">cancelar postulacion</button>
										</form>
								</center>';
				}
				elseif ($participacion['estado'] == 3){
						echo '<form action="/viaje/'.$vars[0].'" method="post">
												<input type="hidden" name="carga_participacion" value="'.$vars[0].'">';

						echo '<center><button type="submit" class="btn btn-light btn-sm">Volver a postularme</button></center>';
						echo '</form>';
				}
			}
			else {
				$participaciones_copiloto=mysqli_query($conexion,"SELECT *
																								 from participacion
																								 inner join usuario on participacion.idUsuario=usuario.idUser
																								 where idViaje='$viaje[idViaje]'")
																								 or die ("problemas con el listado de participaciones del piloto");
				if(mysqli_num_rows($participaciones_copiloto)>0){echo mysqli_num_rows($participaciones_copiloto)." participaciones<hr>";}
				else {echo "no hay participaciones todavia";}
				while ($participacion_copiloto=mysqli_fetch_array($participaciones_copiloto)){
					switch ($participacion_copiloto['estado']) {
						case 1:
							echo '<br><br>postulacion pendiente de aprobacion <br>'.$participacion_copiloto["nombre"].' '.$participacion_copiloto["apellido"].'<br>';
							echo '<form action="/viaje/'.$vars[0].'" method="post" style="display: inline-block">
										<input type="hidden" name="idParticipacion" value="'.$participacion_copiloto['idParticipacion'].'">
										<input type="hidden" name="aceptar_postulacion" value="'.$vars[0].'">
										<button type="submit" class="btn btn-light btn-sm">aprobar postulacion</button>
										</form>';
							//echo ' <a href="">rechazar postulacion</a>';
							break;
						case 2:
						echo 'participacion aprobada <br>'.$participacion_copiloto["nombre"].' '.$participacion_copiloto["apellido"];
						echo '<br><a href="">rechazar postulacion</a>';
							break;
						case 3:
						echo 'participacion cancelada por <br>'.$participacion_copiloto["nombre"].' '.$participacion_copiloto["apellido"];
							break;
						case 4:
							echo 'participacion cancelada por mi <br>'.$participacion["nombre"].' '.$participacion["apellido"];
							break;
						default:
							echo "default";
							break;
						}
				}
			}
			?>

      </div>
    </div>


    <?php
  }
