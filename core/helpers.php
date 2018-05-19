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
