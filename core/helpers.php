<?php
function dias_transcurridos($fecha_alta)
{
 $fecha_alta = date_create($fecha_alta);
 $fecha_actual   = date_create(date("d.m.Y"));
 $diferencia     = date_diff($fecha_alta, $fecha_actual);
 $dif     = $diferencia->format('%a');

 if ($dif == 0){
   return 'hoy';
 }
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
   if (strlen($string)<3 || strlen($string)>30){
      return false;
   }

   //compruebo que los caracteres sean los permitidos
   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_@.";
   for ($i=0; $i<strlen($string); $i++){
      if (strpos($permitidos, substr($string,$i,1))===false){
         return false;
      }
   }
   return true;
}
