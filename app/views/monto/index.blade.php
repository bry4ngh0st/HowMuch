@extends('layout')

@section('content')
	
	<div class="container-title">
		<h3>"Si tiene <b>valor</b> para ti, tiene un <b>precio,</b> </br> 
		<b>encuentralo</b> aqui."</h3>
	</div>
	
	<div class="full-search-bar">
		<ul class="item-stream unstyled search-input-stream">
			<li class="stream-item stream-header search-input-item">						
				{{ Form::open(array('url' => 'search', 'class' => 'form', 'id' => 'ghost_form', 'method' => 'get')) }}								
					{{ Form::text('s', '', array('id' => 'search', "placeholder" => "buscar el precio de...", "autocomplete" => "off", "value" => "")) }}
					{{ Form::text('in', '', array('id' => 'location', "placeholder" => "en...")) }}
					
					{{ Form::hidden('ltt', '', array('id' => 'latitud')) }}
    				{{ Form::hidden('lgt', '', array('id' => 'longitud')) }}
					<button class="btn btn-large btn-inverse" type="submit">
						<i class="icon-search icon-white"></i>
					</button>
				{{ Form::close() }}
			</li>
		</ul>
		<div class="search-status">
			<img src={{ url('img/circle_loader.gif') }} class="search-loader" />
		</div>
	</div>
	
	<div id="pickup">
		<div id="map-canvas"></div>
	</div>
	
	<div class="image-list">
		<a><img src={{ url('img/general/professionals.png') }} /></a>
		<a><img src={{ url('img/general/travels.jpg') }} /></a>
		<a><img src={{ url('img/general/foods.jpg') }} /></a>
		<a><img src={{ url('img/general/rare.jpg') }} /></a>
	</div>
	<div class="sign">
		<span>How Much is powered by Innova. Sign in or try it for <a>free</a>.</span>
		<a href={{ url('/') }} class="btn btn-primary" data-method="post" >Sign in</a>
	</div>
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	
	<script>
	
	function initialize() {
	
	  var mapOptions = {
	    zoom: 13
	  };
	
	  var map = new google.maps.Map(document.getElementById('map-canvas'),
	    mapOptions);
	
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