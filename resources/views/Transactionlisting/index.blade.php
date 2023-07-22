@extends('adminlte::page')

@section('title', 'Transaction Listing')

@section('content_header')
    <h1>Transaction Listing</h1>
    
    <form class="submit">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Start Date:</label>
                <div class="input-group date" id="date_picker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input input-date" name="pickup_date" data-target="#date_picker" data-toggle="datetimepicker" required/>
                    <div class="input-group-append" data-target="#date_picker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>End Date:</label>
                <div class="input-group date" id="date_picker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input input-date" name="pickup_date" data-target="#date_picker" data-toggle="datetimepicker" required/>
                    <div class="input-group-append" data-target="#date_picker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
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
@endsection