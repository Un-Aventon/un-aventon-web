<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>UnAventon</title>

    <!-- icon -->
    <link rel='shortcut icon' type='image/png' href='img/logo.png' />
    <!-- responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS de bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CSS Listado de vehiculos -->
    <link rel="stylesheet" type="text/css" href="/css/estilo-listado-vehiculos.css">
    <!-- CSS principal -->
    <link rel="stylesheet" href="/css/stylo.css">

    <!-- css parcheado -  arreglar... talvez -->
    <style media="screen">
      .boton_cambios{
        width: 40px;
        margin-top: 20px;
        transition: 1s;
      }

      .boton_cambios:hover{
        width: 45px;
      }

      .strike {
          display: block;
          text-align: center;
          overflow: hidden;
          white-space: nowrap;
      }

      .strike > span {
          position: relative;
          display: inline-block;
      }

      .strike > span:before,
      .strike > span:after {
          content: "";
          position: absolute;
          top: 50%;
          width: 9999px;
          height: 1px;
          background: grey;
      }

      .strike > span:before {
          right: 100%;
          margin-right: 15px;
      }

      .strike > span:after {
          left: 100%;
          margin-left: 15px;
      }

      .boton_crear{
          border-radius: 4px;
          transition: 0.5s
      }

      .boton_crear:hover{
          filter: brightness(120%);
      }
    </style>
  </head>
  <body>
    <?php
      include('php/navbar.php');
    ?>
    <div class="container" style="background-color:; border-radius: 5px">
