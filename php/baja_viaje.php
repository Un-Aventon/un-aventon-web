<?php
    
    $contador_participaciones=mysqli_query($conexion,"SELECT *
                                                      from participacion
                                                      where estado=2 and estado=1 and idViaje=$_POST[bajaViaje]")
                                                      or die ("problemas en el contador de participantes del viaje");

    $hayPartipaciones = mysqli_num_rows($contador_participaciones);

    if($hayPartipaciones){
    	while($participante = mysqli_fetch_array($contador_participaciones)){
    		if($participante['estado'] == 2)
    			// Si era un copiloto, setea el estado de su participacion en "terminado"
    			mysqli_query($conexion, "UPDATE participacion set estado=5 where idParticipacion=$participante[idParticipacion]") or die('error '.mysqli_error($conexion));
    		else
    			// Si era un postulante, setea el estado de su postulacion en "cancelado por el piloto"
    			mysqli_query($conexion, "UPDATE participacion set estado=4 where idParticipacion=$participante[idParticipacion]") or die('error '.mysqli_error($conexion));
    	}

    	// FALTA AGREGAR LA RESTA DE 2 PUNTOS AL COPILOTO!!!
	}
    // Actualiza el estado del viaje y lo pone en "cancelado"
    mysqli_query($conexion, "UPDATE viaje set estado=2 where idViaje=$_POST[bajaViaje]") or die('error '.mysqli_error($conexion));

													 
	setcookie("baja_viaje",true);
	$r = new Router;
	$file = $r->get_file();
	header('Location: /' . $file);
		 	
?>
