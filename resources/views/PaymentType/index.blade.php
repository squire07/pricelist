@extends('adminlte::page')

@section('title', 'Payment Types')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payment Types</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Payment Type</button>
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
                                <td class="text-center"><span class="badge {{ Helper::badge($payment->status_id) }}">{{ $payment->status->name }}</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal" 
                                        data-target="#modal-show" 
                                        data-uuid="{{ $payment->uuid }}" 
                                        data-payment-company-id="{{ $payment->company->name }}" 
                                        data-payment-name="{{ $payment->name }}" 
                                        data-payment-code="{{ $payment->code }}"
                                        data-payment-status_id="{{ $payment->status->name }}"
                                        data-payment-remarks="{{ $payment->remarks }}"
                                        data-payment-updated_by="{{ $payment->updated_by }}">
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
                                <input type="text" class="form-control form-control-sm" name="name" pattern="[a-zA-Z0-9\s]+" required>
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
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                                <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    Company
                                                    <select class="form-control form-control-sm" name="company_id" id="modal_edit_company_id" style="font-weight:bold" required>
                                                        <option value="" disabled>-- Select Company --</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}" style="font-weight:bold">{{ $company->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    Name
                                                    <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" required pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    Account Code
                                                    <input type="text" class="form-control form-control-sm" maxlength="3" name="code" id="modal_edit_code" required pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    Payment Status?<br>
                                                    <input type="radio" id="modal_edit_status_id" name="status" value="6" checked="checked">
                                                    <label for="">Enabled</label>&nbsp;&nbsp;
                                                    <input type="radio" id="modal_edit_status_id" name="status" value="7" style="margin-top: 8px">
                                                    <label for="">Disabled</label><br>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    Remarks
                                                <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required oninput="this.value = this.value.toUpperCase()" pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
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
                    <h4 class="modal-title">Payment Type Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon" id="ribbon_bg">
                                        <span id="modal_show_status_id"></span>
                                    </div>
                                </div>
                            </div>         
                        <div class="container-fluid">
                            <div class="col-12">
                            Company:
                            <span id="modal_show_company_id" style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Name:
                                <span id="modal_show_name" style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Branch Code:
                                <span id="modal_show_code"  style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Remarks:
                                <span id="modal_show_remarks" style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Updated By:
                                <span id="modal_show_updated_by" style="font-weight:bold"></span>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        </div>
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
            var updated_by = $(this).attr("data-payment-updated_by");

            // set multiple attributes
            $('#modal_show_company_id').text(c_id);
            $('#modal_show_name').text(name);
            $('#modal_show_code').text(code);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_status_id').text(status_id);
            $('#modal_show_updated_by').text(updated_by);
            console.log(c_id);
            if (status_id == 'Enabled') {
                $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
            } else {
                $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
            }
        });
</script>
@endsection