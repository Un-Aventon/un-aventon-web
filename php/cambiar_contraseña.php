<?php
$ok = false;
$simple_pattern ='/^[a-zA-Z0-9\-_.,! ]{5,50}$/';
if(isset($_POST['enviar']))
{
  $id = $vars[0];
  if($_POST['pass1'] == $_POST['pass2'])
  {
    $ok = true;
    if(!preg_match($simple_pattern, $_POST['pass1']))
    {
      $ok = false;
      echo '<div class="alert alert-danger alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                  La constraseña ingresada es muy corta(5 caracteres como minimo)!
              </div>';
    }
  }
  else {
    echo '<div class="alert alert-danger alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                La primera contraseña ingresada no se corresponde con la segunda contraseña ingresada!
            </div>';
  }
}

if($ok)
{
  $sql = "UPDATE usuario SET recuperarPassword = 0 , clave = '$_POST[pass1]' WHERE idUser = $vars[0]";
  mysqli_query($conexion, $sql) or die("no se pudo actualizar la clave " . mysqli_error($conexion));
  setcookie("cambiar_contraseña",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file . "/$vars[0]");
}

?>
