@extends('adminlte::page')

@section('title', 'Transaction Listing')

@section('content_header')
    <h1>Transaction Listing</h1>
    
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
            <th>Invoice Number</th>
            <th>Account Code</th>
            <th>Account Title</th>
            <th>Debit</th>
            <th>Credit</th>
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