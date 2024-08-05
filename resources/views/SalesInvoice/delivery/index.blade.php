@extends('adminlte::page')

@section('title', 'Delivery Management')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Management - Delivery</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                
                <form id="request_date" class="form-horizontal" action="{{ url('delivery-management') }}" method="get">
                    @csrf
                    <label for="daterange">Request Date</label>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group form-group-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange" value="{{ Request::get('daterange') }}">

                                    <div class="input-group-append" onclick="document.getElementById('request_date').submit();">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('delivery-management') }}')">
                                        <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_delivery" class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                    <tr>
                            <th class="text-center">Delivery #</th>
                            <th class="text-center">Delivery Date</th>
                            <th class="text-center">Store Name</th>
                            <th class="text-center">SRP Type</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Delivery Status</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                        <tr>
                            <td class="text-center"><a href="{{ url('delivery-management/' . $delivery->uuid ) }}" class="{{ Helper::BP(1,3) }}" target="_self">{{ $delivery->dr_no }}</a></td>
                            <td class="text-center">{{ $delivery->delivery_date }}</td>
                            <td class="text-center">{{ $delivery->store_name }}</td>
                            <td class="text-center">{{ $delivery->srp_type }}</td>
                            <td class="text-right">{{ number_format($delivery->grandtotal_amount, 2) }}</td>
                            <td class="text-right">
                                @if ($delivery->delivery_status == 'New')
                                    <span class="badge badge-info">{{ $delivery->delivery_status }}</span>
                                @elseif ($delivery->delivery_status == 'Completed')
                                    <span class="badge badge-success">{{ $delivery->delivery_status }}</span>
                                @else
                                    {{ $delivery->delivery_status ?? '0' }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $statusId = $delivery->payment_status;
                                    $badgeClass = '';
                                    
                                    switch ($statusId) {
                                        case 1:
                                            $badgeClass = 'badge-warning';
                                            break;
                                        case 2:
                                            $badgeClass = 'badge-success';
                                            break;
                                        case 3:
                                            $badgeClass = 'badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge-secondary'; // Default badge style for unknown status IDs
                                            break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $delivery->paymentstatus->name }}</span>
                            </td>
                            <td class="text-center">{{ $delivery->created_by }}</td>
                            <td class="text-center">{{ $delivery->created_at }}</td>
                            <td class="text-center">
                                <a href="{{ url('delivery-management/' . $delivery->uuid . '/print') }}" class="{{ Helper::BP(1,3) }}" target="_blank">
                                    <i class="fas fa-print mr-2"></i> <!-- Font Awesome print icon -->
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

@endsection