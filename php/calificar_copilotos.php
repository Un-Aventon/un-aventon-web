<?php
if(isset($_POST['calificar_a_todos']))
{
  for($i = 0; $i < $_POST['cant_usuarios']; $i++){
    $numeroCalificacion = 'numero' . $i;
    $sql = "UPDATE calificacion\n"

      . "SET calificacion.calificacion=$_POST[calificacion], comentario='$_POST[comentario]'"

      . "WHERE calificacion.idCalificacion = $_POST[$numeroCalificacion]";
    mysqli_query($conexion, $sql) or die("Problemas al actualizar la calificacion del grupo" . mysqli_error($conexion));
  }
}

setcookie("calificar_a_todos",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file);




?>
