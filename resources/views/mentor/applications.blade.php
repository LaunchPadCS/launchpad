@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
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
        ],
    });
});
</script>
@stop

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Applications</div>
        <div class="card-block">
            <table class="table" id="applications-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
