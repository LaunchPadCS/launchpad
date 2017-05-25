@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">Full Interview Schedule</div>
        <div class="card-block">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="hidden-xs hidden-sm hidden-md">ID</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Students</th>
                        <th style="min-width:100px;">Interview</th>
                        <th>Mentors</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($interviews as $interview)
                    <tr>   
                        <td class="hidden-xs hidden-sm hidden-md">#{{$interview->id}}</td>
                        <td>{{$interview->formattedStartTime}}</td>
                        <td>{{$interview->formattedEndTime}}</td>
                        <td>
                            @foreach($interview->applicants as $applicant)
                                <a href="{{action('MentorController@showRate')}}/{{$applicant->id}}">{{$applicant->name}}</a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        @if($interview->applicationsID == '')
                        <td>-</td>
                        @else
                        <td><a href="{{action('MentorController@showInterview')}}{{$interview->applicationsID}}">Interview &raquo;</a></td>
                        @endif
                        <td>
                            @foreach($interview->assignments as $assignment)
                              {{$assignment->user->name}}
                              @if (!$loop->last)
                                  ,
                              @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
