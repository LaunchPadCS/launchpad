@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/datatables_bs4_compat.min.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script>
$("#container").toggleClass('container container-fluid');
$(function() {
    var table = $('#applications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'firstname', name: 'firstname' },
            { data: 'lastname', name: 'lastname' },
            { data: 'email', name: 'email'},
            { data: 'reviews', name: 'ratings', orderable: false, searchable: false},
            { data: 'UserRating', name: 'myrating',searchable: false},
            { data: 'starttime', name: 'starttime',searchable: false},
            { data: 'interview_avg', name: 'interview_avg',searchable: false},
            @role('admin')
            { data: 'hashid', name: 'hashid', searchable: false},
            { data: 'avg', name: 'avg',searchable: false},
            { data: 'total_avg', name: 'total_avg',searchable: false},
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
                "aTargets": [6],
                "mRender": function ( data, type, full ) {
                    if(data) {
                        return moment(data).format("M/D, h:mm a");
                    }
                    return "&#10006";
                }
            },
        ]
    });
});
</script>
<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
.container-fluid {
    margin-top: 40px;
}
</style>
@stop

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Applications</div>
        <div class="card-block">
            @role('admin')
                <a href="{{ action('AdminController@exportDecisionList', ['decision' => 1]) }}" class="btn btn-success">Download Accepted List ({{$accepted}})</a>
                <a href="{{ action('AdminController@exportDecisionList', ['decision' => 0]) }}" class="btn btn-danger">Download Denied List ({{$denied}})</a>
                <hr/>
            @endrole
            <table id="applications-table" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Reviews</th>
                        <th>My Rating</th>
                        <th>Interview Start</th>
                        <th>Avg Interview Rating</th>
                        @role('admin')
                        <th>hashid</th>
                        <th>Average</th>
                        <th>Total Avg</th>
                        @endrole
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
