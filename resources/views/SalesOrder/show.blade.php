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
                
                <div>
                    {{ $sales_order->id }}
                    <br>
                    {{ $sales_order->so_no }}
                    <br>
                    Total AMount {{ $sales_order->total_amount }}
                    <br>
                    Total NUC pts {{ $sales_order->total_nuc }}
                </div>
            
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
                                <td>{{ $sd->item_name }}</td>
                                <td>{{ $sd->quantity }}</td>
                                <td>{{ $sd->amount }}</td>
                                <td>{{ $sd->nuc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
@endsection