@extends('layouts.app')

@section('bottom_js')
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
	$('.disable').click(function(event) {
		$("#name").text($(this).data('name'));
		$("#confirm").data('id', $(this).data('id'));
	});
	$("#confirm").click(function(event) {
		var dataid = $(this).data('id');
    $.ajax({
        type: 'POST',
        url: '{{action('AdminController@disableAccount')}}' + '/' + $(this).data('id'),
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                 $.growl.notice({title: "Success", message: "Successfully deleted user.", size: "large"});
                 $("#user-" + dataid).fadeOut(300, function() { $(this).remove(); });
            } else {
                $.growl.error({title: "Oops!", message: "Something went wrong!", duration: 5000, size: "large" });                   
            }
            $('#myModal').modal('hide');
        }
    });
	});
});
</script>
@stop

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Danger Zone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to disable <b><span id="name"></span>'s</b> account?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-outline-danger" id="confirm">Yes</a>
      </div>
    </div>
  </div>
</div>
<div class="col">
    <div class="card">
        <div class="card-header">Manage Users</div>
        <div class="card-block">
			<ul class="nav nav-tabs" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#admins" role="tab">Admins ({{count($admins)}})</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#mentors" role="tab">Mentors ({{count($mentors)}})</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#mentees" role="tab">Mentees ({{count($mentees)}})</a>
			  </li>
			</ul>
			
			<div class="tab-content">
			  <div class="tab-pane fade show active" id="admins" role="tabpanel">
			  	<br/>
				<table class="table">
  					<thead>
    					<tr>
      						<th>#</th>
      						<th>Name</th>
      						<th>Email</th>
      						<th></th>
      						<th></th>
    					</tr>
  					</thead>
  					<tbody>
  					@if($admins != null)
						@foreach ($admins as $user)
							<tr id="user-{{$user->id}}">
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
        					<td>
        					@if($user->id != Auth::user()->id)
        					<a href="#" class="btn btn-outline-danger btn-sm disable" data-toggle="modal" data-target="#myModal" data-id="{{$user->id}}" data-name="{{$user->name}}"><i class="fa fa-ban" aria-hidden="true"></i> Disable</a>
        					@endif
        					</td>
        					</tr>
    					@endforeach
    				@endif
    				</tbody>
    			</table>
			  </div>
			  <div class="tab-pane fade" id="mentors" role="tabpanel">
			  	<br/>
				<table class="table">
  					<thead>
    					<tr>
      						<th>#</th>
      						<th>Name</th>
      						<th>Email</th>
      						<th></th>
      						<th></th>
    					</tr>
  					</thead>
  					<tbody>
  					@if($mentors != null)
						@foreach ($mentors as $user)
							<tr id="user-{{$user->id}}">
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-outline-primary btn-sm">Edit &raquo;</a></td>
        					<td><a href="#" class="btn btn-outline-danger btn-sm disable" data-toggle="modal" data-target="#myModal" data-id="{{$user->id}}" data-name="{{$user->name}}"><i class="fa fa-ban" aria-hidden="true"></i> Disable</a></td>
                </tr>
    					@endforeach
    				@endif
    				</tbody>
    			</table>
			  </div>
			  <div class="tab-pane fade" id="mentees" role="tabpanel">
			  	<br/>
				<table class="table">
  					<thead>
    					<tr>
      						<th>#</th>
      						<th>Name</th>
      						<th>Email</th>
      						<th></th>
      						<th></th>
    					</tr>
  					</thead>
  					<tbody>
  					@if($mentees != null)
						@foreach ($mentees as $user)
							<tr id="user-{{$user->id}}">
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-outline-primary btn-sm">Edit &raquo;</a></td>
        					<td><a href="#" class="btn btn-outline-danger btn-sm disable" data-toggle="modal" data-target="#myModal" data-id="{{$user->id}}" data-name="{{$user->name}}"><i class="fa fa-ban" aria-hidden="true"></i> Disable</a></td>
                </tr>
    					@endforeach
    				@endif
    				</tbody>
    			</table>
			  </div>
			</div>
        </div>
    </div>
</div>
@endsection
