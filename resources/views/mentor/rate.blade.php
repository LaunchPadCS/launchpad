@extends('layouts.app')

@section('bottom_js')
<script>
var submitted = false;
@if(Auth::user()->enable_keyboard)
$(document).keyup(function(e) {
    var val;
    if(e.keyCode == 97 || e.keyCode == 49) { // 1 key
        val = 1;
    } else if(e.keyCode == 98 || e.keyCode == 50) { // 2 key
        val = 2;
    } else if(e.keyCode == 99 || e.keyCode == 51) { // 3 key
        val = 3;
    }
    if(val && !submitted) {
        submitRating(val);
    }
});
@endif
$('#rating-group button').click(function() {
    if(!submitted) {
        submitRating($(this).attr("value"));
    }
});
function submitRating(value) {
    $.ajax({
        type: 'POST',
        url: '{{action('MentorController@submitRating')}}',
        data: { "_token": "{{ csrf_token() }}", "rating": value, "app_id": '{{$data['id']}}'},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == "success") {
                $('<div class="modal-backdrop" style="background:#fff"></div>').appendTo(document.body).hide().fadeIn();
                submitted = true;
                window.location.href = data.redirect;
            }
        }
    });
}
@role('admin')
$('#timeslotForm').submit(function(event) {
    $.ajax({
        type: 'POST',
        url: '{{action('AdminController@submitTimeslot')}}',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                console.log('success');
                 $("#message").fadeIn().addClass("alert alert-success").html("Successfully assigned interview slot.");
            }
        }
    });
    event.preventDefault();
});

$('#decisionForm button').click(function() {
    var value = $(this).val();
    var button = $(this);
    $.ajax({
        type: 'POST',
        url: '{{action('AdminController@submitDecision')}}',
        data: { "_token": "{{ csrf_token() }}", "decision": value, "app_id": '{{$data['id']}}'},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == "success") {
                // Visual feedback that request was successful
                $("#reject").removeClass("active").html("Reject");
                $("#standby").removeClass("active").html("Standby");
                $("#accept").removeClass("active").html("Accept");
                $(button).append(' <i class="fa fa-check" aria-hidden="true"></i>').addClass("active");
            }
        }
    });
});
@endrole
</script>
@stop

@section('content')
<div class="col-7">
	@if($rating)
	    <div class="alert alert-info"><b>Heads up!</b> You've already rated this application a <b>{{$rating['rating']}}</b>.</div>
	@endif
	<div class="text-center">
	    <div class="btn-group" role="group" aria-label="rating" id="rating-group">
	        <button type="button" class="btn btn-{{$rating['rating'] == 1 ? '' : 'outline-' }}danger" value="1">1 <i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
	        <button type="button" class="btn btn-{{$rating['rating'] == 2 ? '' : 'outline-' }}primary" value="2">2 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
	        <button type="button" class="btn btn btn-{{$rating['rating'] == 3 ? '' : 'outline-' }}success" value="3">3 <i class="fa fa-heart-o" aria-hidden="true"></i></button>
	    </div>
	</div>
	<br/>
    <div class="card">
        <div class="card-header">Application</div>
        <div class="card-block">
        	<h2>{{$application->name}}
        		<small class="text-muted">({{$application->email}})</small>
			</h2>
			<hr/>
            @foreach($application->getResponsesAttribute() as $response)
            	<b>{{$response->text}}</b><br/>
            	{{$response->response}}
            	<hr/>
            @endforeach
        </div>
    </div>
</div>
<div class="col">
	<div class="card">
        <div class="card-header">Rating Guide</div>
        <div class="card-block">
			<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> - Does not display passion, interest. <i>(No)</i><br/>
			<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> - May be good for Ignite, need more info. <i>(Maybe)</i><br/>
			<i class="fa fa-heart-o" aria-hidden="true"></i> - Passionate student, a great fit for Ignite. <i>(Yes)</i>
			<br/><br/>
			Most students will fall in the <b>2 (<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>)</b> range, only a few applicants will be a <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> or <i class="fa fa-heart-o" aria-hidden="true"></i>.
			<hr/>
			You should be looking for passion and interest in the applications (as much as you can with text). Experience <b>should not</b> play a large role when rating.
        </div>
    </div>
</div>
@endsection
