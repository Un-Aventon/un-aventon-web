<?php
$ok = false;
if(isset($_POST['enviar']))
{
  $email = $_POST['email'];
  $sql = "SELECT * FROM usuario WHERE email = '$email'";
  $user = mysqli_query($conexion, $sql) or die("Problemas en el recuperar contraseña" . mysqli_error($conexion));
  $user = mysqli_fetch_array($user);
  if(isset($user))
  {
    $ok = true;
  }
  else {
    echo '<div class="alert alert-warning alert-dismissable centrado" style="z-index: 99999; box-shadow: 0px 3px 20px rgba(54, 54, 54, 0.7)">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                El email ingresado no existe!
            </div>';
  }
}

if($ok)
{
  setcookie("rec_contraseña",true);
  $r = new Router;
  $file = $r->get_file();
  header('Location: /' . $file);
}

?>
