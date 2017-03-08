@extends('layouts.app')

@section('bottom_js')
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function() {
    $('#settingsForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('PageController@submitSettings')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $("#message").fadeIn().removeClass('alert-danger').addClass("alert alert-success").html("Successfully updated settings.");
                     $.growl.notice({title: "Success", message: "Successfully updated settings.", size: "large"});
                } else {
                    string = '';
                    $.each(data, function(key, value){
                        string += value + "<br/>";
                    });
                    $("#message").fadeIn().removeClass('alert-success').addClass("alert alert-danger").html(string);
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
    @if(Session::has('message'))
        <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif  
    <div class="card">
        <div class="card-header">Settings</div>
        <div class="card-block">      
            <div id="message"></div>
            <form id="settingsForm">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputName">Full Name</label>
                    <input type="text" class="form-control" id="inputName" value="{{Auth::user()->name}}" name="name" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <label for="inputTagline">Tagline</label>
                    <input type="text" class="form-control" id="inputTagline" value="{{Auth::user()->tagline}}" name="tagline" placeholder="Tagline">
                    <p class="form-text text-muted">A very short description of you</p>
                </div>
                <hr/>
                <h3>Professional and Social Links <small class="text-muted">(Not required)</small></h3>                
                <div class="form-group">
                    <label for="inputGithub">Github Username</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-github" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputGithub" value="{{Auth::user()->github}}" name="github" placeholder="Github Username">
                    </div>
                    <p class="form-text text-muted">Not required.</p>
                </div>
                <div class="form-group">
                    <label for="inputWebsite">Website</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-globe" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputWebsite" value="{{Auth::user()->website}}" name="website" placeholder="My Portfolio Website">
                    </div>
                    <p class="form-text text-muted">Not required.</p>
                </div>
                <div class="form-group">
                    <label for="inputLinkedIn">LinkedIn</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputLinkedIn" value="{{Auth::user()->linkedin}}" name="linkedin" placeholder="LinkedIn Profile Link">
                    </div>
                    <p class="form-text text-muted">Not required.</p>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="inputFB">Facebook Username</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputFB" value="{{Auth::user()->fb}}" name="fb" placeholder="Facebook Username">
                    </div>
                    @role(['admin', 'mentor'])
                        <p class="form-text text-muted">Displayed on Ignite homepage. Not required.</p>
                    @endrole
                    @role(['mentee'])
                        <p class="form-text text-muted">Shown only to other community members.</p>
                    @endrole
                </div>
                <div class="form-group">
                    <label for="inputInstagram">Instgram Username</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputInstagram" value="{{Auth::user()->instagram}}" name="instagram" placeholder="Instgram Username">
                    </div>
                    <p class="form-text text-muted">Shown only to other community members. Not required.</p>
                </div>
                <div class="form-group">
                    <label for="inputSnap">Snapchat Username</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></div>
                        <input type="text" class="form-control" id="inputSnap" value="{{Auth::user()->snapchat}}" name="snapchat" placeholder="Snapchat Username">
                    </div>
                    <p class="form-text text-muted">Shown only to other community members. Not required.</p>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="inputAbout">About Me:</label>
                    <textarea class="form-control" id="inputAbout" name="about">{{Auth::user()->about}}</textarea>
                    <p class="help-block">Introduce yourself, list organizations you're involved with, etc.</p>
                </div>
                @if(env('APP_PHASE') == 1)
                    @role(['admin', 'mentor'])
                        <hr/>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="enable_keyboard" type="checkbox" {{(Auth::user()->enable_keyboard) ? 'checked' : ''}}>    Enable keyboard control for Rating
                            </label>
                        </div>
                    @endrole
                @endif
                <hr/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div><br/>
</div>
@endsection
