@extends('adminlte::page')

@section('title', 'Distributor List')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Distributor List</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_distributors" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">Subgroup</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>    
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#dt_distributors').DataTable({
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('distributor_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {data: 'bcid', class: 'text-center'},
                {data: 'name'},
                {data: 'group'},
                {data: 'subgroup'},
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });
    });
</script>
@endsection