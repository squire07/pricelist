@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_role" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Updated By</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="text-center">{{ $role->created_by }}</td>
                                <td class="text-center">{{ $role->created_at }}</td>
                                <td class="text-center">{{ $role->updated_by }}</td>
                                <td class="text-center">{{ $role->updated_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-default btn_edit" data-uuid="{{ $role->uuid }}" data-role-name="{{ $role->name }}"><i class="far fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-default btn_delete" data-uuid="{{ $role->uuid }}" data-role-name="{{ $role->name }}"><i class="far fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    {{-- hidden form to submit SO for invoicing --}}
    <form id="form_edit" method="POST">
        @method('PATCH')
        @csrf
        <input type="hidden" name="uuid" id="hidden_edit_uuid">
        <input type="hidden" name="name" id="hidden_edit_name">
    </form>

    <form id="form_delete" method="POST">
        @method('DELETE')
        @csrf
        <input type="hidden" name="uuid" id="hidden_delete_uuid">
    </form>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_role').DataTable({
            dom: 'Bfrtip',
            autoWidth: true,
            responsive: true,
            order: [[ 5, "desc" ]],
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            initComplete: function () {
                $("#dt_role").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
    });

    // $('.btn_edit').on('click', function() {
    //     var uuid = $(this).attr("data-uuid");
    //     var branch_name = $(this).attr("data-branch-name");

    //     // show the confirmation
    //     Swal.fire({
    //         title: 'Edit Branch',
    //         input: 'text',
    //         inputValue: branch_name,
    //         inputAttributes: {
    //             autocapitalize: 'off',
    //             efaultValue: branch_name,
    //             required: 'true',
    //         },
    //         inputValidator: (value) => {
    //             return new Promise((resolve) => {
    //                 if (value.length >= 4) {
    //                     resolve();
    //                 } else if (value.length == 0) {
    //                     resolve('Branch name is required!');
    //                 } else if (value.length <= 3) {
    //                     resolve('Branch name is not valid!');
    //                 }
    //             });
    //         },
    //         inputPlaceholder: branch_name,
    //         showCancelButton: true,
    //         confirmButtonText: 'Update',
    //         cancelButtonColor: '#d33',
    //         confirmButtonColor: '#3085d6',
    //         showLoaderOnConfirm: true,
    //         allowOutsideClick: () => !Swal.isLoading()
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 // get the uuid and pass to form_edit
    //                 $('#hidden_edit_uuid').val(uuid);

    //                 // get the updated branch name and pass to form_edit 
    //                 $('#hidden_edit_name').val(result.value);

    //                 // update the action of form_edit
    //                 $('#form_edit').attr('action', window.location.origin + '/branches/' + uuid);

    //                 // submit the form to controller -> Update method
    //                 $('#form_edit').submit();

    //                 // final confirmation will come from Update method
    //             }
    //         })
    // });

    // $('.btn_delete').on('click', function() {
    //     var uuid = $(this).attr("data-uuid");
    //     var branch_name = $(this).attr("data-branch-name");

    //     Swal.fire({
    //         title: 'Are you sure you want to delete ' + branch_name + ' branch?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // get the uuid and pass to form_edit
    //             $('#hidden_delete_uuid').val(uuid);

    //             // update the action of form_edit
    //             $('#form_delete').attr('action', window.location.origin + '/branches/' + uuid);

    //             // submit the form to controller -> Update method
    //             $('#form_delete ').submit();

    //             // final confirmation will come from Delete method
    //         }
    //     })
    // });
</script>
@endsection