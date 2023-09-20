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
                        {{-- <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <div class="checkbox"> 
                                    <label class="checkbox-custom"> 
                                    <input type="checkbox" name="clases" id="sf_checkbox" value="yes">
                                    <i class="fa fa-fw fa-square-o"></i>With Shipping Fee?
                                    </label> 
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">BCID&nbsp;<span class="required"></span></span>
                                </div>
                                <input type="number" class="form-control form-control-sm" id="bcid" min="0" maxlength="12" name="bcid" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" disabled>
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
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <input type="hidden" class="form-control form-control-sm" id="company" name="company" value="UNO International Corp.">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-4">
                            <label for="item_name">Item Name</label>
                            <select class="form-control form-control-sm select2 select2-primary" id="item_name" data-dropdown-css-class="select2-primary " disabled>
                            </select>
                        </div>
                        <div class="col-md-1 col-2">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control form-control-sm" min="1" id="quantity" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" disabled>
                        </div>
                        <div class="col-md-1 col-2">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control form-control-sm" id="amount" disabled>
                        </div>
                        <div class="col-md-1 col-2">
                            <label for="nuc">NUC</label>
                            <input type="text" class="form-control form-control-sm" id="nuc" disabled>
                        </div>
                        <div class="col-md-2 col-2">
                            <div class="checkbox"> 
                                <label class="checkbox">
                                <input type="checkbox" name="sf_checkbox" id="sf_checkbox" value="yes" disabled>  With Shipping Fee?
                                <span class="required"></span>
                                <input type="text" class="form-control form-control-sm text-right" id="shipping_fee" style="margin-top: 8px" name="shipping_fee" placeholder="0.00" maxlength="12" value="0.00" readonly>
                            </div>
                        </div>
                        <div class="col-md-1 col-2 d-none">
                            <label for="rs_points">RS Points</label>
                            <input type="text" class="form-control form-control-sm" id="rs_points" disabled>
                        </div>
                        <div class="col-md-1 col-2">
                            <input type="button" class="btn btn-primary btn-sm" id="add_item" value="Add Item" style="margin-top: 29px">
                        </div>
                    </div>
                

                    {{-- details --}}
                    <div class="row mt-5">
                        <div class="col-12">
                            <table class="table table-bordered table-hover" id="table_item_details">
                                <thead>
                                    <tr>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center" style="width:125px">Quantity</th>
                                        <th class="text-center" style="width:135px">Amount</th>
                                        <th class="text-center" style="width:155px">Subtotal</th>
                                        <th class="text-center" style="width:125px">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right text-bold">Total</td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right text-bold" id="tfoot_total_amount"></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-primary btn-lg m-2" id="btn_save_so"><i class="fas fa-save mr-2"></i>Save Sales Order</button>
                        </div>
                    </div>

                    {{-- temporary --}}
                    <input type="hidden" name="hidden_total_amount" id="hidden_total_amount">
                    <input type="hidden" name="hidden_total_nuc" id="hidden_total_nuc">
                    <input type="hidden" name="hidden_grandtotal_amount" id="hidden_grandtotal_amount">

                </form>
            </div>    
        </div>
    </div>
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

        // set shipping fee to enable
        $("#sf_checkbox").on('click', function () {
        $("#shipping_fee").attr('readonly', false);
        $('#shipping_fee').attr('readonly',!this.checked);
        $('#shipping_fee').val('',!this.checked)
        });
 
        // set shipping fee to disable on focus out
        $("#shipping_fee").on('focusout', function () {
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
            $(this).attr('readonly', true);
        });
 
        // set shipping fee input to two decimal places  
        $('#shipping_fee').on('input', function () {
        this.value = this.value.match(/^\d+\.?\d{0,2}/);
        });
        
        // initialize total amount nuc grandtotal and shipping fee
        var grandtotal_amount = 0;
        var shipping_fee = 0;
        var total_amount = 0;
        var total_nuc = 0;

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
                else if($.trim($("#company").val()) == "") {
                    $('#company').focus();
                    required_field('Company');
                }
            } else {
                // make sure that item and quantity are not empty
                if($('#item_name').val().length > 0 && $('#quantity').val() != '' && $('#quantity').val() != 0) {
                    // get the quantity
                    var quantity = $('#quantity').val();

                    // clear the item name, quantity and other fields after clicking the Add Item button
                    $('#item_name').val(null).trigger('change'); // this is for select2 type dropdown only
                    $('#quantity').val('');
                    $('#amount').val('');
                    $('#nuc').val('');
                    $('#rs_points').val('');

                    // get the sessionStorage object from item selected
                    var item_selected = JSON.parse(sessionStorage.getItem('item_selected'));

                    // sum of amount
                    total_amount += quantity * item_selected.amount;
                    $('#tfoot_total_amount').text(total_amount.toFixed(2));
                    // sum of nuc
                    total_nuc += quantity * item_selected.nuc;
                    $('#tfoot_total_nuc').text(total_nuc.toFixed(2));

                    // sum of grand total
                    shipping_fee = Number($('#shipping_fee').val());
                    grandtotal_amount = total_amount + shipping_fee;

                    // temporary 
                    $('#hidden_total_amount').val(total_amount.toFixed(2));
                    $('#hidden_total_nuc').val(total_nuc.toFixed(2));
                    $('#hidden_grandtotal_amount').val(grandtotal_amount.toFixed(2));

                    // populate the details table
                    var row = '<tr>' + 
                                '<td>' + item_selected.name + '</td>' +
                                '<td class="text-center">' + quantity + '</td>' +
                                '<td class="text-right">' + item_selected.amount + '</td>' +
                                // '<td class="text-right">' + item_selected.nuc + ' (' + (item_selected.nuc * quantity).toFixed(2) + ')' +'</td>' +
                                // '<td class="text-right">' + item_selected.rs_points + '</td>' +
                                '<td class="text-right">' + (item_selected.amount * quantity).toFixed(2) + '</td>' +
                                '<td class="text-center"><a href="#" class="btn-delete-item" data-quantity="' + quantity + '" data-amount="' + quantity * item_selected.amount + '" data-nuc="' + quantity * item_selected.nuc + '"><i class="far fa-trash-alt"></i></a></td>' +

                                // hidden elements
                                '<input type="hidden" name="item_name[]" value="' + item_selected.name + '" required>' + 
                                '<input type="hidden" name="quantity[]" value="' + quantity + '" required>' + 
                                '<input type="hidden" name="amount[]" value="' + item_selected.amount + '" required>' + 
                                '<input type="hidden" name="nuc[]" value="' + item_selected.nuc + '" required>' + 
                                '<input type="hidden" name="rs_points[]" value="' + item_selected.rs_points + '" required>' + 
                                // hidden elements: computed
                                '<input type="hidden" name="subtotal_nuc[]" value="' + (item_selected.nuc * quantity).toFixed(2) + '" required>' + 
                                '<input type="hidden" name="subtotal_amount[]" value="' + (item_selected.amount * quantity).toFixed(2) + '" required>' + 
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

                    // subtract the amount and nuc
                    total_amount = total_amount - amount;
                    $('#tfoot_total_amount').text(total_amount.toFixed(2));

                    total_nuc = total_nuc - nuc;
                    $('#tfoot_total_nuc').text(total_nuc.toFixed(2));

                    // update the item count
                    item_count--;

                    // remove the row
                    this.closest('tr').remove();

                    // show confirmation
                    Swal.fire(
                        'Removed!',
                        'Item has been removed.',
                        'success'
                    )
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
    });
</script>
@endsection