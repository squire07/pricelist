@extends('adminlte::page')

@section('title', 'Sales Invoice Payments')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>For Invoicing</h1>
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
                                <th class="text-center">NUC</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales_order->sales_details as $sd)
                                <tr>
                                    <td>{{ $sd->item_name }}</td>
                                    <td class="text-center">{{ $sd->quantity }}</td>
                                    <td class="text-right">{{ $sd->nuc }}</td>
                                    <td class="text-right">{{ $sd->amount }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold">Subtotal</td>
                                    <td class="text-right text-bold" id="tfoot_total_nuc">{{ $sales_order->total_nuc }}</td>
                                    <td class="text-right text-bold" id="tfoot_total_amount">{{ $sales_order->total_amount }}</td>
                                    
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
    
    
            <div class="row">
                <div class="col-6">
                    <p class="lead">Payment Methods:</p>
                    <select class="select2" multiple="multiple" id="payment_type" name="payment_type_id[]" data-name="payment_type_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                        <option value="" disabled>-- Select Payment Type --</option>
                        @foreach($payment_types as $payment_type)
                            <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                        @endforeach
                    </select>
                    {{-- <div class="form-group">
                        <p class="lead">Remarks:</p>
                        <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                    </div> --}}
                </div>
    
                <div class="col-6">
                    <p class="lead">Amount Due:</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td class="text-right text-bold">{{ $sales_order->total_amount }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Shipping Fee:</th>
                                <td class="text-right text-bold">{{ $sales_order->shipping_fee }}</td>
                            </tr>
                            <tr>
                                <th>Tax (12%)</th>
                                <td></td>
                            </tr>
                            <tr>
                                <br>
                                <th>Grand Total:</th>
                                <td class="text-right text-bold">{{ $sales_order->grandtotal_amount }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">
                    <a href="{{ url('sales-invoice/for-invoice') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

                    @if($sales_order->status_id == 4)
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    @endif
                    @if($sales_order->status_id != 4)
                        <button type="button" class="btn btn-success float-right" id="btn_submit_payment" data-toggle="modal" data-target="#modal-submit-payment"><i class="far fa-credit-card"></i> Submit Payment</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-submit-payment" data-backdrop='static'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('for-invoice.update', $sales_order->uuid)}}" method="POST" id="form_modal_submit_payment" autocomplete="off">
                    @csrf
                    @method('PUT')

                    {{-- 3 fields:  payment_type_id, remarks, cash_tendered --}}

                    <div class="modal-body form-horizontal">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="total_amount" class="col-sm-5 col-form-label">Total Amount:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-right" id="total_amount" style="font-size:25px;" value="{{ $sales_order->total_amount }}" disabled>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-12">
                            Cash Tendered:
                            <input type="number" class="form-control form-control-sm text-right" id="cash_tendered" style="font-size:25px;" name="cash_tendered" maxlength="12" min="0" pattern="^\d+(?:\.\d{1,2})?$" required> --}}
                            {{-- pattern="^\d+(?:\.\d{1,2})?$" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required> --}}
                        {{-- </div> --}}

                        {{-- dynamic cash tendered field --}}
                        <div id="cash_tendered_fields"></div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="cash_change" class="col-sm-5 col-form-label">Cash Change:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-right" id="cash_change" style="font-size:25px;" name="cash_change" value="0.00" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="ref_number" class="col-sm-5 col-form-label">Reference Number:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-right" id="ref_number" style="font-size:25px;" name="ref_number" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm m-2" id="btn_modal_print_invoice"><i class="fas fa-print mr-2"></i>Print Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- hidden element: this will be used by js fx for dynamic fields computation --}}
    <input type="hidden" id="count_payment_type" value="0">

@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    $('#btn_submit_payment').prop('disabled', true);
    $('#btn_modal_print_invoice').prop('disabled', true);

    $('#btn_submit_payment').on('click', function() {

        // always reset to zero
        $("#cash_change").val('0.00');

        // count the number of payment type
        var count_payment_type = $('#payment_type').val();
        // update the value of hidden field `count_payment_type` from zero to new value
        $('#count_payment_type').val(count_payment_type.length);

        // empty first
        $('#cash_tendered_fields').empty();

        // get the names of payment type
        var selected_payment_types = $("#payment_type :selected").select2(this.data);
        
        // create selected_payment_type_names array
        var selected_payment_type_names = [];
        for (var i = 0; i <= selected_payment_types.length-1; i++) {
            selected_payment_type_names.push(selected_payment_types[i].text);
        };

        let divs = '';
        // render html inside cash_tendered_fields div
        for(let i = 1; i <= count_payment_type.length; i++) {
            divs += "<div class='col-12'>" +
                        "<div class='form-group row'>" +
                            "<label for='" + selected_payment_type_names[i - 1] + "' class='col-sm-5 col-form-label'>" + selected_payment_type_names[i - 1] + ":</label>" +
                            "<div class='col-sm-7'>" +
                                "<input type='text' class='form-control form-control-sm text-right input_amount_field' id='dynamic_amount_field_" + i + "' style='font-size:25px;' name='payments[]' placeholder='0.00' maxlength='12' required>" +
                            "</div>" +
                        "</div>" +
                    "</div>";
        }
        $('#cash_tendered_fields').append(divs);
    });

    // $("#selected_payment_type_name").on('change', function() {
    //     if($(this).val() != 'CASH') {
    //         $('#ref_number').prop('disabled', true);
    //     } else {
    //         $('#ref_number').prop('disabled', false);
    //     }
    // });


    // if payment_type field is empty, then disable the submit payment button
    $("#payment_type").on('change', function() {
        if($(this).val() != '') {
            $('#btn_submit_payment').prop('disabled', false);
        } else {
            $('#btn_submit_payment').prop('disabled', true);
        }
    });

    // prevent the user from using the "-" minus sign
    // 109 is the minus key from number pad or num pad
    // 189 is the minus key from alpha numeric keys
    $(document).on('keydown', '.input_amount_field', function(e) {    
        var charCode = e.which || e.keyCode;  
        if (charCode == 109 || charCode == 189) {
            e.preventDefault();
        } 
    });


    // for dynamic input amount field
    $(document).on('keyup', '.input_amount_field', function(e) {
        // lets assume that every keyup event, the `total` is always set to 0 so we can get the right summation
        let total = 0;
        
        // lets count the `cash tendered` field that is/are not null or empty
        let non_empty_fields = 0;
        
        for(let i = 1; i <= $('#count_payment_type').val(); i++) {
            if($('#dynamic_amount_field_' + i).val() != '') {
                total += Number($('#dynamic_amount_field_' + i).val());

                // increment the non_empty_fields
                non_empty_fields++;
            }
        }

        let cash_change = 0;
        if (total > 0) {
            cash_change = Number($("#total_amount").val()) - total;

            // cash change cannot be more than 0 (positive value), the value must always be 0 or negative
            if(cash_change >= 0) {
                cash_change = 0;
            }
        } else {
            cash_change = 0;
        }
        // cash_change = total.toFixed(2) - Number($("#total_amount").val());
        $("#cash_change").val(cash_change.toFixed(2));

        // enable, disable the print invoice button, if:
        // 1. the `total cash tendered` is greater or equal with the total amount of sales invoice, and
        // 2. the `count_payment_type` is equal to the count of non_empty_fields, in this way, we can prevent a NULL or empty dynamic field
        if(total >= Number($("#total_amount").val()) && $('#count_payment_type').val() == non_empty_fields) {
            $('#btn_modal_print_invoice').prop('disabled', false);
        } else {
            $('#btn_modal_print_invoice').prop('disabled', true);
        }
    });

    // format the dynamic field to two decimal places when the dynamic field has lost it's focus
    $(document).on('blur', '.input_amount_field', function() {
        // Get the current value of the input
        let inputValue = this.value;

        // Convert the value to a number
        inputValue = parseFloat(inputValue);

        // Check if the input is a valid number
        if (!isNaN(inputValue)) {
            // Round the number to two decimal places
            inputValue = inputValue.toFixed(2);
            
            // Update the input value with the formatted value
            this.value = inputValue;
        }
    });

    // prevent paste event in dynamic fields
    $(document).on('paste', '.input_amount_field', function(e) {
        e.preventDefault();
    });


    // submit the final form with payment type details 
    $('#btn_modal_print_invoice').on('click', function() {
        // console.log('test')
    }); 

    
});
</script>

@endsection