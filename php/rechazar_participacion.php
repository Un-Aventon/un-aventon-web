<?php
if ($_POST['estado'] == 1) {
  // nada
}
else {
  mysqli_query($conexion,"INSERT into calificacion (idCalificador,idCalificado,tipo,fecha,calificacion,comentario)
  values (0,'$_SESSION[userId]',3,now(),-1,'penalizacion por rechazo de postulacion')")
  or die ("error en penalizacion ->".mysqli_error($conexion));
}

mysqli_query($conexion,"UPDATE participacion set estado=4 where idParticipacion='$_POST[idParticipacion]'")
or die ("error en la actualizacion de estado");


setcookie("rechazar_postulacion",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file . '/' . "$vars[0]/$vars[1]");

 ?>
