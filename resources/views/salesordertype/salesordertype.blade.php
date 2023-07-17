@extends('adminlte::page')

@section('title', 'Sales Order Type')

@section('content_header')
    <h1>Sales Order Type</h1>
    <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
            <th>Sales Type ID</th>
            <th>Company</th>
            <th>Sales Order Type</th>
            <th>Income Account</th>
            <th>Expense Account</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach ($salesordertypes as $salesordertype)
            <td> {{ $salesordertype->sales_type_id }} </td>
            <td> {{ $salesordertype->sales_company }} </td>
            <td> {{ $salesordertype->sales_order_type }} </td>
            <td> {{ $salesordertype->income_account }} </td>
            <td> {{ $salesordertype->expense_account }} </td>
            </tr>
            @endforeach
            </tr>
            </tbody>
            </table>
            </div>
            
    </div>
@endsection