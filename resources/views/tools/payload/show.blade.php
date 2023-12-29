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
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Distributor</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="">Body</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->distributor }}</textarea>
                </div>
                <div class="col-6">
                    <label for="">Response: {{ $payload->distributor_response_status }} </label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->distributor_response_body }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Sales Order</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="">Body</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->so }}</textarea>
                </div>
                <div class="col-6">
                    <label for="">Response: {{ $payload->so_response_status }}</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->so_response_body }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Sales Invoice</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="">Body</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->si }}</textarea>
                </div>
                <div class="col-6">
                    <label for="">Response: {{ $payload->si_response_status }}</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->si_response_body }}</textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Comment</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="">Body</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->comment }}</textarea>
                </div>
                <div class="col-6">
                    <label for="">Response: {{ $payload->comment_status }}</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->comment_body }}</textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Payment</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="">Body</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->payment }}</textarea>
                </div>
                <div class="col-6">
                    <label for="">Response: {{ $payload->payment_response_status }}</label>
                    <textarea class="form-control json-textarea" readonly>{{ $payload->payment_response_body }}</textarea>
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