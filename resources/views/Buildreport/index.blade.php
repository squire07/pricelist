@extends('adminlte::page')

@section('title', 'NUC Build Report')

@section('content_header')
<div class="card">
    <h1>&nbsp;NUC Report</h1>
        <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
            <div class="modal fade" id="modal-add-data" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Filter Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="filter_request" class="form-horizontal" action="{{ url('reports/build-report') }}" method="get">
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
                                        <label>BCID</label>
                                        <input type="text" class="form-control form-control-sm" id="modal_bcid" name="bcid" value="{{ Request::get('bcid') }}">
                                    </div>
                                </div>
                                @csrf
                                <div class="col-m col-sm-12">
                                    <div class="form-group">
                                        <label>Date Range</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange-btn" value="{{ Request::get('daterange') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="button" class="btn btn-md btn-info" id="daterange-gen" onclick="document.getElementById('filter_request').submit();" value="Generate">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modal-add-data">
                            <i class="fas fa-database"></i> Filter Data
                        </button>
                        <button type="button" class="btn btn-warning mr-2" onclick="window.location.assign('{{ url('reports/build-report') }}')">
                            <i class="fas fa-undo-alt"></i> Reset
                        </button>
                        <button id="exportToExcelBtn" class="btn btn-success mr-2">
                            <i class="far fa-file-excel"></i> Export to Excel
                        </button>
                    </div>
                </div>
                    <div class="col-sm-3 ml-auto">
                        <form id="request_search" class="form-horizontal" action="{{ url('reports/build-report') }}" method="get">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-append" onclick="document.getElementById('request_search').submit();">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="search" id="search-btn" value="{{ Request::get('search') }}" placeholder="Search">
                            </div>
                        </form>
                    </div><br><br>
    
            <table class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Branch</th>
                        <th class="text-center">Invoice #</th>
                        <th class="text-center">BCID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">NUC</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales_orders as $key => $sales_order)
                        <tr>
                            <td class="text-center">{{ $sales_order->updated_at->format('m/d/Y') }}</td>
                            <td class="text-center">{{ $sales_order->branch->name ?? NULL}}</td>
                            <td class="text-center">{{ Helper::get_si_assignment_no($sales_order->si_assignment_id) ?? NULL}}</td>
                            <td class="text-center">{{ $sales_order->bcid ?? NULL}}</td>
                            <td class="text-center">{{ Helper::get_distributor_name_by_bcid($sales_order->bcid) ?? NULL}}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ $sales_order->total_nuc }}</td>
                            {{-- <td class="text-center">{{ $sales_order->nuc[0]['status'] }}</td> --}}
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align: center">No Data Available in Table.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
            window.location.href = "{{ route('excel.nuc.report') }}";
    });

    // Prevent from redirecting back to homepage when cancel button is clicked accidentally
    $('#modal-add-data').on("hide.bs.modal", function (e) {

        if (!$('#modal-add-data').hasClass('programmatic')) {
            e.preventDefault();
            swal.fire({
                title: 'Are you sure?',
                text: "Please confirm that you want to cancel",
                type: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.value) {
                    $('#modal-add-data').addClass('programmatic');
                    $('#modal-add-data').modal('hide');
                    e.stopPropagation();
                    $('#modal_branch_id').val(null).trigger('change'); 
                    $('#modal_bcid').val('');  
                    var currentDate = moment().format('MM/DD/YYYY');
                    $('#daterange-btn').val(currentDate + ' - ' + currentDate);
                } else {
                    e.stopPropagation();

                }
            });

        }
        return true;
        });

        $('#modal-add-data').on('hidden.bs.modal', function () {
        $('#modal-add-data').removeClass('programmatic');
    });

});
</script>
@endsection