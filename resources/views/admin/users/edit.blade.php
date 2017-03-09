@extends('layouts.admin')

@section('bottom_js')
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function() {
    $('#settingsForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@submitEditUser', ['user' => $user->id])}}',
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
    <div class="card">
        <div class="card-header">Edit User ({{$user->name}})</div>
        <div class="card-block">
          <form id="settingsForm">
            {{ csrf_field() }}
            <h4>Login Information</h4>
            <div class="form-group">
              <label for="inputName">Name</label>
              <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" placeholder="Enter Name" name="name" value="{{$user->name}}">
            </div>
            <div class="form-group">
              <label for="inputEmail">Email address</label>
              <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{$user->email}}">
            </div>
            <div class="form-group">
              <label for="inputRoles">Roles (shift-click for multiple)</label>
              <select multiple class="form-control" id="inputRoles" name="roles[]">
                @foreach($roles as $role)
                  @if($role['active'] == 1)
                    <option value="{{$role['id']}}" selected>{{$role['name']}}</option>
                  @else
                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                  @endif                 
                @endforeach
              </select>
            </div>
            <hr/>
            <h4>Biography and Links</h4>
            <div class="form-group">
              <label for="inputTagline">Tagline</label>
              <input type="text" class="form-control" id="inputTagline" value="{{$user->tagline}}" name="tagline" name="tagline" placeholder="Tagline">
            </div>            
            <div class="form-group">
                <label for="inputGithub">Github Username</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-github" aria-hidden="true"></i></div>
                  <input type="text" class="form-control" id="inputGithub" value="{{$user->github}}" name="github" placeholder="Github Username">
                </div>
            </div>
            <div class="form-group">
              <label for="inputWebsite">Website</label>
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-globe" aria-hidden="true"></i></div>
                <input type="text" class="form-control" id="inputWebsite" value="{{$user->website}}" name="website" placeholder="Portfolio Website">
              </div>
            </div>
            <div class="form-group">
              <label for="inputLinkedIn">LinkedIn</label>
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                <input type="text" class="form-control" id="inputLinkedIn" value="{{$user->linkedin}}" name="linkedin" placeholder="LinkedIn Profile Link">
              </div>
            </div>
            <div class="form-group">
              <label for="inputFB">Facebook Username</label>
              <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                  <input type="text" class="form-control" id="inputFB" value="{{$user->fb}}" name="fb" placeholder="Facebook Username">
              </div>
            </div>
            <div class="form-group">
              <label for="inputInstagram">Instgram Username</label>
              <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                  <input type="text" class="form-control" id="inputInstagram" value="{{$user->instagram}}" name="instagram" placeholder="Instgram Username">
              </div>
            </div>
            <div class="form-group">
              <label for="inputSnap">Snapchat Username</label>
              <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></div>
                  <input type="text" class="form-control" id="inputSnap" value="{{$user->snapchat}}" name="snapchat" placeholder="Snapchat Username">
              </div>
            </div>
            <hr/>
            <div class="form-group">
                <label for="inputAbout">About Me:</label>
                <textarea class="form-control" id="inputAbout" name="about">{{$user->about}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</div>
@endsection
