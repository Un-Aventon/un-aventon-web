<?php
if(isset($_POST['enviarCalificacion']))
{
  $sql = "UPDATE calificacion\n"

    . "SET calificacion.calificacion=$_POST[calificacion], comentario='$_POST[comentario]'"

    . "WHERE calificacion.idCalificacion = $_POST[idCalificacion]";
  mysqli_query($conexion, $sql) or die("Problemas al actualizar la calificacion del piloto" . mysqli_error($conexion));
}

setcookie("calificar_piloto",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file);




?>
