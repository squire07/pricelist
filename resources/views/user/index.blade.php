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
                <table id="dt_user" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-left" style="min-width:125px;">Name</th>
                            <th class="text-left">Username</th>
                            <th class="text-left">Email</th>
                            <th class="text-center" style="min-width:125px;">Role</th>
                            <th class="text-center" style="min-width:125px;">Branch</th>
                            <th class="text-center" style="min-width:230px;">Company</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Blocked</th>
                            <th class="text-center" style="min-width:130px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td class="text-left">{{ $user->name }}</td>
                                <td class="text-left">{{ $user->username }}</td>
                                <td class="text-left">{{ $user->email }}</td>
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
                                <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit" 
                                    data-id="{{ $user->id }}" 
                                    data-uuid="{{ $user->uuid }}" 
                                    data-user-name="{{ $user->name }}" 
                                    data-user-username="{{ $user->username }}" 
                                    data-user-email="{{ $user->email }}"
                                    data-branch-id="{{ $user->branch_id }}" 
                                    data-role-id="{{ $user->role_id }}"
                                    data-company_id="{{ $user->company_id }}"
                                    data-user-remarks="{{ $user->remarks }}">
                                    <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                </button>
                                    <a href="{{  url('permissions/' . $user->uuid . '/edit' ) }}" class="btn btn-sm btn-success" target="_self"><i class="fas fa-tasks"></i></a>
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
                    <h4 class="modal-title">Create New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('users.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25" id="modal_add_name" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Username</label>
                                <input type="text" class="form-control form-control-sm" name="username" maxlength="25" id="modal_add_username" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email" maxlength="25" id="modal_add_email" required>
                            </div>
                            <div class="col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password" required>
                            </div>
                            <div class="col-12">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirmpassword" required>
                                <div class="form-text confirm-message"></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="select2" multiple="multiple" name="company_id" data-dropdown-css-class="select2-primary" style="width: 100%;" id="modal_add_company_id" required>
                                        <option value="" disabled>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="select2" multiple="multiple" name="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;" id="modal_add_branch_id" required>
                                        <option value="" disabled>-- Select Branch --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <select class="form-control form-control-sm" name="role_id" id="modal_add_role_id" required>
                                        <option value="" disabled selected>-- Select Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_add_close">Close</button>
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
                    <h4 class="modal-title">Edit User</h4>
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
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" id="modal_edit_name" maxlength="25" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Username</label>
                                <input type="text" class="form-control form-control-sm" name="username" id="modal_edit_username" maxlength="25" readonly>
                            </div>
                            <div class="col-12">
                                <label for="name">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email" id="modal_edit_email" maxlength="255" required>
                            </div>
                            {{-- <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Block User?</label>
                                    <div class="col-12">
                                        <input type="radio" name="blocked" value="1" checked>
                                        <label for="" class="mr-4">Yes</label>
                                        <input type="radio" name="active" value="1">
                                        <label for="">No</label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="select2" multiple="multiple" name="company_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        <option value="" disabled selected>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="comapny_id">Role</label>
                                    <select class="form-control form-control-sm" name="role_id" id="modal_edit_role_id" required>
                                        <option value="" disabled selected>-- Select Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="select2" multiple="multiple" name="branch_id" id="modal_edit_branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        <option value="" disabled selected>-- Select Branch --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_edit_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


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
    <style>
        .success-message{
            color:green
        }
        .error-message{
            color:red;
        }
    </style>
@endsection

@section('adminlte_js')
    <script>
        $(document).ready(function() {

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });

        $('#dt_user').DataTable({
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
                    targets: [9], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_user").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $('.btn_edit').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-user-name");
            var username = $(this).attr("data-user-username");
            var email = $(this).attr("data-user-email");
            var remarks = $(this).attr("data-user-remarks");
            var r_id = $(this).attr("data-user-role_id");
            var b_id = $(this).attr("data-user-branch_id");
            var c_id = $(this).attr("data-user-company_id");


            $('#modal_edit_name').val(name); 
            $('#modal_edit_username').val(username); 
            $('#modal_edit_email').val(email);
            $('#modal_show_remarks').val(remarks);
            $('#modal_edit_role_id option[value=' + r_id + ']').attr('selected', 'selected');
            $('#modal_edit_branch_id option[value=' + b_id + ']').attr('selected', 'selected');
            $('#modal_edit_company_id option[value=' + c_id + ']').attr('selected', 'selected');

            // define the edit form action
            let action = window.location.origin + "/users/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });


        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-user-name");
            var code = $(this).attr("data-user-code");
            var remarks = $(this).attr("data-user-remarks");
            var status_id = $(this).attr("data-user-status_id");
            var updated_by = $(this).attr("data-user-updated_by");

            // set multiple attributes
            $('#modal_show_name').val(name);
            $('#modal_show_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);
            $('#modal_show_updated_by').val(updated_by);
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
                        $('#modal_add_username').val('');
                        $('#modal_add_email').val('');
                        $('#password').val('');
                        $('#confirmpassword').val('');
                        $('.confirm-message').text('');
                        $('#modal_add_role_id').val(''); 
                        $('#modal_add_branch_id').val('');     
                        $('#modal_add_company_id').val('');                     
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

        $('#password, #confirmpassword').on('keyup', function(){

        $('.confirm-message').removeClass('success-message').removeClass('error-message');

        let password=$('#password').val();
        let confirm_password=$('#confirmpassword').val();

        if(password===""){
            $('.confirm-message').text("Password Field cannot be empty").addClass('error-message');
        }
        else if(confirm_password===""){
            $('.confirm-message').text("Confirm Password Field cannot be empty").addClass('error-message');
        }
        else if(confirm_password===password)
        {
            $('.confirm-message').text('Password Match!').addClass('success-message');
        }
        else{
            $('.confirm-message').text("Password Doesn't Match!").addClass('error-message');
        }
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
