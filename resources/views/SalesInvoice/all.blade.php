@extends('adminlte::page')

@section('title', 'Sales Invoice')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Invoice</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_sales_invoice_all" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Transaction Type</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Total NUC</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
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

        $('#dt_sales_invoice_all').DataTable({
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('sales_invoice_all_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {
                    data: 'so_no',
                    class: 'text-center',
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            return '<a href="' + window.location.origin + '/sales-orders/' + row.uuid + '" target="_self">' + data + '</a>';
                        }
                    }
                },
                {data: 'transaction_type.name', class: 'text-center'},
                {data: 'total_amount', class: 'text-right'},
                {data: 'total_nuc', class: 'text-right'},
                {
                    data: 'status.name',
                    class: 'text-center',
                    render: function(data, type, row, meta) {
                        if(data === 'For Invoice'){
                        return '<span class="badge badge-warning">' + data.toUpperCase() + '</span>'
                        }
                        if(data === 'Cancelled'){
                        return '<span class="badge badge-danger">' + data.toUpperCase() + '</span>'
                        }
                        if(data === 'Released'){
                        return '<span class="badge badge-success">' + data.toUpperCase() + '</span>'
                        }
                    }
                },
                {data: 'created_by', class: 'text-center'},
                {
                    data: 'id',
                    class: 'text-center',
                    searchable: false,
                    orderable: false, 
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            return '<button class="btn btn-sm btn-default mx-1"><i class="fas fa-sign-in-alt"></i>&nbsp;Submit</button>' + 
                                    '<a href="' + window.location.origin + '/sales-orders/' + row.uuid + '" target="_self" class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                        }
                        
                    }

                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });
    });
</script>
@endsection