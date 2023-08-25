@extends('adminlte::page')

@section('title', 'Payment Types')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payment Types</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-add">Create Payment Type</button>
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
                            <th class="text-center">Name</th>
                            <th class="text-center">Account Number</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">{{ $payment->name }}</td>
                                <td class="text-center">{{ $payment->code }}</td>
                                <td class="text-center">{{ $payment->company->name}}</td>
                                <td class="text-center">{{ $payment->status->name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-default btn_delete" data-uuid="{{ $payment->uuid }}" data-payment-name="{{ $payment->name }}" data-payment-code="{{ $payment->code }}"><i class="far fa-eye"></i> Show</button>
                                    <a class="btn btn-sm btn-primary" href="{{ route('payment-types.edit',$payment->uuid) }}"><i class="fas fa-pencil-alt"> Edit</i></a>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pencil-alt"> Edit</i></button>
                                
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

    <form id="form_add" action="{{ url('payment-types') }}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="name" id="hidden_create_payment_name">
        <input type="hidden" name="code" id="hidden_create_payment_code">
    </form>

    {{--  modal for create --}}
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Create New Payment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <p>
         <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                        <form class="form-horizontal" action="{{ route('payment-types.store') }}" method="POST" id="submit" autocomplete="off">
                            @csrf
            <div>
                <div class="col-md-12 col-6">
                    <div class="form-group">
                        <label>Company</label>
                        <select class="form-control form-control-sm" name="company_id" required>
                            <option value="" selected="true" disabled>-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-6">
                    <label for="quantity">Name</label>
                    <input type="text" class="form-control form-control-sm"  name="name" required>
                </div>
                <div class="col-md-12 col-6">
                    <label for="quantity">Account Number</label>
                    <input type="number" class="form-control form-control-sm" maxlength="12" min="0" name="code" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required>
                </div>
            </div>
        </p>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-sm m-2" id="submit"><i class="fas fa-save mr-2"></i>Save</button>
        </div>
        </div>

        {{--  modal for editing --}}
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Create New Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <p>
                 <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <form class="form-horizontal" action="{{ route('payment-types.update', $payment_types->uuid) }}" method="POST" id="submit" autocomplete="off">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control form-control-sm" name="company_id" required>
                                    <option value="" selected="true" disabled>-- Select Company --</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id}}" {{ $payment_types->company_id == $company->id ? 'selected' : '' }} >{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $payment_types->name }}" name="name" required>
                        </div>
                        <div class="col-md-4 col-6">
                            <label for="code">Account Number</label>
                            <input type="number" class="form-control form-control-sm" maxlength="12" min="0" value="{{ $payment_types->code }}" name="code" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required>
                        </div>
                    </div>
                    <div>
                    <input type="checkbox" name="status" value="7">
                    <label for="status">&nbsp; Disable Payment?</label><br>
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control form-control-sm" name="remarks" required><br>
                    </div>
            </p>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
            <button class="btn btn-primary btn-sm m-2" id="submit"><i class="fas fa-save mr-2"></i>Save</button>
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
            initComplete: function () {
                $("#dt_payment").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
    });

    $('.btn_edit').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var payment_name = $(this).attr("data-payment-name");
        var payment_code = $(this).attr("data-payment-code");

        // show the confirmation
        Swal.fire({
            title: 'Edit Payment Type',
            // input: 'text',
            // inputValue: branch_name,
            // inputAttributes: {
            //     autocapitalize: 'off',
            //     defaultValue: branch_name,
            //     required: 'true',
            // },
            html:
            '<label for="swal-edit-input1">Name</label>' +
                '<input id="swal-edit-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" value="' + payment_name + '" required>' +
                '<label for="swal-edit-input1">Name</label>' +
                '<input id="swal-edit-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" value="' + payment_name + '" required>' +
                '<label for="swal-edit-input2">Code</label>' +
                '<input id="swal-edit-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" value="' + payment_code + '" required maxlength="12">',
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
            inputPlaceholder: payment_name,
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
                    $('#form_edit').attr('action', window.location.origin + '/payment-types/' + uuid);

                    // submit the form to controller -> Update method
                    $('#form_edit').submit();

                    // final confirmation will come from Update method
                }
            })
    });

    $('.btn_delete').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var payment_name = $(this).attr("data-payment-name");

        Swal.fire({
            title: 'Are you sure you want to delete ' + payment_name + ' type?',
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
                $('#form_delete').attr('action', window.location.origin + '/payment-types/' + uuid);

                // submit the form to controller -> Update method
                $('#form_delete ').submit();

                // final confirmation will come from Delete method
            }
        })
    });

    $('#btn_add_payment').on('click', function() {
        // show the confirmation
        Swal.fire({
            title: 'Add Payment Type',
            html:
                '<label for="swal-select">Company</label>' +
                '<input id="swal-select" class="swal2-select" placeholder="Company" style="width:100%;display:flex" required>' +
                '<label for="swal-input1">Name</label>' +
                '<input id="swal-input1" class="swal2-input" placeholder="Name" style="width:100%;display:flex" required>' +
                '<label for="swal-input2">Code</label>' +
                '<input id="swal-input2" class="swal2-input" placeholder="Code" style="width:100%;display:flex" required maxlength="12">',
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
                    $('#hidden_create_payment_name').val(result.value[0]);
                    $('#hidden_create_payment_code').val(result.value[1]);

                    // submit the form to controller -> Update method
                    $('#form_add').submit();
                }
            })
    });
</script>
@endsection