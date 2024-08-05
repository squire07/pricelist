@extends('adminlte::page')

@section('title', 'Create Sales Orders')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sales Order</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <form class="form-horizontal" id="form_sales_order" action="{{ url('sales-orders') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="tfoot_total_nuc" id="tfoot_total_nuc" value="0"/>
                    <input type="hidden" name="signee_name" id="signee_name">
                    <input type="hidden" name="origin_id" id="origin_id">
                    <div class="row">
                        <div class="col-md-1 col-2 d-none">
                            <label for="rs_points">Item Code</label>
                            <input type="text" class="form-control form-control-sm" id="item_code" disabled>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="item_name">Item Name</label>
                            <select class="form-control form-control-sm select2 select2-primary" id="item_name" data-dropdown-css-class="select2-primary " style="width:100%;" disabled>
                            </select>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control form-control-sm" maxlength="6" id="quantity" disabled>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control form-control-sm" id="amount" disabled>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <label for="nuc">NUC</label>
                            <input type="text" class="form-control form-control-sm" id="nuc" disabled>
                        </div>
                        <div class="col-md-1 col-2 d-none">
                            <label for="rs_points">RS Points</label>
                            <input type="text" class="form-control form-control-sm" id="rs_points" disabled>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <input type="button" class="btn btn-primary btn-sm" id="add_item" value="Add Item" style="margin-top: 29px">
                        </div>
                        
                    </div>
                

                    {{-- details --}}
                    <div class="row mt-5">
                        <div class="col-12">
                            <table class="table table-bordered table-hover" id="table_item_details">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:9%">Item Code</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center" style="width:9%">Quantity</th>
                                        <th class="text-center" style="width:12%">Price</th>
                                        <th class="text-center" style="width:12%">Amount</th>
                                        <th class="text-center" style="width:8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right text-bold" colspan="2">&nbsp;</td>
                                        <td class="text-right text-bold text-center"><span id="total_quantity_count">0</span></td>
                                        <td class="text-right text-bold">Sub Total</td>
                                        <td class="text-right text-bold">
                                            <input type="text" class="text-right custom-input-text" name="total_amount" id="tfoot_subtotal_amount" value="0.00" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right text-bold" colspan="4">VATable Sales</td>
                                        <td class="text-right text-bold">
                                            <input type="text" class="text-right custom-input-text" name="vatable_sales" id="tfoot_vatable_sales" value="0.00" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right text-bold" colspan="4">VAT Amount</td>
                                        <td class="text-right text-bold">
                                            <input type="text" class="text-right custom-input-text" name="vat_amount" id="tfoot_vat_amount" value="0.00" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right text-bold" colspan="4">Grand Total</td>
                                        <td class="text-right text-bold">
                                            <input type="text" class="text-right custom-input-text text-bold" name="grandtotal_amount" id="tfoot_grand_total_amount" value="0.00" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="button" value="Cancel" id="btn_cancel_so" class="btn btn-lg btn-danger">
                            <button class="btn btn-primary btn-lg m-2 " id="btn_save_so" {{ Helper::BP(1,2) }}><i class="fas fa-save mr-2"></i>Save Sales Order</button>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>    
        </div>
    </div>

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
    /* for dark mode only; remove if not dark-mode */
    color: white; 
} 

.custom-input-text:read-only {
    background: transparent;
}

.table-bordered {
    border: 0px solid #dee2e6;
}

tfoot tr td:first-child {
    border: none !important;
}

/* Dynamic rows - tbody */
/* Apply styles to even rows */
tbody tr:nth-child(even) {
  background-color: transparent;
}

/* Apply styles to odd rows */
tbody tr:nth-child(odd) {
  background-color: transparent;
}
</style>
@endsection

