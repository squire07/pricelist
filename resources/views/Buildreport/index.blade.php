@extends('adminlte::page')

@section('title', 'Item Build Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Item Build Report</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ Route('generate-item-build-report') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control form-control-sm" name="company_id" id="company_id" data-dropdown-css-class="select2-primary" style="width: 100%; height:35px;" required>
                                    <option value="" selected disabled>-- Select Company --</option>
                                    @foreach($companies as $company)
                                        @if(in_array($company->status_id, [8,1]))
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control form-control-sm" name="branch_id" id="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%; height:35px;" disabled>
                                    <option value="" selected disabled>-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" data-company-id="{{ $branch->company_id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="daterange">Request Date</label>
                                <div class="form-group form-group-sm">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange" value="{{ Request::get('daterange') }}">

                                        {{-- <div class="input-group-append" onclick="document.getElementById('request_date').submit();">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                        <div class="input-group-append" onclick="window.location.assign('{{ url('reports/nuc') }}')">
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                        </div> --}}
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

    $('#company_id').on('change', function() {
        let company_id = $(this).val();
        $('#branch_id').prop('disabled', false);

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

});
</script>
@endsection