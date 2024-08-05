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
                    </table>
                </div>
            </div>
            <div class="row mt-3">
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
    </div>
    
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Method</h3>
                </div>
                <div class="card-body">
                    <select class="form-control select2" multiple id="payment_type" name="payment_type_id[]" data-name="payment_type_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                        <option value="">-- Select Payment Type --</option>
                        @foreach($payment_types as $payment_type)
                            <option value="{{ $payment_type->id }}" data-is-cash={{ $payment_type->is_cash }}>{{ $payment_type->name }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="card-footer">
                    <a href="{{ url('sales-invoice/for-invoice') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
                    @if($sales_order->status_id == 4)
                        <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    @endif
                    @if($sales_order->status_id != 4)
                        <button type="button" class="btn btn-success float-right" id="btn_submit_payment" data-toggle="modal" data-target="#modal-submit-payment"><i class="far fa-credit-card"></i> Submit Payment</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Amount Due</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless" style="width:100%">
                        <tbody style="width:inherit">
                            <tr>
                                <td class="text-right text-bold" style="width:25%">Sub Total</td>
                                <td class="text-right" style="width:35%">{{ $sales_order->total_amount }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold" style="width:25%">Shipping Fee</td>
                                <td class="text-right" style="width:35%">{{ $sales_order->shipping_fee }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold" style="width:25%">VATable Sales</td>
                                <td class="text-right" style="width:35%">{{ $sales_order->vatable_sales }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold" style="width:25%">VAT Amount</td>
                                <td class="text-right" style="width:35%">{{ $sales_order->vat_amount }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold" style="width:25%">Grand Total</td>
                                <td class="text-right text-bold" style="width:25%">{{ $sales_order->grandtotal_amount }}</td>
                                <td class="text-right text-bold" style="width:25%">Total NUC</td>
                                <td class="text-right text-bold" style="width:15%">{{ $sales_order->total_nuc }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger d-none">
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                You currently don't have an assigned invoice booklet. Please contact your head cashier or branch manager for assistance.
            </div>

            <div class="alert alert-warning d-none">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
                The invoice booklet assigned to you is running low in stock. To replenish your supply, please make a request to your head cashier or branch manager.
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-submit-payment" data-backdrop='static'>
        <div class="modal-dialog modal-lg">
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
                    <input type="hidden" name="status_id" value="5">
                    <input type="hidden" name="version" value="{{ $sales_order->version }}">

                    {{-- 3 fields:  payment_type_id, remarks, cash_tendered --}}

                    <div class="modal-body form-horizontal">

                        {{-- Show the next available invoice number --}}
                        <div class="col-12">
                            @php
                                $first_booklet = !is_null($booklet_details) && isset($booklet_details[0]) ? $booklet_details[0] : null;
                            @endphp
                            
                            <input type="hidden" name="si_assignment_id" value="{{ $first_booklet ? $first_booklet->id : null }}">
                            <h2>
                                <span>Invoice No:</span>
                                <input type="text" id="si_assignment_no" class="custom-input-text text-white"
                                    data-id="{{ $first_booklet ? $first_booklet->id : null }}" 
                                    value="{{ $first_booklet ? $first_booklet->prefix_value . $first_booklet->series_number : null }}" 
                                    readonly tabindex="-1">
                            </h2>
                        </div>


                        <div class="col-12">
                            <div class="form-group row">
                                <label for="total_amount" class="col-sm-4 col-form-label">Total Amount:</label>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm text-right" id="total_amount" value="{{ $sales_order->grandtotal_amount }}" readonly tabindex="-1">
                                </div>
                            </div>
                        </div>

                        {{-- dynamic cash tendered field --}}
                        <div id="payment_info_fields"></div>
                        {{-- hidden elements --}}
                        <div id="payment_id_and_name_fields"></div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="balance" class="col-sm-4 col-form-label text-red">Balance:</label>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm text-right" id="balance" name="balance" value="0.00" readonly tabindex="-1">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="cash_change" class="col-sm-4 col-form-label">Cash Change:</label>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm text-right" id="cash_change" name="cash_change" value="0.00" readonly tabindex="-1">
                                </div>

                                {{-- this will be used by blue event of input_reference_field --}}
                                <span class="d-none" id="is-cash-sufficient">false</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="cashiers_remarks">Remarks:</label>
                                <textarea class="form-control" name="cashiers_remarks" cols="30" rows="5" style="width:100%"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm m-2" id="btn_modal_print_invoice" data-uuid="{{ $sales_order->uuid }}"><i class="fas fa-print mr-2"></i>Print Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- hidden element: this will be used by js fx for dynamic fields computation --}}
    <input type="hidden" id="count_payment_type" value="0">

    {{-- sales invoice assignment percentage remaining handler --}}
    <input type="hidden" id="alert_type" value="{{ $alert_type }}">

@endsection

@section('adminlte_css')
<style>
.custom-input-text {
    background: transparent;
    border: none;
    padding: 0;
    outline: none;
    margin: 0;
    width: 125px;
} 

.custom-input-text:read-only {
    background: transparent;
}
.table-bordered {
    border: 0px solid #dee2e6;
}

tfoot tr td {
    border: none !important;
}

.select2-container--default .select2-selection--multiple {
    background-color: #343a40 !important;
}
</style>
@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    //Initialize Select2 Elements
    $('.select2').select2({
        maximumSelectionLength: 1  // remove this to allow multiple; do not remove the `multiple` in payment_type option
    });

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    $('#btn_submit_payment').prop('disabled', true);
    $('#btn_modal_print_invoice').prop('disabled', true);

    // Initial calculation
    updateCashChange();    

    // initialize: check if there is available si_assignment no
    let next_si_assignment = $('#si_assignment_no').val();
    let alert_type = $('#alert_type').val();

    if(alert_type == 'warning') {
        // show the warning
        $('.alert-warning').removeClass('d-none');

        // hide the danger
        $('.alert-danger').addClass('d-none');
        // enable the select payment method dropdown so that user will be able to update
        $('#payment_type').prop('disabled', false);
    } else if(alert_type == 'danger'){
        // hide the warning
        $('.alert-warning').addClass('d-none');

        // show the danger
        $('.alert-danger').removeClass('d-none');
        // disable the select payment method dropdown so that user will not be able to update
        $('#payment_type').prop('disabled', true);
    }

 

    $('#btn_submit_payment').on('click', function() {
        // empty the dynamic div
        $('#payment_info_fields').empty();
        $('#payment_id_and_name_fields').empty();
        
        // always reset to zero
        $("#cash_change").val('0.00');

        // count the number of payment type
        var count_payment_type = $('#payment_type').val();
        // update the value of hidden field `count_payment_type` from zero to new value
        $('#count_payment_type').val(count_payment_type.length);


        // empty first
        $('#cash_tendered_fields').empty();

        let total_amount = $('#total_amount').val();

        // get the names of payment type
        var selected_payment_types = $("#payment_type :selected").select2(this.data);
        var is_cash = $('#payment_type option:selected').map(function() {
                        return $(this).data("is-cash");
                    }).get();

        // create selected_payment_type_names array
        var selected_payment_type_names = [];
        var selected_is_cash = [];
        for (var i = 0; i <= selected_payment_types.length-1; i++) {
            selected_payment_type_names.push(selected_payment_types[i].text);
            selected_is_cash.push(is_cash[i]);

            // add to element
            $('#hidden_payment_type_name').val(selected_payment_types[i].text);
        };

        let divs = '';
        let els  = '';
        // render html inside cash_tendered_fields div
        for(let i = 1; i <= count_payment_type.length; i++) {


            // if(count_payment_type.length == 1) { 
            //     // 1:1 Payment
            //         divs += "<div class='col-12'>" +
            //                     "<div class='form-group row'>" +
            //                         "<label for='" + selected_payment_type_names[i - 1] + "' class='col-sm-4 col-form-label'>" + selected_payment_type_names[i - 1] + ":</label>" +
            //                         "<div class='col-sm-4'>";
            //     if(selected_is_cash[i - 1] == 0) { 
            //         divs +=         "<input type='text' class='form-control form-control-sm text-right input_reference_field' id='dynamic_reference_field_" + i + "' name='payment_references[]' placeholder='Reference No' required autocomplete='off'>";
            //     } else {
            //         divs +=         "<input type='hidden' name='payment_references[]'>";
            //     }                           
            //         divs +=     "</div>" +
            //                     "<div class='col-sm-4'>" +
            //                         // lock the amount field if not cash and add the total amount (grand total)
            //                         "<input type='text' class='form-control form-control-sm text-right input_amount_field' id='dynamic_amount_field_" + i + "' name='payments[]' placeholder='0.00' maxlength='12' value=" + total_amount + " required autocomplete='off'>" +
            //                     "</div>" +  
            //                 "</div>" +
            //             "</div>";

            // } else {
                // Split Payment - for future use
                    divs += "<div class='col-12'>" +
                            "<div class='form-group row'>" +
                                "<label for='" + selected_payment_type_names[i - 1] + "' class='col-sm-4 col-form-label'>" + selected_payment_type_names[i - 1] + ":</label>" +
                                "<div class='col-sm-4'>";
                if(selected_is_cash[i - 1] == 0) { 
                    divs +=         "<input type='text' class='form-control form-control-sm text-right input_reference_field' id='dynamic_reference_field_" + i + "' name='payment_references[]' placeholder='Reference No' required autocomplete='off'>";
                } else {
                    divs +=         "<input type='hidden' name='payment_references[]'>";
                }                           
                    divs +=     "</div>" +
                                "<div class='col-sm-4'>" +
                                    "<input type='text' class='form-control form-control-sm text-right input_amount_field' id='dynamic_amount_field_" + i + "' name='payments[]' placeholder='0.00' maxlength='12' required autocomplete='off'>" +
                                "</div>" +  
                            "</div>" +
                        "</div>";
            // }

                
                // payment method ids - pass to hidden field
                els += "<input type='hidden' name='hidden_payment_type_ids[]' value='" + count_payment_type[i - 1] + "'>";
                // payment method names - pass to hidden field
                els += "<input type='hidden' name='hidden_payment_type_name[]' value='" + selected_payment_type_names[i - 1] + "'>";
        }

        $('#payment_info_fields').append(divs);

        $('#payment_id_and_name_fields').append(els);
    });

    // if payment_type field is empty, then disable the submit payment button
    $("#payment_type").on('change', function() {
        if($(this).val() != '') {
            $('#btn_submit_payment').prop('disabled', false);
        } else {
            $('#btn_submit_payment').prop('disabled', true);
        }
    });




    



    // ======================== START OF INPUT AMOUNT FIELD =============================

    // prevent paste event in dynamic fields
    $(document).on('paste', '.input_amount_field', function(e) {
        e.preventDefault();
    });

    // only numbers and period 
    $(document).on('input', '.input_amount_field', function() {
        // Remove non-numeric and non-period characters
        $(this).val($(this).val().replace(/[^0-9.]/g, ''));

        // Prevent multiple periods (decimal points)
        if ($(this).val().split('.').length > 2) {
            $(this).val($(this).val().replace(/\.+$/, ''));
        }
    });


    // function --> updateCashChange
    $(document).on('keyup', '.input_amount_field', updateCashChange);    


    // format the dynamic field to two decimal places when the dynamic field has lost it's focus
    $(document).on('blur', '.input_amount_field', function() {
        let inputValue = this.value;
        const commaRegex = /,/;
        inputValue = commaRegex.test(inputValue) ? parseFloat(inputValue.replace(/,/g, '')) : parseFloat(inputValue);
        if (!isNaN(inputValue)) {
            this.value = inputValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    });

    // ======================== END OF INPUT AMOUNT FIELD =============================


    $(document).on('blur', '.input_reference_field', function() { 
        let all_fields_filled = true;
        
        // get the current value of is-cash-sufficient
        let is_cash_sufficient = $('#is-cash-sufficient').text();
        
        // Select all input elements within the form that have the 'required' attribute
        $("form input[required]").each(function() {
            if ($(this).val() === '') {
                all_fields_filled = false;
                return false; // Break out of the loop
            }
        });


        if (is_cash_sufficient === 'true' && all_fields_filled) {
            $('#btn_modal_print_invoice').prop('disabled', false);
        } else {
            $('#btn_modal_print_invoice').prop('disabled', true);
        }
    });


    // Submit the final form with payment type details 
    $('#btn_modal_print_invoice').on('click', function() {
        // get the data-uuid 
        let uuid = $(this).data('uuid');

        // disable the button to prevent multiple submit
        $(this).prop('disabled',true);
        
        $('#form_modal_submit_payment').submit();

        // window.open(window.location.origin + '/sales-invoice/for-invoice/' + uuid + '/print' , '_blank');
        
    }); 






    function formatInputValue(e) {
        var inputElement = document.getElementById('total_amount');
        var value = inputElement.value.replace(/,/g, ''); // Remove existing commas
        var formattedValue = Number(value).toLocaleString('en-US'); // Add commas

        return formattedValue;
    }


    function updateCashChange() {
        let total_amount = parseFloat($("#total_amount").val().replace(/,/g, '')) || 0;
        let total = 0;
        let balance = 0;

        $('.input_amount_field').each(function() {
            let current_amount = $(this).val();
            if (current_amount !== "") {
                total += parseFloat(current_amount.replace(/,/g, ''));
            }
        });

        balance = total_amount - total > 0 ? total_amount - total : 0;

        let cash_change = 0;
        if (total > 0) {
            cash_change = total_amount - total;

            if (cash_change >= 0) {
                cash_change = 0;
            } else {
                cash_change = cash_change * -1;
            }
        }


        let all_fields_filled = true;
        // Select all input elements within the form that have the 'required' attribute
        $("form input[required]").each(function() {
            if ($(this).val() === '') {
                all_fields_filled = false;
                return false; // Break out of the loop
            }
        });


        if (total >= total_amount && all_fields_filled) {
            $('#btn_modal_print_invoice').prop('disabled', false);

            // update is-cash-sufficient
            $('#is-cash-sufficient').text('true');
        } else {
            $('#btn_modal_print_invoice').prop('disabled', true);

            // update is-cash-sufficient
            $('#is-cash-sufficient').text('false');
        }

        $('#balance').val(balance.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        $("#cash_change").val(cash_change.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    // Prevent from redirecting back to homepage when cancel button is clicked accidentally
    $('#modal-submit-payment').on("hide.bs.modal", function (e) {

        if (!$('#modal-submit-payment').hasClass('programmatic')) {
            e.preventDefault();
            swal.fire({
                title: 'Are you sure?',
                text: "Please confirm that you want to cancel",
                type: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.value) {
                    $('#modal-submit-payment').addClass('programmatic');
                    $('#modal-submit-payment').modal('hide');
                    e.stopPropagation();
                } else {
                    e.stopPropagation();

                }
            });

        }
        return true;
    });

    $('#modal-submit-payment').on('hidden.bs.modal', function () {
        $('#modal-submit-payment').removeClass('programmatic');
    });

});
</script>

@endsection