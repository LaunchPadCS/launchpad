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
            @if(env('APP_PHASE') == 1)
                @role(['admin', 'mentor'])
                    @foreach($data->assignments as $assignment)
                        {{$assignment->slot->formattedStartTime}} to {{$assignment->slot->formattedEndTime}}
                    @endforeach
                @endrole
            @endif
        </div>
    </div>
</div>
@endsection
