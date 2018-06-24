<?php

    $contador_participaciones=mysqli_query($conexion,"SELECT *
                                                      from participacion
                                                      where estado <= 2 and (idViaje=$_POST[bajaViaje])")
                                                      or die ("problemas en el contador de participantes del viaje");

    $habiaCopilotos = false;

    while($participante = mysqli_fetch_array($contador_participaciones)){
      mysqli_query($conexion, "UPDATE participacion set estado=4 where idParticipacion='$participante[idParticipacion]'");
    	if($participante['estado'] == 2){
            $habiaCopilotos = true;
      }
  	}

    // Actualiza el estado del viaje y lo pone en "cancelado"
    mysqli_query($conexion, "UPDATE viaje set estado=2 where idViaje=$_POST[bajaViaje]") or die('error '.mysqli_error($conexion));

    // Califica negativo al piloto si habia copilotos
    if($habiaCopilotos){
          mysqli_query($conexion,"INSERT into calificacion (idCalificador,idCalificado,tipo,fecha,calificacion,comentario)
                          values (0,'$_SESSION[userId]',3,now(),-2,'penalizacion por baja de viaje')")
                          or die ("error en penalizacion de la baja del viaje --> ".mysqli_error($conexion));
    }

	setcookie("baja_viaje",true);
	$r = new Router;
	$file = $r->get_file();
	header('Location: /' . $file);

?>
