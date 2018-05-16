<?php 
	function render($vars = [])
	{
		session_destroy();
		header('Location: /home');
	}