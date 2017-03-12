@extends('layouts.app')

@section('bottom_js')
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function() {
    $('#applicantForm').submit(function(event) {
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
                     $.growl.notice({title: "Success", message: "Successfully updated settings.", size: "large"});
                } else {
                    string = '';
                    $.each(data[0], function(key, value){
                        string += value + "<br/>";
                    });
                    $.each(data['errors'], function(key, value){
                        $("#group-"+value).addClass("has-danger");
                        $("#input-"+value).addClass("form-control-danger");
                    });
                    $.growl.error({title: "Oops!", message: string, duration: 5000, size: "large" });                       
                }
            }
        });
        event.preventDefault();
    });
});
</script>
@stop

@section('content')
<div class="col">
	<div class="card">
		<div class="card-header">Dashboard</div>
		<div class="card-block">
			<form id="applicantForm">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="inputName">Name</label>
					<input type="text" class="form-control" id="inputName" name="name">
				</div>
				<div class="form-group">
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
@endsection