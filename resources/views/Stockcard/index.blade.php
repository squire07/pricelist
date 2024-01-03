@extends('adminlte::page')

@section('title', 'Stock Card')

@section('content_header')
    <h1>Stock Card</h1>

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
                        <th>Distributor</th>
                        <th>Invoice No</th>
                        <th>Out Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr>
                            <td>{{ $sale->updated_at }}</td>
                            <td>{{ Helper::get_distributor_name_by_bcid($sale->bcid) }}</td>
                            <td>{{ $sale->nuc->oid ?? '' }}</td>
                            <td>
                                {{ $sale->sales_details[0]['quantity'] }}    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>    
    </div>
    <script>
        document.getElementById("start_date").valueAsDate = new Date();
        document.getElementById("end_date").valueAsDate = new Date();
    </script>
@endsection
