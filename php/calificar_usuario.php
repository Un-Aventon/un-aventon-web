<?php
if(isset($_POST['enviarCalificacion']))
{
  $sql = "UPDATE calificacion\n"

    . "SET calificacion.calificacion=$_POST[calificacion], comentario='$_POST[comentario]'"

    . "WHERE calificacion.idCalificacion = $_POST[idCalificacion]";
  mysqli_query($conexion, $sql) or die("Problemas al actualizar la calificacion del piloto/copiloto" . mysqli_error($conexion));
}

setcookie("calificar_usuario",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file);




?>
