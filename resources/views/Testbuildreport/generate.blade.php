@extends('adminlte::page')

@section('title', 'Test Build Report')

@section('content_header')
    <h1>Test Build Report</h1>
    <div class="container-fluid">
        <a href="/testbuildreport" class="btn btn-default">Generate Again</a>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>BCID</th>
            <th>Name</th>
            <th>NUC</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach ($testbuildreports as $buildreport)
            <td> {{ $buildreport->date }} </td>
            <td> {{ $buildreport->invoice_number }} </td>
            <td> {{ $buildreport->bcid }} </td>
            <td> {{ $buildreport->name }} </td>
            <td> {{ $buildreport->nuc }} </td>
            </tr>
            @endforeach
            </tr>
            </tbody>
            </table>
            </div>
    </div>
@endsection
