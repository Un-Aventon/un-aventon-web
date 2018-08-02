<?php
function render($vars = [])
{
  include('php/conexion.php');

  $sql = "SELECT * FROM usuario WHERE idUser = $vars[0] and recuperarPassword = 1";

  $existe = mysqli_query($conexion, $sql) or die("Problemas con cambiar la contraseña" . mysqli_error($conexion));

  if($existe = mysqli_fetch_array($existe))
  {
      !isset($_POST['enviar'])?:include('php/cambiar_contraseña.php');


    ?>
    <div class="container py-4">

      <div class="card mb-4" style="width:25rem; margin-left: 20rem">
          <h5 class="card-header">Recuperar Contraseña</h5>
        <div class="card-body">
            <form action="/cambiar_contrasena/<?php echo $vars[0];?>" method="post">
              <div class="form-group">
                <label for="exampleInputPassword1">Ingrese su nueva contraseña</label>
                <input type="password" minlength="5" name="pass1" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Repita su nueva contraseña</label>
                <input type="password" name="pass2" minlength="5" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
              </div>
              <button type="submit" name="enviar" class="btn btn-danger">Cambiar</button>
              </form>
        </div>
      </div>

    </div>

  <?php

  }
  else {
    if(isset($_COOKIE["cambiar_contraseña"]) && $_COOKIE["cambiar_contraseña"])
    {
      echo '<div class="alert alert-success">
						Tu contraseña fue cambiada satisfactoriamente!<br/>
						<a href="/"> Ir al inicio</a>
				</div>';

        setcookie("cambiar_contraseña",false);
    }
    else{
        header('Location: /fail');
    }
  }
}
