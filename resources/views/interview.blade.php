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
					@if($applicant->interview_slot_id == 0)
						<p class="card-text">Please select your interview timeslot. Once you 	have selected a time slot, you will not be able to change it. If none 	of these times work for you, please get in touch with <a href="	mailto:team@launchpadcs.org">team@launchpadcs.org</a></p>
						<div class="alert alert-success" id="success" style="display:none;"></div>
						<form id="slotForm">
							<div class="alert alert-danger" id="alert" style="display:none;"></div>
							{{ csrf_field() }}
							<input value="{{$applicant->hashid}}" name="id" type="hidden">
							<div class="form-group">
   							<label for="inputSlot">Select a slot</label>
							<select class="form-control" id="inputSlot" name="slot">
								<option disabled selected>Please select a slot</option>
								@foreach($slots as $interview)
									@if($interview->applicationsCount < 2)
									<option value="{{$interview->id}}">{{$interview->formattedStartTime}} - {{$interview->formattedEndTime}}</option>
									@endif
				    			@endforeach
				    		</select>
				    		</div>
				    		<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					@else
						Your selected time slot is {{$selected->formattedStartTime}} to {{$selected->formattedEndTime}}, in {{$selected->location}}. If you need to change your interview time, please email <a href="mailto:team@launchpadcs.org">team@launchpadcs.org</a>
					@endif
				</div>
			</div>
		</div>


	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#slotForm').submit(function(event) {
				event.preventDefault();
				$.ajax({
				    type: 'POST',
				    url: '{{action('PageController@submitInterviewSelectionForm')}}',
				    data: $(this).serialize(),
				    dataType: 'json',
				    success: function(data) {
				        if(data['message'] == 'success') {
				        	$("#alert").hide();
				            $("#slotForm").slideUp();
				            $("#success").html(data['content']);
				        	$("#success").show();
				        } else {
				        	$("#alert").html("Please select a valid interview slot.");
				        	$("#alert").show();
				        }
				    }
				});
			});
		});
	</script>
</body>
</html>