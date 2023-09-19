@extends('adminlte::page')

@section('title', 'Item List')

@section('content_header')
    <h1>Item List</h1>
    <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
            <th>Item</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach ($items as $item)
            <td> {{ $item->item }} </td>
            </tr>
            @endforeach
            </tr>
            </tbody>
            </table>
            </div>
            
    </div>
@endsection