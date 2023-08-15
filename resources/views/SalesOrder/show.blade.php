@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    


    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Order Details</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
<div class="card-body">
    <div class="row">
    <div class="col-lg-12" >
    <div class="position-relative p-3 bg-light">
    <div class="ribbon-wrapper ribbon-lg">
    <div class="ribbon bg-primary text-bold" id="ribbon_bg">
    {{ $sales_order->status->name }}
    </div>
    </div>
    <div>
    
        <b>Sales Order Type: </b>{{ $sales_order->transaction_type->name }}
        <br>
        <b>Order Number: </b>{{ $sales_order->so_no }}
        <br>
        <b>Distributor: </b>{{ $sales_order->distributor_name }}
        <br>
        <b>Total Amount: </b>{{ $sales_order->total_amount }}
        <br>
        <b>Total NUC: </b> {{ $sales_order->total_nuc }}
    </div>
    <table id="" class="table table-bordered table-hover table-striped" width="100%">
        <thead>  
            
                <table id="" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">NUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_order->sales_details as $sd)
                            <tr>
                                <td class="text-center">{{ $sd->item_name }}</td>
                                <td class="text-center">{{ $sd->quantity }}</td>
                                <td class="text-center">{{ $sd->amount }}</td>
                                <td class="text-center">{{ $sd->nuc }}</td>
                            </tr>
                        @endforeach
                    
                    </tbody>
                </table><br>
                <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
        </div>
    </div>
@endsection
