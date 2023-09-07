@extends('adminlte::page')

@section('title', 'Sales Invoice')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Records History</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                
                <form id="request_date" class="form-horizontal" action="{{ url('sales-invoice/all') }}" method="get">
                    @csrf
                    <label for="daterange">Request Date</label>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group form-group-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange" value="{{ Request::get('daterange') }}">

                                    <div class="input-group-append" onclick="document.getElementById('request_date').submit();">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('sales-invoice/all') }}')">
                                        <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">SO #</th>
                            <th class="text-center">SI #</th>
                            <th class="text-center">Transaction Type</th>
                            <th class="text-center">Module</th>
                            <th class="text-center">Event</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Event Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_histories as $sales_history)
                            <tr>
                                <td class="text-center">{{ $sales_history->so_no }}</td>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $sales_history->transaction_type->name }}</td>
                                <td class="text-center">{{ $sales_history->module }}</td>
                                <td class="text-center">{{ $sales_history->event_name }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($sales_history->status_id) }}">{{ $sales_history->status->name }}</span></td>
                                <td class="text-center">{{ $sales_history->remarks }}</td>
                                <td class="text-right">{{ $sales_history->created_by }}</td>
                                <td class="text-right">{{ $sales_history->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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
        
        // re-initialize the datatable
        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            // serverSide: true,
            // processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
        });
    });
</script>
@endsection

@section('adminlte_js')
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
@endsection