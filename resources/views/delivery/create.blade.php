@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New Delivery</h1>
            </div>                           
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Tab Content -->
        <form class="tab-content" action="{{ route('delivery-management.store') }}" method="POST" id="form_delivery" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <h5>Order Details</h5>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">Delivery Status&nbsp;<span></span></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="delivery_status" value="New" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">Payment Status&nbsp;<span></span></span>
                                </div>
                                <span class="form-control form-control-sm" id="payment_status" readonly>
                                    @foreach($payment_status as $p_status)
                                        @if($p_status->id == 1)
                                            {{ $p_status->name }}
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <label for="last_name" data-required="true">Customer Store Name</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="add_customers" name="store_name" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                    <option value="" selected disabled class="text-center">---- Select Customer ----</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->name }}" 
                                        data-proprietor="{{ $customer->proprietor }}"
                                        data-address="{{ $customer->address }}"
                                        data-zip_code="{{ $customer->zip_code }}"
                                        data-srp_type="{{ $customer->srp_types->name ?? null }}"
                                        data-category="{{ $customer->customer_categories->name ?? null }}"
                                        data-area_group="{{ $customer->area_groups->name ?? null}}"
                                        >{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <input type="text" class="form-control form-control-sm d-none" name="address" id="add_address" readonly>
                        <div class="col-md-2">
                            <div>
                                <label for="nationality">SRP Type</label>
                                <input type="text" class="form-control form-control-sm" name="srp_type" maxlength="25" id="add_srp_type" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <label for="religion">Customer Category</label>
                                <input type="text" class="form-control form-control-sm" name="customer_category" maxlength="25" id="add_category" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <label for="nationality">Area Group</label>
                                <input type="text" class="form-control form-control-sm" name="area_group" maxlength="25" id="add_area_group" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label data-required="true">Delivery Date:</label>
                                <div class="input-group date" id="new_delivery_date" data-target-input="nearest">
                                    <input type="text" name="delivery_date" id="delivery_date" class="form-control form-control-sm datetimepicker-input" data-target="#new_delivery_date" disabled required/>
                                    <div class="input-group-append" data-target="#new_delivery_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <label for="middle_name" data-required="true">Payment Terms</label>
                                <select class="form-control form-control-sm" name="payment_terms" id="add_payment_terms" disabled required>
                                    <option value="" selected disabled>-- Select --</option>
                                    @foreach($payment_terms as $payment_term)
                                        <option value="{{ $payment_term->name }}">{{ $payment_term->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Due Date:</label>
                                <div class="input-group date" id="new_due_date" data-target-input="nearest">
                                    <input type="text" name="due_date" id="due_date" class="form-control form-control-sm datetimepicker-input" data-target="#new_due_date" disabled required/>
                                    <div class="input-group-append" data-target="#new_due_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <label for="middle_name" data-required="true">Delivered By</label>
                                <select class="form-control form-control-sm" name="delivered_by" id="add_drivers" disabled required>
                                    <option value="" selected disabled>-- Select Driver --</option>
                                    @foreach($employees as $employee)
                                        @if($employee->role_id == 4)
                                            <option value="{{ $employee->full_name }}">{{ $employee->full_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <label for="middle_name" data-required="true">Agents</label>
                                <select class="form-control form-control-sm" name="agents" id="add_agents" disabled required>
                                    <option value="" selected disabled>-- Select Agent --</option>
                                    @foreach($employees as $employee)
                                        @if($employee->role_id == 5)
                                            <option value="{{ $employee->full_name }}">{{ $employee->full_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label for="nationality">Delivery Remarks</label>
                                <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <h5>Order Items</h5>
                    <input type="hidden" name="tfoot_total_nuc" id="tfoot_total_nuc" value="0"/>
                    <input type="hidden" name="total_quantity" id="total_quantity" value="0"/>
                    <input type="hidden" name="add_discount" id="add_discount_percent" value="0"/>
                    <input type="hidden" name="add_discount_value" id="add_discount_value" value="0"/>
                <div class="row">
                    <div class="col-md-1 col-2 d-none">
                        <label for="rs_points">Item Code</label>
                        <input type="text" class="form-control form-control-sm" id="add_code" disabled>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label for="item_name" data-required="true">Product Name</label>
                        <select class="form-control form-control-sm select2 select2-primary" id="item_name" data-dropdown-css-class="select2-primary " style="width:100%;" disabled required>
                        <option value="" selected disabled class="text-center">---- Select Product ----</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                    data-code="{{ $product->code }}"
                                    data-name="{{ $product->name }}"
                                    data-pack_size="{{ $product->pack_size }}"
                                    data-size_in_kg="{{ $product->size_in_kg }}"
                                    data-packs_per_case="{{ $product->packs_per_case }}"
                                    data-upc="{{ $product->upc }}"
                                    data-orig_srp="{{ $product->orig_srp }}"
                                    data-spec_srp="{{ $product->spec_srp }}"
                                    >{{ $product->description }}</option>
                                @endforeach    
                    </select>
                    </div>
                    <div class="col-xl-1 col-md-2">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control form-control-sm" maxlength="6" id="quantity" placeholder="0" required disabled>
                    </div>
                    <div class="col-xl-2 col-md-3">
                        <label for="quantity">Item Discount</label>
                        <input type="text" class="form-control form-control-sm" maxlength="6" id="item_discount" placeholder="0" disabled>
                    </div>
                    <div class="col-xl-1 col-md-2">
                        <label for="rs_points">Amount</label>
                        <input type="text" class="form-control form-control-sm" id="amount" placeholder="0.00" disabled>
                    </div>
                    <div class="col-xl-1 col-md-3">
                        <label for="rs_points">Pack Size</label>
                        <input type="text" class="form-control form-control-sm" id="pack_size" disabled>
                    </div>

                    <input type="hidden" class="form-control form-control-sm" id="size_in_kg">

                    <div class="col-md-2 col-3 d-none">
                        <label for="rs_points">Packs Per Case</label>
                        <input type="text" class="form-control form-control-sm" id="add_packs_per_case" disabled>
                    </div>
                    <div class="col-xl-1 col-md-2">
                        <input type="button" class="btn btn-primary btn-sm" id="add_item" value="Add Item" style="margin-top: 29px" disabled>
                    </div>
                </div>
            
                {{-- details --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <table class="table table-bordered table-hover" id="table_item_details">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Pack Size</th>
                                    <th class="text-center" style="width:9%">Item Discount</th>
                                    <th class="text-center" style="width:9%">Quantity</th>
                                    <th class="text-center" style="width:12%">Price</th>
                                    <th class="text-center" style="width:12%">Amount</th>
                                    <th class="text-center" style="width:8%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right text-bold" colspan="3">&nbsp;</td>
                                    <td class="text-right text-bold text-center"><span id="total_quantity_count">0</span></td>
                                    <td class="text-right text-bold">Sub Total</td>
                                    <td class="text-right text-bold">
                                        <input type="text" class="text-right custom-input-text" name="total_amount" id="tfoot_subtotal_amount" value="0.00" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="5">
                                        <span class="ml-1">Discount Value</span>
                                    </td>
                                    <td class="text-right text-bold">
                                        <input type="text" class="text-right custom-input-text" id="tfoot_add_discount_total_amount" value="0.00" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="5">Grand Total</td>
                                    <td class="text-right text-bold">
                                        <input type="text" class="text-right custom-input-text text-bold" name="grandtotal_amount" id="tfoot_grand_total_amount" value="0.00" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkbox_add_discount" disabled>
                                <label for="checkbox_add_discount">Add Discount:</label>
                                <span class="ml-2" id="span_discount_percent"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12">
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkbox_remarks">
                                <label for="checkbox_remarks">Delivery Remarks:</label>
                                <span class="ml-2" id="span_remarks"></span>
                            </div>
                        </div>
                    </div> -->
                </div>
                </div>
            </div>    
            <!-- Common Form Footer -->
            <div class="row">
                <div class="col-12 text-center">
                    <input type="button" value="Cancel" id="btn_cancel_so" class="btn btn-lg btn-danger">
                    <button class="btn btn-primary btn-lg m-2 " id="btn_save_so" {{ Helper::BP(1,2) }}><i class="fas fa-save mr-2"></i>Save Order</button>
                </div>
            </div>
        </form>          
    </div>

    <div class="modal fade" id="modal-add-new-discount" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Discount Value</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">    
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="modal_input_add_discount_percent" placeholder="% Percentage">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="btn-remarks-cancel">Cancel</button>
                    <input type="button" class="btn btn-primary btn-sm m-2" id="btn-new-add-discount" value="Add" disabled>
                </div>
            </div>
        </div>
    </div>

<style>
    .custom-select-dropdown {
        background: transparent;
        border: none;
        padding: 0;
        outline: none;
        margin: 0;
        width: 125px;
        /* for dark mode only; remove if not dark-mode */
        color: white; 
    }

    input[type="text2"], textarea {
      color: #ffffff;
      text-align: left;
      border: none;
      outline: none;
      font-weight: bold;
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    #add_image_preview {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    #edit_image_preview {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
    #show_images {
        display: block;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        border: 2px solid #ccc; /* You can customize the border color */
        box-sizing: border-box; /* Ensures that the border is included in the total width/height */
    }
    
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

    #add_customers + .select2-container .select2-selection,
    #item_name + .select2-container .select2-selection {
        background-color: transparent !important;
    }

    /* Target the Select2 dropdown text color */
    .select2-container .select2-selection--single .select2-selection__rendered {
        color: white !important;
        font-size: 14px !important; /* Adjust the font size as needed */
    }

    /* Optionally, change the placeholder color to white */
    .select2-container .select2-selection--single .select2-selection__placeholder {
        color: white !important;
        font-size: 14px !important; /* Adjust the font size as needed */
    }

    /* Style for text within labels */
    label[for][data-required="true"]::after {
        content: " *";
        color: red;
    }
</style>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        }); 
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // re-initialize the datatable
        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            // serverSide: true,
            // processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            order: [[6, 'desc']],
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
        });

        // Initialize total quantity count, subtotal amount, and grand total amount
        var total_quantity_count = 0;
        var sub_total_amount = 0;
        var grand_total_amount = 0;
        var item_discount = 0;
        var item_count = 0;

        var changeCount = 0; // Initialize change count

        // Function to clear item details
        function clearItemDetails() {
            $('#item_name').val('').trigger('change'); // Clear and trigger change event
            $('#add_code').val('');
            $('#add_upc').val('');
            $('#pack_size').val('');
            $('#size_in_kg').val('');
            $('#add_packs_per_case').val('');
            $('#amount').val('');
            $('#total_quantity').val('');
        }

        // Event handler for customer dropdown change
        $('#add_customers').on('change', function() {
            changeCount++; // Increment change count on every change

            $('#item_name').prop('disabled', false);
            $('#delivery_date').prop('disabled', false);
            $('#due_date').prop('disabled', false);
            $('#add_payment_terms').prop('disabled', false);
            $('#add_drivers').prop('disabled', false);
            $('#add_agents').prop('disabled', false);
            $('#remarks').prop('disabled', false);

            var selectedOption = $(this).find('option:selected');
            $('#add_proprietor').val(selectedOption.data('proprietor'));
            $('#add_address').val(selectedOption.data('address'));
            $('#add_zip_code').val(selectedOption.data('zip_code'));
            $('#add_srp_type').val(selectedOption.data('srp_type'));
            $('#add_category').val(selectedOption.data('category'));
            $('#add_area_group').val(selectedOption.data('area_group'));
            $('#add_items_srp_type').val(selectedOption.data('srp_type'));

            // Check if change count is 2 (dropdown changed twice)
            if (changeCount === 2) {
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Changing the customer will clear the selected items. Do you want to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed to clear item details
                       clearItemDetails();
                       $('#table_item_details > tbody').empty();
                            // reset all the amount
                            var reset_amount = 0;
                            $('#tfoot_subtotal_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            $('#tfoot_grand_total_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                            sub_total_amount = 0;
                            grand_total_amount = 0;

                            // empty the arrays
                            $('#hidden_item_name').val('');
                            $('#hidden_quantity').val('');
                            $('#hidden_amount').val('');
                            $('#hidden_subtotal_amount').val('');

                            // update the total quantity count 
                            total_quantity_count = 0;
                            $('#total_quantity_count').text(total_quantity_count);

                    } else {
                        // Revert back to the previous value of customer dropdown
                        $(this).val($(this).data('prev')).trigger('change'); // Restore previous value and trigger change
                    }

                    // Reset change count after showing the confirmation dialog
                    changeCount = 1;
                });
            } else {
                // Update previous value of customer dropdown
                $(this).data('prev', $(this).val());
            }
        });

        // Store initial value of customer dropdown
        $('#add_customers').data('prev', $('#add_customers').val());

        $('#item_name').on('change', function() {

            $('#quantity').prop('disabled', false);
            $('#item_discount').prop('disabled', false);
            $('#add_item').prop('disabled', false);

            var selectedOption = $(this).find('option:selected');
            var code = selectedOption.data('code');
            var upc = selectedOption.data('upc');
            var pack_size = selectedOption.data('pack_size');
            var size_in_kg = selectedOption.data('size_in_kg');
            var packs_per_case = selectedOption.data('packs_per_case');

            // Determine the amount based on the selected customer's srp_type
            var amount;
            var srpType = $('#add_customers').find('option:selected').data('srp_type');

            if (srpType === 'Standard') {
                amount = selectedOption.data('orig_srp'); // Use orig_srp from item data
            } else if (srpType === 'Special') {
                amount = selectedOption.data('spec_srp'); // Use spec_srp from item data
            } else {
                amount = selectedOption.data('amount'); // Default to regular amount from item data
            }

            // Update the displayed fields with item details
            $('#add_code').val(code);
            $('#add_upc').val(upc);
            $('#pack_size').val(pack_size);
            $('#size_in_kg').val(size_in_kg);
            $('#add_packs_per_case').val(packs_per_case);
            $('#amount').val(amount);

            // Enable the discount checkbox if needed
            $('#add_discount_checkbox').prop('disabled', false);

            // Set focus to the quantity input field
            $('#quantity').focus();
        });


        $('#quantity, #item_discount').on('input', function(e) {    
            const inputValue = e.target.value;
            const numericValue = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            e.target.value = numericValue;
        });

        $('#add_item').on('click', function() {
            $('#quantity').attr('placeholder', '');

            // Check if an item is selected
            if ($('#item_name').val().trim() === '') {
                Swal.fire({
                    title: 'Select an item',
                    text: 'Please select an item.',
                    icon: 'error',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
                return;
            }

            // Retrieve selected item details
            var item_selected = {
                code: $('#add_code').val(),
                name: $('#item_name').find('option:selected').text(),
                amount: parseFloat($('#amount').val().replace(/,/g, '')),
                pack_size: $('#pack_size').val(),
                size_in_kg: $('#size_in_kg').val(),
                // Add other necessary details here
            };

            // Retrieve quantity
            var quantity = parseInt($('#quantity').val().trim());

            // Check if the item is already in the table
            var isDuplicate = false;
            $('#table_item_details tbody tr').each(function() {
                var existingCode = $(this).find('input[name="item_code[]"]').val();
                if (existingCode === item_selected.code) {
                    isDuplicate = true;
                    return false; // Exit each loop early if duplicate found
                }
            });

            if (isDuplicate) {
                Swal.fire({
                    title: 'Duplicate Item',
                    text: 'This item has already been added.',
                    icon: 'warning',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
                return;
            }

            // Check if quantity is valid
            if ($('#quantity').val().trim() === '' || parseInt($('#quantity').val().trim()) === 0) {
                // Show error and focus on quantity input
                Swal.fire({
                    title: 'Invalid Quantity!',
                    text: 'Please enter a valid quantity greater than zero.',
                    icon: 'error',
                    allowEnterKey: false,
                    allowOutsideClick: false
                });
                $('#quantity').focus();
                return;
            }

            // Retrieve item_discount and handle NaN scenario
            var item_discount = $('#item_discount').val().trim();
            var discountPercentage = parseFloat(item_discount); // Parse discount as float

            // Check if discount is valid or set default if NaN or empty
            if (isNaN(discountPercentage) || discountPercentage < 0 || discountPercentage > 100) {
                discountPercentage = 0; // Default discount percentage
            }

            // Calculate discounted amount
            var discountedAmount = item_selected.amount * (1 - discountPercentage / 100); // Apply percentage discount

            // Create HTML for the new table row
            var newRow = `<tr>
                <td class="text-center">${item_selected.name}</td>
                <td class="text-center">${item_selected.pack_size}</td>
                <td class="text-center">${discountPercentage}%</td>
                <td class="text-center">${quantity}</td>
                <td class="text-right">${discountedAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="text-right">${(discountedAmount * quantity).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="text-center"><a href="#" class="btn-delete-item" data-quantity="${quantity}" data-amount="${quantity * discountedAmount}" data-nuc="${quantity * item_selected.nuc}"><i class="far fa-trash-alt"></i></a></td>
                <input type="hidden" id="item_code" name="item_code[]" value="${item_selected.code}" required>
                <input type="hidden" id="item_name" name="item_name[]" value="${item_selected.name}" required>
                <input type="hidden" id="item_discount" name="item_discount[]" value="${item_discount}" required>
                <input type="hidden" id="pack_size" name="pack_size[]" value="${item_selected.pack_size}" required>
                <input type="hidden" id="size_in_kg" name="size_in_kg[]" value="${item_selected.size_in_kg * quantity}" required>
                <input type="hidden" id="quantity" name="quantity[]" value="${quantity}" required>
                <input type="hidden" id="amount" name="amount[]" value="${discountedAmount}" required>
                <input type="hidden" id="subtotal_amount" name="subtotal_amount[]" value="${discountedAmount * quantity}" required>
            </tr>`;

            // increment the item counter
            item_count++;

            $('#checkbox_add_discount').prop('disabled', false);

            // Append the new row to the table
            $('#table_item_details tbody').append(newRow);

            // Clear item selection and quantity input after adding
            $('#item_name').val('').trigger('change');
            $('#quantity').val('');
            $('#item_discount').val('');

            // Update total quantity count
            total_quantity_count += quantity;
            $('#total_quantity_count').text(total_quantity_count);
            $('#total_quantity').val(total_quantity_count);

            // Update subtotal and grand total amounts
            sub_total_amount += (discountedAmount * quantity);
            grand_total_amount = sub_total_amount;

            // Update the displayed subtotal and grand total amounts
            $('#tfoot_subtotal_amount').val(sub_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#tfoot_grand_total_amount').val(grand_total_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        });

        $(document).on('click', '.btn-delete-item', function() {
            var $row = $(this).closest('tr');

            // Get quantity and amount from data attributes
            var quantity = parseInt($(this).attr("data-quantity"));
            var amount = parseFloat($(this).attr("data-amount"));

            // Validate amount to prevent NaN or undefined values
            if (isNaN(amount) || !isFinite(amount) || amount < 0) {
                amount = 0; // Default to zero if amount is invalid
            }

            // Show confirmation dialog
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

                    var item_id = parseFloat($(this).attr("data-id"));

                    // Calculate the current total quantity count
                    total_quantity_count -= quantity;

                    // Calculate new subtotal amount (excluding add_discount)
                    var currentSubtotal = parseFloat($('#tfoot_subtotal_amount').val().replace(/,/g, '') || 0);
                    var newSubtotal = Math.max(0, currentSubtotal - amount);

                    // Update displayed subtotal amount with proper formatting
                    $('#tfoot_subtotal_amount').val(newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // Set grand total amount equal to the new subtotal (since add_discount is removed)
                    var newGrandTotal = Math.max(0, currentSubtotal - amount);

                    // Update displayed grand total amount with proper formatting
                    $('#tfoot_grand_total_amount').val(newGrandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    // Remove the add_discount value from the input field
                    $('#tfoot_add_discount_total_amount').val('0.00'); // Clear add_discount value

                    // Remove the table row
                    $row.remove();

                    item_count--;

                    console.log('grand: ', newGrandTotal);
                    console.log('sub: ', newSubtotal);
                    console.log('item_count: ', item_count);


                    // Check if there are any rows left in the table
                    if (item_count == 0) {
                        // If no rows are left, reset quantities, subtotal, grand total, etc.
                        clearItemDetails();
                       $('#table_item_details > tbody').empty();
                            // reset all the amount
                            var reset_amount = 0;
                            $('#tfoot_subtotal_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            $('#tfoot_grand_total_amount').val(reset_amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                            sub_total_amount = 0;
                            grand_total_amount = 0;

                            // empty the arrays
                            $('#hidden_item_name').val('');
                            $('#hidden_quantity').val('');
                            $('#hidden_amount').val('');
                            $('#hidden_subtotal_amount').val('');

                            // update the total quantity count 
                            $('#total_quantity_count').val('0');

                            $('#checkbox_add_discount').prop('disabled', true);
                    }

                    // Show removal confirmation
                    Swal.fire({
                        title: 'Removed!',
                        text: 'Item has been removed.',
                        icon: 'success',
                        allowEnterKey: false,
                        allowOutsideClick: false
                    });

                    // update the total quantity count 
                    $('#total_quantity_count').text(total_quantity_count);

                    
                    // Check the add_discount_checkbox to indicate that a discount is applied
                    $('#checkbox_add_discount').prop('checked', false);
                    $('#span_discount_percent').text('');
                    $('#add_discount_percentage').val('');
                    $('#tfoot_add_discount_total_amount').val('0.00');
                }
            });
        });

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
                    window.location = "/delivery-management";
                }
            }
            );
        });
    
        $('#new_delivery_date, #new_due_date').datetimepicker({
            format: 'MM-DD-YYYY', // Set the format to display and parse dates
            defaultDate: new Date(),
            useCurrent: false // Prevents the picker from defaulting to the current date
        });

        // Function to calculate due date based on delivery date and payment term
        function calculateDueDate() {
            var deliveryDate = $('#delivery_date').val();
            var paymentTerm = $('#add_payment_terms').val();

            if (deliveryDate && paymentTerm) {
                // Parse the delivery date using Moment.js to handle date operations
                var parsedDeliveryDate = moment(deliveryDate, 'MM-DD-YYYY');
                
                // Add the selected payment term (in days) to the delivery date
                var dueDate = parsedDeliveryDate.add(parseInt(paymentTerm), 'days').format('MM-DD-YYYY');
                
                // Update the due_date input field with the calculated due date
                $('#due_date').val(dueDate);
            }
        }

        // Event listener for changes in delivery date
        $('#delivery_date').on('change', function() {
            calculateDueDate(); // Recalculate due date when delivery date changes
        });

        // Event listener for changes in payment term
        $('#add_payment_terms').on('change', function() {
            calculateDueDate(); // Recalculate due date when payment term changes
        });


        $('#btn_save_so').on('click', function(e) {
            e.preventDefault(); // prevent auto submit

            // Check if drivers field is empty
            if ($.trim($("#add_customers").val()) == "") {
                $('#add_customers').focus();
                required_field('Customer');
            } 

            // Check if drivers field is empty
            else if ($.trim($("#add_payment_terms").val()) == "") {
                $('#add_payment_terms').focus();
                required_field('Payment Terms');
            } 
            // Check if drivers field is empty
            else if ($.trim($("#add_drivers").val()) == "") {
                $('#add_drivers').focus();
                required_field('Drivers');
            } 
            // Check if agents field is empty
            else if ($.trim($("#add_agents").val()) == "") {
                $('#add_agents').focus();
                required_field('Agents');
            }
            // Check if item_count is greater than 0
            else if (item_count > 0) {
                Swal.fire({
                    title: 'Are you sure you want to save this delivery?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_delivery').submit();
                    }
                });
            } 
            // Show error if no items are added
            else {
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


        // =========== START OF NEW SIGN UP ===========
        $('#checkbox_add_discount').on('click', function() {
            if (this.checked) {
                // Checkbox is checked, disable add button and show discount modal
                $('#btn-new-add-discount').attr('disabled', true);
                $('#modal-add-new-discount').modal('show');
            } else {
                // Checkbox is unchecked, clear discount-related fields and recalculate grand total
                $('#span_discount_percent').text('');
                $('#add_discount_percentage').val('');
                $('#tfoot_add_discount_total_amount').val('0.00');

                // Recalculate grand total without discount
                var subtotalAmount = parseFloat($('#tfoot_subtotal_amount').val().replace(/,/g, ''));
                var grandTotalAmount = subtotalAmount;

                // Update displayed grand total amount
                $('#tfoot_grand_total_amount').val(grandTotalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            }
        });

        $('#modal_input_add_discount_percent').on('input', function(e) {
            var inputValue = this.value.trim(); // Trim any leading or trailing spaces
            
            // Replace non-numeric characters with empty string
            var sanitizedValue = inputValue.replace(/\D/g, ''); // \D matches any non-digit character
            
            // Update the input value with the sanitized value
            this.value = sanitizedValue;
            
            // Check the length of the sanitized value (only digits)
            if (sanitizedValue.length > 0) {
                // Enable add button if the length of digits is more than 3
                $('#btn-new-add-discount').prop('disabled', false);
            } else {
                // Disable add button if the length of digits is 3 or less
                $('#btn-new-add-discount').prop('disabled', true);
            }
        });

        $('#btn-remarks-cancel').on('click', function() {
            // remove the value
            $('#modal_input_add_discount_percent').val('');
            // uncheck the checkbox
            $('#checkbox_add_discount').prop('checked', false);
        });

        $('#modal-add-new-discount').on('hide.bs.modal', function (e) {
            // Check if the close button (x button) was clicked
            if (e.target === this) {
                // remove the value
                $('#modal_input_add_discount_percent').val('');
                // uncheck the checkbox
                $('#checkbox_add_discount').prop('checked', false);
            } 
        });
        
        // =========== END OF NEW SIGN UP ===========

        // =========== START OF REMARKS ===========
        $('#checkbox_remarks').on('click', function() {
            if (this.checked) {
                // disable add button
                $('#btn-add-remarks').attr('disabled', true);
                $('#modal-add-remarks').modal('show');
            } else {
                // remove the name
                $('#span_remarks').text('');
                // remove to form hidden field
                $('#signee_name').val('');
            }
        });

        $('#modal_new_remarks').on('keyup', function(e) {
            var char_code = e.which || e.keyCode;

            if (!((char_code >= 65 && char_code <= 90) || (char_code >= 97 && char_code <= 122) || char_code === 32 || char_code === 8)) {
                e.preventDefault();

                this.value = this.value.replace(/[^a-zA-Z ]/g, '');
            }

            if(this.value.length > 3) {
                // enable add button
                $('#btn-add-remarks').prop('disabled', false);
            } else {
                // disable add button
                $('#btn-add-remarks').prop('disabled', true);
            }
            
        });

        $('#btn-add-remarks').on('click', function() {
            // get the value
            let signee_name = $('#modal_new_remarks').val();
            // add the signee name to label
            $('#span_remarks').text(signee_name.toUpperCase());
            // add to form hidden field
            $('#signee_name').val(signee_name.toUpperCase());
            // close the modal
            $('#modal-add-remarks').modal('hide');
            // retain the check
            $('#checkbox_remarks').prop('checked', true);
        });

        $('#btn-remarks-cancel').on('click', function() {
            // remove the value
            $('#modal_new_remarks').val('');
            // uncheck the checkbox
            $('#checkbox_remarks').prop('checked', false);
        });

        $('#modal-add-remarks').on('hide.bs.modal', function (e) {
            // Check if the close button (x button) was clicked
            if (e.target === this) {
                // remove the value
                $('#modal_new_remarks').val('');
                // uncheck the checkbox
                $('#checkbox_remarks').prop('checked', false);
            } 
        });
        
        // =========== END OF REMARKS ===========

    
    $('#btn-new-add-discount').on('click', function() {

        // Retrieve raw input value from modal input field
        var rawDiscountInput = $('#modal_input_add_discount_percent').val().trim();
        console.log('Raw Discount Input:', rawDiscountInput);

        // add the signee name to label
        $('#span_discount_percent').text(rawDiscountInput + ' %');
        // add to form hidden field
        $('#add_discount_percent').val(rawDiscountInput);
        // close the modal
        $('#modal-add-new-discount').modal('hide');
        // retain the check
        $('#checkbox_add_discount').prop('checked', true);

        // Attempt to parse discount percentage as a float
        var discountPercentage = parseFloat(rawDiscountInput);

        // Check if discountPercentage is a valid number
        if (isNaN(discountPercentage) || discountPercentage < 0 || discountPercentage > 100) {
            // Handle invalid input by setting discountPercentage to 0
            console.log('Invalid Discount Percentage. Setting to 0.');
            discountPercentage = 0;
        }

        // Retrieve subtotal amount and convert to float
        var subtotalAmount = parseFloat($('#tfoot_subtotal_amount').val().replace(/,/g, ''));
        console.log('Subtotal Amount:', subtotalAmount);

        // Calculate discount amount based on entered percentage
        var discountAmount = subtotalAmount * (discountPercentage / 100);
        console.log('Discount Amount:', discountAmount);

        // add to form hidden field
        $('#add_discount_value').val(discountAmount);

        // Calculate new grand total after discount
        var grandTotalAmount = subtotalAmount - discountAmount;
        console.log('Grand Total Amount:', grandTotalAmount);

        // Update displayed discount total
        $('#tfoot_add_discount_total_amount').val(discountAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        // Update displayed grand total amount
        $('#tfoot_grand_total_amount').val(grandTotalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        // Close the discount modal
        $('#modal-add-new-discount').modal('hide');
    });




    // Handle Cancel button in discount modal
    $('#btn-remarks-cancel').on('click', function() {
        // Clear discount input and uncheck the discount checkbox
        $('#modal_input_add_discount_percent').val('');
        $('#checkbox_add_discount').prop('checked', false);
    });

    // Clear discount input and checkbox when discount modal is closed
    $('#modal-add-new-discount').on('hide.bs.modal', function (e) {
        // Clear discount input and uncheck the discount checkbox
        $('#modal_input_add_discount_percent').val('');
        $('#checkbox_add_discount').prop('checked', false);
    });
});
</script>
@endsection
