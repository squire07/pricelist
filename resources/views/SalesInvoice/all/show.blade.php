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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon {{ Helper::badge($sales_order->status_id) }} text-md text-bold" id="ribbon_bg">
                        {{ $sales_order->status->name }}
                    </div>
                </div>
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
                    Sales Invoice Number: <span class="text-bold">{{ $sales_order->si_no }}</span>
                    <br>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Item Code</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">NUC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales_order->sales_details as $sd)
                                <tr>
                                    <td>{{ $sd->item_code }}</td>
                                    <td class="text-center">{{ $sd->item_name }}</td>
                                    <td class="text-center" style="width:9%">{{ $sd->quantity }}</td>
                                    <td class="text-right" style="width:12%">{{ $sd->item_price }}</td>
                                    <td class="text-right" style="width:15%">{{ $sd->amount }}</td>
                                    <td class="text-right" style="width:8%">{{ $sd->nuc }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td class="text-right text-bold" colspan="4">Sub Total</td>
                                    <td class="text-right">{{ $sales_order->total_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="4">Shipping Fee</td>
                                    <td class="text-right">{{ $sales_order->shipping_fee }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="4">VATable Sales</td>
                                    <td class="text-right">{{ $sales_order->vatable_sales }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="4">VAT Amount</td>
                                    <td class="text-right">{{ $sales_order->vat_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="4">Grand Total</td>
                                    <td class="text-right text-bold">{{ $sales_order->grandtotal_amount }}</td>
                                    <td class="text-right text-bold">{{ $sales_order->total_nuc }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url('sales-invoice/all') }}" class="btn btn-lg btn-info float-left"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
        </div>
    </div>

    @include('components.history')

@endsection

@section('adminlte_css')
<style>
.table-bordered {
    border: 0px solid #dee2e6;
}

tfoot tr td:first-child {
    border: none !important;
}

</style>
@endsection
