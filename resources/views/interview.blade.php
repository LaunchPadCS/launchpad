<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>LaunchPad</title>

	<!-- Styles -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
	</script>
</head>
<body>

		<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="        navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		<a class="navbar-brand" href="{{ action('PageController@index') }}">LaunchPad</a>
		</nav>
		<div class="container">
			<br/>
			<div class="card">
				<div class="card-header">
					Interview Slot Selection
				</div>
				<div class="card-block">
					<h4 class="card-title">Welcome back, {{$applicant->firstname}}!</h4>
					<p class="card-text">Please select your interview timeslot. Once you have selected a time slot, you will not be able to change it. If none of these times work for you, please get in touch with <a href="mailto:team@launchpadcs.org">team@launchpadcs.org</a></p>
					<form>
						<select>
						@foreach($slots as $interview)
						
								<option>{{$interview->formattedStartTime}} - {{$interview->formattedEndTime}}</option>
						
				    	@endforeach
				    	</select>
					</form>
					<a href="#" class="btn btn-primary">Submit</a>
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