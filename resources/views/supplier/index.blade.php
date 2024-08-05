@extends('adminlte::page')

@section('title', 'Suppliers')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Suppliers</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add" {{ Helper::BP(11,2) }}>Add Supplier</button>
            </div>
        </div>
    </div>
@stop

@php
    $show_button_state = Helper::BP(11,3);
    $edit_button_state = Helper::BP(11,4);
@endphp

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_supplier" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Proprietor</th>
                            <th class="d-none">Created At</th>
                            <th class="d-none">Updated By</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td class="text-center">{{ $supplier->id }}</td>
                                <td class="text-left">{{ $supplier->name }}</td>
                                <td class="text-center">{{ $supplier->proprietor }}</td>
                                <td class="d-none">{{ $supplier->created_at }}</td>
                                <td class="d-none">{{ $supplier->updated_by }}</td>
                                <td class="text-center">{{ $supplier->created_by }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal"
                                        data-target="#modal-show"
                                        data-id="{{ $supplier->id }}"
                                        data-uuid="{{ $supplier->uuid }}"
                                        data-supplier-name="{{ $supplier->name }}"
                                        data-supplier-proprietor="{{ $supplier->proprietor }}"
                                        data-supplier-address="{{ $supplier->address }}" 
                                        data-supplier-zip_code="{{ $supplier->zip_code }}" 
                                        data-supplier-email="{{ $supplier->email }}" 
                                        data-supplier-contact_number="{{ $supplier->contact_number }}" 
                                        data-supplier-vat_type="{{ $supplier->vat_type }}" 
                                        data-supplier-tin="{{ $supplier->tin }}" 
                                        data-supplier-updated_by="{{ $supplier->updated_by }}"
                                        {{ $show_button_state }}>
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-id="{{ $supplier->id }}" 
                                        data-uuid="{{ $supplier->uuid }}" 
                                        data-supplier-name="{{ $supplier->name }}"
                                        data-supplier-proprietor="{{ $supplier->proprietor }}"
                                        data-supplier-address="{{ $supplier->address }}" 
                                        data-supplier-zip_code="{{ $supplier->zip_code }}" 
                                        data-supplier-email="{{ $supplier->email }}" 
                                        data-supplier-contact_number="{{ $supplier->contact_number }}" 
                                        data-supplier-vat_type="{{ $supplier->vat_type }}" 
                                        data-supplier-tin="{{ $supplier->tin }}"  
                                        data-supplier-remarks="{{ $supplier->remarks }}"
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
                    <h4 class="modal-title">Create New Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('suppliers.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name" data-required="true">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" id="modal_add_name" pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="proprietor">Proprietor</label>
                                <input type="text" class="form-control form-control-sm" name="proprietor" id="modal_add_proprietor" pattern="[a-zA-Z0-9\s]+">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="address" data-required="true">Address</label>
                                <input type="text" class="form-control form-control-sm" name="address" id="modal_add_address">
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
                                <label for="email">Email</label>
                                <input type="text" class="form-control form-control-sm" name="email" id="modal_add_email">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="contact_number" data-required="true">Contact Number</label>
                              <input type="text" class="form-control form-control-sm" name="contact_number" maxlength="11" id="modal_add_contact_number"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">Vat Type</label>
                              <select class="form-control form-control-sm" name="vat_type" id="modal_add_vat_type">
                                <option value="NULL">Please select...</option>
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
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
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


    {{--  modal for create --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
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
                                <input type="text" class="form-control form-control-sm" name="name" id="modal_edit_name" pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="proprietor">Proprietor</label>
                                <input type="text" class="form-control form-control-sm" name="proprietor" id="modal_edit_proprietor" pattern="[a-zA-Z0-9\s]+">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="address" data-required="true">Address</label>
                                <input type="text" class="form-control form-control-sm" name="address" id="modal_edit_address">
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
                                <label for="email">Email</label>
                                <input type="text" class="form-control form-control-sm" name="email" id="modal_edit_email">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="contact_number" data-required="true">Contact Number</label>
                              <input type="text" class="form-control form-control-sm" name="contact_number" maxlength="11" id="modal_edit_contact_number"
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-12">
                              <label for="vat_type" data-required="true">Vat Type</label>
                              <select class="form-control form-control-sm" name="vat_type" id="modal_edit_vat_type">
                                <option value="NULL">Please select...</option>
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
                                     pattern="[0-9]+"
                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
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
                    <h4 class="modal-title">Supplier Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">      
                    <div class="row">
                        <table class="table table-borderless">
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
        $('#dt_supplier').DataTable({
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
                    targets: [6], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_role").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-supplier-name");
            var proprietor = $(this).attr("data-supplier-proprietor");
            var address = $(this).attr("data-supplier-address");
            var zip_code = $(this).attr("data-supplier-zip_code");
            var email = $(this).attr("data-supplier-email");
            var contact_number = $(this).attr("data-supplier-contact_number");
            var vat_type = $(this).attr("data-supplier-vat_type");
            var tin = $(this).attr("data-supplier-tin");
            var remarks = $(this).attr("data-supplier-remarks");

            $('#modal_edit_name').val(name); 
            $('#modal_edit_proprietor').val(proprietor);
            $('#modal_edit_address').val(address);
            $('#modal_edit_zip_code').val(zip_code);
            $('#modal_edit_email').val(email);
            $('#modal_edit_contact_number').val(contact_number);
            $('#modal_edit_vat_type').val(vat_type);
            $('#modal_edit_tin').val(tin);
            $('#modal_edit_remarks').val(remarks);

            // define the edit form action
            let action = window.location.origin + "/suppliers/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-supplier-name");
            var proprietor = $(this).attr("data-supplier-proprietor");
            var address = $(this).attr("data-supplier-address");
            var zip_code = $(this).attr("data-supplier-zip_code");
            var email = $(this).attr("data-supplier-email");
            var contact_number = $(this).attr("data-supplier-contact_number");
            var vat_type = $(this).attr("data-supplier-vat_type");
            var tin = $(this).attr("data-supplier-tin");
            var remarks = $(this).attr("data-supplier-remarks");
            var updated_by = $(this).attr("data-supplier-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_proprietor').text(proprietor);
            $('#modal_show_address').text(address);
            $('#modal_show_zip_code').text(zip_code);
            $('#modal_show_email').text(email);
            $('#modal_show_contact_number').text(contact_number);
            $('#modal_show_vat_type').text(vat_type);
            $('#modal_show_tin').text(tin);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_updated_by').text(updated_by);
            if (status == '1') {
                $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
            } else {
                $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
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
                        $('#modal_add_name').val('');
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
    });
</script>
@endsection