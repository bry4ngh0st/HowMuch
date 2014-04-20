@extends('layout')

@section('content')
	<?php
 		// Verificacion de sintaxis de la consulta
 		// formato :  [consulta entidad] en [ubicacion]
 		// ejemplo : [cuanto cuesta un kg de manzanas] en [lima, peru]
 	
		$s = $question; 
		$in = '';
	 	
	 	if (strpos($question, ' en ') !== false) {
	 		$data = explode(' en ', $question);
			$s = $data[0];
			$in = $data[1];
		}
 	?>
	 
	{{ Form::open(array('url' => 'search', 'class' => 'form', 'method' => 'get')) }}
		Resultados para
		{{ Form::text('s', $s, array('id' => 'search', "placeholder" => "buscar el precio de...", "autocomplete" => "off", "value" => "")) }}
		en
		{{ Form::text('in', $in, array('id' => 'location', "placeholder" => "ubicacion", "autocomplete" => "off")) }}
		
		{{ Form::hidden('ltt', isset($_GET['ltt']) ? $_GET['ltt'] : '', array('id' => 'latitud')) }}
		{{ Form::hidden('lgt', isset($_GET['lgt']) ? $_GET['lgt'] : '', array('id' => 'longitud')) }}
		
		{{ Form::submit('Buscar') }}
	{{ Form::close() }}
	
	<div class="container-results">	 	
		@for($i=0; $i<100; $i++)
 		<div class="result-template">
 			<ul>
 				<li>
 					<a href="#">+</a>
 					<a href="#">/</a>
 					<a href="#">-</a>
 				</li>
	 			<li class="result-amount">
	 				<a>USD</a>
	 				<a>240.00</a>
	 			</li>
	 			<li class="result-location">Lima, Peru</li>
	 			<li class="result-description">Description for a result.</li>
	 			<li class="result-tags">a, b, c, d</li>
	 			<li class="result-date">{{ date('Y-m-d'); }}</li>
	 		</ul>
		</div> 		
		@endfor
	</div>
	
	<div id="pickup">
		<div id="map-canvas"></div>
	</div>
		
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	
	<script>
	
	function initialize() {
	
	  var mapOptions = {
	    zoom: 13
	  };

	  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  
	  var input = (document.getElementById('location'));
	
	  /*var types = document.getElementById('type-selector');
	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);*/
	
	  var options = {
	    types: ['(cities)']
	  };
	
	  var autocomplete = new google.maps.places.Autocomplete(input, options);
	  autocomplete.bindTo('bounds', map);
	
	  var infowindow = new google.maps.InfoWindow();
	  var marker = new google.maps.Marker({
	    map: map,
	    anchorPoint: new google.maps.Point(0, -29)
	  });
	
	  google.maps.event.addListener(autocomplete, 'place_changed', function() {
	    infowindow.close();
	    marker.setVisible(false);
	    var place = autocomplete.getPlace();
	    if (!place.geometry) {
	      return;
	    }
	    
	    var latitude = place.geometry.location.lat();
		var longitude = place.geometry.location.lng();
		
		$('#latitud').val(latitude);
		$('#longitud').val(longitude);
	
	    // If the place has a geometry, then present it on a map.
	    if (place.geometry.viewport) {
	      map.fitBounds(place.geometry.viewport);
	    } else {
	      map.setCenter(place.geometry.location);
	      map.setZoom(17);  // Why 17? Because it looks good.
	    }
	    marker.setIcon(/** @type {google.maps.Icon} */({
	      url: place.icon,
	      size: new google.maps.Size(71, 71),
	      origin: new google.maps.Point(0, 0),
	      anchor: new google.maps.Point(17, 34),
	      scaledSize: new google.maps.Size(35, 35)
	    }));
	    marker.setPosition(place.geometry.location);
	    marker.setVisible(true);
	
	    var address = '';
	    if (place.address_components) {
	      address = [
	        (place.address_components[0] && place.address_components[0].short_name || ''),
	        (place.address_components[1] && place.address_components[1].short_name || ''),
	        (place.address_components[2] && place.address_components[2].short_name || '')
	      ].join(' ');
	    }
	
	    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
	    infowindow.open(map, marker);
	  });
	
	  // Sets a listener on a radio button to change the filter type on Places
	  // Autocomplete.
	  /*function setupClickListener(id, types) {
	    var radioButton = document.getElementById(id);
	    google.maps.event.addDomListener(radioButton, 'click', function() {
	      autocomplete.setTypes(types);
	    });
	  }
	
	  setupClickListener('changetype-all', []);
	  setupClickListener('changetype-establishment', ['establishment']);
	  setupClickListener('changetype-geocode', ['geocode']);*/
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
	</script>
@stop