@extends('adminlte::page')

@section('title', 'Branches')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Branches</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" target="_self" class="btn btn-primary" id="btn_add_branch">Add Branch</a>
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
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Updated By</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $branch)
                            <tr>
                                <td class="text-center">{{ $branch->id }}</td>
                                <td>{{ $branch->name }}</td>
                                <td class="text-center">{{ $branch->code }}</td>
                                <td class="text-center">{{ $branch->created_by }}</td>
                                <td class="text-center">{{ $branch->created_at }}</td>
                                <td class="text-center">{{ $branch->updated_by }}</td>
                                <td class="text-center">{{ $branch->updated_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary btn_edit" data-uuid="{{ $branch->uuid }}" data-branch-name="{{ $branch->name }}" data-branch-code="{{ $branch->code }}"><i class="far fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger btn_delete" data-uuid="{{ $branch->uuid }}" data-branch-name="{{ $branch->name }}" data-branch-code="{{ $branch->code }}"><i class="far fa-trash-alt"></i> Delete</button>
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
        <input type="hidden" name="code" id="hidden_edit_code">
    </form>

    <form id="form_delete" method="POST">
        @method('DELETE')
        @csrf
        <input type="hidden" name="uuid" id="hidden_delete_uuid">
    </form>

    <form id="form_add" action="{{ url('branches') }}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="name" id="hidden_create_branch_name">
        <input type="hidden" name="code" id="hidden_create_branch_code">
    </form>

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
                    targets: [7], // column index (start from 0)
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

    $('.btn_edit').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var branch_name = $(this).attr("data-branch-name");
        var branch_code = $(this).attr("data-branch-code");

        // show the confirmation
        Swal.fire({
            title: 'Edit Branch',
            // input: 'text',
            // inputValue: branch_name,
            // inputAttributes: {
            //     autocapitalize: 'off',
            //     defaultValue: branch_name,
            //     required: 'true',
            // },
            html:
                '<label for="swal-edit-input1">Name</label>' +
                '<input id="swal-edit-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" value="' + branch_name + '" required>' +
                '<label for="swal-edit-input2">Code</label>' +
                '<input id="swal-edit-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" value="' + branch_code + '" required maxlength="4">',
            // inputValidator: (value) => {
            //     return new Promise((resolve) => {
            //         if (value.length >= 4) {
            //             resolve();
            //         } else if (value.length == 0) {
            //             resolve('Branch name is required!');
            //         } else if (value.length <= 3) {
            //             resolve('Branch name is not valid!');
            //         }
            //     });
            // },
            inputPlaceholder: branch_name,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: function () {
                return new Promise(function (resolve) {
                    resolve([
                        $('#swal-edit-input1').val(),
                        $('#swal-edit-input2').val(),
                    ])
                })
            },
            }).then((result) => {
                if (result.isConfirmed) {
                    // get the uuid and pass to form_edit
                    $('#hidden_edit_uuid').val(uuid);

                    // get the updated branch name and pass to form_edit 
                    $('#hidden_edit_name').val(result.value[0]);

                    // get the updated company code and pass to form_edit 
                    $('#hidden_edit_code').val(result.value[1]);

                    // update the action of form_edit
                    $('#form_edit').attr('action', window.location.origin + '/branches/' + uuid);

                    // submit the form to controller -> Update method
                    $('#form_edit').submit();

                    // final confirmation will come from Update method
                }
            })
    });

    $('.btn_delete').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var branch_name = $(this).attr("data-branch-name");

        Swal.fire({
            title: 'Are you sure you want to delete ' + branch_name + ' branch?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // get the uuid and pass to form_edit
                $('#hidden_delete_uuid').val(uuid);

                // update the action of form_edit
                $('#form_delete').attr('action', window.location.origin + '/branches/' + uuid);

                // submit the form to controller -> Update method
                $('#form_delete ').submit();

                // final confirmation will come from Delete method
            }
        })
    });

    $('#btn_add_branch').on('click', function() {
        // show the confirmation
        Swal.fire({
            title: 'Add Branch',
            html:
                '<label for="swal-input1">Name</label>' +
                '<input id="swal-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" required>' +
                '<label for="swal-input2">Code</label>' +
                '<input id="swal-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" required maxlength="4">',
            onOpen: function () {
                $('#swal-input1').focus()
            },
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: function () {
                return new Promise(function (resolve) {
                    resolve([
                        $('#swal-input1').val(),
                        $('#swal-input2').val(),
                    ])
                })
            },
            }).then((result) => {
                if (result.isConfirmed) {
                    // get the updated branch name and pass to form_edit 
                    $('#hidden_create_branch_name').val(result.value[0]);
                    $('#hidden_create_branch_code').val(result.value[1]);

                    // submit the form to controller -> Update method
                    $('#form_add').submit();
                }
            })
    });
</script>
@endsection