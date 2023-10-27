@extends('adminlte::page')

@section('title', 'Payment Methods')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payment Methods</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Payment Method</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_payment" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Description</th>
                            <th class="text-center">Account Number</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Is Cash</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-left">{{ $payment->name }}</td>
                                <td class="text-left">{{ $payment->description }}</td>
                                <td class="text-center">{{ $payment->code }}</td>
                                <td class="text-center">{{ $payment->company->name }}</td>
                                <td class="text-center">{{ $payment->is_cash == 0 ? 'No' : 'Yes' }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($payment->status_id) }}">{{ $payment->status->name }}</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal" 
                                        data-target="#modal-show" 
                                        data-uuid="{{ $payment->uuid }}" 
                                        data-company-id="{{ $payment->company->name }}" 
                                        data-name="{{ $payment->name }}" 
                                        data-description="{{ $payment->description }}" 
                                        data-code="{{ $payment->code }}"
                                        data-status-id="{{ $payment->status->name }}"
                                        data-is-cash="{{ $payment->is_cash }}"
                                        data-branch-names="{{ Helper::get_branch_name_by_id($payment->branch_id) }}"
                                        data-remarks="{{ $payment->remarks }}"
                                        data-updated-by="{{ $payment->updated_by }}">
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-uuid="{{ $payment->uuid }}" 
                                        data-company-id="{{ $payment->company->id }}" 
                                        data-name="{{ $payment->name }}" 
                                        data-description="{{ $payment->description }}" 
                                        data-code="{{ $payment->code }}"
                                        data-branch-id="{{ $payment->branch_id }}"
                                        data-is-cash="{{ $payment->is_cash }}"
                                        data-status-id="{{ $payment->status_id }}"
                                        data-remarks="{{ $payment->remarks }}">
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

    {{--  modal for create --}}
    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('payment-methods.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control form-control-sm" name="company_id" required>
                                        <option value="" disabled>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" pattern="[a-zA-Z0-9\s]+" id="modal_add_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Description</label>
                                <input type="text" class="form-control form-control-sm" name="description" pattern="[a-zA-Z0-9\s]+" id="modal_add_description" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="code">Account Number</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="12" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');" id="modal_add_code" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="code">Is Cash ?</label>
                                <div class="col-12">
                                    <input type="radio" id="modal_create_is_cash" name="status" value="1">
                                    <label for="" class="mr-4">Yes</label>
                                    <input type="radio" id="modal_create_is_cash" name="status" value="0">
                                    <label for="">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branches">Branches</label>
                                    @foreach($branches as $branch)
                                        <br/>
                                        <input type="checkbox" name="branch_id[]" id="modal_add_branch_id" value={{ $branch->id }}><span class="ml-2">{{ $branch->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_add_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--  modal for edit --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Payment Method</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="comapny_id">Company</label>
                                    <select class="form-control form-control-sm" name="company_id" id="modal_edit_company_id" required>
                                        <option value="" disabled>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="modal_edit_name" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <input type="text" class="form-control form-control-sm" name="description" id="modal_edit_description" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Account Code</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="10" name="code" id="modal_edit_code" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="code">Is Cash ?</label>
                                <div class="col-12">
                                    <input type="radio" name="is_cash" value="1">
                                    <label for="" class="mr-4">Yes</label>
                                    <input type="radio" name="is_cash" value="0">
                                    <label for="">No</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Payment Status</label>
                                    <div class="col-12">
                                        <input type="radio" name="status" value="6">
                                        <label for="" class="mr-4">Enabled</label>
                                        <input type="radio" name="status" value="7">
                                        <label for="">Disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="branches">Branches</label>
                                    @foreach($branches as $branch)
                                        <br/>
                                        <input type="checkbox" name="branch_id[]" id="modal_edit_branch_{{ $branch->id }}" value={{ $branch->id }}><span class="ml-2">{{ $branch->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_edit_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  modal for show --}}
    <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Method Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="ribbon-wrapper ribbon-lg">
                            <div class="ribbon" id="ribbon_bg">
                                <span id="modal_show_status_id"></span>
                            </div>
                        </div>
                    </div>         
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td width="25%">Company</td>
                                <td><span id="modal_show_company_id" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Description</td>
                                <td><span id="modal_show_description" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Account Number</td>
                                <td><span id="modal_show_code" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Is Cash ?</td>
                                <td><span id="modal_show_is_cash" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Remarks</td>
                                <td><span id="modal_show_remarks" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Branches</td>
                                <td id="modal_show_branch_names"></td>
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


@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_payment').DataTable({
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
                $("#dt_payment").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

    // use class instead of id because the button are repeating. ID can be only used once
    $('.btn_edit').on('click', function() {
        // remove all the marked check
        $('input[type="checkbox"]').prop('checked', false);
        $('input[type="radio"]').prop('checked', false);

        var uuid = $(this).attr("data-uuid");
        var c_id = $(this).attr("data-company-id");
        var name = $(this).attr("data-name");
        var description = $(this).attr("data-description");
        var code = $(this).attr("data-code");
        var remarks = $(this).attr("data-remarks");
        var status_id = $(this).attr("data-status-id");
        var is_cash = $(this).attr("data-is-cash");
        var branch_id = $(this).attr("data-branch-id");

        $('#modal_edit_company_id option[value=' + c_id + ']').attr('selected', 'selected');
        $('#modal_edit_name').val(name); 
        $('#modal_edit_description').val(description); 
        $('#modal_edit_code').val(code);
        $('#modal_show_remarks').val(remarks);
        $('#modal_show_status_id').val(status_id);

        // add check to is_cash and status
        if(is_cash == 1) {
            $('input[type="radio"][value="1"]').prop('checked', true);
        } else if(is_cash == 0) {
            $('input[type="radio"][value="0"]').prop('checked', true);
        } 

        if(status_id == 6) {
            $('input[type="radio"][value="6"]').prop('checked', true);
        } else if(status_id == 7) {
            $('input[type="radio"][value="7"]').prop('checked', true);
        } 

        // add check to branch checkboxes
        const array_branches = branch_id.split(",");
        array_branches.forEach(function(element, index, array) {
            $('#modal_edit_branch_' + element).prop('checked',true);
        });

        // define the edit form action
        let action = window.location.origin + "/payment-methods/" + uuid;
        $('#form_modal_edit').attr('action', action);
    });


    $('.btn_show').on('click', function() {
        // remove first the contents of the element before appending; see append() below
        $('#modal_show_branch_names').empty();

        var uuid = $(this).attr("data-uuid");
        var c_id = $(this).attr("data-company-id");
        var name = $(this).attr("data-name");
        var description = $(this).attr("data-description");
        var code = $(this).attr("data-code");
        var remarks = $(this).attr("data-remarks");
        var status_id = $(this).attr("data-status-id");
        var is_cash = $(this).attr("data-is-cash");
        var branch_names = $(this).attr("data-branch-names");
        var updated_by = $(this).attr("data-updated-by");

        // is_cash = is_cash == 1 ? 'Yes' : 'No';

        // set multiple attributes
        $('#modal_show_company_id').text(c_id);
        $('#modal_show_name').text(name);
        $('#modal_show_description').text(description);
        $('#modal_show_code').text(code);
        $('#modal_show_remarks').text(remarks);
        $('#modal_show_status_id').text(status_id);
        $('#modal_show_is_cash').text(is_cash == 1 ? 'Yes' : 'No')
        $('#modal_show_updated_by').text(updated_by);

        if (status_id == 'Enabled' || status_id == 1) {
            $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
        } else {
            $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
        }

        const array_branches = branch_names.split(",");
        array_branches.forEach(function(element, index, array) {
            $('#modal_show_branch_names').append('<span class="badge bg-info mx-2" style="font-size:85%">' + element + '</span>');
        });
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
                        $('#modal_add_description').val('');
                        $('#modal_add_code').val(''); 
                        $('input[type="radio"]').prop('checked', false);
                        $('input[type="checkbox"]').prop('checked', false);
                        $('#modal_edit_remarks').val('');
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