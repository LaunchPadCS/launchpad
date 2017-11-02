@extends('layouts.app')

@section('bottom_js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<style>
.CodeMirror, .CodeMirror-scroll {
	min-height: 150px;
}
</style>
<script>
@for($i = 0; $i < count($applicants); $i++)
var editor{{$i}} = new SimpleMDE({ element: $("#editor{{$i}}")[0], spellChecker: false });
var timeoutId{{$i}};
editor{{$i}}.codemirror.on('change', function() {
    clearTimeout(timeoutId{{$i}});
    data = editor{{$i}}.value();
    timeoutId{{$i}} = setTimeout(function() {
        saveToDB({{$applicants[$i]['id']}}, data);
    }, 1000);
});
@endfor
function saveToDB(applicant_id, data) {
    $.ajax({
        type: 'POST',
        url: '{{action('MentorController@updateInterview')}}',
        data: { "_token": "{{ csrf_token() }}", "applicant_id": applicant_id, "notes":  data},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                 $("#save_text").html('Saved at ' + data['updated_at']);
            }
        }
    });
}
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(".ratingBtn").click(function(event){
	var btn = $(this);
    $.ajax({
        type: 'POST',
        url: '{{action('MentorController@updateInterviewRating')}}',
        data: { "_token": "{{ csrf_token() }}", "applicant_id": $(this).data('id'), "rating":  $(this).text()},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
            	$('.app-' + btn.data('id')).removeClass('active btn-primary').addClass('btn-secondary');
            	btn.removeClass('btn-secondary').addClass('active btn-primary');
            	btn.blur();
            }
        }
    });
	event.preventDefault();
});
</script>
@stop

@section('content')
<div class="col-7">
@for($i = 0; $i < count($applicants); $i++)
	<h4>{{$applicants[$i]['name']}} <small><a href="{{action('MentorController@showRate', ['id' => $applicants[$i]['id']])}}">(Application)</a></small></h4>
	<form>
		<textarea name="notes" id="editor{{$i}}" rows="10" cols="80">{{$interviews[$i]['notes']}}</textarea>
		<button class="btn {{ $interviews[$i]['rating'] == 1? 'active btn-primary' : 'btn-secondary' }} btn-sm ratingBtn app-{{$applicants[$i]['id']}}" data-toggle="tooltip" data-placement="top" title="A bad fit for {{ env('APP_NAME') }}" data-id="{{$applicants[$i]['id']}}">1 <i class="fa fa-thumbs-o-down" aria-hidden="true" class="ratingBtn"></i></button>
		<button class="btn {{ $interviews[$i]['rating'] == 2? 'active btn-primary' : 'btn-secondary' }} btn-sm ratingBtn app-{{$applicants[$i]['id']}}" data-id="{{$applicants[$i]['id']}}">2</button>
		<button class="btn {{ $interviews[$i]['rating'] == 3? 'active btn-primary' : 'btn-secondary' }} btn-sm ratingBtn app-{{$applicants[$i]['id']}}" data-id="{{$applicants[$i]['id']}}">3</button>
		<button class="btn {{ $interviews[$i]['rating'] == 4? 'active btn-primary' : 'btn-secondary' }} btn-sm ratingBtn app-{{$applicants[$i]['id']}}" data-id="{{$applicants[$i]['id']}}">4</button>
		<button class="btn {{ $interviews[$i]['rating'] == 5? 'active btn-primary' : 'btn-secondary' }} btn-sm ratingBtn app-{{$applicants[$i]['id']}}" data-id="{{$applicants[$i]['id']}}">5</button>
	</form>
	<hr/>
@endfor
</div>
<div class="col-5">
	<div id="save_text"></div>
    <div class="card">
        <div class="card-block">
             @markdown($prompt->prompt)
        </div>
    </div>
</div>
@endsection
