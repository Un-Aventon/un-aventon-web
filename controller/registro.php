<?php

function render($arr = [])
{
  //la utilizo para ver si muestro el formulario.
  $form = true;
  include('php/conexion.php');

    if(isset($_POST['registro']))
    {
        $simple_pattern ='/^[a-zA-Z0-9\-_.,! ]{5,50}$/';
        $names_pattern ='/^[a-zA-Z ]{3,50}$/';
        $email_patter = '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/';
        $mail = $_POST['mail'];

        $form = false;
        if(preg_match($email_patter, $mail))
        {
          //verifico que no se encuentre registrado el email.
          $rec=mysqli_query($conexion,"SELECT * 
from usuario
 WHERE email='$mail' and estadoUsuario = 1 ")
          or
          die("Problemas en la base de datos:".mysqli_error($conexion));
          if(mysqli_fetch_array($rec) > 0)
          {
                  echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El E-Mail ya se encuentra registrado
              </div>';
            $form = true;
          }
        }else{
                 echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El E-Mail ingresado no es válido.
              </div>';
           $form = true;
          }

          $edad = $_POST['edad'];
          if(calc_edad($edad) < 16)
          {
                 echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Debes ser mayor de 16 años.
              </div>';
             $form = true;
          }

          $pass = $_POST['pass'];
          if(!preg_match($simple_pattern, $pass))
          {
                 echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    La contraseña ingreasada no es válida.
              </div>';
            $form = true;
          }

          $nombre = $_POST['nombre'];
          if(!preg_match($names_pattern, $nombre))
          {
                 echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El nombre ingresado no es válido.
              </div>';
            $form = true;
          }

          $apellido = $_POST['apellido'];
          if(!preg_match($names_pattern, $apellido))
          {
                 echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    El Nombre ingresado no es válido.
              </div>';
            $form = true;
          }

          if(!$form)
          {
            $rec=mysqli_query($conexion,"

insert into usuario
 (email,clave,nombre,apellido) VALUES ('$mail','$pass','$nombre','$apellido' )") or die ('error '.mysqli_error($conexion));
            echo "<h2> El usuario se registro correctamente. </h3><br/>";
            echo "<h4><a href='/login'> iniciar sesion </a></h4>";
          }

  }



  if($form)
  {
  ?>

  </div>

  <div class="container h-100" style="background-image: url('/img/sys/cover-registro.jpg'); background-repeat:no-repeat; background-size: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="card bg-white" style="max-width: 600px; margin-top: 20px; margin-bottom: 20px">
        <div class="card-header"><h2 class="text-center">Registro</h2></div>
        <div class="card-body">
          <form action="/registro" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Dirección de Email</label>
            <input type="email" name="mail" class="form-control" id="email" aria-describedby="emailHelp" <?php if(isset($mail) && preg_match($email_patter, $mail)){echo 'value="'. $mail.'"';}else{echo 'placeholder="Ingrese su email"';} ?>>
            <small id="emailHelp" class="form-text text-muted">Tu información nunca será compartida con terceros.</small>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" <?php if(isset($nombre) && preg_match($names_pattern, $nombre)){echo 'value="'. $nombre.'"';}else{echo 'placeholder="Ingrese su nombre"';} ?>>
          </div>
          <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" id="apellido" <?php if(isset($apellido) && preg_match($names_pattern, $apellido)){echo 'value="'. $apellido.'"';}else{echo 'placeholder="Ingrese su apellido"';} ?>>
          </div>
          <div class="form-group">
            <label>Fecha de nacimiento</label>
            <input type="date" name="edad" class="form-control" id="edad" <?php if(isset($edad)){ echo 'value="' . $edad . '"';}?>>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="pass" class="form-control" id="pass" pattern="{5,50}" placeholder="Ingresa una contraseña">
          </div>

          <div class="container-fluid" style="margin-top:.5rem; padding: 0">
            <input type="submit" name="registro" value="Registrarse!" class="btn btn-success form-control form-control-lg">
          </div>
        </form>
       </div>
    </div>
  </div>
</div>

<!-- fin parche = abro container -->
<div class="container" style="border-radius: 5px">

  <?php

  }


}
