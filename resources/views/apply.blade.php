<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>LaunchPad</title>
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<style>
		body {
		  /* Margin bottom by footer height */
		  margin-top:50px;
		  margin-bottom: 60px;
		  background-color:#000;
		}
		#particlesjs {
  			background-color: #001333;
  			position:fixed;
  			top:0;
  			right:0;
  			bottom:0;
  			left:0;
  			z-index:0; 
		}
	</style>
</head>
<body>
<div id="particlesjs"></div>
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<h3 class="card-header">Apply to LaunchPad</h3>
				<div class="card-block">
					<div class="alert alert-danger" role="alert" id="danger" style="display:none;"></div>
					<div class="alert alert-success" role="alert" id="success" style="display:none;">
						<h4 class="alert-heading">Nice!</h4>
  						<p>Your application has been successfully submitted. We'll review it, and get back to you with more information soon!</p>
					</div>
					<form id="applicantForm">
						{{ csrf_field() }}
						<div class="form-group" id="inputNameGroup">
							<label for="inputName">First and Last Name</label>
							<input type="text" class="form-control" id="inputName" name="name">
						</div>
						<div class="form-group" id="inputEmailGroup">
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" id="inputEmail" name="email">
						</div>
						<hr/>
						@foreach($questions as $question)
							<div class="form-group" id="group-{{$question->id}}">
								<label for="input-{{$question->id}}">{{$question->text}}</label>
							@if($question->type == "string")
								<input type="text" name="{{$question->id}}" class="form-control" id="input-{{$question->id}}">
							@elseif($question->type == "text")
								<textarea name="{{$question->id}}" class="form-control" id="input-{{$question->id}}"></textarea>
							@endif
							</div>
						@endforeach
						<hr/>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{asset('js/particles.min.js')}}"></script>
    <script>
    	particlesJS.load('particlesjs', 'particlesjs-config.json', function() {
		});
		$(document).ready(function() {
		    $('#applicantForm').submit(function(event) {
		    	$("#inputName").removeClass('has-danger');
		    	$("#inputEmail").removeClass('has-danger');
		    	$("#inputNameGroup").removeClass('has-danger');
		    	$("#inputEmailGroup").removeClass('has-danger');
		    	@foreach($questions as $question)
		    		$("#group-{{$question->id}}").removeClass('has-danger');
		    		$("#input-{{$question->id}}").removeClass('has-danger');
		    	@endforeach
		        $.ajax({
		            type: 'POST',
		            url: '{{action('PageController@submitApplicationForm')}}',
		            data: $(this).serialize(),
		            dataType: 'json',
		            success: function(data) {
		                if(data['message'] == 'success') {
		                     $("#success").show();
		                     $("#applicantForm").slideUp();
		                } else {
		                    string = '';
		                    if(data[0].includes("name")) {
		                    	string += "Please fill in your complete name.<br/>";
		    					$("#inputNameGroup").addClass('has-danger');
		    					$("#inputName").addClass('form-control-danger');
		                    }
		                    if(data[0].includes("email")) {
		                    	string += "There was an issue with the provided email.<br/>";
		    					$("#inputEmailGroup").addClass('has-danger');
		    					$("#inputEmail").addClass('form-control-danger');
		                    }
		                    if(data['errors']) {
		                    	string += 'Please fill in all the application questions.';
		                    }
		                    $.each(data['errors'], function(key, value){
		                        $("#group-"+value).addClass("has-danger");
		                        $("#input-"+value).addClass("form-control-danger");
		                    });
		                    $("#danger").html(string).show();                    
		                }
		            }
		        });
		        event.preventDefault();
		    });
		});		
	</script>
</body>
</html>