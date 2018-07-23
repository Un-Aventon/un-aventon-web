<?php

	function render($vars = [])
	{
    // incluyo la conexion.
    include('php/conexion.php');

    if($vars[1] == "positivas")
    {
      $positivas = "active";
      $neutras = "";
      $negativas = "";
      $estilo = "success";
      $sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

          . "FROM calificacion\n"

          . "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

          . "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = 1";
    }
    else
    {
      if($vars[1] == "neutras")
      {
        $positivas = "";
        $neutras = "active";
        $negativas = "";
        $estilo = "warning";
        $sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

            . "FROM calificacion\n"

            . "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

            . "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = 0";
      }
      else
      {
        $positivas = "";
        $neutras = "";
        $negativas = "active";
        $estilo = "danger";
        $sql = "SELECT calificacion.fecha, calificacion.comentario, usuario.nombre, usuario.apellido \n"

            . "FROM calificacion\n"

            . "INNER JOIN usuario ON usuario.idUser = calificacion.idCalificador\n"

            . "WHERE calificacion.idCalificado = $vars[0] AND calificacion.calificacion = -1";           
      }
    }

    $c = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

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
        </ul>
      </div>
      <div class="card-body">
        <div class="mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 500px; overflow: auto;">

          <?php
          //var_dump($c);
          echo "Todavia no muestra contenido xD";
          while($calificacion = mysqli_fetch_array($c))
          {
          ?>
          <div class="card border-<?php echo $estilo;?> mb-3 w-100">
            <div class="card-body text-<?php echo $estilo;?> text-left">
              <h6 class="card-title text-dark"><?php echo $calificacion['nombre'] . " " . $calificacion['apellido'];?> Calificó positivo a <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido'];?></h6>
              <p class="card-text"><?php echo $calificacion['comentario'];?></p>
              <small class="float-right" style="margin-top: -4.3rem; margin-bottom: 0rem"> 9/10/2018</small>
            </div>
          </div>
          <?php
          }
          ?>

        </div>

      </div>
    </div>

    <br>
    <br>

  <?php 

  }
