<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to [How Much]</title>
		<link href="{{ url('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
		<link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ url('/vendor/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet">
		<link href="{{ url('css/styles.css') }}" rel="stylesheet">
		<link href="{{ url('css/search.css') }}" rel="stylesheet">
		@yield('styles')
	</head>
	<body>
		<!-- <header></header> -->
		
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href={{ URL::to("/") }}>How Much</a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href={{ URL::to("/") }}>Home</a></li>
	            <li><a href={{ URL::to("/") }}>About</a></li>
	            <li><a href={{ URL::to("/") }}>Contact</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>		
				
		<div class="container">
			<div class="starter-template">				
				@yield('content')
		    </div>
		</div>
		
		<!--  <footer></footer> -->
		
		<script type="text/javascript">
	        var root = '{{url("/")}}';
	    </script>
	    
	    <script type="text/javascript" src='//code.jquery.com/jquery-1.10.2.min.js'></script>
	    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	    <script type="text/javascript" src='{{ url("/vendor/selectize/js/standalone/selectize.min.js") }}'></script>
	    <script type="text/javascript" src='{{ url("js/main.js") }}'></script>
	    @yield('scripts')
	</body>
</html>