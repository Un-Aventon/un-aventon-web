<?php

	include('core/router.php');

	$router = new Router;
	$file = $router->get_file();
	
	$vars = $router->get_variables();


	file_exists('test/'.$file.'.php')? include('test/'.$file. '.php') : include('test/home.php');


	render($vars);
