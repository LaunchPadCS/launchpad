@extends('layouts.admin')

@section('bottom_js')
<script src="{{ asset('js/cleave.min.js') }}"></script>
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<script>
$('.day-input').toArray().forEach(function(field) {
  new Cleave(field, {
    date: true,
    datePattern: ['d', 'm', 'Y']
  });
});

$('.time-input').toArray().forEach(function(field) {
  new Cleave(field, {
    delimiters: ['/', '/', ' ', ':'],
    blocks: [2, 2, 4, 2, 2]
  });
});

$(document).ready(function() {
    $('#individualInterviewForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@submitCreateInterview')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $.growl.notice({title: "Success", message: "Added interview.", size: "large"});
                } else {
                    string = '';
                    $.each(data, function(key, value){
                        string += value + "<br/>";
                    });
                    $.growl.error({title: "Oops!", message: string, duration: 5000, size: "large" });
                }
            }
        });
        event.preventDefault();
    });
    $('#bulkInterviewForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@submitBulkCreateInterview')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $.growl.notice({title: "Success", message: "Added bulk interviews.", size: "large"});
                } else {
                    string = '';
                    $.each(data, function(key, value){
                        string += value + "<br/>";
                    });
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
        <div class="card-header">Create Interview Timeslot</div>
        <div class="card-block">
          <h3>Individual Interview Creation</h3><hr/>
          <form id="individualInterviewForm">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="inputStart">Start (DD/MM/YYYY HH:ii)</label>
              <input type="text" class="form-control time-input" id="inputStart" placeholder="09/05/2017 10:15" name="start_time">
            </div>
            <div class="form-group">
              <label for="inputEnd">End (DD/MM/YYYY HH:ii)</label>
              <input type="text" class="form-control time-input" id="inputEnd" placeholder="09/05/2017 18:05" name="end_time">
            </div>
            <button type="submit" class="btn btn-primary">Submit &raquo;</button>
          </form>
          <hr/>
          <h3>Bulk Interview Creation</h3>
            <form id="bulkInterviewForm">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputStartDay">Start Date (DD/MM/YYYY)</label>
                    <input type="text" class="form-control day-input" id="inputStartDay" placeholder="09/05/2017" name="start_day">
                </div>
                <div class="form-group">
                    <label for="inputEndDay">End Date (DD/MM/YYYY)</label>
                    <input type="text" class="form-control day-input" id="inputEndDay" placeholder="09/09/2017" name="end_day">
                </div>
                <hr/>
                <div class="form-group">
                    <label for="inputStartTime">Start Time</label>
                    <input type="text" class="form-control" id="inputStartTime" placeholder="10" name="start_time">
                    <p id="passwordHelpBlock" class="form-text text-muted">
                      This describes the hour at which an interview should <b>begin</b> every day. For example, 10 corresponds to 10am.
                    </p>
                </div>
                <div class="form-group">
                    <label for="inputEndTime">End Time (every day, in hours)</label>
                    <input type="text" class="form-control" id="inputEndTime" placeholder="18" name="end_time">
                    <p id="passwordHelpBlock" class="form-text text-muted">
                      This describes the latest hour an interview can begin every day. For example, 18 means that the last interview can begin no later than 6pm.
                    </p>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="inputLength">Length of Interview (minutes)</label>
                    <input type="text" class="form-control" id="inputLength" placeholder="20" name="length">
                </div>
                <div class="form-group">
                    <label for="inputOffset">Length of Offset (minutes)</label>
                    <input type="text" class="form-control" id="inputOffset" placeholder="5" name="offset">
                    <p id="passwordHelpBlock" class="form-text text-muted">
                      This field describes the time in between interviews. For example, with a value of 5, there will be 5 minutes in between interviews.
                    </p>
                </div>
                <button type="submit" class="btn btn-primary">Submit &raquo;</button>
            </form>
        </div>
    </div>
</div>
@endsection
