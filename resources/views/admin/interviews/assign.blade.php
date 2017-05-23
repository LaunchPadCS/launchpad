@extends('layouts.app')

@section('bottom_js')
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap3-typeahead.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.mentorInput').tagsinput({
  typeahead: {
    source: [
    @foreach($interviewers as $interviewer)
      '{{$interviewer->name}}',
    @endforeach
    ]
  },
  tagClass: 'label label-primary',
  freeInput: false
});

function handleAssignmentChange(mentors, id) {
  console.log(mentors);
  console.log(id);
  $.ajax({
      type: 'POST',
      url: '{{action('AdminController@submitAssignment')}}' + '/' + id,
      data: {'mentors': mentors},
      dataType: 'json',
      success: function(data) {
          if(data['message'] == 'success') {
               $.growl.notice({title: "Success", message: "Successfully updated assignent.", size: "large"});
          } else {
              $.growl.error({title: "Oops!", message: "Something went wrong!", duration: 5000, size: "large" });                   
          }
      }
  });
}

$('.mentorInput').on('itemAdded', function() {
  setTimeout(function() {
      $(">input[type=text]", ".bootstrap-tagsinput").val("");
  }, 0);
  handleAssignmentChange($(this).tagsinput('items'), $(this).data('mentorid'));
});
$('.mentorInput').on('itemRemoved', function() {
  handleAssignmentChange($(this).tagsinput('items'), $(this).data('mentorid'));
});
</script>

<style>
/*
 * bootstrap-tagsinput v0.8.0
 * 
 */

.bootstrap-tagsinput {
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  display: inline-block;
  padding: 4px 6px;
  color: #555;
  vertical-align: middle;
  border-radius: 4px;
  max-width: 100%;
  line-height: 22px;
  cursor: text;
}
.bootstrap-tagsinput input {
  border: none;
  box-shadow: none;
  outline: none;
  background-color: transparent;
  padding: 0 6px;
  margin: 0;
  width: auto;
  max-width: inherit;
}
.bootstrap-tagsinput.form-control input::-moz-placeholder {
  color: #777;
  opacity: 1;
}
.bootstrap-tagsinput.form-control input:-ms-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
  color: #777;
}
.bootstrap-tagsinput input:focus {
  border: none;
  box-shadow: none;
}
.bootstrap-tagsinput .tag {
  margin-right: 2px;
  color: white;
}
.bootstrap-tagsinput .tag [data-role="remove"] {
  margin-left: 8px;
  cursor: pointer;
}
.bootstrap-tagsinput .tag [data-role="remove"]:after {
  content: "x";
  padding: 0px 2px;
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover {
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}
.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}
.label {
  display: inline;
  padding: .2em .6em .3em;
  font-size: 75%;
  font-weight: bold;
  line-height: 1;
  color: #ffffff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25em;
}
a.label:hover,
a.label:focus {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}
.label:empty {
  display: none;
}
.btn .label {
  position: relative;
  top: -1px;
}
.label-default {
  background-color: #777777;
}
.label-default[href]:hover,
.label-default[href]:focus {
  background-color: #5e5e5e;
}
.label-primary {
  background-color: #337ab7;
}
.label-primary[href]:hover,
.label-primary[href]:focus {
  background-color: #286090;
}
.label-success {
  background-color: #5cb85c;
}
.label-success[href]:hover,
.label-success[href]:focus {
  background-color: #449d44;
}
.label-info {
  background-color: #5bc0de;
}
.label-info[href]:hover,
.label-info[href]:focus {
  background-color: #31b0d5;
}
.label-warning {
  background-color: #f0ad4e;
}
.label-warning[href]:hover,
.label-warning[href]:focus {
  background-color: #ec971f;
}
.label-danger {
  background-color: #d9534f;
}
.label-danger[href]:hover,
.label-danger[href]:focus {
  background-color: #c9302c;
}
</style>
@endsection

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Assign Interviews</div>
        <div class="card-block">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Start</th>
                <th>End</th>
                <th>Students</th>
                <th>Interview</th>
                <th>Mentors</th>
              </tr>
            </thead>
            <tbody>
				    @foreach($interviews as $interview)
				      <tr>
                <td scope="row">{{$interview->id}}</td>
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
                <td>Interview &raquo;</td>
                <td>
                  <select multiple data-role="tagsinput" name="interview-{{$interview->id}}" class="mentorInput" data-mentorid="{{$interview->id}}">
                    @foreach($interview->assignments as $assignment)
                      <option value="{{$assignment->user->name}}">{{$assignment->user->name}}</option>
                    @endforeach
                  </select> 
                </td>
              </tr>
				    @endforeach
        </div>
    </div>
</div>
@endsection