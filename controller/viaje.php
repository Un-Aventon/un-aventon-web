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
                                   or die ("problemas con el select".mysqli_error($conexion));
    $viaje=mysqli_fetch_array($viaje);
    ?>
    <div class="row">
      <div class="col-md-6" style="padding: 5px 5px;">
        <img src="/img/prueba_maps2.png" alt="mapa" class="img-fluid rounded">
      </div>
      <div class="col-md-6">
          <h1><?php echo $viaje['origen'] ?> a <?php echo $viaje['destino']; ?></h1>
					<span title="<?php echo $viaje['fecha_publicacion'] ?>">Publicado <?php echo dias_transcurridos($viaje['fecha_publicacion'],'publicacion');?>
																																	por <a href="#"><?php echo $viaje['nombre']." ".$viaje['apellido']; ?></a> (3.4pts)
					</span>
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
				<br>
        <button type="button" class="btn btn-outline-danger" style="width:100%">Participar</button>
      </div>
    </div>


    <?php
  }
