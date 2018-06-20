<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container" style="background-color:rgba(0, 0, 0, 0.0); margin-top: -3px; padding: 0 0; box-shadow: 0 0 0 #fff">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <ul class="nav navbar-nav navbar-logo mx-auto">
      <li class="nav-item">
        <img src="/img/logo.png" alt="logo" style="width: 40px; margin-right: 8px">
        <a class="navbar-brand" href="/">UnAventon</a>
      </li>
    </ul>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>

      <?php
        if ($file!='home'){
          ?>
          <ul class='navbar-nav float-right'>
            <li class="nav-item active">
            <a class="nav-link" href="/">Inicio <span class="sr-only">(current)</span></a>
          </li>
          </ul>
          <?php
        }
      if(isset($_SESSION['nombre'])){
        ?>
        <ul class='navbar-nav float-right'>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/perfil">Mi perfil</a>
                  <a class="dropdown-item" href="/logout">Cerrar sesion</a>
                </div>
            </li>
        </ul>
        <?php
      }
      else {
        echo "<ul class='navbar-nav float-right'>
                <li class='nav-item float-right'>
                  <a class='nav-link' href='/login'>Login</a>
                </li>
                  <a class='nav-link' href='/registro'>Registro</a>
              </ul>";
      }
      ?>
  </div>
</div>
</nav>
