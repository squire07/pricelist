@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ url('sales-orders/create') }}" target="_self" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Create Sales Order</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Transaction Type</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
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

    {{-- hidden form to submit SO for invoicing --}}
    <form id="form_for_invoicing" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="status_id" value="2">
        @csrf
    </form>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#dt_sales_orders').DataTable({
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('sales_orders_list') }}",
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
                {data: 'bcid', class: 'text-center'},
                {data: 'distributor_name', class: 'text-center'},
                {data: 'total_amount', class: 'text-right'},
                {data: 'total_nuc', class: 'text-right'},
                {
                    data: 'status.name',
                    class: 'text-center',
                    render: function(data, type, row, meta) {
                        return '<span class="badge badge-info">' + data.toUpperCase() + '</span>'
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
                            return '<button class="btn btn-sm btn-default mx-1 btn-for-invoice" data-uuid="' + row.uuid + '" data-so-no="' + row.so_no + '"><i class="fas fa-sign-in-alt"></i>&nbsp;Submit</button>' + 
                            '<a href="' + window.location.origin + '/sales-orders/' + row.uuid + '/edit' + '"target="_self" class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                        }
                    }

                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });

        // use this format to target any class that is dynamically created by js 
        $(document).on('click','.btn-for-invoice', function() {
            var uuid = $(this).attr("data-uuid");
            var so_no = $(this).attr("data-so-no");

            // show the confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Submit ' + so_no + ' for Invoicing!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // add uuid dynamically to hidden uuid field
                    $('#hidden_uuid').val(uuid);

                    // update the action of form_for_invoicing 
                    $('#form_for_invoicing').attr('action', window.location.origin + '/sales-orders/' + uuid);

                    // finally, submit the form
                    $('#form_for_invoicing').submit();
                }
            });
        });
    });
</script>
@endsection