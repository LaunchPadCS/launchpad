<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ env('APP_NAME') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<style>
	.container {
		margin-top: 40px;
	}
     .dropdown-menu-right {
            right: 0;
            left: auto !important;
          }	
	</style>

	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
	</script>
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		<a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			@if (Auth::guest())
				<ul class="navbar-nav mr-auto">
					<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
		   		</ul>
		   	@else
		   		<ul class="navbar-nav mr-auto">
		   			<li class="nav-item"><a class="nav-link" href="{{ action('PageController@dashboard') }}">Dashboard</a></li>
		   			@if(env('APP_PHASE') == 1)
		   				@role('mentor')
		   					<li class="nav-item"><a class="nav-link" href="{{ action('MentorController@showRate') }}">Rate</a></li>
		   					<li class="nav-item"><a class="nav-link" href="{{ action('MentorController@showApplications') }}">Applications</a></li>
		   					<li class="nav-item"><a class="nav-link" href="{{ action('MentorController@showInterviewSchedule') }}">Interview Schedule</a></li>
		   				@endrole
		   				<li class="nav-item"><a class="nav-link" href="{{ action('PageController@showCommunity') }}">Community</a></li>
		   			@endif
		   			@role('admin')
		   				@include('layouts.admin_nav')
		   			@endrole
		   		</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Auth::user()->name }}
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="{{ action('PageController@showSettings') }}"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
							<a class="dropdown-item" href="{{ action('PageController@showSettingsPicture') }}"><i class="fa fa-camera" aria-hidden="true"></i> Profile Photo</a>						
							<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
									<i class="fa fa-sign-out" aria-hidden="true"></i> Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
						</div>
					</li>
				@endif
			</ul>
		  </div>
		</nav>
		<div class="container" id="container">
			<div class="row">
				@yield('content')
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="{{ asset('js/tether.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	@yield('bottom_js')
</body>
</html>
