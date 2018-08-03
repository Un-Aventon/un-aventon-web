<?php
// LA VALIDACION ES SIMULADA. SOLO ACEPTA LAS TARJETAS QUE NO FORMEN PARTE DEL ARRAY HARDCODEADO ABAJO
	function es_valida($tarjetaEnviada)
	{
		$tarjetasInvalidas = ["7777777777777777",
													"1234123412341234",
													"4321432143214321",
													"9876987698769876"];
		$esValida = true;
		foreach ($tarjetasInvalidas as $t) {
			if($t == $tarjetaEnviada) $esValida = false;
		}
		return $esValida;
	}

	$num = $_POST['numero'];
  $fecha = $_POST['vencimiento'];
  $cod = $_POST['codigoseg'];

  if(es_valida($num) and ($fecha >= date("Y-m-d") and preg_match("/^[0-9]{3}/", $cod)))
	{
    var_dump($num);
		$fecha = date("Y-m-d");
    $sql = "UPDATE pago SET fecha = '$fecha', estado = 1 WHERE idPago = $_POST[idPago]";
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
