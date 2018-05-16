<?php 
	function render($vars = [])
	{
		session_start();
		session_destroy();
		echo "Se rompio todo";
	}