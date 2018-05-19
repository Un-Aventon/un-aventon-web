<?php
function dias_transcurridos($fecha_alta)
{
 $fecha_alta = date_create($fecha_alta);
 $fecha_actual   = date_create(date("d.m.Y"));
 $diferencia     = date_diff($fecha_alta, $fecha_actual);

 switch ($diferencia->format('%a')) {
   case 0:
    return 'hoy';
    break;
   case 1:
    return 'ayer';
    break;
   default:
    return 'hace '.$diferencia->format('%a').'dias';
     break;
 }
}
