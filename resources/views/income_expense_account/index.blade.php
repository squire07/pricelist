@extends('adminlte::page')

@section('title', 'Income and Expense Accounts')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Income and Expense Accounts</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Account</button>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-bold">{{ $accounts->name ?? null }}</div>
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_transaction_types" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Currency</th>
                            <th class="text-center">Income Account</th>
                            <th class="text-center">Expense Account</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts->accounts as $account)
                            <tr>
                                <td class="text-center">{{ $account->id }}</td>
                                <td>{{ $account->company->name }}</td>
                                <td class="text-center validity">{{ $account->currency }}</td>
                                <td class="text-center">{{ $account->income_account }}</td>
                                <td class="text-center">{{ $account->expense_account }}</td>
                                <td class="text-center">{{ $account->created_at }}</td>
                                <td class="text-center">{{ $account->created_by }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-id="{{ $account->id }}" 
                                        data-company-id="{{ $account->company_id }}" 
                                        data-currency="{{ $account->currency }}"
                                        data-income-account="{{ $account->income_account }}"
                                        data-expense-account="{{ $account->expense_account }}">
                                        <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>   
            <div class="card-footer">
                <a href="{{ url('transaction-types') }}" class="btn btn-sm btn-primary" id="btn-sync">Return To Transaction Types</a>     
            </div> 
        </div>
    </div>

    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('income-expense-accounts.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $accounts->uuid }}">
                    <input type="hidden" name="transaction_type_id" value="{{ $accounts->id }}">
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="company_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                    <option value="" selected="true">-- Select Company --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="currency" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                    <option value="" selected="true">-- Select Currency --</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency['name'] }}">{{ $currency['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="income_account">Income Account</label>
                            <input type="text" class="form-control form-control-sm" name="income_account" minlength="15" required>
                        </div>
                        <div class="col-12">
                            <label for="expense_account">Expense Account</label>
                            <input type="text" class="form-control form-control-sm" name="expense_account" minlength="15" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_add_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--  modal for edit --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control form-control-sm select2 select2-primary" id="modal_edit_company_id" name="company_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        <option value="" selected="true">-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control form-control-sm select2 select2-primary" id="modal_edit_currency" name="currency" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                        <option value="" selected="true">-- Select Currency --</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency['name'] }}">{{ $currency['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="income_account">Income Account</label>
                                <input type="text" class="form-control form-control-sm" name="income_account" id="modal_edit_income_account" minlength="15" required>
                            </div>
                            <div class="col-12">
                                <label for="expense_account">Expense Account</label>
                                <input type="text" class="form-control form-control-sm" name="expense_account" id="modal_edit_expense_account" minlength="15" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_edit_close" >Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_css')
<style>

</style>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn_edit', function() {
            var id = $(this).attr("data-id");
            var company_id = $(this).attr("data-company-id");
            var currency = $(this).attr("data-currency");
            var income_account = $(this).attr("data-income-account");
            var expense_account = $(this).attr("data-expense-account");

            // $('#modal_edit_company_id[value="' + company_id + '"]').prop('selected', true);
            $('#modal_edit_company_id').val(company_id).trigger('change.select2');
            $('#modal_edit_currency').val(currency);
            $('#modal_edit_income_account').val(income_account);
            $('#modal_edit_expense_account').val(expense_account);

            // define the edit form action
            let action = window.location.origin + "/income-expense-accounts/" + id;
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
                        $('#modal_add_code').val('');
                        $('#modal_add_cost_center').val(''); 
                        $('#modal_edit_remarks').val('');  
                    } else {
                        e.stopPropagation();

                    }
                });

            }
            return true;
        });

        $('#modal-add, #modal-edit').on('hidden.bs.modal', function () {
            $('#modal-add , #modal-edit').removeClass('programmatic');
        });

        // Prevent user from using enter key
        $("input:text, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13) {
                event.preventDefault();
                return false;
            } else if ((event.keyCode >= 48 && event.keyCode <= 57) || // 0-9
                (event.keyCode >= 65 && event.keyCode <= 90) || // A-Z
                (event.keyCode >= 97 && event.keyCode <= 122) || // a-z
                event.keyCode === 45) { 
                return true; // Allow the character
            } else {
                return false; // Prevent the character
            }
        });
    });
</script>
@endsection