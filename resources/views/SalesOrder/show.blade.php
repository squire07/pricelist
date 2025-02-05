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
                    Date/Time: <span class="text-bold">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sales_order->created_at)->format('m/d/Y g:i A') }}</span>
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
                                    <td class="text-center">{{ $sd->item_code }}</td>
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
            <div class="row">
                <div class="col-12">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" {{ $sales_order->new_signup != null ? 'checked' : '' }}>
                            <label for="checkbox_new_signup">New sign up:</label>
                            <span class="ml-2">{{ $sales_order->signee_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" {{ $sales_order->origin_id != null ? 'checked' : '' }}>
                            <label for="checkbox_origin">Origin:</label>
                            <span class="ml-2">{{ $sales_order->origin != null ? $sales_order->origin->name : null }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url('sales-orders') }}" class="btn btn-lg btn-info float-left" style="margin-top: 8px"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            <button class="btn btn-lg btn-success float-right" style="margin-top: 8px" id="btn-for-invoice" data-uuid="{{ $sales_order->uuid }}" data-so-no="{{ $sales_order->so_no }}" {{ Helper::BP(1,4) }}><i class="far fa-share-square"></i>&nbsp;Submit</button>
            <a href="{{ url('sales-orders/' . $sales_order->uuid . '/edit' ) }}" class="btn btn-lg btn-primary m-2 float-right {{ Helper::BP(1,4) }}"><i class="far fa-edit"></i>&nbsp;Edit</a>
        </div>
    </div>

    @include('components.history')

    {{-- hidden form to submit SO for invoicing --}}
    <form id="form_for_invoicing" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="status_id" value="2">
            <input type="hidden" name="version" value="{{ $sales_order->version }}">
        @csrf
    </form>
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

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#btn-for-invoice').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var so_no = $(this).attr("data-so-no");

        console.log('test');

        // show the confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Submit ' + so_no + ' for Invoicing!',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
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