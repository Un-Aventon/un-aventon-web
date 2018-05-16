<?php 
	function render($vars = [])
	{
		session_destroy();
		echo "Se rompio todo";
	}