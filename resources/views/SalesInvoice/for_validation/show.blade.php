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
                    <div class="ribbon {{ Helper::badge($sales_order->status_id) }} text-bold" id="ribbon_bg">
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
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped" width="100%">
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
                                    <td class="text-center">{{ $sd->quantity }}</td>
                                    <td class="text-right">{{ $sd->amount }}</td>
                                    <td class="text-right">{{ $sd->nuc }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold">Sub-Total</td>
                                    <td class="text-right" id="tfoot_sub_total_amount">{{ $sales_order->total_amount }}</td>
                                    <td class="text-right text-bold" id="tfoot_total_amount">{{ $sales_order->total_nuc }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold">Shipping Fee</td>
                                    <td class="text-right" id="tfoot_shipping_fee">{{ $sales_order->shipping_fee }}</td>
                                    <td class="text-right text-bold"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold"></td>
                                    <td class="text-right text-bold"></td>
                                    <td class="text-right text-bold"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold">Grand Total</td>
                                    <td class="text-right text-bold" id="tfoot_grandtotal_amount"><b>{{ $sales_order->grandtotal_amount }}</b></td>
                                    <td class="text-right text-bold" id="tfoot_grandtotal_amount"></td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url('sales-invoice/for-validation') }}" class="btn btn-lg btn-info float-left" style="margin-top: 8px"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            <a href="{{ url('sales-invoice/for-invoice/' . $sales_order->uuid . '/edit' ) }}" class="btn btn-lg btn-success m-2 float-right"><i class="far fa-share-square"></i>&nbsp;Validate</a>
            <button class="btn btn-lg btn-danger float-right" style="margin-top: 8px" id="btn-for-cancel" data-uuid="{{ $sales_order->uuid }}" data-so-no="{{ $sales_order->so_no }}"><i class="fas fa-ban"></i>&nbsp;Cancel Invoice</button>
        </div>
    </div>

    @include('components.history')

    {{-- hidden form to return SO to Draft --}}
    <form id="form_for_cancel" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="status_id" value="3">
            <input type="hidden" name="si_remarks" id="hidden_si_remarks">
        @csrf
    </form>
@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#btn-for-cancel').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var so_no = $(this).attr("data-so-no");

        console.log('test');

        // show the confirmation
        Swal.fire({
            title: 'Are you sure to cancel ' + so_no + ' ?',
                text: 'Remarks:',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                input: 'text',
                inputName: '',
                inputAttributes: {
                    autocapitalize: 'on',
                    required: 'true',
                },
                inputValidator: (value) => {
                var regex = /^[a-zA-Z0-9\s]*$/;
                return new Promise((resolve) => {
                    if (value.length >= 4 && regex.test(value) === true) {
                        resolve();
                    } else if (value.length == 0) {
                        resolve('Please fill out this field!');
                    } else if (value.length <= 3) {
                        resolve('Remarks too short!');
                    } else {
                        resolve('Invalid Format!');
                    }
                });
            },
            confirmButtonText: 'Yes, submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                // add uuid dynamically to hidden uuid field
                $('#hidden_uuid').val(uuid);

                // update the action of form_for_invoicing 
                $('#hidden_si_remarks').val(result.value);
                $('#form_for_cancel').attr('action', window.location.origin + '/sales-invoice/for-validation/' + uuid);

                // finally, submit the form
                $('#form_for_cancel').submit();
            }
        });
    });
});
</script>
@endsection