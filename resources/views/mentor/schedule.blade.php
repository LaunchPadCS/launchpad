@extends('layouts.app')

@section('bottom_js')
<script>
$("#container").toggleClass('container container-fluid');
</script>

<style>
.table-dark {
  background-color: #c6c8ca;
}
.container-fluid {
    margin-top: 40px;
}
</style>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">Full Interview Schedule</div>
        <div class="card-block">
            <table class="table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Duration</th>
                        <th>Students</th>
                        <th style="min-width:100px;">Interview</th>
                        <th>Mentors</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($interviews as $interview)
                    <tr {{ $interview->pastDate ? 'class=table-dark' :''}}>
                        <td>{{$interview->formattedDay}}</td>
                        <td>{{$interview->formattedStartTime}} - {{$interview->formattedEndTime}}</td>
                        <td>
                            @foreach($interview->applicants as $applicant)
                                <a href="{{action('MentorController@showRate')}}/{{$applicant->id}}">{{$applicant->name}}</a>{{ !$loop->last ? ',' : ''}}
                            @endforeach
                        </td>
                        @if($interview->applicationsID == '')
                        <td>-</td>
                        @else
                        <td><a href="{{action('MentorController@showInterview')}}{{$interview->applicationsID}}">Interview</a></td>
                        @endif
                        <td>
                            @foreach($interview->assignments as $assignment)
                              {{$assignment->user->name}}{{ !$loop->last ? ',' : ''}}
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
