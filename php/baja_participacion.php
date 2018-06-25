<?php
$verificacion_participacion=mysqli_query($conexion,"SELECT *
                        from participacion
                        where idParticipacion='$_POST[idParticipacion]'")
                        or die ("eeror en la verificacion");
switch (mysqli_fetch_array($verificacion_participacion)['estado']) {
  case 1:
  mysqli_query($conexion,"DELETE from participacion where idParticipacion='$_POST[idParticipacion]'")
  or die ("error en la carga de participacion");
  break;
  case 2:
  mysqli_query($conexion,"UPDATE participacion set estado=3 where idParticipacion='$_POST[idParticipacion]'")
  or die ("error en la actualizacion de estado");

  mysqli_query($conexion,"INSERT into calificacion (idCalificador,idCalificado,tipo,fecha,calificacion,comentario)
                          values (0,'$_SESSION[userId]',3,now(),-1,'penalizacion por cancelacion de participacion')")
                          or die ("error en penalizacion --> ".mysqli_error($conexion));
  break;
  default:
    echo "error :(";
  break;
}

  setcookie("baja_participacion",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file);
