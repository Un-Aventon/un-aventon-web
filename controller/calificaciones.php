<?php
function render($vars = []){

// FALTA INCLUIR TODA LA LOGICA. SOLO ES VISTA

include('php/conexion.php');
?>

<div class="row">
    <div class="col-md-3" style="text-align: center">
      <img src="img/user.png" alt="imagen de usuario" style="width: 150px; margin-top: 15px">
    </div>
    <div class="col-md-8" style="margin-top: 1.5rem">
      <h1 class="display-6" style="font-family: helvetica;">Mis calificaciones pendientes</h1>
      <p> En esta sección se encuentran tus calificaciones pendientes como piloto y como copiloto. </p>
      <p> ES CONTENIDO ESTATICO. FALTA LA LOGICA </p>
    </div>
</div>
 <hr>
 <div class="row">
   <div class="col col-md-6">
     <h5 class="px-2">Calificaciones como piloto</h5>
   </div>
   <div class="col col-md-6">
     <h5 class="px-2">Calificaciones como copiloto</h5>
   </div>
</div>

<div class="row">
  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">
    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50">Viaje a nequen,Neuquén a el bolson,Río Negro</h5>
        <div class="card-body">
          <h5 class="card-title">Tus copilotos en este viaje</h5>
          <ul class="list-group list-group-flush py-1">
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Mario casas
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Mariano Martinelli
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Paula Galindez
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Carolina Oliveti
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-info">Calificar a todos</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->


    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50">Viaje a nequen,Neuquén a el bolson,Río Negro</h5>
        <div class="card-body">
          <h5 class="card-title">Tus copilotos en este viaje</h5>
          <ul class="list-group list-group-flush py-1">
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Alberto Benitez
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  José Perez
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Alejandro lopez
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col col-md-6">
                  Claudio almanza
                </div>
                <div class="col col-md-6 text-right pr-1">
                  <button type="button" class="btn btn-outline-danger">Calificar</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-info">Calificar a todos</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->
  </div>


  <div class="col col-md-6 mCustomScrollbar" data-mcs-theme="dark-3" style="max-height: 520px; overflow: auto;">


    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50">chascomus,Buenos Aires a la plata,Buenos Aires</h5>
        <div class="card-body px-0 py-0">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Piloto</th>
                <td>Mark Weiss</td>
              </tr>
              <tr>
                <th scope="row">Fecha del viaje</th>
                <td>10/08/2018</td>
              </tr>
            </tbody>
          </table>

        </div>
        <div class="card-footer text-right py-2">
          <a href="#" class="btn btn-success">Calificar al piloto</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->

    <div class="row px-3 my-4"> <!-- Comienzo de este viaje-->
      <div class="card" style="width: 30rem;">
        <h5 class="card-header h-50">la plata,Buenos Aires a buenos aires,Buenos Aires</h5>
        <div class="card-body px-0 py-0">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Piloto</th>
                <td>Pepito flores</td>
              </tr>
              <tr>
                <th scope="row">Fecha del viaje</th>
                <td>06/07/2018</td>
              </tr>
            </tbody>
          </table>

        </div>
        <div class="card-footer text-right py-2">
          <a href="#" class="btn btn-success">Calificar al piloto</a>
        </div>
      </div>
    </div><!-- Fin de este viaje -->



  </div>

</div>

<?php
}
