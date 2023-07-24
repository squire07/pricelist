@extends('adminlte::page')

@section('title', 'Build Report')

@section('content_header')
    <h1>Build Report</h1>

    <form action="" method="GET">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Start Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="start_date" id="start_date" required/>
                <label>End Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="end_date" id="end_date" required/>           
            </div>      
        <input type="submit" class="btn btn-info" name="submit" value="Generate">       
        </div> 
    </form>
    <div class="container-fluid">
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
            {{-- <tbody>
            <tr>
            @foreach ($items as $item)
            <td> {{ $item->item }} </td>
            </tr>
            @endforeach
            </tr>
            </tbody> --}}
            </table>
            </div>
            
    </div>
    <script>
        document.getElementById("start_date").valueAsDate = new Date();
        document.getElementById("end_date").valueAsDate = new Date();
    </script>
@endsection
