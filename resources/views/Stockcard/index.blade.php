@extends('adminlte::page')

@section('title', 'Stock Card')

@section('content_header')
    <h1>Stock Card</h1>

    <form class="submit">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Start Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="start_date" id="start_date" required/>
                <label>End Date:</label>
                    <input type="date" class="form-control datetimepicker-input input-date" name="end_date" id="end_date" required/>           
            </div>           
        </div> 
        <button class="btn btn-info">Generate</button>
    </form>
    <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Out Qty</th>
            <th>Balance Qty</th>
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
