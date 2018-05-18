<?php
function render($vars = [])
{
  //###### agregar comprobacion de que no tenga viajes pendientes

  // incluyo la conexion
  include('php/conexion.php');

  mysqli_query($conexion,"UPDATE usuario set email='$_REQUEST[email]', nombre='$_REQUEST[nombre]', apellido='$_REQUEST[apellido]'
                          WHERE email = '$_SESSION[mail]'")
  or
  die("Problemas en la actualizacion:".mysqli_error($conexion));

  $_SESSION['email']=$_REQUEST['email'];
  $_SESSION['nombre']=$_REQUEST['nombre'];
  $_SESSION['apellido']=$_REQUEST['apellido'];

  ?>
  <div class="alert alert-success" role="alert" style="margin-top: 5px">
    <a href="#" class="alert-link">Exito</a> se realizaron los cambios correctamente
  </div>

  <center> <a href="/perfil">volver a mi perfil</a> </center>
  <?php


}
