@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add User</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_company" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Branch</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Blocked</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">{{ $user->username }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->role->name ?? '' }}</td>
                                <td class="text-center">{{ $user->branch->name ?? '' }}</td>
                                <td class="text-center">{{ $user->company->name ?? '' }}</td>
                                <td class="text-center">
                                    @if($user->active == 1)
                                        <i class="fas fa-check-circle" style="color:#28a745"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->blocked == 1)
                                        <i class="fas fa-times-circle" style="color:#dc3545"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</button>

                                    <a href="#" class="btn btn-sm btn-primary" target="_self"><i class="fas fa-tasks"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    {{-- <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('companies.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Company Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="2"  pattern="[a-zA-Z0-9\s]+" required>
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
    </div> --}}


    {{--  modal for create --}}
    {{-- <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" required pattern="[a-zA-Z0-9\s]+">
                            </div>
                            <div class="col-12">
                                <label for="code">Company Code</label>
                                <input type="text" class="form-control form-control-sm" maxlength="2" name="code" id="modal_edit_code" required pattern="[a-zA-Z0-9\s]+">
                            </div><br>
                            <div class="col-12">
                                <label for="">Company Status?</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="8" checked="checked">
                                <label for="">Active</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="9">
                                <label for="">Inactive</label><br>
                            </p>
                            </div>
                            <div class="col-12">
                                <label for="remarks">Remarks</label>
                                <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required oninput="this.value = this.value.toUpperCase()" pattern="[a-zA-Z0-9\s]+">
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
    </div> --}}

    {{--  modal for show --}}
    {{-- <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Company Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-12">
                            <label for="name">Company Name</label>
                            <input type="" class="form-control form-control-sm" name="name" id="modal_show_name" disabled>
                        </div>
                        <div class="col-12">
                            <label for="code">Company Code</label>
                            <input type="text" class="form-control form-control-sm" name="code" id="modal_show_code" disabled>
                        </div>
                        <div class="col-12">
                            <label for="status">Status</label>
                            <input type="" class="form-control form-control-sm" name="status" id="modal_show_status_id" disabled>
                        </div>
                        <div class="col-12">
                            <label for="remarks">Remarks</label>
                            <input type="" class="form-control form-control-sm" name="remarks" id="modal_show_remarks" disabled>
                        </div>
                        <div class="col-12">
                            <label for="updated_by">Updated By</label>
                            <input type="" class="form-control form-control-sm" name="updated_by" id="modal_show_updated_by" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_company').DataTable({
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
                    targets: [5], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_company").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

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
            var name = $(this).attr("data-company-name");
            var code = $(this).attr("data-company-code");
            var remarks = $(this).attr("data-company-remarks");
            var status_id = $(this).attr("data-company-status_id");

            $('#modal_edit_name').val(name); 
            $('#modal_edit_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);

            // define the edit form action
            let action = window.location.origin + "/companies/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });


        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-company-name");
            var code = $(this).attr("data-company-code");
            var remarks = $(this).attr("data-company-remarks");
            var status_id = $(this).attr("data-company-status_id");
            var updated_by = $(this).attr("data-company-updated_by");

            // set multiple attributes
            $('#modal_show_name').val(name);
            $('#modal_show_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);
            $('#modal_show_updated_by').val(updated_by);
        });
</script>
@endsection
