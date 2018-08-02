<?php
function render($vars = [])
{
  include('php/conexion.php');

  !isset($_POST['enviar'])?:include('php/rec_contraseña.php');

  if(isset($_COOKIE["cambiar_contraseña"]) && $_COOKIE["cambiar_contraseña"])
  {
      echo '<div class="alert alert-success alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                  Se te envió un email con un link para recuperar tu contraseña!
              </div>';

      setcookie("cambiar_contraseña",false);
  }
?>
<div class="container py-4">

  <div class="card mb-4" style="width:25rem; margin-left: 20rem">
      <h5 class="card-header">Recuperar Contraseña</h5>
    <div class="card-body">
        <form action="/cambiar_contrasena" method="post">
          <div class="form-group">
            <label for="exampleInputPassword1">Ingrese su nueva contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Repita su nueva contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <button type="submit" name="enviar" class="btn btn-danger">Cambiar</button>
          </form>
    </div>
  </div>

</div>

<?php

}
