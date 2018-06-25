
function estimated_time()
{
	let loc_or = document.getElementById('localidad_origen').value;
	let prov_or = document.getElementById('prov_origen').value;
	let loc_dest = document.getElementById('localidad_destino').value;
	let prov_dest = document.getElementById('prov_destino').value;

	let service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix(
	  {
	    origins: [loc_or, prov_or],
	    destinations: [loc_dest, prov_dest],
	    travelMode: 'DRIVING',
	  }, function(a,b){
	  	console.log(a);
	  	console.log(b);
	  	if(b == 'OK')
	  	{
	  		if(a['rows']['1']['elements']['0']['status'] == 'NOT_FOUND')
	  		{
	  			return false;
	  		}
	  		let estimado = a['rows']['0']['elements']['0']['duration']['text'];
	  		document.getElementById('tiempo_estimado').placeholder = 'Tiempo estimado de viaje: ' + estimado;
	  	}
	  });
}

function is_valid_location(loc,prov)
{
		let localidad = document.getElementById(loc).value;
		let provincia = document.getElementById(prov).value;
		return(
			fetch('https://maps.googleapis.com/maps/api/geocode/json?address='+localidad+','+provincia+',+AR&key=AIzaSyBCmsUIxdjkHChho9s5V1T7Xl4axSmR3-w',{method: 'GET'})
				.then(function(response) {
				//console.log(response);
				response.json().then(function(data){
					//console.log(data);
					if(data['status'] == 'OK'){
						if(data['results']['0']['types']['0'] == 'locality')
						{
							document.getElementById(loc).setCustomValidity('');
							estimated_time();
							return true;
						}
					}
					document.getElementById(loc).setCustomValidity('Localidad no encontrada :(');
					console.log(document.getElementById(loc).checkValidity());
					return false
				})
			})
		);
}

function mod_asientos()
{
	var id_v = document.getElementById('vehiculo').value;
	document.getElementById('asientos').max = --aux[id_v];
	console.log('id -> ' + id_v);
	console.log('asientos -> ' + aux[id_v]);
}

function swtich(id)
{
	let elem = document.getElementById(id);
	let intervalo = document.getElementById('intervalo_rep');
	let repeticiones = document.getElementById('cant_intervalos');

	if(elem.hidden)
	{
		elem.hidden = false;
		intervalo.value = 1;
		intervalo.required = "true";
		repeticiones.value = 0;
		repeticiones.required = "true";
		return 0
	}
	elem.hidden = true;
	intervalo.required = "";
	intervalo.value = "";
	repeticiones.value = "";
	repeticiones.required = "";
	return 1
}