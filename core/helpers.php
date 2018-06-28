<?php

date_default_timezone_set("America/Buenos_Aires");

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

function calificacion($idUser){
  // incluyo la conexion.
  include('php/conexion.php');
  $calificaciones=mysqli_query($conexion,"SELECT SUM(calificacion) as calificacion_final
                                          from calificacion
                                          where idCalificado='$idUser'")
                                          or die ("error calculo calificacion");
  return(mysqli_fetch_array($calificaciones)['calificacion_final']+0);
}

function calificacion_grafica_simple($idUser){
  // incluyo la conexion.
  include('php/conexion.php');
  $calificaciones_totales=mysqli_query($conexion,"SELECT count(*) as contador
                                                    from calificacion
                                                    where idCalificado='$idUser'")
                                                    or die ("problemas en el contador de calificaciones totales");
  $calificaciones_totales=mysqli_fetch_array($calificaciones_totales)['contador'];

  $calificaciones_positivas=mysqli_query($conexion,"SELECT count(*) as contador
                                                    from calificacion
                                                    where idCalificado='$idUser' and calificacion > 0")
                                                    or die ("problemas en el contador de calificaciones positivas");
  $calificaciones_positivas=mysqli_fetch_array($calificaciones_positivas)['contador'];

  $calificaciones_neutras=mysqli_query($conexion,"SELECT count(*) as contador
                                                    from calificacion
                                                    where idCalificado='$idUser' and calificacion = 0")
                                                    or die ("problemas en el contador de calificaciones neutras");
  $calificaciones_neutras=mysqli_fetch_array($calificaciones_neutras)['contador'];

  $calificaciones_negativas=mysqli_query($conexion,"SELECT count(*) as contador
                                                    from calificacion
                                                    where idCalificado='$idUser' and calificacion < 0")
                                                    or die ("problemas en el contador de calificaciones negativas");
  $calificaciones_negativas=mysqli_fetch_array($calificaciones_negativas)['contador'];

  if ($calificaciones_positivas > 0) {
    $porcentaje_pos=round(($calificaciones_positivas/$calificaciones_totales)*100);
  }
  else {
    $porcentaje_pos=0;
  }

  if ($calificaciones_neutras > 0) {
    $porcentaje_neu=round(($calificaciones_neutras/$calificaciones_totales)*100);
  }
  else {
    $porcentaje_neu=0;
  }

  if ($calificaciones_negativas > 0) {
    $porcentaje_neg=round(($calificaciones_negativas/$calificaciones_totales)*100);
  }
  else {
    $porcentaje_neg=0;
  }


  $calificacion_ple = array(
    "contador_total" => $calificaciones_totales,
    "positivas" => $calificaciones_positivas,
    "neutras" => $calificaciones_neutras,
    "negativas" => $calificaciones_negativas,
    "porcentaje_pos" => $porcentaje_pos,
    "porcentaje_neu" => $porcentaje_neu,
    "porcentaje_neg" => $porcentaje_neg,
  );
  return $calificacion_ple;
}

function introtext($text) {
  if (strlen($text) > 18) {
      $pos = strpos($text, ' ', "18");
      if ((!$pos) || ($pos > 18)) {
         $pos = 18;
      }
      $text = substr($text, 0, $pos + 1) . " ...";
      return $text;

  }else{
    return $text;
  }
}


function es_fecha_valida($conexion, $id_vehiculo, $fecha_partida, $tiempo_estimado, $id_piloto = NULL, $id_viaje = NULL)
{

  $vehiculo = mysqli_query($conexion, "
    SELECT *
    from vehiculo v, viaje v2
    where v.idVehiculo = '$id_vehiculo'
    and v.idVehiculo = v2.idVehiculo
    and v2.idViaje != '$id_viaje'
    and(
      ('$fecha_partida' BETWEEN v2.fecha_partida AND DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR))
        or (DATE_ADD('$fecha_partida', INTERVAL $tiempo_estimado HOUR) BETWEEN v2.fecha_partida AND DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR))
        or (v2.fecha_partida BETWEEN 'fecha_partida' AND DATE_ADD('fecha_partida', INTERVAL v2.tiempo_estimado HOUR))
        or (DATE_ADD(v2.fecha_partida, INTERVAL v2.tiempo_estimado HOUR) BETWEEN 'fecha_partida' AND DATE_ADD('fecha_partida', INTERVAL v2.tiempo_estimado HOUR))
    )
  ") or die (mysqli_error($conexion));

  $piloto = mysqli_query($conexion, "
    SELECT * 
      from viaje v, participacion p
      where 
      p.idUsuario = '$id_piloto'
      and v.idViaje = p.idViaje
      or v.idPiloto = '$id_piloto'
      and v.idViaje != '$id_viaje'
      and(
        ('$fecha_partida' BETWEEN v.fecha_partida AND DATE_ADD(v.fecha_partida, INTERVAL v.tiempo_estimado HOUR))
          or (DATE_ADD('$fecha_partida', INTERVAL 12 HOUR) BETWEEN v.fecha_partida AND DATE_ADD(v.fecha_partida, INTERVAL v.tiempo_estimado HOUR))
          or (v.fecha_partida BETWEEN '$fecha_partida' AND DATE_ADD('$fecha_partida', INTERVAL v.tiempo_estimado HOUR))
          or (DATE_ADD(v.fecha_partida, INTERVAL v.tiempo_estimado HOUR) BETWEEN '$fecha_partida' AND DATE_ADD('$fecha_partida', INTERVAL v.tiempo_estimado HOUR))
      )
      ") or die(mysqli_error($conexion));

  if($v = mysqli_fetch_array($vehiculo))
  {

    return 1;
  }

  if($p = mysqli_fetch_array($piloto))
  {

    return 2;
  }

    return 0;
}

function sum_days($fecha, $cant_dias)
{
      $fecha_a = $fecha;
      $nuevafecha = strtotime ( $cant_dias.' day' , strtotime ( $fecha_a ) ) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      return $nuevafecha;
}

function date_toString($fecha,$opc){
  $dias = array("...","lunes","martes","miercoles","jueves","viernes","sábado","domingo");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $date = date_create($fecha);
  $string = $dias[date_format($date, 'N')]." ".date_format($date, 'd')." de ".$meses[date_format($date, 'm')-1] ;
  if ($opc =="y"){
    $string .= " ".date_format($date, 'Y');
  }
  if ($opc =="br"){
    $string .= "<br>";
  }
  else{
    $string .= " - ";
  }
  $string .= date_format($date, 'G:ia');

  return $string;
}
