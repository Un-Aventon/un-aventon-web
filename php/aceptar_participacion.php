<?php
mysqli_query($conexion,"UPDATE participacion set estado=2 where idParticipacion='$_POST[idParticipacion]'")
or die ("error en la actualizacion de estado");

setcookie("aceptar_postulacion",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file . '/' . $_POST['aceptar_postulacion']);

 ?>
