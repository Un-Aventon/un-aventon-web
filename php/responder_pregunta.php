<?php
if(isset($_POST['responder'])){
    $consulta = "UPDATE pregunta set respuesta='$_POST[respuesta]' where idPregunta='$_POST[idPregunta]'";
    mysqli_query($conexion,$consulta) or die("problemas al efectuar la respuesta a la pregunta");
}

setcookie("responder_pregunta",true);
$r = new Router;
$file = $r->get_file();
header('Location: /' . $file . '/' . "$vars[0]/$vars[1]");

 ?>
