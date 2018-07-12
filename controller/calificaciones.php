<?php
function render($vars = []){

include('php/conexion.php');

!isset($_POST['enviarCalificacion'])?:include('php/calificar_usuario.php');

if(isset($_COOKIE["calificar_usuario"]) && $_COOKIE["calificar_usuario"])
{
    echo '<div class="alert alert-success alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                Tu calificacion se envió correctamente!
            </div>';

    setcookie("calificar_usuario",false);
}

$consulta = "SELECT calificacion.idCalificacion, calificacion.idCalificador, calificacion.idCalificado, calificacion.idViaje, viaje.idPiloto, viaje.fecha_partida, viaje.origen, viaje.destino, usuario.nombre, usuario.apellido\n"

    . "FROM calificacion \n"

    . "INNER JOIN viaje ON ((calificacion.idCalificado=viaje.idPiloto) AND (calificacion.idViaje = viaje.idViaje))\n"

    . "INNER JOIN usuario on (calificacion.idCalificado = usuario.idUser)\n"

    . "WHERE (calificacion.idCalificador = $_SESSION[userId]) and (calificacion.calificacion IS NULL)";

$calificaciones_como_copiloto = mysqli_query($conexion, $consulta) or die("Error en la consulta de calificaciones pendientes como copiloto". mysqli_error($conexion));

$consulta = "SELECT calificacion.idCalificacion, calificacion.idCalificador, calificacion.idCalificado, calificacion.idViaje, viaje.idPiloto, viaje.fecha_partida, viaje.origen, viaje.destino, usuario.nombre, usuario.apellido\n"

    . "FROM calificacion\n"

    . "INNER JOIN viaje ON ((calificacion.idCalificador=viaje.idPiloto) AND (calificacion.idViaje = viaje.idViaje))\n"

    . "INNER JOIN usuario on (calificacion.idCalificado = usuario.idUser)\n"

    . "WHERE (calificacion.idCalificador = $_SESSION[userId]) and (calificacion.calificacion IS NULL)";

$calificaciones_como_piloto = mysqli_query($conexion, $consulta) or die("Error en la consulta de calificaciones pendientes como piloto". mysqli_error($conexion));


?>

<div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/calificacion.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-8" style="margin-top: 1.5rem">
      <h1 class="display-6" style="font-family: helvetica;">Mis calificaciones pendientes</h1>
      <p> En esta sección se encuentran tus calificaciones pendientes como piloto y como copiloto. </p>
    </div>
</div>
 <hr>
 <div class="row">
   <div class="col col-md-6">
     <h5 class="px-2">Calificaciones como piloto</h5>
   </div>
   <div class="col col-md-6">
     <h5 class="px-2">Calificaciones como copiloto</h5>
   </div>
</div>

<div class="row">
  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">

  <?php
    if(mysqli_num_rows($calificaciones_como_piloto) == 0){

      ?>
      <div class="cardalert alert-info mt-2 mb-4">
        <div class="card-body ">
          <h5 class="card-title">No tienes calificaciones a copilotos pendientes!</h5>
          <small class="card-text">Al finalizar un viaje como piloto, podrás calificar a los copilotos en esta sección.</small>
          <div class="pt-2 my-0 text-right">
            <a href="/altaviaje" class="btn btn-primary">Publica un viaje!</a>
        </div>
        </div>
      </div>

    <?php
  }
    else{
  $pendiente_como_piloto = mysqli_fetch_array($calificaciones_como_piloto);
  while ($pendiente_como_piloto) {
    $idViaje = $pendiente_como_piloto['idViaje'];

  ?>
    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50"><?php echo $pendiente_como_piloto['destino']?></h5>
        <div class="card-body">
          <h5 class="card-title">Tus copilotos en este viaje</h5>
          <ul class="list-group list-group-flush py-1">
          <?php
          while (($pendiente_como_piloto) && ($pendiente_como_piloto['idViaje'] == $idViaje)){

          ?>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  <?php echo $pendiente_como_piloto['nombre'] . ' ' . $pendiente_como_piloto['apellido'];?>
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $pendiente_como_piloto['idCalificacion'];?>">Calificar</button>
                </div>
              </div>
            </li>

            <!-- Modal -->
            <form action="/calificaciones" method="post">
            <div class="modal fade" id="exampleModalCenter<?php echo $pendiente_como_piloto['idCalificacion'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Calificar a <?php echo $pendiente_como_piloto['nombre'] . ' ' . $pendiente_como_piloto['apellido']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                      Fué tu copiloto en el viaje <?php echo $pendiente_como_piloto['origen'] . ' a ' . $pendiente_como_piloto['destino']; ?> que se realizó en la fecha <?php $date = date_create($pendiente_como_piloto['fecha_partida']);
                      echo $date->format('d-m-Y');?>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlSelect1">Cual fue tu experiencia con el en tu viaje?</label>
                      <select name="calificacion" class="form-control" id="exampleFormControlSelect1">
                        <option value="1">Buena</option>
                        <option value="-1">Mala</option>
                        <option value="0">Regular</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Comenta tu experiencia</label>
                      <textarea name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="¿Que tal estuvo el viaje con el copiloto?"></textarea>
                      <input type="hidden" name="idCalificacion" value="<?php echo $pendiente_como_piloto['idCalificacion']?>">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="enviarCalificacion" class="btn btn-success">Enviar!</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

          <?php
          $pendiente_como_piloto = mysqli_fetch_array($calificaciones_como_piloto);
        } // Fin corte de control
          ?>
          </ul>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-info">Calificar a todos</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->

    <?php
    } //Fin while principal
  }
     ?>
   </div> <!-- Fin de las calificaciones pendientes como piloto -->



  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">
  <?php
  if(mysqli_num_rows($calificaciones_como_copiloto) == 0){

    ?>
    <div class="cardalert alert-info mt-2 mb-4">
      <div class="card-body ">
        <h5 class="card-title">No tienes calificaciones a pilotos pendientes!</h5>
        <small class="card-text">Al finalizar un viaje como copiloto, podrás calificar al piloto en esta sección.</small>
        <div class="pt-2 my-0 text-right">
          <a href="/" class="btn btn-primary">Busca viajes!</a>
      </div>
      </div>
    </div>

  <?php
}
  else{
    while($pendiente_como_copiloto = mysqli_fetch_array($calificaciones_como_copiloto))
    {
  ?>
    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50"><?php echo $pendiente_como_copiloto['origen'] . ' a ' . $pendiente_como_copiloto['destino']; ?></h5>
        <div class="card-body px-0 py-0">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Piloto</th>
                <td><?php echo $pendiente_como_copiloto['nombre'] . ' ' . $pendiente_como_copiloto['apellido']; ?></td>
              </tr>
              <tr>
                <th scope="row">Fecha del viaje</th>
                <td><?php $date = date_create($pendiente_como_copiloto['fecha_partida']);
                echo $date->format('d-m-Y');?></td>
              </tr>
            </tbody>
          </table>

        </div>
        <div class="card-footer text-right py-2">
          <a href="#"class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $pendiente_como_copiloto['idCalificacion'];?>">Calificar al piloto</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->

    <!-- Modal -->
    <form action="/calificaciones" method="post">
    <div class="modal fade" id="exampleModalCenter<?php echo $pendiente_como_copiloto['idCalificacion'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Calificar a <?php echo $pendiente_como_copiloto['nombre'] . ' ' . $pendiente_como_copiloto['apellido']; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning" role="alert">
              Fué tu piloto en el viaje <?php echo $pendiente_como_copiloto['origen'] . ' a ' . $pendiente_como_copiloto['destino']; ?> que se realizó en la fecha <?php $date = date_create($pendiente_como_copiloto['fecha_partida']);
              echo $date->format('d-m-Y');?>
            </div>
            <div class="form-group">
            <label for="exampleFormControlSelect1">Cual fue tu experiencia en su viaje?</label>
              <select name="calificacion" class="form-control" id="exampleFormControlSelect1">
                <option value="1">Buena</option>
                <option value="-1">Mala</option>
                <option value="0">Regular</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Comenta tu experiencia</label>
              <textarea name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="¿Que tal estuvo el viaje con el piloto?"></textarea>
              <input type="hidden" name="idCalificacion" value="<?php echo $pendiente_como_copiloto['idCalificacion']?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="enviarCalificacion" class="btn btn-success">Enviar!</button>
          </div>
        </div>
      </div>
    </div>
  </form>
    <?php
    }
  }
    ?>


  </div> <!-- Fin scroll bar -->

</div>

<?php
}
