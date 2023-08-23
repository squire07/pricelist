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
        {{-- <b>Transaction Type: </b>{{ $sales_order->transaction_type->name }}
        <br>
        <b>Distributor: </b>{{ $sales_order->distributor_name }}
        <br>
        <b>BCID: </b>{{ $sales_order->bcid }}
        <br>
        <b>Group: </b>{{ $sales_order->group_name }}
        <br> --}}
        <div class="row mb-4">
            <div class="col-md-6 col-sm-12">
                Name: <span class="text-bold">{{ $sales_order->distributor_name }}</span>
                <br>
                BCID: <span class="text-bold">{{ $sales_order->bcid }}</span>
                <br>
                Group: <span class="text-bold">{{ $sales_order->group_name }}</span>
            </div>
            <div class="col-md-6 col-sm-12">
                Transaction Type: <span class="text-bold">{{ $sales_order->transaction_type->name }}</span>
                <br>
                Sales Order Number: <span class="text-bold">{{ $sales_order->so_no }}</span>
                <br>
            </div>
        </div>
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
                                <td class="text-right">{{ $sd->amount }}</td>
                                <td class="text-right">{{ $sd->nuc }}</td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td class="text-right"></td>
                                <td class="text-right text-bold">Total</td>
                                <td class="text-right text-bold" id="tfoot_total_amount"></b>{{ $sales_order->total_amount }}</td>
                                <td class="text-right text-bold" id="tfoot_total_amount"></b>{{ $sales_order->total_nuc }}</td>
                            </tr>
                        </tfoot>
                    </tbody>
                </table><br>
                <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
        </div>
    </div>
@endsection
