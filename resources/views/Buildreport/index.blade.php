@extends('adminlte::page')

@section('title', 'NUC Build Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Build Report</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                
                <form id="request_date" class="form-horizontal" action="{{ url('reports/build-report') }}" method="get">
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
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('reports/build-report') }}')">
                                        <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Branch</th>
                            <th class="text-center">OID #</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Total NUC</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_orders as $sales_order)
                            <tr>
                                <td class="text-center">{{ $sales_order->updated_at->format('m/d/Y') }}</td>
                                <td class="text-center">{{ $sales_order->branch }}</td>
                                <td class="text-center">{{ $sales_order->oid }}</td>
                                <td class="text-center">{{ $sales_order->bcid }}</td>
                                <td class="text-center">{{ $sales_order->distributor->name ?? null }}</td>
                                <td class="text-right">{{ $sales_order->total_nuc }}</td>
                                <td class="text-center">{{ $sales_order->status == 1 ? 'Credited' : null }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="d-none"></th>
                            <th class="d-none"></th>
                            <th class="d-none"></th>
                            <th class="d-none"></th>
                            <th class="d-none" style="text-align: right">TOTAL</th>
                            <th class="d-none">sum_nuc</th>
                        </tr>
                    </tfoot>
                </table>
            </div>    
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // re-initialize the datatable
        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show All']],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    footer: true,
                    filename: 'NUC_Build_' + getCurrentDate(),
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // Get the data from DataTable
                        var data_table = $('#dt_sales_orders').DataTable();
                        var data = data_table.rows().data();

                        // Calculate the sum of data in sum nuc
                        var sum = 0;
                        data.each(function(value, index) {
                            sum += parseFloat(value[5]);
                        });

                        // Add the sum to the Excel file
                        var sum_row = sheet.createElement('row');
                        var c6 = sum_row.appendChild(sheet.createElement('c'));
                        var t6 = c6.appendChild(sheet.createElement('t'));
                        t6.innerHTML = '<t>' + sum + '</t>';
                        sheet.getElementsByTagName('sheetData')[0].appendChild(sum_row);
                    }
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Calculate the sum of data in sum nuc across all pages
                var sum_nuc = api.column(5).data().reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

                // Update the footer
                $(api.column(5).footer()).html(sum_nuc);
            }
        });
    });
    
        // Function to get the current date in the format YYYY-MM-DD
        function getCurrentDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var yyyy = today.getFullYear();
            return mm + '-' + dd + '-' + yyyy;
        }
</script>
@endsection

@section('adminlte_js')
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
@endsection