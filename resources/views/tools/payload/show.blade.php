@extends('adminlte::page')

@section('title', 'Payload')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payload</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <label for="">Distributor</label>
                    <textarea class="form-control json-textarea">{{ $payload->distributor }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Sales Order</label>
                    <textarea class="form-control json-textarea">{{ $payload->so }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Sales Invoice</label>
                    <textarea class="form-control json-textarea">{{ $payload->si }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Payment</label>
                    <textarea class="form-control json-textarea">{{ $payload->payment }}</textarea>
                </div>
            </div>

            
            <h5 class="mt-5">Response Code</h5>
            <div class="row">
                
                <div class="col-3">
                    <div class="form-group">
                        <label for="distributor">Distributor</label>
                        <input type="text" class="form-control form-control-sm" id="distributor" value="{{ $payload->distributor_response_status }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="sales_order">Sales Order</label>
                        <input type="text" class="form-control form-control-sm" id="sales_order" value="{{ $payload->so_response_status }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="sales_invoice">Sales Invoice</label>
                        <input type="text" class="form-control form-control-sm" id="sales_invoice" value="{{ $payload->si_response_status }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="payment">Payment</label>
                        <input type="text" class="form-control form-control-sm" id="payment" value="{{ $payload->payment_response_status }}" disabled>
                    </div>
                </div>
            </div>


            <h5 class="mt-5">Response Body</h5>
            <div class="row">
                <div class="col-3">
                    <label for="">Distributor</label>
                    <textarea class="form-control json-textarea" disabled>{{ $payload->distributor_response_body }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Sales Order</label>
                    <textarea class="form-control json-textarea">{{ $payload->so_response_body }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Sales Invoice</label>
                    <textarea class="form-control json-textarea">{{ $payload->si_response_body }}</textarea>
                </div>
                <div class="col-3">
                    <label for="">Payment</label>
                    <textarea class="form-control json-textarea">{{ $payload->payment_response_body }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('tools/payload') }}" class="btn btn-lg btn-info float-left"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
        </div>
    </div>
@endsection

@section('adminlte_css')
<style>
    textarea {
        height: 200px !important;
        width: 100%;
        box-sizing: border-box;
    }
</style>
@endsection                 

@section('adminlte_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var jsonTextAreas = document.querySelectorAll('.json-textarea');

        jsonTextAreas.forEach(function (textarea) {
            try {
                var jsonString = textarea.value;
                var parsedJson = JSON.parse(jsonString);
                var formattedJson = JSON.stringify(parsedJson, null, 2);
                textarea.value = formattedJson;
            } catch (error) {
                console.error('Invalid JSON string:', error);
            }
        });
    });
</script>
@endsection