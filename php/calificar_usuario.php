<?php
if(isset($_POST['enviarCalificacion']))
{
  $fecha = date("Y-m-d");
  $sql = "UPDATE calificacion\n"

    . "SET calificacion.calificacion=$_POST[calificacion], comentario='$_POST[comentario]', fecha = '$fecha'"

    . "WHERE calificacion.idCalificacion = $_POST[idCalificacion]";
  mysqli_query($conexion, $sql) or die("Problemas al actualizar la calificacion del piloto/copiloto" . mysqli_error($conexion));
}

setcookie("calificar_usuario",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file);




?>
