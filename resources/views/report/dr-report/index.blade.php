@extends('adminlte::page')

@section('title', 'Stock Card Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Delivery Report</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ Route('generate-item-dr-report') }}" method="get" id="period_report">
            @csrf
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="col-12">
                                            <input type="radio" name="report" value="1" checked>
                                            <label for="" class="mr-4">Customers</label><br>
                                            <input type="radio" name="report" value="2">
                                            <label for="">Products</label><br>
                                            <input type="radio" name="report" value="3">
                                            <label for="" class="mr-4">Delivery Details</label><br>
                                            <input type="radio" name="report" value="4">
                                            <label for="">Payment Details</label><br>
                                        </div>
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
      //timePickerIncrement: 30,
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
});
</script>
@endsection