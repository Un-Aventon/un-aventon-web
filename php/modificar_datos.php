<?php
  $viajes_user=mysqli_query($conexion, "SELECT *
                                 from viaje
                                 where idPiloto = $_SESSION[userId] and estado = 'activo'")
                                 or die("problemas en la busqueda de viajes activos del usuario".mysqli_error($conexion));

    if (mysqli_num_rows($viajes_user) == 0){

        if ( (comprobar_string($_REQUEST['email'])) && (comprobar_string($_REQUEST['nombre'])) && (comprobar_string($_REQUEST['apellido'])) ){

          mysqli_query($conexion,"UPDATE usuario set email='$_REQUEST[email]', nombre='$_REQUEST[nombre]', apellido='$_REQUEST[apellido]'
                                  WHERE email = '$_SESSION[mail]'")
                                  or
                                  die("Problemas en la actualizacion:".mysqli_error($conexion));

                                  $_SESSION['email']=$_REQUEST['email'];
                                  $_SESSION['nombre']=$_REQUEST['nombre'];
                                  $_SESSION['apellido']=$_REQUEST['apellido'];

                                  setcookie("modificacion_datos",true);
                                  header('Location: /perfil');
        }
        else{
          echo '  <br>
                  <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b>Parece que pusiste algun caracter de mas ;)</b> , solo letras y guiones por favor.
                  </div>';
        }
    }
    else {
      echo '  <br>
              <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b>Parece que todavia tenes viajes activos</b>, hasta que no finalicen no podras cambiar tus datos
              </div>';
    }

  ?>