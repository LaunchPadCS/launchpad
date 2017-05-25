@extends('layouts.app')

@section('bottom_js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
var simplemde = new SimpleMDE({ element: $("#edtior")[0] });
var timeout;
simplemde.codemirror.on("change", function() {
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        $("#save_text").html('Saving...');
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@submitPrompt')}}',
            data: { "_token": "{{ csrf_token() }}", "data":  simplemde.value()},
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $("#save_text").html('<abbr title="' + data['updated_at'] +'">Saved.</abbr>');
                }
            }
        });
    }, 500);
});
</script>
@stop

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Manage Interview Prompt</div>
        <div class="card-block">
            <textarea id="editor">{{$prompt->prompt}}</textarea>
            <span id="save_text">Nothing saved yet.</span>
        </div>
    </div>
</div>
@endsection
