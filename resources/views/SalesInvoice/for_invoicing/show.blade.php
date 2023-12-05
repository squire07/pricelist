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
                        </tbody>
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
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url('sales-invoice/for-invoice') }}" class="btn btn-lg btn-info float-left" style="margin-top: 8px"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

            <button class="btn btn-lg btn-success float-right" style="margin-top: 8px; margin-left: 10px" id="btn-submit-payment" data-uuid="{{ $sales_order->uuid }}" data-so-no="{{ $sales_order->so_no }}" {{ Helper::BP(2,4) }}><i class="far fa-share-square"></i>&nbsp;Submit</button>

            <button class="btn btn-lg btn-danger float-right" style="margin-top: 8px" id="btn-for-return" data-uuid="{{ $sales_order->uuid }}" data-so-no="{{ $sales_order->so_no }}" {{ Helper::BP(2,4) }}><i class="fas fa-undo-alt"></i>&nbsp;Return</button>
        </div>
    </div>

    @include('components.history')

    {{-- hidden form to return SO to Draft --}}
    <form id="form_for_return" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="status_id" value="1">
            <input type="hidden" name="so_remarks" id="hidden_so_remarks">
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
    $('#btn-for-return').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var so_no = $(this).attr("data-so-no");

        // show the confirmation
        Swal.fire({
            title: 'Are you sure to return \n' + so_no + ' \nto Draft?',
            text: 'Remarks:',
                icon: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                onOpen: () => Swal.getConfirmButton().focus(),
                input: 'text',
                inputName: '',
                inputAttributes: {
                    autocapitalize: 'on',
                    required: 'true',
                },
                inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value.length >= 4) {
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
                $('#hidden_so_remarks').val(result.value);
                $('#form_for_return').attr('action', window.location.origin + '/sales-invoice/for-invoice/' + uuid);

                // finally, submit the form
                $('#form_for_return').submit();
            }
        });
    });

    //Event for Submit to Payment
    $('#btn-submit-payment').on('click', function() {

        var so_no = $(this).attr("data-so-no");
        // show the confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Submit ' + so_no + ' for Payment!',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ url('sales-invoice/for-invoice/' . $sales_order->uuid . '/edit' ) }}";
            }
        });
    });

    // Prevent user from using enter key
    $("input:text").keypress(function(event) {
        if (event.keyCode === 10 || event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});
</script>
@endsection