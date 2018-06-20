<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>UnAventon</title>

    <!-- icon -->
    <link rel='shortcut icon' type='/image/png' href='img/logo.png' />
    <!-- responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS de bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CSS de Malihu -->
    <link rel="stylesheet" href="/js/Malihu/jquery.mCustomScrollbar.css" />
    <!-- CSS Listado de vehiculos -->
    <link rel="stylesheet" type="text/css" href="/css/estilo-listado-vehiculos.css">
    <!-- CSS principal -->
    <link rel="stylesheet" href="/css/stylo.css">

    <!-- css parcheado -  arreglar... talvez -->
    <style media="screen">
      body{
        background-color: #fff;
        background: linear-gradient(-90deg, #76ddff, #d8f5ff);
      }
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

      .postulacion{
          width: 100%;
          background-color: #fafafa;
          border-radius: 4px;
          padding: 4px 4px;
          margin-bottom: 3px;
          margin-top: 3px;
          min-height: 37px;
      }
    </style>
  </head>
  <body>
    <?php
      include('php/navbar.php');
    ?>
    <div class="container" style="border-radius: 5px; box-shadow: 0 0 0 #fff; margin-top: 10px">
