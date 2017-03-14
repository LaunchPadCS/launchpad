@extends('layouts.app')

@section('content')
<div class="col">
	@if(Session::has('message'))
	    <p class="alert alert-info">{{ Session::get('message') }}</p>
	@endif  
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-block">
        	<h3>Welcome Back, <b>{{Auth::user()->name}}</b></h3>
        	<hr/>
        	Nothing to see here...yet.
        </div>
    </div>
</div>
@endsection
