@extends('adminlte::page')

@section('title', 'Branches')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Branches</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Branch</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_branch" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Cost Center</th>
                            <th class="text-center">Cost Center Name</th>
                            <th class="text-center">Warehouse</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td class="text-center">{{ $branch->code }}</td>
                                <td class="text-center">{{ $branch->cost_center }}</td>
                                <td>{{ $branch->cost_center_name }}</td>
                                <td>{{ $branch->warehouse }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($branch->status_id) }}">{{ $branch->status->name }}</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal"
                                        data-target="#modal-show"
                                        data-uuid="{{ $branch->uuid }}"
                                        data-branch-name="{{ $branch->name }}" 
                                        data-branch-code="{{ $branch->code }}"
                                        data-branch-company_id="{{ $branch->company->name }}"
                                        data-branch-cost_center="{{ $branch->cost_center }}"
                                        data-branch-cost_center_name="{{ $branch->cost_center_name }}"
                                        data-branch-warehouse="{{ $branch->warehouse }}"
                                        data-branch-status_id="{{ $branch->status->name}}"
                                        data-branch-remarks="{{ $branch->remarks }}"
                                        data-branch-updated_by="{{ $branch->updated_by }}">
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-uuid="{{ $branch->uuid }}" 
                                        data-branch-name="{{ $branch->name }}" 
                                        data-branch-code="{{ $branch->code }}"
                                        data-branch-company_id="{{ $branch->company_id }}"
                                        data-branch-cost_center="{{ $branch->cost_center }}"
                                        data-branch-cost_center_name="{{ $branch->cost_center_name }}"
                                        data-branch-warehouse="{{ $branch->warehouse }}"
                                        data-branch-status_id="{{ $branch->status->name}}"
                                        data-branch-remarks="{{ $branch->remarks }}">
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
                    <h4 class="modal-title">Create New Branch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('branches.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control form-control-sm" name="company_id" id="modal_add_company_id" required>
                                        <option value="" selected disabled>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            @if(in_array($company->status_id, [8,1]))
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="name">Branch Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25"  pattern="[a-zA-Z0-9\s]+" id="modal_add_name" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Branch Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="3"  pattern="[a-zA-Z0-9\s]+" id="modal_add_code" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Cost Center</label>
                                <input type="text" class="form-control form-control-sm" name="cost_center" maxlength="3" id="modal_add_cost_center" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Cost Center Name</label>
                                <input type="text" class="form-control form-control-sm" name="cost_center_name" maxlength="50"  id="modal_add_cost_center_name" placeholder="IMPORTANT: Must be exactly same from ERPNext" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Warehouse</label>
                                <input type="text" class="form-control form-control-sm" name="warehouse" maxlength="50"  id="modal_add_warehouse" placeholder="IMPORTANT: Must be exactly same from ERPNext" required>
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


    {{--  modal for create --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Branch</h4>
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
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="25" name="name" id="modal_edit_name" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Branch Code</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="3" name="code" id="modal_edit_code" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Cost Center</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="3" name="cost_center" id="modal_edit_cost_center" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Cost Center Name</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="50" name="cost_center_name" id="modal_edit_cost_center_name" placeholder="IMPORTANT: Must be exactly same from ERPNext" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Warehouse</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="50" name="warehouse" id="modal_edit_warehouse" placeholder="IMPORTANT: Must be exactly same from ERPNext" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    Branch Status?<br>
                                    <input type="radio" id="status_8" name="status" value="8">
                                    <label for="">Active</label>&nbsp;
                                    <input type="radio" id="status_9" name="status" value="9" style="margin-top: 8px">
                                    <label for="">Inactive</label><br>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required>
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
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Branch Details</h4>
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
                                <td><span id="modal_show_company" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Branch Code</td>
                                <td><span id="modal_show_code" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Cost Center</td>
                                <td><span id="modal_show_cost_center" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Cost Center Name</td>
                                <td><span id="modal_show_cost_center_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Warehouse</td>
                                <td><span id="modal_show_warehouse" style="font-weight:bold"></span></td>
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
</style>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_branch').DataTable({
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
                $("#dt_branch").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");

            var companySelect = $('#modal_edit_company_id');

            // Clear existing options
            companySelect.empty();

            // Add a placeholder or default option if needed
            companySelect.append('<option value="" disabled>-- Select Company --</option>');

            // Iterate through companies and add all companies
            @foreach($companies as $company)
                var companyId = {{ $company->id }};
                var companyName = "{{ $company->name }}";
                var companyStatus = "{{ $company->status_id }}";
                if (companyStatus == 8) {
                    var option = $('<option value="' + companyId + '">' + companyName + '</option>');

                    companySelect.append(option);
                }
            @endforeach
            var name = $(this).attr("data-branch-name");
            var code = $(this).attr("data-branch-code");
            var c_id = $(this).attr("data-branch-company_id");
            var cost_center = $(this).attr("data-branch-cost_center");
            var cost_center_name = $(this).attr("data-branch-cost_center_name");
            var warehouse = $(this).attr("data-branch-warehouse");
            var remarks = $(this).attr("data-branch-remarks");
            var status_id = $(this).attr("data-branch-status_id");

            $('#modal_edit_company_id option[value=' + c_id + ']').attr('selected', 'selected');
            $('#modal_edit_name').val(name);
            $('#modal_edit_code').val(code);
            $('#modal_edit_cost_center').val(cost_center);
            $('#modal_edit_cost_center_name').val(cost_center_name);
            $('#modal_edit_warehouse').val(warehouse);
            $('#modal_show_remarks').val(remarks);

            if (status_id == 'Active') {
                $('#status_8[value="8"]').prop('checked', true);
            } else {
                $('#status_9[value="9"]').prop('checked', true);
            }

            // define the edit form action
            let action = window.location.origin + "/branches/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });
        

        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-branch-name");
            var code = $(this).attr("data-branch-code");
            var c_id = $(this).attr("data-branch-company_id");
            var cost_center = $(this).attr("data-branch-cost_center");
            var cost_center_name = $(this).attr("data-branch-cost_center_name");
            var warehouse = $(this).attr("data-branch-warehouse");
            var remarks = $(this).attr("data-branch-remarks");
            var status_id = $(this).attr("data-branch-status_id");
            var updated_by = $(this).attr("data-branch-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_code').text(code);
            $('#modal_show_company').text(c_id);
            $('#modal_show_cost_center').text(cost_center);
            $('#modal_show_cost_center_name').text(cost_center_name);
            $('#modal_show_warehouse').text(warehouse);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_status_id').text(status_id);
            $('#modal_show_updated_by').text(updated_by);
            if (status_id == 'Active') {
                $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
            } else {
                $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
            }
        });

        // Prevent input of special characters from user
        $('#modal_add_cost_center , #modal_edit_cost_center').on('input', function(e) {    
            const inputValue = e.target.value;
            const numericValue = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            e.target.value = numericValue;
        });

        $('#modal_add_cost_center , #modal_edit_cost_center').bind('copy paste', function (e) {
            e.preventDefault();
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
                        $('#modal_add_code').val('');
                        $('#modal_add_company_id').val(''); 
                        $('#modal_add_cost_center').val(''); 
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
    });
</script>
@endsection
