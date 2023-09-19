@extends('adminlte::page')

@section('title', 'Sales Invoice Assignment')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Sales Invoice Assignment Details</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/profile/cashier_pic.png') }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $series->cashier->name }}</h3>
                            <p class="text-muted text-center">Cashier</p>
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Series Number:</th>
                                <td>{{ $series->prefix_value . $series->series_from . ' - ' . $series->prefix_value . $series->series_to }}</td>
                            </tr>
                            <tr>
                                <th>Branch:</th>
                                <td>{{ $series->branch->name }}</td>
                            </tr>
                            <tr>
                                <th>Total: Used / Count</th>
                                <td>{{ $series->used . ' / ' . $series->count }}</td>
                            </tr>
                            <tr>
                                <th>Assigned By:</th>
                                <td>{{ $series->created_by }}</td>
                            </tr>
                            <tr>
                                <th>Assigned At:</th>
                                <td>{{ $series->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ url('sales-invoice-assignment') }}" class="btn btn-lg btn-info float-left" style="margin-top: 8px"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_series" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Series Number</th>
                            <th class="text-center">Used (?)</th>
                            <th class="text-center">SO No.</th>
                            <th class="text-center">SI No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($series->booklet_details as $detail)
                            <tr>
                                <td class="text-center">{{ $detail->id }}</td>
                                <td class="text-center">{{ $detail->series_number }}</td>
                                <td class="text-center">
                                    @if($detail->used == 1)
                                        <i class="fas fa-check-circle" style="color:#28a745"></i>
                                    @endif
                                </td>
                                <td class="text-center">{{ $detail->so_no }}</td>
                                <td class="text-center">{{ $detail->si_no }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_series').DataTable({
            dom: 'Bfrtip',
            autoWidth: true,
            responsive: true,
            order: [[ 0, "asc" ]],
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            initComplete: function () {
                $("#dt_series").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
    });
</script>
@endsection
