@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Companies</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" target="_self" class="btn btn-primary" id="btn_add_company">Add Company</a>
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
                            <th class="text-center">Code</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Updated By</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center">{{ $company->id }}</td>
                                <td>{{ $company->name }}</td>
                                <td class="text-center">{{ $company->code }}</td>
                                <td class="text-center">{{ $company->created_by }}</td>
                                <td class="text-center">{{ $company->created_at }}</td>
                                <td class="text-center">{{ $company->updated_by }}</td>
                                <td class="text-center">{{ $company->updated_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary btn_edit" data-uuid="{{ $company->uuid }}" data-company-name="{{ $company->name }}" data-company-code="{{ $company->code }}"><i class="far fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger btn_delete" data-uuid="{{ $company->uuid }}" data-company-name="{{ $company->name }}" data-company-code="{{ $company->code }}"><i class="far fa-trash-alt"></i> Delete</button>
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

    <form id="form_add" action="{{ url('companies') }}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="name" id="hidden_create_company_name">
        <input type="hidden" name="code" id="hidden_create_company_code">
    </form>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_company').DataTable({
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
            columnDefs: [ 
                {
                    targets: [7], // column index (start from 0)
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

    $('.btn_edit').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var company_name = $(this).attr("data-company-name");
        var company_code = $(this).attr("data-company-code");

        // show the confirmation
        Swal.fire({
            title: 'Edit Company',
            // input: 'text',
            // inputValue: company_name,
            // inputAttributes: {
            //     autocapitalize: 'off',
            //     defaultValue: company_name,
            //     required: 'true',
            // },
            html:
                '<label for="swal-edit-input1">Name</label>' +
                '<input id="swal-edit-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" value="' + company_name + '" required>' +
                '<label for="swal-edit-input2">Code</label>' +
                '<input id="swal-edit-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" value="' + company_code + '" required>',
            // inputValidator: (value) => {
            //     return new Promise((resolve) => {
            //         if (value.length >= 4) {
            //             resolve();
            //         } else if (value.length == 0) {
            //             resolve('Company name is required!');
            //         } else if (value.length <= 3) {
            //             resolve('Company name is not valid!');
            //         }
            //     });
            // },
            inputPlaceholder: company_name,
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

                    // get the updated company name and pass to form_edit 
                    $('#hidden_edit_name').val(result.value[0]);

                    // get the updated company code and pass to form_edit 
                    $('#hidden_edit_code').val(result.value[1]);

                    // update the action of form_edit
                    $('#form_edit').attr('action', window.location.origin + '/companies/' + uuid);

                    // submit the form to controller -> Update method
                    $('#form_edit').submit();

                    // final confirmation will come from Update method
                }
            })
    });

    $('.btn_delete').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var company_name = $(this).attr("data-company-name");

        Swal.fire({
            title: 'Are you sure you want to delete ' + company_name + '?',
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
                $('#form_delete').attr('action', window.location.origin + '/companies/' + uuid);

                // submit the form to controller -> Update method
                $('#form_delete ').submit();

                // final confirmation will come from Delete method
            }
        })
    });

    $('#btn_add_company').on('click', function() {
        // show the confirmation
        Swal.fire({
            title: 'Add Company',
            html:
                '<label for="swal-input1">Name</label>' +
                '<input id="swal-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" required>' +
                '<label for="swal-input2">Code</label>' +
                '<input id="swal-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" required>',
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
                    // get the updated company name and pass to form_edit 
                    $('#hidden_create_company_name').val(result.value[0]);
                    $('#hidden_create_company_code').val(result.value[1]);

                    // submit the form to controller -> Update method
                    $('#form_add').submit();
                }
            })
    });
</script>
@endsection

@section('adminlte_css')
<style>
    .swal2-html-container {
        margin: 0
    }
    
    .swal2-input {
        height: 2.625em;
        padding: 0 0.75em;
    }

    .swal2-file, .swal2-input, .swal2-textarea {
        box-sizing: border-box;
        width: 100%;
        transition: border-color .3s,box-shadow .3s;
        border: 1px solid #d9d9d9;
        border-radius: 0.1875em;
        background: inherit;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.06);
        color: inherit;
        font-size: 1.125em;
    }
</style>
@endsection