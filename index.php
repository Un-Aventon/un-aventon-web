
<?php
	session_start();
	include ('core/router.php');
	include ('php/inicio_body.php');

	$router = new Router;
	// $file contiene el archivo que se incluira
	$file = $router->get_file();

	// $vars contiene el arreglo de variables obtenida de la url
	$vars = $router->get_variables();


	// si existe el archivo lo incluyo, traigo un error.
	file_exists('controller/'.$file.'.php')? include('controller/'.$file. '.php') : include('404.php');

	// se llama al render del archivo incluido
	render($vars);

	include ('php/cierre_body.php');
