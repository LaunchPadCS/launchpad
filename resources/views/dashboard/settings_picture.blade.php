@extends('layouts.app')

@section('bottom_js')
<link href="{{asset('css/cropper.min.css')}}" rel="stylesheet">
<script src="{{asset('js/cropper.min.js')}}"></script>
<script>
$(document).ready(function() {
    var image;
    var cropper;
    $('body').on('click', '#croppedSubmit', function () {
        var data = cropper.getData();
        $.ajax({
            type: 'POST',
            url: '{{action('PageController@cropPicture')}}',
            data: { "_token": "{{ csrf_token() }}", "x" : data['x'], "y" : data['y'], "width": data['width'], "height" : data['height']},
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                    window.location.href = '{{action('PageController@showSettings')}}';
                }
            }
        });
    });
    $('#settingsForm').submit(function(event) {
        $("#message").fadeOut();
        $.ajax({
            url: '{{action('PageController@tempProfilePicStore')}}',
            data: new FormData($("#settingsForm")[0]),
            dataType:'json',
              async:false,
              type:'post',
              processData: false,
              contentType: false,
              success:function(data){
                if(data['message'] == 'success') {
                    $("#message").fadeOut();
                    $("#settingsForm").fadeOut("normal", function() {
                        $(this).remove();
                    });
                    $("#image_holder").append('<button class="btn btn-success" id="croppedSubmit">Submit Photo</button><hr/><div><img id="image" src="' + data['location'] + '"></div>');
                    image = document.getElementById('image');
                    cropper = new Cropper(image, {
                        aspectRatio: 1/1,
                        viewMode: 1,
                        crop: function(e) {
                        }
                    });
                } else {
                    $("#message").fadeIn().addClass('alert alert-danger').html(data);
                }
              },
            });
        event.preventDefault();
    });
});
</script>
@stop

@section('content')
<div class="col">
    @if(Session::has('message'))
        <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif  
    <div class="card">
        <div class="card-header">Manage Profile Photo</div>
        <div class="card-block">   
            @if(Auth::user()->image)
                Current Photo:<br/>
                <img src="{{asset('storage/uploads/' . Auth::user()->image)}}" class="mx-auto d-block img-thumbnail" style="max-width: 300px;">
                <hr/>
            @endif
            <div id="image_holder"></div>
            <form id="settingsForm" method="POST" enctype="multipart/form-data">
                <div id="message"></div>
                {{ csrf_field() }}
                <label for="photoUpload">Please select a photo to upload.</label>
                <input type="file" name="photo" id="photoUpload">
                <hr/>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
