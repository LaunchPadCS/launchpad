@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/datatables_bs4_compat.min.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
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
            { data: 'starttime', name: 'starttime',searchable: false},
            @role('admin')
            { data: 'avg', name: 'avg',searchable: false},
            @endrole
        ],
		"aoColumnDefs": [
            {
                "aTargets": [0],
                "mRender": function ( data, type, full ) {
                    return '<a href="{{action('MentorController@showRate')}}/' + data + '">' + data + '</a>';
                }
            },
            {
                "aTargets": [5],
                "mRender": function ( data, type, full ) {
                    if(data) {
                        return moment(data).format("MMMM Do, h:mm a");
                    }
                    return "&#10006";
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
                        <th>Interview Start</th>
                        @role('admin')
                        <th>Average</th>
                        @endrole
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
