<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <img src="img/logo.png" alt="logo" style="width: 40px; margin-right: 8px">
  <a class="navbar-brand" href="#">UnAventon</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Inicio <span class="sr-only">(current)</span></a>
      </li>
    </ul>

      <?php
      if(isset($_SESSION['nombre'])){
        echo "<ul class='navbar-nav float-right'>
                <li class='nav-item'>
                    <a class='nav-link' href='/logout'>cerrar sesion</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='/perfil'>".$_SESSION['nombre']." ".$_SESSION['apellido']."</a>
                </li>
              </ul>";
      }
      else {
        echo "<ul class='navbar-nav float-right'>
                <li class='nav-item float-right'>
                  <a class='nav-link' href='/login'>Login</a>
                </li>
              </ul>";
      }
      ?>



    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="A donde queres ir ?" aria-label="Search">
      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  -->
  </div>
</nav>
