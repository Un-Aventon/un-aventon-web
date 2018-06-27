<?php
$verificacion_participacion=mysqli_query($conexion,"SELECT *
                        from participacion
                        where idParticipacion='$_POST[idParticipacion]'")
                        or die ("eeror en la verificacion");
if (mysqli_fetch_array($verificacion_participacion)['estado'] == 1){
mysqli_query($conexion,"UPDATE participacion set estado=2 where idParticipacion='$_POST[idParticipacion]'")
or die ("error en la actualizacion de estado");
}

setcookie("aceptar_postulacion",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file . '/' . "$vars[0]/$vars[1]");

 ?>
