@extends('layouts.admin')

@section('content')
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
							<tr>
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
        					<td><a href="#" class="btn btn-outline-danger btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Disable</a></td>
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
    					</tr>
  					</thead>
  					<tbody>
  					@if($mentors != null)
						@foreach ($mentors as $user)
							<tr>
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-outline-primary btn-sm">Edit &raquo;</a></td>
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
    					</tr>
  					</thead>
  					<tbody>
  					@if($mentees != null)
						@foreach ($mentees as $user)
							<tr>
        					<th scope="row">{{$user->id}}</th>
        					<td>{{ $user->name }}</td>
        					<td>{{ $user->email }}</td>
        					<td><a href="{{action('AdminController@editUser', ['user' => $user->id])}}" class="btn btn-outline-primary btn-sm">Edit &raquo;</a></td>
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
