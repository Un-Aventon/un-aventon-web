<?php

	function render($vars = [])
	{
    // incluyo la conexion.
    include('php/conexion.php');

		if(isset($vars[1]))
		{
			switch ($vars[1])
			{
			    case "positivas":
							$positivas = "active";
				      $neutras = "";
				      $negativas = "";
							$sistema = "";
				      $estilo = "success";
				      $sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

				          . "FROM calificacion\n"

				          . "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

				          . "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = 1";
						 break;
			    case "neutras":
							$positivas = "";
							$neutras = "active";
							$negativas = "";
							$sistema = "";
							$estilo = "info";
							$sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

									. "FROM calificacion\n"

									. "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

									. "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = 0";
			        break;
			    case "negativas":
							$positivas = "";
							$neutras = "";
							$negativas = "active";
							$sistema = "";
							$estilo = "danger";
							$sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

									. "FROM calificacion\n"

									. "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

									. "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = -1";
			        break;
					case "sistema":
							$positivas = "";
							$neutras = "";
							$negativas = "";
							$sistema = "active";
							$estilo = "danger";
							$vars[1] = "del sistema";
							$sql = "SELECT calificacion.fecha, calificacion.calificacion, calificacion.comentario \n"

									. "FROM calificacion\n"

									. "WHERE calificacion.idCalificado = $vars[0] AND calificacion.tipo = 3";
							break;
			}
		}
		else {
			$positivas = "active";
			$neutras = "";
			$negativas = "";
			$sistema = "";
			$estilo = "success";
			$sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

					. "FROM calificacion\n"

					. "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

					. "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = 1";
		}

		$calificacionesNoNulas = mysqli_query($conexion, "SELECT * FROM calificacion WHERE idCalificado = $vars[0] and calificacion IS NOT NULL");

    $c = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

    $usuario=mysqli_query($conexion,"SELECT *
                                    from usuario
                                    where idUser='$vars[0]'")
                                    or die ("problemas en el select de usuarios");

    $usuario=mysqli_fetch_array($usuario);
    ?>
    <h1>Perfil de <?php echo $usuario['nombre']." ".$usuario['apellido'];?> </h1>
    <?php $calificaciones = calificacion_grafica_simple($usuario['idUser']);

    echo "calificaciones totales: ".mysqli_num_rows($calificacionesNoNulas)."
          <br>";
    echo  "<small class='float-right''>".$calificaciones['positivas']." calificaciones positivas </small> <br>";
    echo "<div class='progress'>
            <div class='progress-bar bg-success' role='progressbar' style='width: ".$calificaciones['porcentaje_pos']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo  "<small class='float-right''>".$calificaciones['neutras']." calificaciones neutras </small> <br>";
    echo "<div class='progress'>
              <div class='progress-bar bg-info' role='progressbar' style='width: ".$calificaciones['porcentaje_neu']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo  "<small class='float-right''>".$calificaciones['negativas']." calificaciones negativas </small> <br>";
    echo "<div class='progress'>
              <div class='progress-bar bg-danger' role='progressbar' style='width: ".$calificaciones['porcentaje_neg']."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
          </div> <br>";

    echo "<br>";

    ?>

    <h3 class="text-center"> Detalle de las calificaciones </h3>
    <hr>

    <div class="card text-center" style="width: 65rem;margin-left: auto; margin-right: auto">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link <?php echo $positivas?>" href="/usuario/<?php echo $vars[0];?>/positivas">Positivas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $neutras?>" href="/usuario/<?php echo "$vars[0]";?>/neutras">Neutras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $negativas?>" href="/usuario/<?php echo "$vars[0]";?>/negativas">Negativas</a>
          </li>
					<li class="nav-item">
						<a class="nav-link <?php echo $sistema?>" href="/usuario/<?php echo "$vars[0]";?>/sistema">De UnAventon</a>
					</li>
        </ul>
      </div>
      <div class="card-body">
        <div class="mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 500px; overflow: auto;">
					<?php
						if(mysqli_num_rows($c) == 0){

							?>
							<div class="alert alert-info mt-2 mb-4">
								<div class="card-body ">
									<h5 class="card-title">Parece que <?php echo $usuario['nombre'] . " " . $usuario['apellido'];?> no tiene calificaciones <?php echo (isset($vars[1])) ? $vars[1] : "positivas";?></h5>
									<small class="card-text">Su historial de calificaciones <?php echo (isset($vars[1])) ? $vars[1] : "positivas";?> se encontrará en esta sección.</small>
								</div>
							</div>

						<?php
					}
						else{
          while($calificacion = mysqli_fetch_array($c))
          {
						if($sistema != "active"){
	          ?>
	          <div class="card border-<?php echo $estilo;?> mb-3 w-100">
	            <div class="card-body text-<?php echo $estilo;?> text-left">
	              <h6 class="card-title text-dark"><?php echo $calificacion['nombre'] . " " . $calificacion['apellido'];?> Calificó a <?php echo $usuario['nombre'] . " " . $usuario['apellido'];?></h6>
	              <p class="card-text"><?php echo $calificacion['comentario'];?></p>
	              <small class="float-right" style="margin-top: -4.3rem; margin-bottom: 0rem"> <?php $date = date_create($calificacion['fecha']);
								echo $date->format('d-m-Y');?></small>
	            </div>
	          </div>
	          <?php
						}
						else {
							?>
							<div class="card border-<?php echo $estilo;?> mb-3 w-100">
								<div class="card-body text-<?php echo $estilo;?> text-left">
									<h6 class="card-title text-dark">UnAventon penalizó a <?php echo $usuario['nombre'] . " " . $usuario['apellido'];?> restandole <?php echo $calificacion['calificacion'];?></h6>
									<p class="card-text"><?php echo $calificacion['comentario'];?></p>
									<small class="float-right" style="margin-top: -4.3rem; margin-bottom: 0rem"> <?php $date = date_create($calificacion['fecha']);
									echo $date->format('d-m-Y');?></small>
								</div>
							</div>
							<?php
						}

          }// Fin while
				}// Fin else
          ?>

        </div>

      </div>
    </div>

    <br>
    <br>

  <?php

  }
