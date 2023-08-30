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
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal" 
                                        data-target="#modal-show" 
                                        data-uuid="{{ $payment->uuid }}" 
                                        data-payment-company-id="{{ $payment->company->id }}" 
                                        data-payment-name="{{ $payment->name }}" 
                                        data-payment-code="{{ $payment->code }}"
                                        data-payment-status_id="{{ $payment->status->name }}"
                                        data-payment-remarks="{{ $payment->remarks }}">
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-uuid="{{ $payment->uuid }}" 
                                        data-payment-company-id="{{ $payment->company->id }}" 
                                        data-payment-name="{{ $payment->name }}" 
                                        data-payment-code="{{ $payment->code }}"
                                        data-payment-status_id="{{ $payment->status->id }}"
                                        data-payment-remarks="{{ $payment->remarks }}">
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
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('payment-types.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
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
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" required>
                            </div>
                            <div class="col-12">
                                <label for="code">Account Number</label>
                                <input type="number" class="form-control form-control-sm" name="code" maxlength="12" min="0" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required>
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
                    <h4 class="modal-title">Edit Payment Type</h4>
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
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control form-control-sm" name="company_id" id="modal_edit_company_id" required>
                                        <option value="" disabled>-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" id="modal_edit_name" required style="text-transform:uppercase">
                            </div>
                            <div class="col-12">
                                <label for="code">Account Number</label>
                                <input type="number" class="form-control form-control-sm" maxlength="12" min="0" name="code" id="modal_edit_code" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required>
                            </div><br>
                            <div class="col-12">
                                <label for="">Disable Payment?</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="7" checked="checked">
                                <label for="">YES</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="6">
                                <label for="">NO</label><br>
                            </p>
                            </div>
                            <div class="col-12">
                                <label for="remarks">Remarks</label>
                                <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required oninput="this.value = this.value.toUpperCase()">
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
                    <h4 class="modal-title">Payment Type Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control form-control-sm" name="company_id" id="modal_show_company_id" disabled>
                                    <option value="" disabled>-- Select Company --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="name">Name</label>
                            <input type="" class="form-control form-control-sm" name="name" id="modal_show_name" disabled>
                        </div>
                        <div class="col-12">
                            <label for="code">Account Number</label>
                            <input type="number" class="form-control form-control-sm" maxlength="12" min="0" name="code" id="modal_show_code" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" disabled>
                        </div>
                        <div class="col-12">
                            <label for="status">Status</label>
                            <input type="" class="form-control form-control-sm" name="status" id="modal_show_status_id" disabled>
                        </div>
                        <div class="col-12">
                            <label for="remarks">Remarks</label>
                            <input type="" class="form-control form-control-sm" name="remarks" id="modal_show_remarks" disabled>
                        </div>
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
                    targets: [4], // column index (start from 0)
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
            var uuid = $(this).attr("data-uuid");
            var c_id = $(this).attr("data-payment-company-id");
            var name = $(this).attr("data-payment-name");
            var code = $(this).attr("data-payment-code");
            var remarks = $(this).attr("data-payment-remarks");
            var status_id = $(this).attr("data-payment-status_id");

            $('#modal_edit_company_id option[value=' + c_id + ']').attr('selected', 'selected');
            $('#modal_edit_name').val(name); 
            $('#modal_edit_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);

            // define the edit form action
            let action = window.location.origin + "/payment-types/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });


        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var c_id = $(this).attr("data-payment-company-id");
            var name = $(this).attr("data-payment-name");
            var code = $(this).attr("data-payment-code");
            var remarks = $(this).attr("data-payment-remarks");
            var status_id = $(this).attr("data-payment-status_id");

            // set multiple attributes
            $('#modal_show_company_id option[value=' + c_id + ']').attr('selected', 'selected');
            $('#modal_show_name').val(name);
            $('#modal_show_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);
        });
    });
</script>
@endsection