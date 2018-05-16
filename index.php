<?php

	include('core/router.php');

	$router = new Router;
	$file = $router->get_file();
	
	$vars = $router->get_variables();


	file_exists('controller/'.$file.'.php')? include('controller/'.$file. '.php') : include('controller/home.php');



	render($vars);
