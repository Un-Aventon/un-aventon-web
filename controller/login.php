<?php
	function render($vars = [])
	{
    function verificar_login($mail,$password,$result)
    {
      //parche
      $conexion=mysqli_connect("localhost","root","","base") or
    		die("Problemas con la conexión a la base de datos");

      $rec=mysqli_query($conexion,"SELECT * FROM Usuario WHERE email='$mail' AND clave='$password'")
      or
      die("Problemas en la base de datos:".mysqli_error($conexion));

      $count = 0;
      while($row = mysqli_fetch_array($rec))
      {
        $count++;
        $result = $row;
      }
      if($count == 1)
      {
        return $result;
      }
      else
      {
        return 0;
      }
    }


    function comprobar_string($string){
       if (strlen($string)<3 || strlen($string)>30){
          return false;
       }

       //compruebo que los caracteres sean los permitidos
       $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_@.";
       for ($i=0; $i<strlen($string); $i++){
          if (strpos($permitidos, substr($string,$i,1))===false){
             return false;
          }
       }
       return true;
    }


    $result = 67;
    if(isset($_POST['login'])){
      if( (comprobar_string($_POST['mail'])) & (comprobar_string($_POST['password'])) ){

            $result = verificar_login($_POST['mail'],$_POST['password'],$result);
            if($result != 0){
                $_SESSION['userId'] = $result['idUser'];
                $_SESSION['mail'] = $result['email'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['apellido'] = $result['apellido'];

                header("Location: /");

            } //fin verificar usuario existe
      }// fin verificar string
    }// fin verificar login


		?>
    <h3 style="text-align: center">Bienvenido de nuevo :)</h3>
    <hr>
    <form action="" method="post" class="login">
      <div class="form-group">
        <label for="email">Direccion Email</label>
        <input name="mail" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ingresa tu email">
      </div>
      <div class="form-group">
        <label for="contraseña">Contraseña</label>
        <input name="password" type="password" class="form-control" id="contraseña" placeholder="Ingresa tu contraseña">
      </div>
      <button name="login" type="submit" value="ingresar" class="btn btn-primary">Entrar</button>

    </form>
    <?php
      if ( ($result == 0)){
      echo "<hr />";
      echo "<div class='alert alert-warning' role='alert'>Algun dato esta mal, volve a intentarlo!</div>";
      }
    ?>
    <br><br>

    <?php
	}
