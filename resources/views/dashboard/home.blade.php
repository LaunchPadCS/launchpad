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
                    <h4>Ratings Leaderboard</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Ratings</th>
                                @role(['admin'])
                                    <th>Average Rating</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ratings as $rating)
                            <tr>
                                <td>
                                    <span class="badge badge-pill badge-default">{{ $loop->index + 1}}</span>
                                </td>
                                <td>
                                    {{$rating->name}}
                                </td>
                                <td>
                                  {{$rating->ratingCount}}
                                </td>
                                @role(['admin'])
                                <td>
                                    {{$rating->averageRatingValue}}
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endrole
            @endif
        </div>
    </div>
</div>
@endsection
