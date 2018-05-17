<?php
	// seteo coonexion con la bd
	$conexion=mysqli_connect("localhost","root","","base") or
		die("Problemas con la conexión a la base de datos");

	session_start();

	$DB = array(
  				'host' => 'localhost',
  				'user' => 'root',
  				'pass' => '',
 				'name' => 'base',
			);
