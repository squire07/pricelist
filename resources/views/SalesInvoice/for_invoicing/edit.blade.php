@extends('adminlte::page')

@section('title', 'Sales Invoice Payments')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Invoice Payment</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-lg-12" >
                <div class="position-relative p-3 bg-light">
                <div class="ribbon-wrapper ribbon-lg">
                <div class="ribbon bg-primary text-bold" id="ribbon_bg">
                {{ $sales_order->status->name }}
                </div>
                </div>
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <form class="form-horizontal" id="form_sales_order" action="" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <b>Order Number: </b>{{ $sales_order->so_no }}<br>
                                <b>Transaction Type: </b>{{ $sales_order->transaction_type->name }}<br>
                                <b>Distributor Name: </b>{{ $sales_order->distributor_name }}<br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-4 col-sm-12">
                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>
                 </div>
             </div>
                    

                <table id="" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>  
                        
                            <table id="" class="table table-bordered table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Total NUC</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales_order->sales_details as $sd)
                                        <tr>
                                            <td class="text-center">{{ $sd->quantity }}</td>
                                            <td class="text-center">{{ $sd->item_name }}</td>
                                            <td class="text-center">{{ $sd->item_price }}</td>
                                            <td class="text-center">{{ $sd->nuc }}</td>
                                            <td class="text-center">{{ $sd->amount }}</td>
                                        </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
                </div>
                <div class="row">

                    <div class="col-6">
                    <p class="lead">Payment Methods:</p>
                    <select class="form-control form-control-sm select2 select2-primary" id="transaction_type" name="transaction_type_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                        <option value="">-- Select Payment Type --</option>
                        @foreach($payment_types as $payment_type)
                            <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                        @endforeach
                    </select><br>
                    <div class="form-group">
                        <p class="lead">Remarks:</p>
                        <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                    </div>
                    </div>
                <div class="col-6">
                <p class="lead">Amount Due:</p>
                <div class="table-responsive">
                <table class="table">
                <tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
                </tr>
                <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
                </tr>
                <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
                </tr>
                <tr>
                <th>Total:</th>
                <td>$265.24</td>
                </tr>
                </table>
                </div>
                </div>
                
                </div>
                
                
                <div class="row no-print">
                <div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
                </button>
                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
                </button>
                </div>
                </div>
                </div>
                
                </div>
                </div>
                </div>
                </section>
                
                </div>
                
                <aside class="control-sidebar control-sidebar-dark">
                
                </aside>
                
                </div>
                
                
                <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="../../plugins/jquery/jquery.min.js"></script>
                
                <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                
                <script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
                
                <script src="../../dist/js/demo.js"></script>
@endsection