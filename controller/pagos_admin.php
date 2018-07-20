<?php
function render($vars = [])
{
  include('php/conexion.php');

  if(isset($_SESSION['userId']))
  {
    if($_SESSION['admin'] == 1)
    {
      // Aca va toda la vista

      $sql = "SELECT pago.fecha, usuario.nombre, usuario.apellido, viaje.costo\n"

    . "FROM pago\n"

    . "INNER JOIN viaje on (pago.idViaje = viaje.idViaje)\n"

    . "INNER JOIN usuario ON (viaje.idPiloto = usuario.idUser)"

    . "WHERE pago.estado IS NOT NULL";

    $pagos = mysqli_query($conexion, $sql);

    ?>

    <div class="row">
        <div class="col-md-3" style="text-align: center">
          <img src="img/pago.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
        </div>
        <div class="col-md-8" style="margin-top: 1.5rem">
          <h1 class="display-6" style="font-family: helvetica;">Administracion de pagos</h1>
          <p class="mb-1"> En esta sección se encuentra toda la información en relacion a las comisiones cobradas por 'UnAventon' a los usuarios que publican viajes. </p>
        </div>
    </div>
     <hr>
    <form action="/pagos_admin" method="post">
    <div class="row my-2 mb-3 ml-4">
      <div class="col col-md-5">
          <label>Desde</label>
          <input type="date" name="inicial" class="form-control" <?php if(isset($inicial)){ echo 'value="' . $inicial . '"';}?>>
      </div>

      <div class="col col-md-5">
          <label>Hasta</label>
          <input type="date" name="terminal" class="form-control" <?php if(isset($terminal)){ echo 'value="' . $terminal . '"';}?>>
      </div>

      <div class="col col-md-2 pt-4 mt-2">
        <button type="submit" name="filtar"class="btn btn-info w-75"> Filtrar </button>
      </div>
    </div>
  </form>

    <div class="row">
      <div class="col col-md-12 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 500px; overflow: auto;">
        <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Nombre Completo</th>
                  <th scope="col" class="">Fecha</th>
                  <th scope="col">Monto Cobrado</th>
                </tr>
              </thead>
            <tbody>
              <?php
              while($pago = mysqli_fetch_array($pagos))
              {
              ?>
              <tr>
                <td><?php echo $pago['nombre'] . " " . $pago['apellido'];?></td>
                <td><?php echo $pago['fecha'];?></td>
                <td><?php echo ($pago['costo'] * 5 / 100);?></td>
              </tr>
              <?php
              }
              ?>
            </tbody>
        </table>
      </div>
    </div>
    <?php


    }
    else  echo "Menú solo para administradores";
  }
  else echo "Debes ser administrador logueado para ver esta sección";

}
