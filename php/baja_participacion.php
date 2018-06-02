<?php
$verificacion_participacion=mysqli_query($conexion,"SELECT *
                        from participacion
                        where idParticipacion='$_POST[idParticipacion]'")
                        or die ("eeror en la verificacion");
if  (mysqli_fetch_array($verificacion_participacion)['estado'] == 2){
  if ($_POST['estado'] == 1){
  mysqli_query($conexion,"DELETE from participacion where idParticipacion='$_POST[idParticipacion]'")
  or die ("error en la carga de participacion");
  }
  else {
    mysqli_query($conexion,"UPDATE participacion set estado=3 where idParticipacion='$_POST[idParticipacion]'")
    or die ("error en la actualizacion de estado");

    mysqli_query($conexion,"INSERT into calificacion (idCalificador,idCalificado,tipo,fecha,calificacion,comentario)
                            values (0,'$_SESSION[userId]',3,now(),-1,'penalizacion por cancelacion de participacion')")
                            or die ("error en penalizacion");
  }
}
  setcookie("baja_participacion",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file . '/' . $_POST['baja_participacion']);
