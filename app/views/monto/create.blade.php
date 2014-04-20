@extends('layout')

@section('content')

<h4>Nuevo registro</h4>
@if ( $errors->count() > 0 )
	<p>The following errors have occurred:</p>

	<ul>
		@foreach( $errors->all() as $message )
        	<li>{{ $message }}</li>
		@endforeach
    </ul>
@endif

<div class="form-container">

	{{ Form::open(array('url' => 'monto', 'class' => 'form', 'id' => 'ghost_form')) }}

	<!-- Entidad -->
	<div class="form-group" style="width: 300px;">
		<label>Que?</label>
		{{ Form::select('q', array(), null, array('id' => 'searchbox_entidades', 'placeholder' => 'Buscar...', 'class' => 'form-control')) }}		
		<!-- <select id="searchbox_entidades" name="q" placeholder="Buscar..." class="form-control"></select> -->
	</div>

	<!-- Descripcion -->
	<div class="form-group">
		<label>Descripcion</label>
		{{ Form::text('observacion') }}
	</div>

	<!-- Ubicacion -->
	<div class="form-group">
		<label>Donde?</label>
		
		<div id="pickup">
			{{ Form::text('ubicacion', '', array('id' => 'ubicacion', "placeholder" => "Ingresa la ubicacion")) }}
			
			<div id="map-canvas"></div>
		</div>
	    
	    <div class="clearfix">
	    	{{ Form::hidden('latitud', '', array('id' => 'latitud')) }}
	    	{{ Form::hidden('longitud', '', array('id' => 'longitud')) }}
	    </div>

		{{ $errors->first('ubicacion'); }}
	</div>

	<!-- Valor -->
	<div class="form-group">
		<label>Cuanto</label>
		{{ Form::text('monto', '', array('placeholder' => 'Ingresa el monto')) }} <br />
		{{ Form::select('moneda', array('USD' => 'Dolares', 'PEN' => 'Soles')) }}
		{{ $errors->first('monto'); }}	
	</div>
	
	{{ Form::submit('Guardar') }}
	{{ Form::close() }}

</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

<script>

function initialize() {

  var mapOptions = {
    zoom: 13
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  var input = (document.getElementById('ubicacion'));

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