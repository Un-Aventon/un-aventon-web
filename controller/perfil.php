<?php
function render($vars = [])
{
  //parche
  $conexion=mysqli_connect("localhost","root","","base") or
    die("Problemas con la conexión a la base de datos");
  $usuario=mysqli_query($conexion,"SELECT *
                                   FROM Usuario
                                   WHERE email='$_SESSION[mail]' limit 1")
                                   or
                                   die("Problemas en la base de datos:".mysqli_error($conexion));
  $user = mysqli_fetch_array($usuario);

  $contador=mysqli_query($conexion,"SELECT count(*) as cont
                                    FROM viaje
                                    where estado='activo' and idPiloto='$user[idUser]'")
                                    or
                                    die ("problemas con el contador");
  $contador=mysqli_fetch_array($contador);
  ?>
  <br>
  <div class="jumbotron">
    <h1 class="display-4"><?php echo $user['nombre']; ?></h1>
    <p class="lead">Tenes <?php echo $contador['cont']; ?> viajes</p>
      <hr class="my-4">
    <p>Podes publicar un viaje para reducir costos y conocer gente</p>
    <p class="lead">
      <a class="btn btn-primary btn-lg" href="#" role="button">Publicar un viaje</a>
    </p>
  </div>

  <?php
}
