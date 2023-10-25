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
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Transaction Type</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="transaction_type" name="transaction_type_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                    <option value="" selected="true" disabled>-- Select Transaction Type --</option>
                                    @foreach($transaction_types as $transaction_type)
                                        <option value="{{ $transaction_type->id }}">{{ $transaction_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="branch_id" name="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required {{ count($branches) > 1 ? '':'readonly' }}>
                                    @if(count($branches) > 1)
                                        <option value="" selected="true" disabled>-- Select Branch --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">BCID&nbsp;<span class="required"></span></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="bcid" min="0" maxlength="12" name="bcid" disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">Name&nbsp;<span class="required"></span></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="distributor_name" name="distributor_name" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">Group&nbsp;<span class="required"></span></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="group_name" name="group_name" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 col-2 d-none">
                            <label for="rs_points">Item Code</label>
                            <input type="text" class="form-control form-control-sm" id="item_code" disabled>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="item_name">Item Name</label>
                            <select class="form-control form-control-sm select2 select2-primary" id="item_name" data-dropdown-css-class="select2-primary " disabled>
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
                                        <td class="text-right text-bold" colspan="4">Sub Total</td>
                                        <td class="text-right text-bold">
                                            <input type="text" class="text-right custom-input-text" name="total_amount" id="tfoot_subtotal_amount" value="0.00" readonly>
                                        </td>
                                    </tr>
                                    @if(Request::get('so') == 'delivery')
                                        <tr>
                                            <td class="text-right text-bold" colspan="4">
                                                <input type="checkbox" name="sf_checkbox" id="sf_checkbox" data-toggle="modal" disabled/>
                                                <span class="ml-1">Shipping Fee</span>
                                            </td>
                                            <td class="text-right text-bold">
                                                <input type="text" class="text-right custom-input-text" name="shipping_fee" id="tfoot_sf_total_amount" value="0.00" readonly/>
                                            </td>
                                        </tr>
                                    @endif
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
                            <button class="btn btn-primary btn-lg m-2 " id="btn_save_so"><i class="fas fa-save mr-2"></i>Save Sales Order</button>
                        </div>
                    </div>
            </div>    
        </div>
    </div>

    <div class="modal fade" id="modal-add-sf">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Shipping Fee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="form-group">
                                <label for="modal_select_sf">Parcel Size and Region</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="modal_select_sf" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option value="" selected="true" disabled>-- Select Size and Region --</option>
                                    @foreach($shipping_fees as $shipping_fee)
                                        <option value="{{ $shipping_fee->id }}" data-parcel-rate="{{ $shipping_fee->parcel_rate }}">{{ $shipping_fee->parcel_size}} - {{ $shipping_fee->region}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">    
                            <div class="form-group">
                                <label for="modal_sf_amount">Shipping Fee Amount</label>
                                <input type="text" class="form-control form-control-sm" id="modal_sf_amount" style="text-align:right;" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                    <input type="button" class="btn btn-primary btn-sm m-2" id="btn-add-sf" value="Save">
                </div>
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
  background-color: #ffffff;
}

/* Apply styles to odd rows */
tbody tr:nth-child(odd) {
  background-color: #f2f2f2;
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

        // initialize item counter: this will trigger if there is/are items in the table; This will be used by btn-delete-item AND transaction_type change event 
        var item_count = 0;

        // default state
        var old_transaction_type = 0;
        var change_count = 0;

        // initialize total amount nuc grandtotal and shipping fee
        var sub_total_amount = 0;
        var total_nuc = 0;
        var modal_sf_amount = 0;
        var shipping_fee = 0;
        var grand_total_amount = 0;


        // check if SO is for delivery
        let url_param = getUrlParameter('so');
        // mark the tfoot_sf_total_amount field as required
        if(url_param == 'delivery') {
            $('#tfoot_sf_total_amount').prop('required', true);
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

            // check if there is/are item(s) in the details table
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
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // just refresh the page and remove all existing data; no longer needed to remove all data from elements
                        location.reload();
                    } 
                });

                $(this).select2('val', old_transaction_type);
            }

            if(this.value !== '') {
                fetch(window.location.origin + '/api/item/transaction_type/' + this.value, {
                    method: 'get',
                    headers: {
                        'Content-type': 'application/json',
                    }

                })
                .then(response => response.json())
                .then((response) => {
                    obj = JSON.parse(JSON.stringify(response));
                    $('#bcid').attr('disabled', false);
                    // make sure the select element is empty before populating with values
                    $('#item_name').empty();
                    // add blank as first value
                    $('#item_name').append($('<option></option>').val('').html('-- Select Item --'));
                    // add some values to item dropdown element
                    $.each(obj, function(key, data) {
                        $('#item_name').append($('<option></option>').val(data.id).html(data.name));
                    });

                    // clear the sessionStorage first before storing another obj
                    sessionStorage.clear();

                    // store the `obj` to sessionStorage
                    window.sessionStorage.setItem('item_object', JSON.stringify(obj));
                })
            }
        });

        // fetch the distributor's name by bcid using FETCH API
        $('#bcid').on('focusout', function() {
            if(this.value !== "" || this.value.length !== 0) {

                // add leading zero's to bcid
                let bcid = $(this).val().toString().padStart(12, '0')

                fetch(window.location.origin + '/api/distributor/' + bcid, {
                    method: 'get',
                    headers: {
                        'Content-type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then((response) => {
                    obj = JSON.parse(JSON.stringify(response));
                    if(obj[0] == undefined) {
                        // show modal bcid not found
                        Swal.fire({
                            title: 'BCID not found!',
                            icon: 'error',
                        });
                        // remove name field content
                        $('#distributor_name').val('');
                        $('#group_name').val('');

                    } else {
                        if(obj[0].name != '') {
                            $('#distributor_name').val(obj[0].name);
                            $('#group_name').val(obj[0].group);
                            $('#bcid').attr('readonly','readonly');
                            $('#item_name').attr('disabled', false);
                            $('#quantity').attr('disabled', false);
                            $('#sf_checkbox').attr('disabled', false);
                        } else {
                            $('#distributor_name').val('');
                            $('#group_name').val('');
                        }
                    }
                })
                .catch(err => console.error(err));
            } else {
                // be sure to empty the name field
                $('#distributor_name').val('');
                $('#group_name').val('');
            }
        });

        // item name dropdown
        $('#item_name').on('change', function() {
            var item_id = this.value;

            // get the sessionStorage object
            var items = sessionStorage.getItem('item_object');

            // create object 
            obj = JSON.parse(items);

            $.each(obj, function(key, data) {
                // item_id is the id of item from dropdown Item Name
                if(item_id == data.id) {

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
        }); 

        // add item 
        $('#add_item').on('click', function() {

            if($('#quantity').val().length > 0 != '' && $('#quantity').val() == 0) {
                // set focus to quantity field
                $('#quantity').focus();
                // show invalid notification
                Swal.fire({
                    title: 'Invalid Quantity!',
                    icon: 'error',
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
                                '<td>' + item_selected.code + '</td>' +
                                '<td class="text-center">' + item_selected.name + '</td>' +
                                '<td class="text-center">' + quantity + '</td>' +
                                '<td class="text-right">' + item_price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                                '<td class="text-right">' + (item_price * quantity).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                                '<td class="text-center"><a href="#" class="btn-delete-item" data-quantity="' + quantity + '" data-amount="' + quantity * item_price + '" data-nuc="' + quantity * item_selected.nuc + '"><i class="far fa-trash-alt"></i></a></td>' +
                                // hidden elements
                                '<input type="hidden" name="item_code[]" value="' + item_selected.code + '" required>' + 
                                '<input type="hidden" name="item_name[]" value="' + item_selected.name + '" required>' + 
                                '<input type="hidden" name="quantity[]" value="' + quantity + '" required>' + 
                                '<input type="hidden" name="amount[]" value="' + item_price + '" required>' + 
                                '<input type="hidden" name="nuc[]" value="' + item_selected.nuc + '" required>' + 
                                '<input type="hidden" name="rs_points[]" value="' + item_selected.rs_points + '" required>' + 
                                // hidden elements: computed
                                '<input type="hidden" name="subtotal_nuc[]" value="' + item_selected.nuc * quantity + '" required>' + 
                                '<input type="hidden" name="subtotal_amount[]" value="' + item_price * quantity + '" required>' + 
                                '</tr>';

                    // increment the item counter
                    item_count++;

                    // append the table with dynamic rows
                    $("#table_item_details tbody").append(row);
                } else if($('#item_name').val().length == 0) {
                    Swal.fire({
                        title: 'Select an item',
                        text: 'Select an item.', 
                        icon: 'error',
                    });
                } else if($('#quantity').val() == '' || $('#quantity').val() == 0) {
                    Swal.fire({
                        title: 'Invalid quantity',
                        text: 'Add quantity.', 
                        icon: 'error',
                    });
                } else {
                    Swal.fire({
                        title: 'Please add an item',
                        text: 'Select an item and add quantity.', 
                        icon: 'error',
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // subtract the amount to sub_total_amount, total_nuc and grand_total_amount
                    sub_total_amount = parseFloat(sub_total_amount) - parseFloat(amount.replace(/,/g, ''));
                    console.log(sub_total_amount);
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
                        icon: 'success'
                    });
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "/sales-orders";
            }
        });
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
                });
            }
        });

        function required_field(field) {
            Swal.fire({
                title: field + ' is required',
                icon: 'error',
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

    });
</script>
@endsection