@section('adminlte_js')
{{-- should select2 be initialized at master page instead(?) --}}
<script>
    $(function () {

        // initialize select2 on this page using bootstrap 4 theme
        $('.select2').select2({
            theme: 'bootstrap4'
        });


        // set the focus on search field after clicking the select2 dropdown
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('#posting_datetime').datetimepicker({ 
            icons: { 
                time: 'far fa-clock' 
            } 
        });

        $('#created_at').focus(function () {
            $('#posting_datetime').datetimepicker('toggle');
        });

        // initialize item counter: this will trigger if there is/are items in the table; This will be used by btn-delete-item AND transaction_type change event 
        var item_count = 0;
        var total_quantity_count = 0;

        // default state
        var old_transaction_type = 0;
        var change_count = 0;

        // initialize total amount nuc grandtotal and shipping fee
        var sub_total_amount = 0;
        var total_nuc = 0;
        var modal_sf_amount = 0;
        var shipping_fee = 0;
        var grand_total_amount = 0;

        var api_url = null;
        var title = null;


        // check if SO is for delivery
        let url_param = getUrlParameter('so');
        // mark the tfoot_sf_total_amount field as required
        if(url_param == 'delivery') {
            $('#tfoot_sf_total_amount').prop('required', true);
        }


        function update_item_dropdown(response) {
            obj = JSON.parse(JSON.stringify(response));

            $('#bcid').attr('disabled', false);
            $('#item_name').empty().append($('<option></option>').val('').html('-- Select Item --'));

            $.each(obj, function(key, data) {
                $('#item_name').append($('<option></option>').val(data.id).html(data.name).attr('data-item-name', data.name));
            });

            sessionStorage.clear();
            window.sessionStorage.setItem('item_object', JSON.stringify(obj));
        }
        
        // fetch the items details by transaction type id using FETCH API
        $('#transaction_type').on('change', function(e) {

            // count the change event
            change_count++;

            // get the current value of transaction type
            var currently_selected = this.value;

            if(change_count == 1) {
                old_transaction_type = this.value
            }

            // additional, check if bcid field is not empty
            var bcid = $('#bcid').val();

            if(item_count > 0 && currently_selected != old_transaction_type) {
                    // show notification
                    Swal.fire({
                        title: 'Change Transaction Type?',
                        text: 'Your current sales order will be deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        allowEnterKey: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // just refresh the page and remove all existing data; no longer needed to remove all data from elements
                            // location.reload();

                            fetch(window.location.origin + '/api/item/transaction_type/' + this.value, {
                                method: 'get',
                                headers: {
                                    'Content-type': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(update_item_dropdown);

                            // clear the sessionStorage first before assigning new values
                            sessionStorage.removeItem("item_selected");

                            // remove existing item/s
                            $('#table_item_details > tbody').empty();

                            // reset all the amount
                            var reset_amount = 0;
                            $('#tfoot_subtotal_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            $('#tfoot_vatable_sales').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            $('#tfoot_vat_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            $('#tfoot_grand_total_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                            sub_total_amount = 0;
                            total_nuc = 0;
                            modal_sf_amount = 0;
                            shipping_fee = 0;
                            grand_total_amount = 0;

                            // empty the arrays
                            $('#hidden_item_code').val('');
                            $('#hidden_item_name').val('');
                            $('#hidden_quantity').val('');
                            $('#hidden_amount').val('');
                            $('#hidden_nuc').val('');
                            $('#hidden_rs_points').val('');
                            $('#hidden_subtotal_nuc').val('');
                            $('#hidden_subtotal_amount').val('');
                            $('#hidden_subtotal_rs_points').val(''); 

                            // update the total quantity count 
                            total_quantity_count = 0;
                            $('#total_quantity_count').text(total_quantity_count);

                        } else {
                            // Set the value to the old_transaction_type
                            // this also fixes the "Maximum call stack size exceeded" issue;
                            $('#transaction_type').val(old_transaction_type).trigger('change.select2');
                        }
                    });

                    fetch(window.location.origin + '/api/item/transaction_type/' + old_transaction_type, {
                        method: 'get',
                        headers: {
                            'Content-type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(update_item_dropdown);
            } else {
                fetch(window.location.origin + '/api/item/transaction_type/' + this.value, {
                    method: 'get',
                    headers: {
                        'Content-type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(update_item_dropdown);
            }
        });


        // item name dropdown
        $('#item_name').on('change', function() {

            var selected_item_name = $(this).find('option:selected').data('item-name');

            var item_id = this.value;

            // get the sessionStorage object
            var items = sessionStorage.getItem('item_object');

            // create object 
            obj = JSON.parse(items);

            if (typeof selected_item_name === 'string') {

                // check if the item name contains the word 'shipping' or 'freight'
                if (selected_item_name.toLowerCase().includes('shipping') || selected_item_name.toLowerCase().includes('freight')) {

                    // show the shipping fee modal amount 
                    Swal.fire({
                        title: "Shipping Fee",
                        input: "text",
                        inputLabel: "Amount",
                        inputPlaceholder: "0.00",
                        inputAttributes: {
                            maxlength: "10",
                            autocapitalize: "off",
                            autocorrect: "off"
                        },
                        showCancelButton: true,
                        allowEnterKey: false,
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        inputValidator: (value) => {
                            if (!value.trim()) {
                                return 'Please enter a valid amount';
                            }
                            // Regular expression to check if value is a valid double
                            if (!/^\d+(\.\d{1,2})?$/.test(value.trim())) {
                                return 'Please enter a valid amount (up to 2 decimal places)';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.each(obj, function(key, data) {

                                // item_id is the id of item from dropdown Item Name
                                if(item_id == data.id) {
                                    
                                    $('#quantity').val(1);
                                    $('#amount').val(result.value);
                                    $('#nuc').val(data.nuc);
                                    $('#rs_points').val(data.rs_points);

                                    // Update the amount property of the data object with result.value
                                    data.amount = result.value;

                                    // clear the sessionStorage first before assigning new values
                                    sessionStorage.removeItem("item_selected");

                                    // store the selected item to sessionStorage so the Add Item button can get the details
                                    window.sessionStorage.setItem('item_selected', JSON.stringify(data));
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            console.log('Cancelled!'); // Log a message if cancel was clicked

                            $('#quantity').val('');
                            $('#amount').val('');
                            $('#nuc').val('');
                            $('#rs_points').val('');

                            // clear the sessionStorage first before assigning new values
                            sessionStorage.removeItem("item_selected");

                            $('#item_name').val(null).trigger('change');
                        }
                    });

                } else if (selected_item_name.toLowerCase().includes('estore - clicked') || selected_item_name.toLowerCase().includes('transfer of ownership - premier')) {

                // show the shipping fee modal amount 
                Swal.fire({
                    title: "",
                    input: "text",
                    inputLabel: "Amount",
                    inputPlaceholder: "0.00",
                    inputAttributes: {
                        maxlength: "10",
                        autocapitalize: "off",
                        autocorrect: "off"
                    },
                    showCancelButton: true,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    inputValidator: (value) => {
                        if (!value.trim()) {
                            return 'Please enter a valid amount';
                        }
                        // Regular expression to check if value is a valid double
                        if (!/^\d+(\.\d{1,2})?$/.test(value.trim())) {
                            return 'Please enter a valid amount (up to 2 decimal places)';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.each(obj, function(key, data) {

                            // item_id is the id of item from dropdown Item Name
                            if(item_id == data.id) {
                                
                                $('#quantity').val(1);
                                $('#amount').val(result.value);
                                $('#nuc').val(data.nuc);
                                $('#rs_points').val(data.rs_points);

                                // Update the amount property of the data object with result.value
                                data.amount = result.value;

                                // clear the sessionStorage first before assigning new values
                                sessionStorage.removeItem("item_selected");

                                // store the selected item to sessionStorage so the Add Item button can get the details
                                window.sessionStorage.setItem('item_selected', JSON.stringify(data));
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        console.log('Cancelled!'); // Log a message if cancel was clicked

                        $('#quantity').val('');
                        $('#amount').val('');
                        $('#nuc').val('');
                        $('#rs_points').val('');

                        // clear the sessionStorage first before assigning new values
                        sessionStorage.removeItem("item_selected");

                        $('#item_name').val(null).trigger('change');
                    }
                });

            } else if (selected_item_name.toLowerCase().includes('less estore clicked')) {

                // show the shipping fee modal amount 
                Swal.fire({
                    title: "",
                    input: "text",
                    inputLabel: "Amount",
                    inputPlaceholder: "0.00",
                    inputAttributes: {
                        maxlength: "10",
                        autocapitalize: "off",
                        autocorrect: "off"
                    },
                    showCancelButton: true,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    inputValidator: (value) => {
                        if (!value.trim()) {
                            return 'Please enter a valid amount';
                        }
                        // Regular expression to check if value is a valid double
                        if (!/^\d+(\.\d{1,2})?$/.test(value.trim())) {
                            return 'Please enter a valid amount (up to 2 decimal places)';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                    let input_value = result.value.trim();
                    if (!input_value.startsWith('-')) {
                        input_value = '-' + input_value;
                    }
                    $.each(obj, function(key, data) {
                        // item_id is the id of item from dropdown Item Name
                        if(item_id == data.id) {
                            $('#quantity').val(1);
                            $('#amount').val(input_value);
                            $('#nuc').val(data.nuc);
                            $('#rs_points').val(data.rs_points);

                            // Update the amount property of the data object with input_value
                            data.amount = input_value;

                                // clear the sessionStorage first before assigning new values
                                sessionStorage.removeItem("item_selected");

                                // store the selected item to sessionStorage so the Add Item button can get the details
                                window.sessionStorage.setItem('item_selected', JSON.stringify(data));
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        console.log('Cancelled!'); // Log a message if cancel was clicked

                        $('#quantity').val('');
                        $('#amount').val('');
                        $('#nuc').val('');
                        $('#rs_points').val('');

                        // clear the sessionStorage first before assigning new values
                        sessionStorage.removeItem("item_selected");

                        $('#item_name').val(null).trigger('change');
                    }
                });
                
                } else {
                    $.each(obj, function(key, data) {

                        // item_id is the id of item from dropdown Item Name
                        if(item_id == data.id) {

                            // when shipping/freight is replaced, set the quantity field as empty so the validator will require it
                            $('#quantity').val('');

                            // DISPLAY: populate amount, nuc and rs rewards fields
                            $('#amount').val(data.amount);
                            $('#nuc').val(data.nuc);
                            $('#rs_points').val(data.rs_points);

                            // clear the sessionStorage first before assigning new values
                            sessionStorage.removeItem("item_selected");

                            // store the selected item to sessionStorage so the Add Item button can get the details
                            window.sessionStorage.setItem('item_selected', JSON.stringify(data));
                        }
                    });

                    // set the focus to quantity
                    if (item_id !== "") {
                        // async
                        setTimeout(function(){ $('#quantity').focus(); }, 100);
                    } 
                }
            }
        }); 



        // add item 
        $('#add_item').on('click', function() {

            if(item_count >= 14) { // this is actually 15, item_count starts at 0
                Swal.fire({
                    title: 'Maximum item count reached.',
                    text: 'You can no longer add new item.',
                    icon: 'warning',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
                // disable the add button

                $('#add_item').prop('disabled', true);
            }

            $('#quantity').attr('placeholder', '');

            if($('#quantity').val().length > 0 != '' && $('#quantity').val() == 0) {
                // set focus to quantity field
                $('#quantity').focus();
                // show invalid notification
                Swal.fire({
                    title: 'Invalid Quantity!',
                    icon: 'error',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
            }

            // simple validation 
            let allAreFilled = true;
            document.getElementById("form_sales_order").querySelectorAll("[required]").forEach(function(i) {
                if (!allAreFilled) return;
                if (!i.value) { 
                    allAreFilled = false;  
                    return; 
                } 
            });
            if (!allAreFilled) {
                
                // set focus to specific field
                if($.trim($("#transaction_type").val()) == "") {
                    $('#transaction_type').focus();
                    required_field('Transaction Type');
                } 
                else if($.trim($("#branch_id").val()) == "") {
                    $('#branch_id').focus();
                    required_field('Branch');
                } 
                else if($.trim($("#bcid").val()) == "") {
                    $('#bcid').focus();
                    required_field('BCID');
                }
                else if($.trim($("#distributor_name").val()) == "") {
                    $('#distributor_name').focus();
                    required_field('Distributor name');
                }
                else if($.trim($("#group_name").val()) == "") {
                    $('#group_name').focus();
                    required_field('Group');
                }

            } else {
                // make sure that item and quantity are not empty
                if($('#item_name').val().length > 0 && $('#quantity').val() != '' && $('#quantity').val() != 0) {
                    // get the quantity
                    var quantity = parseInt($('#quantity').val());

                    // add to total_quantity_count
                    total_quantity_count += quantity;

                    // update the total quantity count 
                    $('#total_quantity_count').text(total_quantity_count);

                    // clear the item name, quantity and other fields after clicking the Add Item button
                    $('#item_name').val(null).trigger('change');
                    $('#item_code').val('');
                    $('#quantity').val('');
                    $('#amount').val('');
                    $('#nuc').val('');
                    $('#rs_points').val('');

                    // get the sessionStorage object from item selected
                    var item_selected = JSON.parse(sessionStorage.getItem('item_selected'));

                    // sum of amount
                    sub_total_amount += parseInt(quantity) * parseFloat(item_selected.amount.replace(/,/g, ''));
                    $('#tfoot_subtotal_amount').val(sub_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // sum of nuc
                    total_nuc += parseInt(quantity) * item_selected.nuc;
                    $('#tfoot_total_nuc').val(total_nuc.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // sum of grand total amount
                    if(url_param == 'delivery') {
                        // get the shipping fee
                        current_shipping_fee = $('#tfoot_sf_total_amount').val();

                        grand_total_amount = parseFloat(current_shipping_fee.replace(/,/g, '')) + parseFloat(sub_total_amount);
                    } else {
                        grand_total_amount = parseFloat(sub_total_amount);
                    }
                    $('#tfoot_grand_total_amount').val(grand_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // get the computed tax values
                    vat_result = calculateVAT(grand_total_amount);
                    $('#tfoot_vatable_sales').val(vat_result.vatable_sales);
                    $('#tfoot_vat_amount').val(vat_result.vat_amount);


                    // populate the details table
                    let item_price = parseFloat(item_selected.amount.replace(/,/g, ''));

                    var row = '<tr>' + 
                                '<td class="text-center">' + item_selected.code + '</td>' +
                                '<td class="text-center">' + item_selected.name + '</td>' +
                                '<td class="text-center">' + quantity + '</td>' +
                                '<td class="text-right">' + item_price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                                '<td class="text-right">' + (item_price * quantity).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                                '<td class="text-center"><a href="#" class="btn-delete-item" data-quantity="' + quantity + '" data-amount="' + quantity * item_price + '" data-nuc="' + quantity * item_selected.nuc + '"><i class="far fa-trash-alt"></i></a></td>' +
                                // hidden elements
                                '<input type="hidden" id="hidden_item_code" name="item_code[]" value="' + item_selected.code + '" required>' + 
                                '<input type="hidden" id="hidden_item_name" name="item_name[]" value="' + item_selected.name + '" required>' + 
                                '<input type="hidden" id="hidden_quantity" name="quantity[]" value="' + quantity + '" required>' + 
                                '<input type="hidden" id="hidden_amount" name="amount[]" value="' + item_price + '" required>' + 
                                '<input type="hidden" id="hidden_nuc" name="nuc[]" value="' + item_selected.nuc + '" required>' + 
                                '<input type="hidden" id="hidden_rs_points" name="rs_points[]" value="' + item_selected.rs_points + '" required>' + 
                                // hidden elements: computed
                                '<input type="hidden" id="hidden_subtotal_nuc" name="subtotal_nuc[]" value="' + item_selected.nuc * quantity + '" required>' + 
                                '<input type="hidden" id="hidden_subtotal_amount" name="subtotal_amount[]" value="' + item_price * quantity + '" required>' + 
                                '<input type="hidden" id="hidden_subtotal_rs_points" name="subtotal_rs_points[]" value="' + item_selected.rs_points * quantity + '" required>' + 
                                '</tr>';

                    // increment the item counter
                    item_count++;

                    // append the table with dynamic rows
                    $("#table_item_details tbody").append(row);
                } else if($('#item_name').val().length == 0) {
                    Swal.fire({
                        title: 'Select an item',
                        text: 'Select an item.', 
                        allowEnterKey: false,
                        icon: 'error',
                        allowOutsideClick: false
                    });
                } else if($('#quantity').val() == '' || $('#quantity').val() == 0) {
                    Swal.fire({
                        title: 'Invalid quantity',
                        text: 'Add quantity.', 
                        allowEnterKey: false,
                        icon: 'error',
                        allowOutsideClick: false
                    });
                } else {
                    Swal.fire({
                        title: 'Please add an item',
                        text: 'Select an item and add quantity.', 
                        allowEnterKey: false,
                        icon: 'error',
                        allowOutsideClick: false
                    });
                }
            }
        }); 

        // delete row
        $(document).on('click','.btn-delete-item', function() {

            // get the data to be subtracted
            var quantity = $(this).attr("data-quantity");
            var amount = $(this).attr("data-amount");
            var nuc = $(this).attr("data-nuc");

            // deduct the quantity to total_quantity_count
            total_quantity_count -= quantity;

            // get the current sub total amount value
            var current_sub_total_amount = $('#tfoot_subtotal_amount').val();

            // get the current grand total amount value
            var current_grand_total_amount = $('#tfoot_grand_total_amount').val();

            // get the current shipping fee value
            var current_shipping_fee = $('#tfoot_sf_total_amount').val();

            // show notification
            Swal.fire({
                title: 'Are you sure you want to remove this item?',
                icon: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // subtract the amount to sub_total_amount, total_nuc and grand_total_amount
                    sub_total_amount = parseFloat(sub_total_amount) - parseFloat(amount.replace(/,/g, ''));

                    if(!isNaN(sub_total_amount)) {
                        $('#tfoot_subtotal_amount').val(sub_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    } else {
                        $('#tfoot_subtotal_amount').val("0.00");
                    }

                    total_nuc = parseFloat(total_nuc) - parseFloat(nuc.replace(/,/g, ''));
                    if(!isNaN(total_nuc)) {
                        $('#tfoot_total_nuc').val(total_nuc.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    } else {
                        $('#tfoot_total_nuc').val("0.00");
                    }

                    grand_total_amount = parseFloat(current_grand_total_amount.replace(/,/g, '')) - parseFloat(amount.replace(/,/g, ''));
                    $('#tfoot_grand_total_amount').val(grand_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // get the computed tax values
                    vat_result = calculateVAT(grand_total_amount);
                    $('#tfoot_vatable_sales').val(vat_result.vatable_sales);
                    $('#tfoot_vat_amount').val(vat_result.vat_amount);

                    // update the item count
                    item_count--;

                    // remove the row
                    this.closest('tr').remove();

                    // show confirmation
                    Swal.fire({
                        title: 'Removed!',
                        text: 'Item has been removed.',
                        icon: 'success',
                        allowEnterKey: false,
                        allowOutsideClick: false
                    });
                    
                    if(item_count <= 14) { // this is actually 15, item_count starts at 0
                        $('#add_item').prop('disabled', false);
                    }

                    // update the total quantity count 
                    $('#total_quantity_count').text(total_quantity_count);

                }
            });
            
        });


        $('#quantity, #bcid').on('input', function(e) {    
            const inputValue = e.target.value;
            const numericValue = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            e.target.value = numericValue;
        });

        $('#quantity').bind('copy paste', function (e) {
            e.preventDefault();
            $('#quantity').attr('maxlength','6');
        });


        $('#tfoot_subtotal_amount').each(function(){ // To loop on each value
            var amount = parseFloat($(this).html()); // Convert string into float number
            var newamount = amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); // add comma
            $(this).html(newamount); // replace old number with new number
        });


        // =========== START OF SHIPPING FEE MODAL ===========

        // if sf_amount field is empty, then disable the save button
        $("#modal_select_sf").on('change', function() {
            if($(this).val() != '') {
                $('#btn-add-sf').prop('disabled', false);
            } else {
                $('#btn-add-sf').prop('disabled', true);
            }
        });

        // open the modal shipping fee
        $('#sf_checkbox').on('click', function() {
            var current_shipping_fee = $('#tfoot_sf_total_amount').val();
            if ($(this).prop('checked')) {
                $("#modal-add-sf").modal('show');
            } else {
                // set the shipping value zero
                const zero_value = 0;
                $('#tfoot_sf_total_amount').val(zero_value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                // update the grand total amount
                var current_grand_total_amount = $('#tfoot_grand_total_amount').val();
                var grand_total_amount = parseFloat(current_grand_total_amount.replace(/,/g, '')) - parseFloat(current_shipping_fee.replace(/,/g, ''));
                $('#tfoot_grand_total_amount').val(grand_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                // get the computed tax values
                vat_result = calculateVAT(grand_total_amount);
                $('#tfoot_vatable_sales').val(vat_result.vatable_sales);
                $('#tfoot_vat_amount').val(vat_result.vat_amount);
            }
        });

        // uncheck sf_checkbox on modal close event
        $("#modal-add-sf").on('hide.bs.modal', function() {
            $('#sf_checkbox').prop('checked', false);
        });

        // this is the modal shipping fee dropdown / select option
        $('#modal_select_sf').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var parcel_rate = selectedOption.data('parcel-rate');
            $('#modal_sf_amount').val(parcel_rate);
        });  
        
        // add shipping fee amount
        $('#btn-add-sf').on('click', function() {
            var shipping_amount = $('#modal_sf_amount').val();
            $('#tfoot_sf_total_amount').val(shipping_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#modal-add-sf').modal('hide');
            // $('#sf_checkbox').prop('disabled', true);
            $('#sf_checkbox').prop('checked', true);
      
            // update the grand total amount
            var current_grand_total_amount = $('#tfoot_grand_total_amount').val();
            var grand_total_amount = parseFloat(current_grand_total_amount.replace(/,/g, '')) + parseFloat(shipping_amount.replace(/,/g, ''));
            $('#tfoot_grand_total_amount').val(grand_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

            // get the computed tax values
            vat_result = calculateVAT(grand_total_amount);
            $('#tfoot_vatable_sales').val(vat_result.vatable_sales);
            $('#tfoot_vat_amount').val(vat_result.vat_amount);
        });

        // =========== END OF SHIPPING FEE MODAL ===========


        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#btn_cancel_so').on('click', function() {

            // show the confirmation
            Swal.fire({
                title: 'Cancel Transaction?',
                    text: 'All unsaved progress will be lost.',
                    icon: 'warning',
                    showCancelButton: true,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/sales-orders";
                }
            }
        );

    });


    $('#btn_save_so').on('click', function(e) {
        // prevent auto submit
        e.preventDefault();

        // simple validation 
        let allAreFilled = true;

        document.getElementById("form_sales_order").querySelectorAll("[required]").forEach(function(i) {
            if (!allAreFilled) return;
            if (!i.value) { 
                allAreFilled = false;  
                return; 
            } 
            else if(url_param == 'delivery' && $('#tfoot_sf_total_amount').val() == 0) {
                allAreFilled = false;
                return;
            }
        });

        if (!allAreFilled) {

            // set focus to specific field
            if($.trim($("#transaction_type").val()) == "") {
                $('#transaction_type').focus();
                required_field('Transaction Type');
            } 
            else if($.trim($("#branch_id").val()) == "") {
                $('#branch_id').focus();
                required_field('Branch');
            } 
            else if($.trim($("#bcid").val()) == "") {
                $('#bcid').focus();
                required_field('BCID');
            }
            else if($.trim($("#distributor_name").val()) == "") {
                $('#distributor_name').focus();
                required_field('Distributor name');
            }
            else if($.trim($("#group_name").val()) == "") {
                $('#group_name').focus();
                required_field('Group');
            }

            // check if item count equals to zero before checking the shipping fee
            else if(item_count == 0) {
                Swal.fire({
                    title: 'Please add an item',
                    text: 'Select an item and add quantity.', 
                    icon: 'error',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
            }
            else if(url_param == 'delivery' && $('#tfoot_sf_total_amount').val() == 0) {
                required_field('Shipping Fee');
            }
        } 

        // lets check if there is/are actual item(s) in the details table before submitting
        // use `if else` statement to support older browser
        else if(item_count > 0) {
            Swal.fire({
                title: 'Are you sure you want to save this sales order?',
                icon: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_sales_order').submit();
                }
            });
        } else {
            // show error
            Swal.fire({
                title: 'Please add an item',
                text: 'Select an item and add quantity.', 
                icon: 'error',
                allowEnterKey: false,
                allowOutsideClick: false
            });
        }
    });

    


    function required_field(field) {
        Swal.fire({
            title: field + ' is required',
            icon: 'error',
            allowEnterKey: false,
            allowOutsideClick: false
        });
    }

    function calculateVAT(salesAmount) {
        // Calculate VATable Sales
        let vatable_sales = parseFloat(salesAmount) / 1.12; 

        // Calculate VAT Amount
        let vat_amount = parseFloat(vatable_sales) * 0.12;

        // Calculate the difference between salesAmount and the sum of vatable_sales and vat_amount
        const difference = parseFloat(salesAmount) - (vatable_sales + vat_amount);

        // Round vat_amount to account for the difference
        vat_amount += difference;

        // Return an object with both results
        return {
            vatable_sales: vatable_sales.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
            vat_amount: vat_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        };
    }

    // check if url contains parameter e.g. 'so'
    function getUrlParameter(parameterName) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(parameterName);
    }

    // Prevent user from using enter key
    $("input:text").keypress(function(event) {
        if (event.keyCode === 10 || event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#btn_save_so, #add_item, #btn_cancel_so').keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
        }
    });


    // =========== START OF NEW SIGN UP ===========
    $('#checkbox_new_signup').on('click', function() {
        if (this.checked) {
            // disable add button
            $('#btn-add-new-signup').attr('disabled', true);
            $('#modal-add-new-signup').modal('show');
        } else {
            // remove the name
            $('#span_signee_name').text('');
            // remove to form hidden field
            $('#signee_name').val('');
        }
    });

    $('#modal_new_signup_name').on('keyup', function(e) {
        var char_code = e.which || e.keyCode;

        if (!((char_code >= 65 && char_code <= 90) || (char_code >= 97 && char_code <= 122) || char_code === 32 || char_code === 8)) {
            e.preventDefault();

            this.value = this.value.replace(/[^a-zA-Z ]/g, '');
        }

        if(this.value.length > 3) {
            // enable add button
            $('#btn-add-new-signup').prop('disabled', false);
        } else {
            // disable add button
            $('#btn-add-new-signup').prop('disabled', true);
        }
        
    });

    $('#btn-add-new-signup').on('click', function() {
        // get the value
        let signee_name = $('#modal_new_signup_name').val();
        // add the signee name to label
        $('#span_signee_name').text(signee_name.toUpperCase());
        // add to form hidden field
        $('#signee_name').val(signee_name.toUpperCase());
        // close the modal
        $('#modal-add-new-signup').modal('hide');
        // retain the check
        $('#checkbox_new_signup').prop('checked', true);
    });

    $('#btn-new-signup-cancel').on('click', function() {
        // remove the value
        $('#modal_new_signup_name').val('');
        // uncheck the checkbox
        $('#checkbox_new_signup').prop('checked', false);
    });

    $('#modal-add-new-signup').on('hide.bs.modal', function (e) {
        // Check if the close button (x button) was clicked
        if (e.target === this) {
            // remove the value
            $('#modal_new_signup_name').val('');
            // uncheck the checkbox
            $('#checkbox_new_signup').prop('checked', false);
        } 
    });
    
    // =========== END OF NEW SIGN UP ===========





    // =========== START OF ORIGIN ===========
    $('#checkbox_origin').on('click', function() {
        if (this.checked) {
            // disable add button
            $('#btn-add-origin').attr('disabled', true);
            $('#modal-add-origin').modal('show');
        } else {
            // remove the origin
            $('#span_origin').text('');
            // remove to form hidden field
            $('#origin_id').val('');
        }
    });

    $('#modal-select-origin-id').on('change', function() {
        if(this.value != '') {
            // enable add button
            $('#btn-add-origin').attr('disabled', false);
        } else {
            // disable add button
            $('#btn-add-origin').attr('disabled', true);
        }
    });

    $('#btn-add-origin').on('click', function() {
        // get the value
        let origin_id = $('#modal-select-origin-id').val();
        let origin_name = $('#modal-select-origin-id').select2('data')[0].text;
        // add the origin name to label
        $('#span_origin').text(origin_name);
        // add to form hidden field
        $('#origin_id').val(origin_id);
        // close the modal
        $('#modal-add-origin').modal('hide');
        // retain the check
        $('#checkbox_origin').prop('checked', true);
    });

    $('#btn-origin-cancel').on('click', function() {
        // select the null from dropdown
        $('#modal-select-origin-id').val($('#modal-select-origin-id option:first').val()).trigger('change');
        // uncheck the checkbox
        $('#checkbox_origin').prop('checked', false);
    });

    $('#modal-add-origin').on('hide.bs.modal', function (e) {
        // Check if the close button (x button) was clicked
        if (e.target === this) {
            // select the null from dropdown
            $('#modal-select-origin-id').val($('#modal-select-origin-id option:first').val()).trigger('change');
            // uncheck the checkbox
            $('#checkbox_origin').prop('checked', false);
        } 
    });

    // =========== END OF ORIGIN ===========


    $('#quantity').on('focus', function() {
        let item_id = $('#item_name').val();
        let branch_id = $('#branch_id').val();

        fetch(window.location.origin + '/api/item/stock_by_warehouse/' + item_id + '/' + branch_id, {
            method: 'get',
            headers: {
                'Content-type': 'application/json',
            }
        })
        .then(response => response.json())
        .then((response) => {
            obj = JSON.parse(JSON.stringify(response));
            $(this).attr('placeholder', obj.total_quantity + ' In Stock');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    $('#quantity').on('blur', function() {
        $(this).attr('placeholder', '');
    });
});
</script>
@endsection