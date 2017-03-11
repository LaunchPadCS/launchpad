@extends('layouts.admin')

@section('bottom_js')
<script src="{{ asset('js/Sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.binding.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.growl.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet" type="text/css" />
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
	            $.growl.error({title: "Oops!", message: string, duration: 5000, size: "large" });                       
	        }
	    }
	});
  }
});

$(document).ready(function() {
	$('.edit').click(function(event) {
		$("#inputQuestionText").val($(this).data('question'));
		$("#" + $(this).data('type')).prop('selected', true);
		$("#save").data('id', $(this).data('id'));
	});
	$('.delete').click(function(event) {
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
});
</script>
@stop

@section('content')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
  			<div class="form-group">
    			<label for="inputQuestionText">Question Text</label>
    			<textarea class="form-control" id="inputQuestionText" rows="3"></textarea>
  			</div>
			<div class="form-group">
			  <label for="inputQuestionType">Question Type</label>
			  <select class="form-control" id="inputQuestionType">
			    <option value="string" id="string">string (short answer)</option>
			    <option value="text" id="text">text (long answer)</option>
			  </select>
			</div>
  		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
      </div>
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
        	<button class="btn btn-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Create Question</button>
        	<hr/>
        	<div id="listWithHandle" class="list-group">	
        	@foreach($questions as $question)
				<div class="list-group-item" data-id="{{$question->order}}" data-dbid="{{$question->id}}" id="question-{{$question->id}}">
					<div class="btn-group" role="group">
  						<button type="button" class="btn btn-outline-primary mover"><i class="fa fa-arrows" aria-hidden="true"></i></button>
  						<button type="button" class="btn btn-outline-success edit" data-toggle="modal" data-target="#myModal" data-id="{{$question->id}}" data-question="{{$question->text}}" data-type="{{$question->type}}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
  						<button type="button" class="btn btn-outline-danger delete" data-toggle="modal" data-target="#deleteModal" data-id="{{$question->id}}"><i class="fa fa-ban" aria-hidden="true"></i></button>
					</div>
      				&nbsp;{{$question->text}}
    			</div>
        	@endforeach
        	</div>
        </div>
    </div>
</div>
@endsection