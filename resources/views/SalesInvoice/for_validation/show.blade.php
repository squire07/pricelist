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
                    Invoice Number: <span class="text-bold">{{ Helper::get_si_assignment_no($sales_order->si_assignment_id) }}</span>
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
            <a href="{{ url('sales-invoice/for-validation') }}" class="btn btn-lg btn-info float-left"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

            {{-- Print Button for cashier and head cashier --}}
            @if(in_array(Auth::user()->role_id, [2,4]))
                <a href="{{ url('sales-invoice/for-validation/' . $sales_order->uuid . '/print') }}" class="btn btn-primary btn-lg float-left ml-2" target="_blank" rel="noopener noreferrer"><i class="fas fa-print mr-1"></i>Print</a>
            @endif
            
            {{-- for accounting role only --}}
            @if(Auth::user()->role_id == 8) 
                <button class="btn btn-lg btn-success float-right" id="btn-validate" data-uuid="{{ $sales_order->uuid }}" {{ isset($error) ? 'disabled' : '' }} {{ Helper::BP(4,4) }}><i class="far fa-share-square"></i>&nbsp;Validate</button>
                <button class="btn btn-lg btn-danger float-right mx-2" id="btn-for-cancel" data-uuid="{{ $sales_order->uuid }}" data-si-no="{{ $sales_order->si_no }}" {{ Helper::BP(4,4) }}><i class="fas fa-ban"></i>&nbsp;Cancel Invoice</button>
            @endif
        </div>
    </div>

    @include('components.payment')

    @include('components.income_expense')

    @include('components.history')

    {{-- hidden form to return SO to Draft --}}
    <form id="form_for_cancel" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="form_cancel_uuid">
            <input type="hidden" name="status_id" value="3">
            <input type="hidden" name="si_remarks" id="form_cancel_si_remarks">
            <input type="hidden" name="version" value="{{ $sales_order->version }}">
        @csrf
    </form>
    <form id="form_validate" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="form_validate_uuid">
            <input type="hidden" name="status_id" value="5">
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
.swal-custom-width{
    width:850px !important;
}
</style>
@endsection                 

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#btn-for-cancel').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var so_no = $(this).attr("data-so-no");
        var si_no = $(this).attr("data-si-no");

        // show the confirmation
        Swal.fire({
            title: 'Are you sure to cancel \n' + si_no + '?',
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
                $('#hidden_form_cancel_uuiduuid').val(uuid);

                // update the action of form_for_invoicing 
                $('#form_cancel_si_remarks').val(result.value);
                $('#form_for_cancel').attr('action', window.location.origin + '/sales-invoice/for-validation/' + uuid);

                // finally, submit the form
                $('#form_for_cancel').submit();
            }
        });
    });


    $('#btn-validate').on('click', function() {
        var uuid = $(this).attr("data-uuid");

        // show the confirmation
        Swal.fire({
            title: 'Are you sure to validate this transaction?',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, validate!',
            preConfirm: () => {
                // Display "Please wait" modal
                Swal.showLoading();

                // Return a promise to wait for asynchronous actions
                return new Promise((resolve) => {
                    // Add uuid dynamically to hidden uuid field
                    $('#form_validate_uuid').val(uuid);

                    // Update the action of form_for_invoicing 
                    $('#form_validate').attr('action', window.location.origin + '/sales-invoice/for-validation/' + uuid);

                    // Resolve the promise to continue
                    resolve();
                });
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                $('#form_validate').submit();

                Swal.fire({
                    title: "Posting to ERPNext",
                    html: "Please wait",
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    });
});

@if(isset($error))
    Swal.fire({
        title: 'Error!',
        html: '{!! addslashes($error) !!}',
        icon: 'error',
        customClass: 'swal-custom-width',
    });
@endif
</script>
@endsection