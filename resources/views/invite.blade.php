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
					Applicant Account Creation
				</div>
				<div class="card-block">
					<h3>Congratulations {{$applicant->firstname}}! 🎉🎉</h3>
					<p>Welcome to the LaunchPad family. We're happy you're here.</p>
					<hr/>
					<p>Please create your user account below. Once you're signed up and logged in, add information about yourself, and upload a profile photo. You can then explore our community and view all the other mentors and mentees.</p>
					<div class="alert alert-success" id="success" style="display:none;"></div>
					<div class="alert alert-danger" id="alert" style="display:none;"></div>
					<form id="userForm">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="inputName">Name</label>
    						<input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="First and last name" name="name">
    						<small id="nameHelp" class="form-text text-muted">Enter the name you'd like to be called by (and your last name)</small>
  						</div>
  						<div class="form-group">
  							<label for="inputEmail">Email</label>
    						<input type="text" class="form-control" id="inputEmail" aria-describedby="emailHelp" name="email" placeholder="{{$applicant->lastname}}@gmail.com">
    						<small id="emailHelp" class="form-text text-muted">Enter your non-Purdue email address.</small>
    					</div>
  						<div class="form-group">
  							<label for="inputPassword">Password</label>
    						<input type="password" class="form-control" id="inputPassword" name="password">
    					</div>
    					<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>


	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#userForm').submit(function(event) {
				event.preventDefault();
				$.ajax({
				    type: 'POST',
				    url: '{{action('PageController@submitInviteForm')}}',
				    data: $(this).serialize(),
				    dataType: 'json',
				    success: function(data) {
				        if(data['message'] == 'success') {
				        	window.location.replace("{{action('PageController@dashboard')}}");
				        } else {
				        	var string = "";
							$.each(data, function(key, value){
		                        string += value + "<br/>";
		                    });
		                    $("#alert").html(string);
				        	$("#alert").show();
				        }
				    }
				});
			});
		});
	</script>
</body>
</html>