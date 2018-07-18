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

    . "INNER JOIN usuario ON (viaje.idPiloto = usuario.idUser)";

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
     <div class="row">
       <div class="col col-md-6">
         <h5 class="px-2">Tus pagos pendientes</h5>
       </div>
       <div class="col col-md-6">
         <h5 class="px-2">Tus pagos abonados</h5>
       </div>
    </div>

    <?php


    }
    else  echo "Menú solo para administradores";
  }
  else echo "Debes ser administrador logueado para ver esta sección";

}
