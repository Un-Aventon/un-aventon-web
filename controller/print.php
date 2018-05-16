<?php

		function render($text = [])
		{

			echo "<br/>-- -- -- test -- -- -- -- <br/>";
			if(isset($text['0'])){
				foreach ($text as $key => $value) {
					echo $value.', ';
				}
			}else{
				echo "Falta Variable";
			}
		}
