@extends('adminlte::page')

@section('title', 'Transaction List Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaction List Report</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ Route('generate-transaction-list-report') }}" method="get" id="period_report">
            @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">                            
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Company</label>
                                            <select class="form-control form-control-sm" name="company_id" id="company_id" data-dropdown-css-class="select2-primary" style="width: 100%; height:35px;" required>
                                                {{-- @if(count($companies) > 1) --}}
                                                    <option value="" selected="true">-- Select --</option>
                                                {{-- @endif --}}
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select class="form-control form-control-sm" name="branch_id" id="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%; height:35px;">
                                                @if(count($branches) > 1)
                                                    <option value="" selected="true">-- All --</option>
                                                @endif
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" data-company-id="{{ $branch->company_id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Transaction Type</label>
                                            <select class="form-control form-control-sm select2 select2-primary" name="transaction_type_id" id="transaction_type_id" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                <option value="" selected="true">-- All --</option>
                                                @foreach($transaction_types as $transaction_type)
                                                    <option value="{{ $transaction_type->id }}">{{ $transaction_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Items</label>
                                            <select class="form-control form-control-sm select2 select2-primary" name="item" id="item" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                <option value="" selected="true">-- All --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->name }}" data-item-name="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Invoice #</label>
                                            <input type="text" class="form-control form-control-sm" name="invoice" id="invoice" data-dropdown-css-class="select2-primary" style="width: 100%;" placeholder="-- All --">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Cashier Name</label>
                                            <select class="form-control form-control-sm mt-2 select2 select2-primary" name="cashier" id="cashier_id" data-dropdown-css-class="select2-primary" style="width: 100%; height:35px;">
                                                    <option value="" selected="true">-- All --</option>
                                                @foreach($cashiers as $cashier)
                                                    <option value="{{ $cashier->id }}" data-user-id="{{ $cashier->id }}">{{ $cashier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Summary Only</label>
                                            <input type="checkbox" name="summary_report" id="summary_report">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">As Of</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {{-- <div class="input-group date" id="as_of" data-target-input="nearest">
                                            <div class="input-group-prepend" data-target="#as_of" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <input type="text" name="as_of" id="as_of" class="form-control datetimepicker-input" data-target="#as_of">
                                        </div> --}}

                                        <div class="input-group date" id="as_of" data-target-input="nearest">
                                            <div class="input-group-prepend" data-target="#as_of" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <input type="text" name="as_of" id="as_of_input" class="form-control datetimepicker-input" data-target="#as_of">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <input type="submit" class="btn btn-default" name="as_of_report" value="Generate Report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Period</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" name="period" id="period" class="form-control float-right" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <input type="submit" class="btn btn-default" name="period_report" value="Generate Report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('adminlte_css')
<style>
    select option { 
        line-height: 20px;
    }
</style>
@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    // initialize select2 on this page using bootstrap 4 theme
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    $('#as_of').datetimepicker({
        format: 'L',
        defaultDate: new Date(),
        maxDate: new Date(),
        autoclose: true,
        todayHighlight: true,
        showAnim: 'fold',
    });

    $('#as_of_input').focus(function () {
        $('#as_of').datetimepicker('toggle');
    });

    $('#period').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      },
      maxDate: new Date(),
    })

    $('#company_id').on('change', function() {
        let company_id = $(this).val();

        if (company_id == 2) {
            $('#branch_id').find('option[data-company-id="3"]').hide();
            $('#branch_id').find('option[data-company-id="2"]').show();
        } else if (company_id == 3) {
            $('#branch_id').find('option[data-company-id="2"]').hide();
            $('#branch_id').find('option[data-company-id="3"]').show();
        } else {
            $('#branch_id').find('option[data-company-id]').show();
        }

        $('#branch_id').val(null).trigger('change');
    });

        $('#summary_report').on('change', function () {
            if ($(this).prop('checked')) {
                $('#period_report').attr('action', '{{ route('generate-summary-transaction-list-report') }}');
            } else {
                $('#period_report').attr('action', '{{ route('generate-transaction-list-report') }}');
            }
    });
});
</script>
@endsection