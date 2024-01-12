@extends('adminlte::page')

@section('title', 'Stock Card')

@section('content_header')
<h1>Stock Card</h1>
<div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
    <div class="modal fade" id="modal-add-data" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter by Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filter_request" class="form-horizontal" action="{{ url('reports/stock-card') }}" method="get">
                    <div class="container fluid">
                        <div class="col-m col-sm-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="branch_id" name="branch" data-dropdown-css-class="select2-primary" style="width: 100%;"{{ count($branches) > 1 ? '':'readonly' }}>
                                    @if(count($branches) > 1)
                                        <option value="" selected="true" disabled>-- Select Branches --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-m col-sm-12">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="item_id" name="item" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option value="" selected="true" disabled>-- Select Item --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id}}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-m col-sm-12">
                            <div class="form-group">
                                <label>BCID</label>
                                <input type="text" class="form-control form-control-sm" id="bcid" name="bcid" value="{{ Request::get('bcid') }}">
                            </div>
                        </div>
                        <div class="col-m col-sm-12">
                            <div class="form-group">
                                <label>Transaction Type</label>
                                <select class="form-control form-control-sm select2 select2-primary" id="transaction_type_id" name="transaction_type" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option value="" selected="true" disabled>-- Select Transaction Type --</option>
                                    @foreach($transaction_types as $transaction_type)
                                        <option value="{{ $transaction_type->id }}">{{ $transaction_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-m col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-md btn-info" id="btn-filter" onclick="document.getElementById('filter_request').submit();">Generate</button>
                                <input type="button" class="btn btn-md btn-warning" id="btn-reset" onclick="window.location.assign('{{ url('reports/stock-card') }}')" value="Reset">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-date" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter by Date</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form id="request_date" class="form-horizontal" action="{{ url('reports/stock-card') }}" method="get">
                        @csrf
                        <div class="container fluid">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange-btn" value="{{ Request::get('daterange') }}">
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-m col-sm-12">
                            <input type="button" class="btn btn-md btn-info" id="daterange-gen" onclick="document.getElementById('request_date').submit();" value="Generate">
                            <input type="button" class="btn btn-md btn-warning" id="btn-reset" onclick="window.location.assign('{{ url('reports/stock-card') }}')" value="Reset">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-data" {{ Helper::BP(7,2) }}>
            <i class="fas fa-database"></i> Filter by Data
        </button>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-date" {{ Helper::BP(7,2) }}>
            <i class="fas fa-calendar"></i> Filter by Date
        </button>
        <button type="button" class="btn btn-warning" {{ Helper::BP(7,2) }} onclick="window.location.assign('{{ url('reports/stock-card') }}')">
            <i class="fas fa-undo-alt"></i> Reset
        </button>
        <button id="exportToExcelBtn" class="btn btn-success" {{ Helper::BP(7,2) }}>
            <i class="far fa-file-excel"></i> Export to Excel
        </button>
    </div><br>
    <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Branch</th>
                        <th>Item</th>
                        <th>Transaction Type</th>
                        <th>Invoice No</th>
                        <th>BCID</th>
                        <th>Distributor</th>
                        <th>Out Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $key => $sale)
                        <tr>
                            <td>{{ $sale->updated_at->format('m/d/Y') }}</td>
                            <td>{{ $sale->branch->name ?? NULL }}</td>
                            <td>{{ $sale->sales_details[0]['item_name'] }}</td>
                            <td>{{ $sale->transaction_type->name }}</td>
                            <td>{{ Helper::get_si_assignment_no($sale->si_assignment_id) }}</td>
                            <td>{{ $sale->bcid }}</td>
                            <td>{{ Helper::get_distributor_name_by_bcid($sale->bcid) }}</td>
                            <td>{{ $sale->sales_details[0]['quantity'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="8" style="text-align: center">No Data Available in Table.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        // initialize select2 on this page using bootstrap 4 theme
        $('.select2').select2({
            theme: 'bootstrap4'
        });

     //Date range as a button
     $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    $('#exportToExcelBtn').click(function () {
            // Redirect to the export route
            window.location.href = "{{ route('excel.stockcard.report') }}";
    });
});
</script>
@endsection
