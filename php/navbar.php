<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container" style="background-color:rgba(0, 0, 0, 0.0); margin-top: -3px; padding: 0 0; box-shadow: 0 0 0 #fff">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <ul class="nav navbar-nav navbar-logo mx-auto">
      <li class="nav-item">
        <img src="/img/logo.png" alt="logo" style="width: 60px; margin-right: 8px; margin-top: -10px; margin-bottom: -10px">
        <a class="navbar-brand" href="/" style="margin-top: 0px; margin-bottom: -40px;">UnAventon</a>
      </li>
    </ul>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>

      <?php
      if(isset($_SESSION['nombre'])){
        ?>
        <ul class='navbar-nav float-right'>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php 
                  if($_SESSION['admin'] != 1)
                  {
                    echo '<a class="dropdown-item" href="/perfil">Mi perfil</a>';
                  } 
                ?>
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
<div class="container-fluid" style="height:0px; background-color: #f17376">
</div>
