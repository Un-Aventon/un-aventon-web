<?php

/**
 * 
 */
class Router
{
      var $file;
      var $variables;

	function __construct()
	{
            $url = $_SERVER['REQUEST_URI'];
            $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
            $repl = array('a', 'e', 'i', 'o', 'u', 'n');
            $url = str_replace ($find, $repl, $url);
       
            $url = explode('/', $url);

            $url['1']? $this->file = $url['1'] : $this->file ='home';
            
            //Si es el admin, solo puede ver los pagos realizados
            if(isset($_SESSION['admin']) and $_SESSION['admin'] == 1 and $this->get_file() != 'logout')
            {
                  $this->file = 'pagos_admin';
            }

            $this->variables = array_slice($url, 2);
      }


      function get_file()
      {
            return $this->file;
      }

      function get_variables()
      {
            return $this->variables;
      }

}
 