<?php
function render($vars = [])
{
  function dias_transcurridos($fecha_alta)
  {
	 $fecha_alta = date_create($fecha_alta);
	 $fecha_actual   = date_create(date("d.m.Y"));
	 $diferencia     = date_diff($fecha_alta, $fecha_actual);

	 return $diferencia->format('%a');
  }
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
  ?>

  <div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/user.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-9">
      <h1 class="display-4"><?php echo $user['nombre']; ?> <?php echo $user['apellido']; ?></h1>
      <span><?php echo $user['email']; ?></span><br>
      <span><?php echo $contador_vehiculos['cont']; ?> vehiculos</span> | <a href="#">agregar un vehiculo</a> | <a href="#">ver vehiculos</a> <br>
      <span><?php echo $contador['cont']; ?> viajes totales (*)</span>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-6">
      <h3>Mis viajes</h3>
      <?php
        $viajes=mysqli_query($conexion,"SELECT *
                                       FROM viaje
                                       WHERE idPiloto='$user[idUser]'")
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
                        echo "<small class='float-right text-success'>";
                      break;
                    case 'terminado':
                        echo "<small class='float-right text-primary'>";
                      break;
                    case 'cancelado':
                        echo "<small class='float-right text-danger'>";
                      break;
                    case 'suspendido':
                        echo "<small class='float-right text-warning'>";
                      break;
                  }
                  echo $viaje['estado']."</small>";
                  ?>
              </h5>
              <small class="card-text">publicado <?php if(dias_transcurridos($viaje['fecha_publicacion']) == 0){echo "hoy";}
                                                        else {echo "hace ".dias_transcurridos($viaje['fecha_publicacion'])." dias";}?> <br>
              partida el <?php echo date("d-m-Y", strtotime($viaje['fecha_partida']));?> a las <?php echo date("H:i", strtotime($viaje['fecha_partida']));?> </small>
              <hr>
            </div>

            <!--<ul class="list-group list-group-flush">
              <li class="list-group-item">lista 1</li>
            </ul>
          -->
            <div class="card-body">
              <a href="#" class="card-link">dar de baja</a>
              <a href="#" class="card-link">ver postulantes</a>
            </div>
          </div>
          <?php
        }
      ?>
    </div>

    <div class="col-md-6">
      <h3>Mis postulaciones</h3>
      <?php
        $postulaciones=mysqli_query($conexion,"SELECT *
                                       FROM participacion
                                       WHERE idUsuario='$user[idUser]'")
                                       or
                                       die("Problemas en la base de datos:".mysqli_error($conexion));
        if (mysqli_num_rows($postulaciones) == 0){
            echo "no tenes ninguna postulacion :( <br>";
            echo "<a href='/'>ver viajes disponibles</a>";
        }
        while ($postulacion = mysqli_fetch_array($postulaciones)) {
          echo "postulacion";
        }
      ?>
    </div>
  </div>
  <?php
}
