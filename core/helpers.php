<?php
function dias_transcurridos($fecha_alta, $string)
{
 $fecha_alta = date_create($fecha_alta);
 $fecha_actual   = date_create(date("d.m.Y"));
 $diferencia     = date_diff($fecha_alta, $fecha_actual);
 $dif     = $diferencia->format('%a');

// si se publico o parte hoy
 if ($dif == 0){
   return 'hoy';
 }

// si se pide la partida
else if ($string == "partida"){
  if ($dif == 1){
    return 'mañana';
  }
  else{
    return $dif." dias restantes";
  }
}

// si se pide la publicacion
 else if ($dif == 1){
   return 'ayer';
 }
 else {
   return 'hace '.$dif." dias";
 }
}

function calc_edad($fecha) {
    $tiempo = strtotime($fecha);
    $ahora = time();
    $edad = ($ahora-$tiempo)/(60*60*24*365.25);
    $edad = floor($edad);
    return $edad;
}

function comprobar_string($string){
	$expresion = '/^[a-zA-Z0-9@-_. ]{3,50}/';

	return(preg_match($expresion, $string));
}
