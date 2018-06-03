<?php

	function render($vars = [])
	{
    // incluyo la conexion.
    include('php/conexion.php');

    $usuario=mysqli_query($conexion,"SELECT *
                                     from usuario
                                     where idUser='$vars[0]'")
                                     or die ("problemas en el select de usuarios");
    $usuario=mysqli_fetch_array($usuario);
    ?>
    <h1>Perfil de <?php echo $usuario['nombre']." ".$usuario['apellido'];?> </h1>
    <?php $calificaciones = calificacion_grafica_simple($usuario['idUser']);

    echo "calificaciones totales: ".$calificaciones["contador_total"]."
          <br>";
    echo  "<small class='float-right''>".$calificaciones['positivas']." calificaciones positivas </small> <br>";
    echo "<div class='progress'>
            <div class='progress-bar bg-success' role='progressbar' style='width: ".$calificaciones['porcentaje_pos']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo  "<small class='float-right''>".$calificaciones['neutras']." calificaciones neutras </small> <br>";
    echo "<div class='progress'>
              <div class='progress-bar bg-warning' role='progressbar' style='width: ".$calificaciones['porcentaje_neu']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo  "<small class='float-right''>".$calificaciones['negativas']." calificaciones negativas </small> <br>";
    echo "<div class='progress'>
              <div class='progress-bar bg-danger' role='progressbar' style='width: ".$calificaciones['porcentaje_neg']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo "<br> <br>";

  }
