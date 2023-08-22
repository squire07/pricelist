@extends('adminlte::page')

@section('title', 'Transaction Type')

@section('content_header')
    


    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaction Types</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_sales_order_types" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Sales Type ID</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Sales Order Type</th>
                            <th class="text-center">Income Account</th>
                            <th class="text-center">Expense Account</th>
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

        $('#dt_sales_order_types').DataTable({
            dom: "Bftrip",
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('salesordertype_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {data: 'sales_type_id', class: 'text-center'},
                {data: 'sales_company'},
                {data: 'sales_order_type'},
                // {data: 'income_account'},
                {
                    data: null,
                    render: data => data.income_account_id + ' - ' + data.income_account
                },
                // {data: 'expense_account'},
                {
                    data: null,
                    render: data => data.expense_account_id + ' - ' + data.expense_account
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });
    });
</script>
@endsection