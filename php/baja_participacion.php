<?php
  if ($_POST['estado'] == 1){
  mysqli_query($conexion,"DELETE from participacion where idParticipacion='$_POST[idParticipacion]'")
  or die ("error en la carga de participacion");
  }
  else {
    mysqli_query($conexion,"UPDATE participacion set estado=3 where idParticipacion='$_POST[idParticipacion]'")
    or die ("error en la actualizacion de estado");
  }

  setcookie("baja_participacion",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file . '/' . $_POST['baja_participacion']);
