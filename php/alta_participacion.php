<?php if (!isset($_SESSION['userId'])){
  header('Location: /login');
}
else{
  $contador=mysqli_query($conexion,"SELECT *
                          from participacion
                          where idViaje='$viaje[idViaje]' and estado = 2")
                          or die ("problemas con el listado de participaciones del piloto");
  if (mysqli_num_rows($contador) < $viaje['asientos_disponibles']) {

  mysqli_query($conexion,"DELETE from participacion where idViaje='$viaje[idViaje]' and idUsuario='$_SESSION[userId]'")
  or die ("error en la limpieza de participacion");
  mysqli_query($conexion,"INSERT INTO participacion (idUsuario,idViaje,fecha_solicitud,estado) VALUES ('$_SESSION[userId]','$viaje[idViaje]',now(),1)")
  or die ("error en la carga de participacion");

  setcookie("carga_participacion",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file . '/' . $_POST['carga_participacion']);
  }
}
