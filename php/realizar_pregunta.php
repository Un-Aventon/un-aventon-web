<?php
if(isset($_POST['preguntar'])){
    $consulta = "INSERT into pregunta (idPreguntante, idViaje , pregunta, respuesta, fecha) values ('$_SESSION[userId]', '$viaje[idViaje]', ' $_POST[pregunta]', '', now())";
    mysqli_query($conexion,$consulta) or die("problemas al efectuar la carga de la pregunta");
}

setcookie("realizar_pregunta",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file . '/' . "$vars[0]/$vars[1]");

 ?>