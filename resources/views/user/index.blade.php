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
                            <th class="text-center" style="min-width:125px;">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
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
                                <td class="text-center">
                                    {{ !is_null($user->branch_id) ? str_replace(',', ', ', Helper::get_branch_name_by_id($user->branch_id)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ !is_null($user->company_id) ? str_replace(',', ', ', Helper::get_company_names_by_id($user->company_id)) : '' }}
                                </td>
                                <td class="text-center">
                                    @if($user->active == 1)
                                        <i class="fas fa-check-circle" style="color:#28a745"></i>
                                    @else
                                        <i class="fas fa-times-circle" style="color:#dc3545"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->blocked == 1)
                                        BLOCKED
                                        {{-- <i class="fas fa-times-circle" style="color:#dc3545"></i> --}}
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
                                    data-company-id="{{ $user->company_id }}"
                                    data-user-active="{{ $user->active }}"
                                    data-user-blocked="{{ $user->blocked }}">
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

    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
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
                                <input type="email" class="form-control form-control-sm" name="email" maxlength="55" id="modal_add_email" required>
                            </div>
                            <div class="col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" name="password" id="password" maxlength="12" minlength="8" required>
                            </div>
                            <div class="col-12">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirmpassword" maxlength="12" minlength="8" required>
                                <div class="form-text confirm-message"></div>
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
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="companies">Companies</label>
                                    <select class="select2" multiple="multiple" id="modal_add_company" name="company_id[]" data-name="company_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="companies">Branches</label>
                                    <select class="select2" multiple="multiple" id="modal_add_branch" name="branch_id[]" data-name="branch_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" class="{{ $branch->company_id == 3 ? 'branch-local' : 'branch-premier' }}">{{ $branch->name }}</option>
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
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
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
                                <input type="email" class="form-control form-control-sm" name="email" id="modal_edit_email" maxlength="55" required>
                            </div>
                            <div class="col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" name="password" id="password_edit" maxlength="12" minlength="8">
                            </div>
                            <div class="col-12">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirmpassword_edit" maxlength="12" minlength="8">
                                <div class="form-text confirm-message"></div>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">User Status</label>
                                    <div class="col-12">
                                        <input type="radio" name="active" value="1" id="status_1">
                                        <label for="" class="mr-4">Active</label>
                                        <input type="radio" name="active" value="0" id="status_0">
                                        <label for="">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Block User?</label>
                                    <div class="col-12">
                                        <input type="radio" name="blocked" value="1" id="blocked_1" required>
                                        <label for="" class="mr-4">Yes</label>
                                        <input type="radio" name="blocked" value="0" id="blocked_0" required>
                                        <label for="">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="companies">Companies</label>
                                    <select class="select2" multiple="multiple" id="modal_edit_company_id" name="company_id[]" data-name="company_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="companies">Branches</label>
                                    <select class="select2" multiple="multiple" id="modal_edit_branch_id" name="branch_id[]" data-name="branch_name[]" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" class="{{ $branch->company_id == 3 ? 'branch-local' : 'branch-premier' }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>                                 
                                </div>
                            </div>
                            {{-- <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="companies">Companies</label>
                                    @foreach($companies as $company)
                                        <br/>
                                        <input type="checkbox" name="company_id[]" id="modal_edit_company_{{ $company->id }}" value={{ $company->id }}><span class="ml-2">{{ $company->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="branches">Branches</label>                                   
                                    @foreach($branches as $branch)
                                        <br/>
                                        <input type="checkbox" name="branch_id[]" class="{{ $branch->company_id == 3 ? 'branch-local' : 'branch-premier' }}" id="modal_edit_branch_{{ $branch->id }}" value={{ $branch->id }}><span class="ml-2">{{ $branch->name }}</span>
                                    @endforeach
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_edit_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_css')    
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
        $(document).on('click', '.btn_edit', function() {

            var uuid = $(this).attr("data-uuid");
            var company_id = $(this).attr("data-company-id");
            var branch_id = $(this).attr("data-branch-id");
            var r_id = $(this).attr("data-role-id");
            var name = $(this).attr("data-user-name");
            var username = $(this).attr("data-user-username");
            var email = $(this).attr("data-user-email");
            var active = $(this).attr("data-user-active");
            var blocked = $(this).attr("data-user-blocked");

            $('#modal_edit_role_id option[value=' + r_id + ']').attr('selected', 'selected');
            $('#modal_edit_name').val(name); 
            $('#modal_edit_username').val(username); 
            $('#modal_edit_email').val(email);
            $('#modal_show_active').val(active);
            $('#modal_show_blocked').val(blocked);

            // add check to active status
            if(active == 1) {
                $('#status_1[value="1"]').prop('checked', true);
            } else if(active == 0) {
                $('#status_0[value="0"]').prop('checked', true);
            } 

            // add check to blocked status
            if(blocked == 1) {
                $('#blocked_1[value="1"]').prop('checked', true);
            } else if(blocked == 0) {
                $('#blocked_0[value="0"]').prop('checked', true);
            } 

            // if(company_id == 2) {
            //     $('.branch-premier').prop('disabled', false);
            // } else if(company_id == 3) {
            //     $('.branch-local').prop('disabled', false);
            // } else {
            //     $('.branch-local').prop('disabled', false);
            //     $('.branch-premier').prop('disabled', false);
            // } 

            // add check to branch checkboxes
            // const array_branches = branch_id.split(",");
            // array_branches.forEach(function(element, index, array) {
            //     $('#modal_edit_branch_' + element).prop('checked',true);
            // });

            // // add check to company checkboxes
            // const array_companies = company_id.split(",");
            // array_companies.forEach(function(element, index, array) {
            //     $('#modal_edit_company_' + element).prop('checked',true);
            // });

            // define the edit form action
            let action = window.location.origin + "/users/" + uuid;
            $('#form_modal_edit').attr('action', action);
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
                    allowOutsideClick: false,
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
                        $('#password_edit').val('');
                        $('#confirmpassword_edit').val('');
                        $('.confirm-message').text('');
                        $('#modal_add_role_id').val(''); 
                        $('#modal_add_company').val(null).trigger('change');
                        $('#modal_add_branch').val(null).trigger('change'); 
                        $('#modal_edit_company_id').val(null).trigger('change'); 
                        $('#modal_edit_branch_id').val(null).trigger('change');                     
                    } else {
                        e.stopPropagation();

                    }
                });

            }
            return true;
        });

        $('#modal-add, #modal-edit').on('hidden.bs.modal', function () {
            $('#modal-add, #modal-edit').removeClass('programmatic');
        });

        //password and confirm password success and error for create modal
        $('#password, #confirmpassword').on('keyup', function(){

            $('.confirm-message').removeClass('success-message').removeClass('error-message');

            let password=$('#password').val();
            let confirm_password=$('#confirmpassword').val();

            if(password===""){
                $('.confirm-message').text("Password Field cant be empty and must be 8 characters").addClass('error-message');
            }
            else if(confirm_password===""){
                $('.confirm-message').text("Password Field cant be empty and must be 8 characters").addClass('error-message');
            }
            else if(confirm_password===password)
            {
                $('.confirm-message').text('Password Match!').addClass('success-message');
            }
            else{
                $('.confirm-message').text("Password Doesn't Match!").addClass('error-message');
            }
        });

        
        //password and confirm password success and error for edit modal
        $('#password_edit, #confirmpassword_edit').on('keyup', function(){

            $('.confirm-message').removeClass('success-message').removeClass('error-message');

            let password_edit=$('#password_edit').val();
            let confirm_password_edit=$('#confirmpassword_edit').val();

            if(password_edit === ""){
                $('.confirm-message').text("Password Field cant be empty and must be 8 characters").addClass('error-message');
            }
            else if(confirm_password_edit === ""){
                $('.confirm-message').text("Password Field cant be empty and must be 8 characters").addClass('error-message');
            }
            else if(confirm_password_edit === password_edit)
            {
                $('.confirm-message').text('Password Match!').addClass('success-message');
            }
            else{
                $('.confirm-message').text("Password Doesn't Match!").addClass('error-message');
            }
        });

        // Prevent user from using enter key
            
        $("input:text, input:password, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13 || event.keyCode === 32 || event.keyCode == "Escape") {
                event.preventDefault();
                return false;
            }
        });

        $( '#modal-add, #modal-edit' ).on( 'keypress', function( e ) {
            if( event.keyCode === 10 || e.keyCode === 13 || event.keyCode == "Escape" ) {
                e.preventDefault();
                $( this ).trigger( 'submit' );
            }
        });

        //enable branch when company is selected

        // $("#company_name[][value='2']").on('change', function(){
        // if ($(this).select2('selected')) {
        //     $('.branch-premier').select2('disabled', false);
        //     } else {
        //     $('.branch-premier').select2('disabled', true);
        //     }
        // });

        // $("select2[value='3']").on('change', function(){
        // if ($(this).select2('selected')) {
        //     $('.branch-local').select2('disabled', false);
        //     } else {
        //     $('.branch-local').select2('disabled', true);
        //     }
        // });

        // $("#modal_add_company[value='2']").on('click', function(){
        //     if ($(this).select2('company_name[]')) {
        //     // $('.branch-premier').select2('disabled', false);
        //     $('#modal_add_branch').hasClass('.branch-premier').select2('disabled', false)
        //     } else {
        //     // $('.branch-premier').select2('disabled', true);
        //     $('#modal_add_branch').hasClass('.branch-premier').select2('disabled', true)
        //     }
        // });

        // $("#modal_add_company[value='3']").on('click', function(){
        //     if ($(this).select2('company_name[]')) {
        //     // $('.branch-premier').select2('disabled', false);
        //     $('#modal_add_branch').hasClass('.branch-local').select2('disabled', false)
        //     } else {
        //     // $('.branch-premier').select2('disabled', true);
        //     $('#modal_add_branch').hasClass('.branch-local').select2('disabled', true)
        //     }
        // });
        
});
</script>
@endsection
