@extends('adminlte::page')

@section('title', 'Stock Card Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Stock Card Report</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ Route('generate-stock-card-report') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="company_id" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    @if(count($companies) > 1)
                                        <option value="" selected="true">-- All --</option>
                                    @endif
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    @if(count($branches) > 1)
                                        <option value="" selected="true">-- All --</option>
                                    @endif
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Transaction Type</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="transaction_type_id" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option value="" selected="true">-- All --</option>
                                    @foreach($transaction_types as $transaction_type)
                                        <option value="{{ $transaction_type->id }}">{{ $transaction_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>As of:</label>
                                <div class="input-group date" id="as_of" data-target-input="nearest">
                                    <input type="text" name="as_of" class="form-control form-control-sm datetimepicker-input" data-target="#as_of" style="padding:16px">
                                    <div class="input-group-append" data-target="#as_of" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="submit" class="btn btn-default" value="Generate Report">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
$(function () {
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

});
</script>
@endsection