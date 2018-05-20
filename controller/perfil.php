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
                                    where idPropietario='$user[idUser]'")
                                    or
                                    die ("problemas con el contador");
  $contador_vehiculos=mysqli_fetch_array($contador_vehiculos);

  !isset($_POST['marca'])?:include('php/alta_vehiculo.php');

  if(isset($_COOKIE["carga_vehiculo"]) && $_COOKIE["carga_vehiculo"])
  {
      echo '<div class="alert alert-success alert-dismissable">
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

  <div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/user.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-8">
      <h1 class="display-4"><?php echo $user['nombre']." ".$user['apellido']; ?></h1>
      <span><?php echo $user['email']; ?></span><br>
      <span><?php echo $contador_vehiculos['cont']; ?> vehiculos</span> | <a href="#" data-toggle="modal" data-target="#CargarAuto">agregar un vehiculo</a> | <a href="/listado-vehiculos">ver vehiculos</a> <br>
      <span><?php echo $contador['cont']; ?> viajes totales</span>
    </div>
    <div class="col-md-1">
      <img src="img/cambio.png" alt="boton cambios" style="width: 40px; margin-top: 20px" title="Cambiar datos personales" data-toggle="modal" data-target="#modalCambioDatos">
    </div>

  </div>

  <hr>

  <div class="row">
    <div class="col-md-6">
      <h3>Mis ultimos viajes </h3>
      <?php
        $viajes=mysqli_query($conexion,"SELECT *
                                       FROM viaje
                                       WHERE idPiloto='$user[idUser]'
                                       order by idViaje
                                       limit 5")
                                       or
                                       die("Problemas en la base de datos:".mysqli_error($conexion));
        if (mysqli_num_rows($viajes) == 0){
             echo "no tenes ningun viaje publicado :( <br>";
             echo "<a href='/publicar'>publicar viaje</a>";
        }
        while ($viaje = mysqli_fetch_array($viajes)) {
          ?>
          <div class="card" style="margin-bottom: 7px">
            <img class="card-img-top" src="img/prueba_maps.png" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title"><?php echo $viaje['origen']." a ".$viaje['destino'] ?>
                  <?php switch ($viaje['estado']) {
                    case 'activo':
                        echo "<button type='button' class='btn btn-success btn-sm float-right ' disabled>";
                      break;
                    case 'terminado':
                        echo "<button type='button' class='btn btn-primary btn-sm float-right ' disabled>";
                      break;
                    case 'cancelado':
                        echo "<button type='button' class='btn btn-danger btn-sm float-right ' disabled>";
                      break;
                  }
                  echo $viaje['estado']."</button>";
                  ?>
              </h5>
              <small class="card-text">publicado <?php echo dias_transcurridos($viaje['fecha_publicacion']); ?> <br>
              partida el <?php echo date("d-m-Y", strtotime($viaje['fecha_partida']));?> a las <?php echo date("H:i", strtotime($viaje['fecha_partida']));?> </small>
              <hr>
              <a href="#" class="card-link">dar de baja</a>
              <a href="#" class="card-link">ver postulantes</a>
            </div>
          </div>
          <?php
        }
      ?>

      <center> <a href="#">Ver todos los viajes</a> </center>
    </div>

    <div class="col-md-6">
      <h3>Mis ultimas postulaciones</h3>
      <?php
        $postulaciones=mysqli_query($conexion,"SELECT *, participacion.estado as estado_participacion
                                       FROM participacion
                                       inner join viaje on participacion.idViaje=viaje.idViaje
                                       WHERE idUsuario='$user[idUser]'
                                       order by idParticipacion
                                       limit 10")
                                       or
                                       die("Problemas en la base de datos:".mysqli_error($conexion));
        if (mysqli_num_rows($postulaciones) == 0){
            echo "no tenes ninguna postulacion :( <br>";
            echo "<a href='/'>ver viajes disponibles</a>";
        }
        while ($postulacion = mysqli_fetch_array($postulaciones)) {
          echo "<div class='alert ";
          switch ($postulacion['estado_participacion']) {
            case 'pendiente':
                echo "alert-primary'";
              break;
            case 'terminada':
                echo "alert-secondary'";
              break;
            case 'cancelada':
                echo "alert-warning'";
              break;
            case 'aprobada':
                echo "alert-success'";
              break;
            default:
                echo "alert-secondary'";
              break;
          }
          echo "role='alert'>
                  participacion ".$postulacion['estado_participacion']." <span class='float-right'><a href='#'> cancelar postulacion </a> </span>
                  <br><b> ".$postulacion['origen']." a ".$postulacion['destino']." </b> <a href='#' class='float'> ver viaje </a>
                  </div>";

        }
      ?>
        <center><a href="#">ver todas las postulaciones</a></center>
    </div>
  </div>



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
        <a href="#">Cambiar clave de acceso</a>
      </div>
    </div>
  </div>
</div>
  <?php
}
