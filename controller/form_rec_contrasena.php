<?php
function render($vars = [])
{
  include('php/conexion.php');

  !isset($_POST['enviar'])?:include('php/rec_contraseña.php');

  if(isset($_COOKIE["rec_contraseña"]) && $_COOKIE["rec_contraseña"])
  {
      echo '<div class="alert alert-success alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                  Se te envió un email con un link para recuperar tu contraseña!
              </div>';

      setcookie("rec_contraseña",false);
  }
?>
<div class="container py-4">

  <div class="card mb-4" style="width:25rem; margin-left: 20rem">
      <h5 class="card-header">Recuperar Contraseña</h5>
    <div class="card-body">
        <form action="/form_rec_contrasena" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Ingresa el email de la cuenta que deseas recuperar</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <button type="submit" name="enviar" class="btn btn-primary">Recuperar</button>
          </form>
    </div>
  </div>

</div>

<?php

}
