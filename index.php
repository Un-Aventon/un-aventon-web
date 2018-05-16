<?php

	include('core/router.php');

	$router = new Router;
	$file = $router->get_file();
	
	$vars = $router->get_variables();


	// si existe el archivo lo incluyo, traigo un erro.
	file_exists('controller/'.$file.'.php')? include('controller/'.$file. '.php') : include('404.php');


	render($vars);
