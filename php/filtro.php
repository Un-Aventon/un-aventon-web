<?php

function viajes_query(){

	$query = "SELECT *, tipo_vehiculo.tipo as tipoVehiculo
											from viaje
											inner join usuario on viaje.idPiloto = usuario.idUser
											inner join vehiculo on viaje.idVehiculo = vehiculo.idVehiculo
											inner join tipo_vehiculo on vehiculo.tipo = tipo_vehiculo.idTipo
											where fecha_partida > now() and estado = 1";
	if(isset($_POST['origen']) and comprobar_string($_POST['origen']))
	{
		$query .= " AND origen LIKE '%$_POST[origen]%' ";

		if(isset($_POST['destino']) and comprobar_string($_POST['destino']))
		{
			$query .= " AND destino LIKE '%$_POST[destino]%' ";
		}
		if(isset($_POST['fecha_partida']) and !empty($_POST['fecha_partida']))
		{
			$query .= " AND fecha_partida >= '$_POST[fecha_partida]' ";
		}

	}
	
	$query .= " order by fecha_partida ";
	return $query;

}