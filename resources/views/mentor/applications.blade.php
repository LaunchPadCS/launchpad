@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/tempbs4.min.js') }}"></script>
<script>
$(function() {
    var table = $('#applications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'reviews', name: 'ratings',searchable: false},
            { data: 'UserRating', name: 'myrating',searchable: false},
        ],
		"aoColumnDefs": [
            {
                "aTargets": [0], // Column to target
                "mRender": function ( data, type, full ) {
                    return '<a href="{{action('MentorController@showRate')}}/' + data + '">' + data + '</a>';
                }
            },
        ]
    });
});
</script>
<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@stop

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Applications</div>
        <div class="card-block">
            <table id="applications-table" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Reviews</th>
                        <th>My Rating</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
