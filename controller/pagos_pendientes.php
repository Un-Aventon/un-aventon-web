<?php
function render($vars = []){

include('php/conexion.php');

!isset($_POST['idPago'])?:include('php/pagar_viaje.php');

if(isset($_COOKIE["pagar_viaje"]) && $_COOKIE["pagar_viaje"])
{
    echo '<div class="alert alert-success alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                Tu pago se efectuó correctamente!
            </div>';

    setcookie("pagar_viaje",false);
}

$sql = "SELECT pago.idPago, viaje.idPiloto, viaje.fecha_partida, viaje.origen, viaje.destino, viaje.costo, usuario.nombre, usuario.apellido\n"

    . "FROM pago\n"

    . "INNER JOIN viaje ON (viaje.idViaje = pago.idViaje)\n"

    . "INNER JOIN usuario ON (viaje.idPiloto = usuario.idUser)\n"

    . "WHERE viaje.idPiloto = $_SESSION[userId] AND pago.estado IS NULL";

$pagos_pendientes = mysqli_query($conexion, $sql);

$sql = "SELECT pago.idPago, viaje.idPiloto, viaje.fecha_partida, viaje.origen, viaje.destino, viaje.costo, usuario.nombre, usuario.apellido\n"

    . "FROM pago\n"

    . "INNER JOIN viaje ON (viaje.idViaje = pago.idViaje)\n"

    . "INNER JOIN usuario ON (viaje.idPiloto = usuario.idUser)\n"

    . "WHERE viaje.idPiloto = $_SESSION[userId] AND pago.estado IS NOT NULL";

$pagos_abonados = mysqli_query($conexion, $sql);


?>

<div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/pago.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-8" style="margin-top: 1.5rem">
      <h1 class="display-6" style="font-family: helvetica;">Mis Pagos Pendientes</h1>
      <p class="mb-1"> En esta sección se encuentran tus pagos pendientes en relacion a los viajes que hayas realizado. </p>
      <p class="mt-0"> Recordá que UnAventón solo cobra un 5% del valor total de cada viaje que hayas efectuado. </p>
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

<div class="row">
  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">

    <?php
    if(mysqli_num_rows($pagos_pendientes) == 0){

        ?>
        <div class="alert-info mt-4 mb-4">
          <div class="card-body ">
            <h5 class="card-title">No tienes pagos pendientes!</h5>
            <small class="card-text">Al finalizar un viaje como piloto, podrás abonar la comisión por publicar un viaje en esta sección.</small>
            <div class="pt-2 my-0 text-right">
              <a href="/altaviaje" class="btn btn-primary">Publica un viaje!</a>
          </div>
          </div>
        </div>

      <?php
    }
    else{

    while($pago = mysqli_fetch_array($pagos_pendientes))
    {
    ?>
    <div class="row px-3 my-4"> <!-- Comienzo del pago pendiente -->
      <div class="card" style="width:30rem;">
        <h5 class="card-header h-50"><?php echo $pago['origen'] . ' a ' . $pago['destino']; ?></h5>
        <div class="card-body pt-3 pb-1">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Fecha del viaje</th>
                <td><?php $date = date_create($pago['fecha_partida']);
                echo $date->format('d-m-Y');?></td>
              </tr>
              <tr>
                <th scope="row">Costo a pagar</th>
                <td>$<?php $costo = $pago['costo'] * 5 /100; echo $costo ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right py-2">
          <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $pago['idPago'];?>">Realizar Pago</a>
        </div>
      </div>
  </div> <!-- Fin del pago pendiente -->

  <form action="/pagos_pendientes" method="post">
    <div class="modal fade" id="exampleModalCenter<?php echo $pago['idPago'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Realizar Pago</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning" role="alert">
              Estas a punto de abonar el viaje <?php echo $pago['origen'] . ' a ' . $pago['destino']; ?> que se realizó en la fecha <?php $date = date_create($pago['fecha_partida']);
              echo $date->format('d-m-Y');?> con un valor de <?php $costo = $pago['costo'] * 5 /100; echo "$$costo.";?>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Ingresa los 16 dígitos de tu tarjeta</label>
              <input type="text" class="form-control" minlength="16" maxlength="16" name="numero" placeholder="1111 2222 3333 4444" required>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Ingresa la fecha de vencimiento de la tarjeta</label>
              <input type="date" class="form-control" name="vencimiento" id="vencimiento" required>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Ingresa el código de seguridad de la tarjeta</label>
              <input type="text" class="form-control" name="codigoseg" id="codigoseg" minlength="3" maxlength="3" placeholder="123" required>
              <input type="hidden" name="idPago" value="<?php echo $pago['idPago']?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="enviarCalificacion" class="btn btn-success">Pagar!</button>
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

  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">

    <?php
    if(mysqli_num_rows($pagos_abonados) == 0){

        ?>
        <div class="alert-info mt-4 mb-4">
          <div class="card-body ">
            <h5 class="card-title">No dispones de viajes abonados</h5>
            <small class="card-text">Al efectuar el pago de la comisión por publicar un viaje, podrás ver el listado de tus viajes pagos en esta sección.</small>
            <div class="pt-2 my-0 text-right">
              <a href="/altaviaje" class="btn btn-primary">Publica un viaje!</a>
          </div>
          </div>
        </div>

      <?php
    }
    else{

    while($pago = mysqli_fetch_array($pagos_abonados))
    {
    ?>

    <div class="row px-3 my-4">
      <div class="card border-success mb-3" style="width: 30rem;">
        <h5 class="card-header h-50"><?php echo $pago['origen'] . ' a ' . $pago['destino']; ?></h5>
        <div class="card-body text-success pt-3 pb-1">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Fecha del viaje</th>
                <td><?php $date = date_create($pago['fecha_partida']);
                echo $date->format('d-m-Y');?></td>
              </tr>
              <tr>
                <th scope="row">Costo abonado</th>
                <td>$<?php $costo = $pago['costo'] * 5 /100; echo $costo ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- Fin del pago pagado -->

    <?php
    }
    }
     ?>


  </div> <!-- Fin scroll bar -->



</div> <!-- Fin row principal -->


<?php
} // Fin funcion render()
