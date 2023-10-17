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
                            <th class="text-center">Created By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $branch)
                            <tr>
                                <td class="text-center">{{ $branch->name }}</td>
                                <td class="text-center">{{ $branch->code }}</td>
                                <td class="text-center">{{ $branch->cost_center }}</td>
                                <td class="text-center">{{ $branch->created_by }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($branch->status_id) }}">{{ $branch->status->name }}</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal"
                                        data-target="#modal-show"
                                        data-uuid="{{ $branch->uuid }}"
                                        data-branch-name="{{ $branch->name }}" 
                                        data-branch-code="{{ $branch->code }}"
                                        data-branch-cost_center="{{ $branch->cost_center }}"
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
                                        data-branch-cost_center="{{ $branch->cost_center }}"
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

    <div class="modal fade" id="modal-add">
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
                                <label for="name">Branch Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Branch Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="3"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Cost Center</label>
                                <input type="text" class="form-control form-control-sm" name="cost_center" maxlength="3"  pattern="[a-zA-Z0-9\s]+" required>
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
    <div class="modal fade" id="modal-edit">
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
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    Branch Status?<br>
                                    <input type="radio" id="modal_edit_status_id" name="status" value="8" checked="checked">
                                    <label for="">Active</label>&nbsp;
                                    <input type="radio" id="modal_edit_status_id" name="status" value="9" style="margin-top: 8px">
                                    <label for="">Inactive</label><br>
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
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
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
                    targets: [4], // column index (start from 0)
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
    });

        // use class instead of id because the button are repeating. ID can be only used once
        $('.btn_edit').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-branch-name");
            var code = $(this).attr("data-branch-code");
            var cost_center = $(this).attr("data-branch-cost_center");
            var remarks = $(this).attr("data-branch-remarks");
            var status_id = $(this).attr("data-branch-status_id");

            $('#modal_edit_name').val(name);
            $('#modal_edit_code').val(code);
            $('#modal_edit_cost_center').val(cost_center);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);

            // define the edit form action
            let action = window.location.origin + "/branches/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-branch-name");
            var code = $(this).attr("data-branch-code");
            var cost_center = $(this).attr("data-branch-cost_center");
            var remarks = $(this).attr("data-branch-remarks");
            var status_id = $(this).attr("data-branch-status_id");
            var updated_by = $(this).attr("data-branch-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_code').text(code);
            $('#modal_show_cost_center').text(cost_center);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_status_id').text(status_id);
            $('#modal_show_updated_by').text(updated_by);
            if (status_id == 'Active') {
                $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
            } else {
                $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
            }
        });
</script>
@endsection
