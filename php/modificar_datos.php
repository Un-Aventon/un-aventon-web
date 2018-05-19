<?php
  mysqli_query($conexion,"UPDATE usuario set email='$_REQUEST[email]', nombre='$_REQUEST[nombre]', apellido='$_REQUEST[apellido]'
                          WHERE email = '$_SESSION[mail]'")
  or
  die("Problemas en la actualizacion:".mysqli_error($conexion));

  $_SESSION['email']=$_REQUEST['email'];
  $_SESSION['nombre']=$_REQUEST['nombre'];
  $_SESSION['apellido']=$_REQUEST['apellido'];

  setcookie("modificacion_datos",true);

  header('Location: /perfil');

  ?>
