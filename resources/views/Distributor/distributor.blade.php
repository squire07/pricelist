@extends('adminlte::page')

@section('title', 'Distributor List')

@section('content_header')
    <h1>Distributor List</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div>
            <a href="{{ url('distributor/create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add New</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
            <th>BCID</th>
            <th>Name</th>
            <th>Group</th>
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach ($distributors as $distributor)
            <td> {{ $distributor->bcid }} </td>
            <td> {{ $distributor->distributor }} </td>
            <td> {{ $distributor->group }} </td>
            <td>
                {{-- <form action="{{ route('Department.destroy',$department->id) }}" method="POST"> --}}
                   
                <a class="btn btn-info" href="{{ route('distributor.show',$distributor->id) }}"><i class="fas fa-search"></i></a>
                
                {{-- <a class="btn btn-primary" href="{{ route('Department.edit',$department->id) }}"><i class="fas fa-pencil-alt"></i></a>

                @csrf
                @method('DELETE')
  
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button> --}}
            {{-- </td>
            </form> --}}
            </tr>
            @endforeach
            </tr>
            </tbody>
            </table>
            </div>
            
    </div>
@endsection