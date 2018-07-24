<?php

// LA VALIDACION ES SIMULADA. SOLO ACEPTA LA TARJETA 7777 7777 7777 7777
	$num = $_POST['numero'];

  if($num == "7777777777777777")
	{
    var_dump($num);
    $sql = "UPDATE pago SET estado = 1 WHERE idPago = $_POST[idPago]";
    mysqli_query($conexion, $sql);
    setcookie("pagar_viaje",true);
    $r = new Router;
    $file = $r->get_file();
    header('Location: /' . $file);
  }
  else {
    echo '<div class="alert alert-danger alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                Existe un inconveniente con la tarjeta ingresada
            </div>';
  }
