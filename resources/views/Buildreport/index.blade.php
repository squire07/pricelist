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
                            <th class="text-center">SI #</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Total NUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_orders as $sales_order)
                            <tr>
                                <td class="text-center">{{ $sales_order->updated_at->format('m/d/Y') }}</td>
                                <td class="text-center">{{ $sales_order->branch }}</td>
                                <td class="text-center">{{ $sales_order->oid }}</td>
                                <td class="text-center">{{ $sales_order->bcid }}</td>
                                <td class="text-center">{{ $sales_order->distributor->name }}</td>
                                <td class="text-right">{{ $sales_order->total_nuc }}</td>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // re-initialize the datatable
        $('#dt_sales_orders').DataTable({
            dom: 'Bfrtip',
            // serverSide: true,
            // processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
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
                    var dataTable = $('#dt_sales_orders').DataTable();
                    var data = dataTable.rows().data();

                    // Compute the total sum of column F
                    var columnIndex = 5;
                    var totalSum = computeTotalSum(data, columnIndex);

                    // Add a footer row with the total sum
                    var footerRow = '<row><c t="inlineStr" s="footer"><is><t>Total Sum: ' + totalSum + '</t></is></c></row>';
                    sheet.childNodes[0].childNodes[1].innerHTML += footerRow;
                }
            },
            {
                extend: 'pdf',
                text: 'Export to PDF'
            }
        ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
        });
    });
        // Function to compute the total sum of a single column
        function computeTotalSum(data, columnIndex) {
            var sum = 0;
                for (var i = 0; i < data.length; i++) {
                    sum += parseFloat(data[i][columnIndex]) || 0;
                }
            return sum;
        }

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