<?php 
	function render($vars = [])
	{
		session_destroy();
		echo "Se cerro la sesión";
		header('Location: /home');
	}