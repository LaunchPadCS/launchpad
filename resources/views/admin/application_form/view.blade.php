@extends('layouts.admin')

@section('bottom_js')
<script src="{{ asset('js/Sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.binding.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
<style>
.mover {
    cursor: move;
    cursor: -webkit-grabbing;
}
</style>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var sortable = Sortable.create(listWithHandle, {
  handle: '.mover',
  animation: 150,
  dataIdAttr: 'data-id',
  onEnd: function (/**Event*/evt) {
  	var order = {},
	el,
	children = this.el.children,
	i = 0,
	n = children.length;

	for (; i < n; i++) {
		el = children[i];
		order[el.getAttribute('data-dbid')] = i;		
	}

	$.ajax({
	    type: 'POST',
	    url: '{{action('AdminController@submitQuestionOrder')}}',
	    data: JSON.stringify(order),
	    dataType: 'json',
	    success: function(data) {
	        if(data['message'] == 'success') {
	             $.growl.notice({title: "Success", message: "Questions reordered.", size: "large"});
	        } else {
	            $.growl.error({title: "Oops!", message: 'Something went wrong!', duration: 5000, size: "large" });                       
	        }
	    }
	});
  }
});

$(document).ready(function() {
	$('#listWithHandle').on('click', '.edit', function() {
		$("#inputQuestionText").val($("#question-text-" + $(this).data('id')).text());
		$("#" + $(this).data('type')).prop('selected', true);
		$("#qid").val($(this).data('id'));
	});
	$('#listWithHandle').on('click', '.delete', function() {
		$("#confirm").data('id', $(this).data('id'));
	});
	$("#confirm").click(function(event) {
		var dataid = $(this).data('id');
		$.ajax({
		    type: 'POST',
		    url: '{{action('AdminController@deleteQuestion')}}' + '/' + $(this).data('id'),
		    dataType: 'json',
		    success: function(data) {
		        if(data['message'] == 'success') {
		             $.growl.notice({title: "Success", message: "Successfully deleted question.", size: "large"});
		             $("#question-" + dataid).fadeOut(300, function() { $(this).remove(); });
		        } else {
		            $.growl.error({title: "Oops!", message: "Something went wrong!", duration: 5000, size: "large" });                   
		        }
		        $('#deleteModal').modal('hide');
		    }
		});
	});
	$('#questionUpdateForm').submit(function(event) {
		var question_id = $("#qid").val();
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@updateQuestion')}}' + '/' + question_id,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $.growl.notice({title: "Success", message: "Successfully updated settings.", size: "large"});
                     $("#question-text-" + question_id).text($("#inputQuestionText").val());
                     $("#question-edit-" + question_id).data('type', $("#inputQuestionType").val());
                     $('#myModal').modal('hide');
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
	$('#questionCreateForm').submit(function(event) {
        $.ajax({
            type: 'POST',
            url: '{{action('AdminController@createQuestion')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $.growl.notice({title: "Success", message: "Successfully created question.", size: "large"});
                     $('#addQuestionModal').modal('hide');
                     $("#inputQuestionTextAdd").val("");
                     $("#inputQuestionTypeAdd").val("string");
                     var string = `
                     <div class="list-group-item" data-id="`+data['question']['order']+`" data-dbid="`+data['question']['id']+`" id="question-`+data['question']['id']+`">
						<div class="btn-group" role="group">
  							<button type="button" class="btn btn-outline-primary mover"><i class="fa fa-arrows" aria-hidden="true"></i></button>
  							<button type="button" class="btn btn-outline-success edit" id="question-edit-`+data['question']['id']+`" data-toggle="modal" data-target="#myModal" data-id="`+data['question']['id']+`" data-type="`+data['question']['type']+`"><i class="fa fa-pencil" aria-hidden="true"></i></button>
  							<button type="button" class="btn btn-outline-danger delete" data-toggle="modal" data-target="#deleteModal" data-id="`+data['question']['id']+`"><i class="fa fa-ban" aria-hidden="true"></i></button>
						</div>
      					&nbsp;<span id="question-text-`+data['question']['id']+`">`+data['question']['text']+`</span>
    				</div>
                     `;
                     $("#listWithHandle").append(string);
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
<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form id="questionCreateForm">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuestionModal">Add Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label for="inputQuestionTextAdd">Question Text</label>
			<textarea class="form-control" id="inputQuestionTextAdd" rows="3" name="text_create"></textarea>
		</div>
		<div class="form-group">
		  <label for="inputQuestionTypeAdd">Question Type</label>
		  <select class="form-control" id="inputQuestionTypeAdd" name="type_create">
		    <option value="string">string (short answer)</option>
		    <option value="text">text (long answer)</option>
		  </select>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Question</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form id="questionUpdateForm">
    	<input type="hidden" name="question-id" id="qid">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label for="inputQuestionText">Question Text</label>
			<textarea class="form-control" id="inputQuestionText" rows="3" name="text"></textarea>
		</div>
		<div class="form-group">
		  <label for="inputQuestionType">Question Type</label>
		  <select class="form-control" id="inputQuestionType" name="type">
		    <option value="string" id="string">string (short answer)</option>
		    <option value="text" id="text">text (long answer)</option>
		  </select>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModal">Danger Zone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this question?
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
        <div class="card-header">Application Form</div>
        <div class="card-block">
        	<button class="btn btn-secondary" data-toggle="modal" data-target="#addQuestionModal"><i class="fa fa-plus" aria-hidden="true"></i> Create Question</button>
        	<hr/>
        	<div id="listWithHandle" class="list-group">
        	@foreach($questions as $question)
				<div class="list-group-item" data-id="{{$question->order}}" data-dbid="{{$question->id}}" id="question-{{$question->id}}">
					<div class="btn-group" role="group">
  						<button type="button" class="btn btn-outline-primary mover"><i class="fa fa-arrows" aria-hidden="true"></i></button>
  						<button type="button" class="btn btn-outline-success edit" id="question-edit-{{$question->id}}" data-toggle="modal" data-target="#myModal" data-id="{{$question->id}}" data-type="{{$question->type}}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
  						<button type="button" class="btn btn-outline-danger delete" data-toggle="modal" data-target="#deleteModal" data-id="{{$question->id}}"><i class="fa fa-ban" aria-hidden="true"></i></button>
					</div>
      				&nbsp;<span id="question-text-{{$question->id}}">{{$question->text}}</span>
    			</div>
        	@endforeach
        	</div>
        </div>
    </div>
</div>
@endsection