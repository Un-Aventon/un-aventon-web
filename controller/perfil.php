<?php
function render($vars = [])
{
  //incluyo la conexion
  include('php/conexion.php');

  $usuario=mysqli_query($conexion,"SELECT *
                                   FROM Usuario
                                   WHERE email='$_SESSION[mail]' limit 1")
                                   or
                                   die("Problemas en la base de datos:".mysqli_error($conexion));
  $user = mysqli_fetch_array($usuario);

  $contador=mysqli_query($conexion,"SELECT count(*) as cont
                                    FROM viaje
                                    where idPiloto='$user[idUser]'")
                                    or
                                    die ("problemas con el contador");
  $contador=mysqli_fetch_array($contador);

  $contador_vehiculos=mysqli_query($conexion,"SELECT count(*) as cont
                                    FROM vehiculo
                                    where idPropietario='$user[idUser]'
                                    and eliminado = 0")
                                    or
                                    die ("problemas con el contador");
  $contador_vehiculos=mysqli_fetch_array($contador_vehiculos);

  $sql = "SELECT pago.idPago\n"

      . "FROM pago\n"

      . "INNER JOIN viaje ON (viaje.idViaje = pago.idViaje)\n"

      . "WHERE viaje.idPiloto = $_SESSION[userId] AND pago.estado IS NULL";

  $contador_pagos = mysqli_query($conexion, $sql);

  !isset($_POST['marca'])?:include('php/alta_vehiculo.php');

  if(isset($_COOKIE["carga_vehiculo"]) && $_COOKIE["carga_vehiculo"])
  {
      echo '<div class="alert alert-success alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    La carga del vehiculo se realizó correctamente!
              </div>';

      setcookie("carga_vehiculo",false);
  }

  // cargo algoritmo de modificacion de datos
  !isset($_POST['email'])?:include('php/modificar_datos.php');

  if(isset($_COOKIE["modificacion_datos"]) && $_COOKIE["modificacion_datos"])
  {
      echo '<br><div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Se modificaron los datos exitosamente!
              </div>';
      setcookie("modificacion_datos",false);
  }

    // Baja de un viaje.
  !isset($_POST['bajaViaje'])?:include('php/baja_viaje.php');

  if(isset($_COOKIE["baja_viaje"]) && $_COOKIE["baja_viaje"])
  {
      //mensaje exito
      echo '';

      setcookie("baja_viaje",false);
  }

  // Fin baja del viaje

  // Baja de la participacion
  !isset($_POST['baja_participacion'])?:include('php/baja_participacion.php');
  if(isset($_COOKIE["baja_participacion"]) && $_COOKIE["baja_participacion"]){
    setcookie("baja_participacion",false);
  }
  // Fin baja de la participacion

  $tipos=mysqli_query($conexion,"SELECT * FROM `tipo_vehiculo` ")
                                   or
                                   die("Problemas en la base de datos:".mysqli_error($conexion));
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
        <form action="/perfil" method="post">
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
            <label for="tipo">Tipo:</label>
              <select class="form-control" name="tipo" id="tipo">
                <?php
                  while ($t=mysqli_fetch_array($tipos)){
                    echo '<option value="'. $t['idTipo'] .'">'. $t['tipo'] .'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Cantidad de Asientos</label>
            <input type="number" name="cant_asientos" class="form-control" id="cant_asientos" placeholder="Ingrese la cantidad de asientos">
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

  <div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/user.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-8">
      <h1 class="display-4" style="margin-bottom: -6px"><?php echo $user['nombre']." ".$user['apellido']; ?></h1>
      <span style="margin-bottom: 10px; display: block"><?php echo $user['email']; ?></span>
      <span><?php echo calificacion($user['idUser']) ?> puntos</span> | <a href="/calificaciones">ver calificaciones pendientes</a> <br>
      <span><?php echo $contador_vehiculos['cont']; ?> vehiculos</span> | <a href="#" data-toggle="modal" data-target="#CargarAuto">agregar un vehiculo</a> | <a href="/listado-vehiculos">ver vehiculos</a> <br>
      <span><?php echo mysqli_num_rows($contador_pagos)?> pagos pendientes</span> | <a href="/pagos_pendientes">ver pagos pendientes</a> <br>
    </div>
    <div class="col-md-1">
      <img src="img/cambio.png" class="boton_cambios" alt="boton cambios" title="Cambiar datos personales" data-toggle="modal" data-target="#modalCambioDatos">
    </div>

  </div>

  <hr>

  <div class="row">
    <div class="col-md-6">
      <?php
        $viajes=mysqli_query($conexion,"SELECT *, viaje.estado as 'estadodelviaje'
                                       FROM viaje
                                       INNER JOIN estado_viaje on viaje.estado=estado_viaje.idEstado
                                       WHERE idPiloto='$user[idUser]'
                                       order by fecha_publicacion DESC, fecha_partida ASC")
                                       or
                                       die("Problemas en la base de datos:".mysqli_error($conexion));
      ?>
      <h5>Mis ultimos viajes <span class="badge badge-pill badge-secondary"><?php echo mysqli_num_rows($viajes);?></span></h5>
        <div class="mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 400px; overflow: auto;">
      <?php
        if (mysqli_num_rows($viajes) == 0){
             echo "no tenes ningun viaje publicado :( <br>";
             echo "<a href='/altaviaje'>publicar viaje</a>";
        }
        while ($viaje = mysqli_fetch_array($viajes)) {
          ?>
          <div class="card" style="margin-bottom: 7px">
            <!-- <img class="card-img-top" src="img/prueba_maps.png" alt="Card image cap"> -->
            <div class="card-body" style="background-color: #fafafa">
              <h5 class="card-title"><?php echo $viaje['origen']." a ".$viaje['destino'] ?>
              </h5>
              <small class="card-text">publicado <?php echo dias_transcurridos($viaje['fecha_publicacion'],'publicacion'); ?> <br>
              partida el <?php echo date_toString($viaje['fecha_partida'],"y");?> </small>
              <hr>
              <?php
                if ($viaje['estadodelviaje']==1){
                  echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#EliminarViaje".$viaje['idViaje']."'>Cancelar</button>
                <a href='/viaje/".$viaje['idViaje']."/".$viaje['origen']."/".$viaje['destino']."'><button type='button'class='btn btn-info btn-sm'>Ver detalles</button></a>";
                }
              ?>

              <button type='button' class='btn btn-<?php echo $viaje['color']; ?> btn-sm float-right ' disabled>
                <?php echo "viaje ".$viaje['estado']; ?>
              </button>
            </div>
          </div>
           <?php
                            // Se lleva a cabo la cuenta de la cantidad de participantes
                            // En base a eso, se decide si la baja del viaje se hara con baja de puntos.
                            $contador_participaciones=mysqli_query($conexion,"SELECT *
                                                                              from participacion
                                                                              where estado=2 and idViaje='$viaje[idViaje]'")
                                                                              or die ("problemas en el contador de participantes del viaje");
                            if(mysqli_num_rows($contador_participaciones) > 0)
                                $hayParticipaciones = true;
                            else
                                $hayParticipaciones = false;

                            if($viaje['tipo'] == "recurrente"){
                              $viajes_recurrentes=mysqli_query($conexion,"SELECT *
                                                                          from viaje
                                                                          where tipo='recurrente' and idPiloto='$viaje[idPiloto]'
                                                                          and origen='$viaje[origen]' and destino='$viaje[destino]'
                                                                          and fecha_partida > '$viaje[fecha_partida]'
                                                                          and HOUR(fecha_partida) = HOUR('$viaje[fecha_partida]')")
                                                                          or die ("problemas en el select de viaje recurrentes");
                              if (mysqli_num_rows($viajes_recurrentes)==0){
                                $viaje['tipo'] = "unico";
                              }
                            }
               ?>

          <div class="modal fade" id="<?php echo "EliminarViaje$viaje[idViaje]"?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cancelar Viaje</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php
                          if ($viaje['tipo']== "recurrente"){
                            echo "<div class='alert alert-warning' role='alert'>
                                  <h4 class='alert-heading'>Este es un viaje recurrente!</h4>";
                            echo "estos son otros viajes que podrias querer borrar<br>";
                            echo "<div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                      <label class='input-group-text' for='viajes_recurrentes'>Viajes</label>
                                    </div>
                                    <select multiple class='custom-select' id='viajes_recurrentes' name='viajes_recurrentes' style='height: 200px; max-height: 800px' data-mcs-theme='dark-3'>";
                            while ($viaje_recurrente=mysqli_fetch_array($viajes_recurrentes)){
                              echo "<option value='".$viaje_recurrente['idViaje']."'>".date_toString($viaje_recurrente['fecha_partida'],"y")."</option>";
                            }
                            echo "</select></div>";
                            echo "<small style='margin-top: -20px'> Podes seleccionar mas de uno con (Ctrl + click) </small></div>";
                          }

                        ?>
                        <?php if(!$hayParticipaciones){
                          ?>
                            <div class="alert alert-danger" role="alert">
                            ¿Estas Completamente seguro de que deseas cancelar el viaje? <b>Esta accion será irreversible.</b>
                        </div>
                      <?php
                             }
                             else{
                            ?>
                            <div class="alert alert-danger" role="alert">
                            Ya aceptaste a copilotos para este viaje, la cancelacion de este viaje provocará que se te resten 2 puntos de tu calificación general, <b>¿Estas Completamente seguro de que deseas Cancelar el viaje?</b>
                        </div>
                        <?php
                          }
                          ?>
                      </div>
                      <div class="modal-footer">
                                        <div class="row">
                                            <div class="col col-md-6">
                                                <form action="/perfil" method="post">
                                                  <button type="submit" class="btn btn-danger" name="bajaViaje" value="<?php echo "$viaje[idViaje]"?>">Si, Cancelar</button>
                                                </form>
                                            </div>
                                            <div class="col col-md-6">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                         </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php
        }
      ?>
      </div>
    </div>

    <div class="col-md-6">
      <?php
      $postulaciones=mysqli_query($conexion,"SELECT *, participacion.estado as estado_participacion, viaje.estado as estado_viaje
                                     FROM participacion
                                     inner join viaje on participacion.idViaje=viaje.idViaje
                                     inner join estado_participacion on participacion.estado=estado_participacion.idEstado
                                     WHERE idUsuario='$user[idUser]'
                                     order by fecha_publicacion and idParticipacion")
                                     or
                                     die("Problemas en la base de datos:".mysqli_error($conexion));?>
      <h5>Mis ultimas postulaciones <span class="badge badge-pill badge-secondary"><?php echo mysqli_num_rows($postulaciones);?></span></h5>
      <div class="mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 400px; overflow: auto;">
      <?php
        if (mysqli_num_rows($postulaciones) == 0){
            echo "no tenes ninguna postulacion :( <br>";
            echo "<a href='/'>ver viajes disponibles</a>";
        }
        while ($postulacion = mysqli_fetch_array($postulaciones)) {
          echo "<div class='alert alert-".$postulacion['color']."' role='alert'>
                  participacion ".$postulacion['estado'];

          if ($postulacion['estado_participacion'] < 3){
            $baja_participacion = "true";


													if ($postulacion['estado_participacion'] == 2){
                          ?>
                            <span class="float-right"><a href="#" data-toggle="modal" data-target="#modalAlertRechazarPostulacion<?php echo $postulacion['idParticipacion']?>">cancelar postulacion </a> </span>;
                          <?php
                          echo '<center>
                          <form action="/perfil" method="post">
                                            <input type="hidden" name="idParticipacion" value="'.$postulacion['idParticipacion'].'">
                                            <input type="hidden" name="estado" value="'.$postulacion['estado'].'">
                                            <input type="hidden" name="baja_participacion" value="'.$baja_participacion.'">
													<div class="modal fade" id="modalAlertRechazarPostulacion'.$postulacion['idParticipacion'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                            ?>
                            <span class="float-right"><a href="#" data-toggle="modal" data-target="#modalAlertRechazarPostulacion<?php echo $postulacion['idParticipacion']?>">Cancelar Postulacion </a> </span>
                          <?php
                        echo '<center>
                        <form action="/perfil" method="post">
                                            <input type="hidden" name="idParticipacion" value="'.$postulacion['idParticipacion'].'">
                                            <input type="hidden" name="estado" value="'.$postulacion['estado'].'">
                                            <input type="hidden" name="baja_participacion" value="'.$baja_participacion.'">';

													echo'<div class="modal fade" id="modalAlertRechazarPostulacion'.$postulacion['idParticipacion'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
													    <div class="modal-dialog modal-dialog-centered" role="document">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h5 class="modal-title" id="exampleModalCenterTitle">Cuidado</h5>
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span>
													        </button>
													      </div>
													      <div class="modal-body">
																	Estas seguro de querer cancelar tu postulacion?
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Volver atras</button>
													        <button type="submit" class="btn btn-warning btn-sm">Si, cancelar</button>
													      </div>
													    </div>
													  </div>
													</div>';
													}

									echo '</form>
								</center>';
                echo "<br><b> ".$postulacion['origen']." a ".$postulacion['destino']." </b> <a href='/viaje/".$postulacion['idViaje']."' class='float'> Ver detalles </a>
                </div>";
          }
          else{
                     echo "<br><b> ".$postulacion['origen']." a ".$postulacion['destino']." </b>
                     </div>";
          }

        }
      ?>
      </div>
    </div>
  </div>
  <br>



<!-- Modal Cambio de datos personales -->
<div class="modal fade" id="modalCambioDatos" tabindex="-1" role="dialog" aria-labelledby="modalCambioDatos" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambio de datos personales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/perfil" method="post">
          <div class="form-group row">
            <label for="mail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name='email' id="mail" placeholder="Email" value="<?php echo $user['email']; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name='nombre' id="nombre" placeholder="nombre" value="<?php echo $user['nombre']; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name='apellido' id="apellido" placeholder="apellido" value="<?php echo $user['apellido']; ?>">
            </div>
          </div>
          <button type="submit" class="btn btn-primary float-right">Aplicar cambios</button>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#" onclick="alert('Esta funcion todavia esta en desarrollo')">Cambiar clave de acceso</a>
      </div>
    </div>
  </div>
</div>
  <?php
}
