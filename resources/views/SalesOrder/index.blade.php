@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    


    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Orders</h1>
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
                            <th class="text-center">Sales ID</th>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Total NUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_orders as $so)
                            <tr>
                                <td><a href="{{ url('sales-orders/' . $so->id ) }}" target="_self">{{ $so->id }}</a></td>
                                <td>{{ $so->so_no }}</td>
                                <td>{{ $so->total_amount }}</td>
                                <td>{{ $so->total_nuc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
@endsection