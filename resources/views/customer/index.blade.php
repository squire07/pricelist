@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customers</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add" {{ Helper::BP(6,2) }}>Add Customer</button>
            </div>
        </div>
    </div>
@stop

@php
    $show_button_state = Helper::BP(6,3);
    $edit_button_state = Helper::BP(6,4);
@endphp

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_customer" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">SRP Type</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td class="text-center">{{ $customer->id }}</td>
                                <td class="text-left">{{ $customer->name }}</td>
                                <td class="text-center">{{ $customer->customer_categories->name ?? null }}</td>
                                <td class="text-center">{{ $customer->area_groups->name ?? null}}</td>
                                <td class="text-center">{{ $customer->srp_types->name ?? null }}</td>
                                <td class="text-center">
                                    @if($customer->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $customer->created_by }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal"
                                        data-target="#modal-show"
                                        data-id="{{ $customer->id }}"
                                        data-uuid="{{ $customer->uuid }}"
                                        data-customer-name="{{ $customer->name }}"
                                        data-customer-proprietor="{{ $customer->proprietor }}"
                                        data-customer-address="{{ $customer->address }}" 
                                        data-customer-zip_code="{{ $customer->zip_code }}" 
                                        data-customer-category="{{ $customer->customer_categories->name ?? null}}" 
                                        data-customer-area_group="{{ $customer->area_groups->name ?? null}}" 
                                        data-customer-email="{{ $customer->email }}" 
                                        data-customer-contact_number="{{ $customer->contact_number }}" 
                                        data-customer-vat_type="{{ $customer->vat_type }}" 
                                        data-customer-tin="{{ $customer->tin }}" 
                                        data-customer-srp_types="{{ $customer->srp_types->name ?? null }}" 
                                        data-customer-status="{{ $customer->status }}"
                                        data-customer-updated_by="{{ $customer->updated_by }}"
                                        {{ $show_button_state }}>
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-id="{{ $customer->id }}" 
                                        data-uuid="{{ $customer->uuid }}" 
                                        data-customer-name="{{ $customer->name }}"
                                        data-customer-proprietor="{{ $customer->proprietor }}"
                                        data-customer-address="{{ $customer->address }}" 
                                        data-customer-zip_code="{{ $customer->zip_code }}" 
                                        data-customer-category="{{ $customer->category_id }}" 
                                        data-customer-area_group="{{ $customer->area_id }}" 
                                        data-customer-email="{{ $customer->email }}" 
                                        data-customer-contact_number="{{ $customer->contact_number }}" 
                                        data-customer-vat_type="{{ $customer->vat_type }}" 
                                        data-customer-tin="{{ $customer->tin }}"  
                                        data-customer-srp_type_id="{{ $customer->srp_type_id }}" 
                                        data-customer-status="{{ $customer->status }}"
                                        data-customer-remarks="{{ $customer->remarks }}"
                                        {{ $edit_button_state }}>
                                        <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>


    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('customers.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name" data-required="true">Name</label>
                                <textarea rows="3" class="form-control form-control-sm text-left" name="name" id="modal_add_name" required></textarea>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="proprietor">Proprietor</label>
                                <input type="text" class="form-control form-control-sm" name="proprietor" id="modal_add_proprietor">
                            </div>
                        </div>
                            <div class="container-fluid">
                                <div class="col-12">
                                    <label for="address" data-required="true">Address</label>
                                    <textarea rows="3" class="form-control form-control-sm text-left" name="address" id="modal_add_address" required></textarea>
                                </div>
                            </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code">Zip Code</label>
                              <input type="text" class="form-control form-control-sm" name="zip_code" maxlength="4" id="modal_add_zip_code"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code" data-required="true">Customer Category</label>
                                <select class="form-control form-control-sm" name="category_id" id="modal_add_category_id" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                        @foreach($customer_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code" data-required="true">Area Group</label>
                                <select class="form-control form-control-sm" name="area_id" id="modal_add_area_id" required>
                                    <option value="" selected disabled>-- Select Area --</option>
                                        @foreach($area_groups as $area_group)
                                                <option value="{{ $area_group->id }}">{{ $area_group->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email" id="modal_add_email">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="contact_number">Contact Number</label>
                              <input type="text" class="form-control form-control-sm" name="contact_number" maxlength="11" id="modal_add_contact_number"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">Vat Type</label>
                              <select class="form-control form-control-sm" name="vat_type" id="modal_add_vat_type" required>
                                <option value="" selected disabled> -- Select VAT Type --</option>
                                <option value="VAT">VAT</option>
                                <option value="NON-VAT">NON-VAT</option>
                                <option value="NOT APPLICABLE">NOT APPLICABLE</option>
                              </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="tin">TIN</label>
                                <input type="text" class="form-control form-control-sm" name="tin" id="modal_add_tin"
                                       pattern="[0-9-]+"
                                       oninput="this.value = this.value.replace(/[^0-9-]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">SRP Type</label>
                              <select class="form-control form-control-sm" name="srp_type_id" id="modal_srp_type_id" required>
                                    <option value="" selected disabled>-- Select SRP Type --</option>
                                        @foreach($srp_types as $srp_type)
                                                <option value="{{ $srp_type->id }}">{{ $srp_type->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name" data-required="true">Name</label>
                                <textarea rows="3" class="form-control form-control-sm text-left" name="name" id="modal_edit_name" required></textarea>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="proprietor">Proprietor</label>
                                <input type="text" class="form-control form-control-sm" name="proprietor" id="modal_edit_proprietor">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="address" data-required="true">Address</label>
                                <textarea rows="3" class="form-control form-control-sm text-left" name="address" id="modal_edit_address" required></textarea>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code">Zip Code</label>
                              <input type="text" class="form-control form-control-sm" name="zip_code" maxlength="4" id="modal_edit_zip_code"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code" data-required="true">Customer Category</label>
                                <select class="form-control form-control-sm" name="category_id" id="modal_edit_category_id" required>
                                    <option value="" disabled selected> -- Category --</option>
                                        @foreach($customer_categories as $category)
                                            <option value="{{ $category->id }}" @if ($category->id == $customer->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="zip_code" data-required="true">Area Group</label>
                                <select class="form-control form-control-sm" name="area_id" id="modal_edit_area_id" required>
                                    <option value="" disabled selected> -- Area Group --</option>
                                    @foreach($area_groups as $area_group)
                                        <option value="{{ $area_group->id }}" @if ($area_group->id == $customer->area_id) selected @endif>{{ $area_group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email" id="modal_edit_email">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="contact_number">Contact Number</label>
                              <input type="text" class="form-control form-control-sm" name="contact_number" maxlength="11" id="modal_edit_contact_number"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">Vat Type</label>
                              <select class="form-control form-control-sm" name="vat_type" id="modal_edit_vat_type" required>
                                <option value="" disabled> -- Select VAT Type --</option>
                                <option value="VAT">VAT</option>
                                <option value="NON-VAT">NON-VAT</option>
                                <option value="NOT APPLICABLE">NOT APPLICABLE</option>
                              </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="tin">TIN</label>
                                <input type="text" class="form-control form-control-sm" name="tin" id="modal_edit_tin"
                                       pattern="[0-9-]+"
                                       oninput="this.value = this.value.replace(/[^0-9-]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">SRP Type</label>
                              <select class="form-control form-control-sm" name="srp_type_id" id="modal_edit_srp_type_id" required>
                              <option value="" disabled selected> -- SRP Type --</option>
                                    @foreach($srp_types as $srp_type)
                                            <option value="{{ $srp_type->id}}">{{ $srp_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-md-6 col-sm-12">
                                <label for="code">Customer Status</label>
                                <div class="col-12">
                                    <input type="radio" name="status" value="1">
                                    <label for="" class="mr-4">Active</label>
                                    <input type="radio" name="status" value="0">
                                    <label for="">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  modal for show --}}
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Customer Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">      
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td width="25%">Status</td>
                                <td>
                                    <span id="modal_show_status" style="font-weight:bold"></span>
                                    <span id="status_badge"></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Proprietor</td>
                                <td><span id="modal_show_proprietor" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Address</td>
                                <td><span id="modal_show_address" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Zip Code</td>
                                <td><span id="modal_show_zip_code" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Category</td>
                                <td><span id="modal_show_category" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Area Group</td>
                                <td><span id="modal_show_area_group" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Email</td>
                                <td><span id="modal_show_email" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Contact Number</td>
                                <td><span id="modal_show_contact_number" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Vat Type</td>
                                <td><span id="modal_show_vat_type" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">TIN</td>
                                <td><span id="modal_show_tin" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">SRP Type</td>
                                <td><span id="modal_show_srp_types" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Remarks</td>
                                <td><span id="modal_show_remarks" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Updated By</td>
                                <td><span id="modal_show_updated_by" style="font-weight:bold"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<style>
input[type="text2"], textarea {
  color: #ffffff;
  text-align: center;
  border: none;
  outline: none;
  font-weight: bold;
}

#modal_edit_category_id + .select2-container .select2-selection,
    #modal_edit_area_id + .select2-container .select2-selection {
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

    // initialize select2 on this page using bootstrap 4 theme
    $('.select2').select2({
        theme: 'bootstrap4'
    });


    $(document).ready(function() {
        $('#dt_customer').DataTable({
            dom: 'Bfrtip',
            autoWidth: true,
            responsive: true,
            order: [[ 0, "asc" ]],
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            columnDefs: [ 
                {
                    targets: [7], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_customer").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-customer-name");
            var proprietor = $(this).attr("data-customer-proprietor");
            var address = $(this).attr("data-customer-address");
            var zip_code = $(this).attr("data-customer-zip_code");
            var category = $(this).attr("data-customer-category");
            var area_group = $(this).attr("data-customer-area_group");
            var email = $(this).attr("data-customer-email");
            var contact_number = $(this).attr("data-customer-contact_number");
            var vat_type = $(this).attr("data-customer-vat_type");
            var tin = $(this).attr("data-customer-tin");
            var srp_types = $(this).attr("data-customer-srp_type_id");
            var status = $(this).attr("data-customer-status");
            var remarks = $(this).attr("data-customer-remarks");

            console.log('Category ID:', category);
            console.log('Area ID:', area_group);

            $('#modal_edit_name').val(name); 
            $('#modal_edit_proprietor').val(proprietor);
            $('#modal_edit_address').val(address);
            $('#modal_edit_zip_code').val(zip_code);
            $('#modal_edit_contact_number').val(contact_number);
            $('#modal_edit_email').val(email);
            $('#modal_edit_vat_type').val(vat_type);
            $('#modal_edit_tin').val(tin);
            $('#modal_edit_srp_type_id option[value=' + srp_types + ']').attr('selected', 'selected');
            $('#modal_edit_category_id option[value=' + category + ']').attr('selected', 'selected');
            $('#modal_edit_area_id option[value=' + area_group + ']').attr('selected', 'selected');

            $('#modal_edit_remarks').val(remarks);

            // Set status radio button based on the 'status' value
            if(status == 1) {
                $('input[type="radio"][value="1"]').prop('checked', true);
            } else if(status == 0) {
                $('input[type="radio"][value="0"]').prop('checked', true);
            }

            // define the edit form action
            let action = window.location.origin + "/customers/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-customer-name");
            var proprietor = $(this).attr("data-customer-proprietor");
            var address = $(this).attr("data-customer-address");
            var zip_code = $(this).attr("data-customer-zip_code");
            var category = $(this).attr("data-customer-category");
            var area_group = $(this).attr("data-customer-area_group");
            var email = $(this).attr("data-customer-email");
            var contact_number = $(this).attr("data-customer-contact_number");
            var vat_type = $(this).attr("data-customer-vat_type");
            var tin = $(this).attr("data-customer-tin");
            var srp_types = $(this).attr("data-customer-srp_types");
            var remarks = $(this).attr("data-customer-remarks");
            var status = $(this).attr("data-customer-status");
            var updated_by = $(this).attr("data-customer-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_proprietor').text(proprietor);
            $('#modal_show_address').text(address);
            $('#modal_show_zip_code').text(zip_code);
            $('#modal_show_category').text(category);
            $('#modal_show_area_group').text(area_group);
            $('#modal_show_email').text(email);
            $('#modal_show_contact_number').text(contact_number);
            $('#modal_show_vat_type').text(vat_type);
            $('#modal_show_tin').text(tin);
            $('#modal_show_srp_types').text(srp_types);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_updated_by').text(updated_by);
            // Set status display based on value
            if (status === '1') {
                $('#modal_show_status').text('Active').removeClass('badge-danger').addClass('badge-success');
            } else {
                $('#modal_show_status').text('Inactive').removeClass('badge-success').addClass('badge-danger');
            }
        });

        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#modal-add , #modal-edit').on("hide.bs.modal", function (e) {

            if (!$('#modal-add , #modal-edit').hasClass('programmatic')) {
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
                        $('#modal-add , #modal-edit').addClass('programmatic');
                        $('#modal-add , #modal-edit').modal('hide');
                        e.stopPropagation();
                        $('#modal_add_category_id').val('')
                        $('#modal_add_area_id').val('')
                        $('#modal_srp_type_id').val('')
                        $('#modal_edit_category_id option:selected').removeAttr('selected');
                        $('#modal_edit_category_id option:first').attr('selected', 'selected');
                        $('#modal_edit_area_id option:selected').removeAttr('selected');
                        $('#modal_edit_area_id option:first').attr('selected', 'selected');
                        $('#modal_edit_srp_type_id option:selected').removeAttr('selected');
                        $('#modal_edit_srp_type_id option:first').attr('selected', 'selected');
                        $('#modal_add_name').val('');
                        $('#modal_add_address').val('');
                        $('#modal_add_vat_type').val('');
                        $('#modal_add_zip_code').val('');
                        $('#modal_add_email').val('');
                        $('#modal_add_tin').val('');
                        $('#modal_add_contact_number').val('');
                        $('#modal_add_proprietor').val('');
                    } else {
                        e.stopPropagation();

                    }
                });

            }
            return true;
        });

        $('#modal-add , #modal-edit').on('hidden.bs.modal', function () {
        $('#modal-add , #modal-edit').removeClass('programmatic');
        });

        // Prevent user from using enter key
            $("input:text, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $( '#modal-add, #modal-edit' ).on( 'keypress', function( e ) {
        if( event.keyCode === 10 || e.keyCode === 13 ) {
            e.preventDefault();
            $( this ).trigger( 'submit' );
        }
        });

        $("#modal_add_name, #modal_add_proprietor, #modal_add_address, #modal_edit_name, #modal_edit_proprietor, #modal_edit_name").on("keypress", function(event) {
            const forbiddenChars = ["/", "\\"];
            if (forbiddenChars.includes(event.key)) {
                event.preventDefault(); // Prevent adding the character
            }
        });
    });
</script>
@endsection