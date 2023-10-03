@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-so-option"><i class="fas fa-cart-plus"></i> Create Sales Order</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                
                <form id="request_date" class="form-horizontal" action="{{ url('sales-orders') }}" method="get">
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
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('sales-orders') }}')">
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
                            <th class="text-center"></th>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Transaction Type</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Total NUC</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_orders as $sales_order)
                            <tr>
                                <td class="text-center">
                                    @if($sales_order->shipping_fee > 0)
                                        <span class="badge badge-success">D</span>
                                    @else
                                        <span class="badge badge-primary">P</span>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ url('sales-orders/' . $sales_order->uuid ) }}" target="_self">{{ $sales_order->so_no }}</a></td>
                                <td class="text-center">{{ $sales_order->transaction_type->name }}</td>
                                <td class="text-center">{{ $sales_order->bcid }}</td>
                                <td class="text-center">{{ $sales_order->distributor_name }}</td>
                                <td class="text-right">{{ $sales_order->total_amount }}</td>
                                <td class="text-right">{{ $sales_order->total_nuc }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($sales_order->status_id) }}">{{ $sales_order->status->name }}</span></td>
                                <td class="text-center">{{ $sales_order->created_by }}</td>
                                <td class="text-center">{{ $sales_order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    <div class="modal fade" id="modal-so-option">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-body text-center">
                        <h3>Select Delivery Option</h3>
                        <div class="d-grid col-6 mx-auto">
                            <a href="{{ url('sales-orders/create?so=branch-pickup') }}" class="btn btn-app" id="btn-pickup" style="min-width: 150px;"><i class="fas fa-shopping-bag"></i>Branch Pickup</a>

                            <a href="{{ url('sales-orders/create?so=delivery') }}" class="btn btn-app" id="btn-shipping" style="min-width: 150px;"><i class="fas fa-shipping-fast"></i>Delivery</a>


                            {{-- <button type="button" class="btn btn-app" id="btn-pickup" style="min-width: 150px;">
                                <i class="fas fa-shopping-bag"></i>Branch Pickup
                            </button>
                            <button type="button" class="btn btn-app" id="btn-shipping" style="min-width: 150px;">
                                <i class="fas fa-shipping-fast"></i>Delivery
                            </button> --}}
                        </div>
                    </div>    
                </div>

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
            initComplete: function () {
                $("#dt_sales_orders").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
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