@extends('adminlte::page')

@section('title', 'Transaction List')

@section('content_header')
    <h1>Transaction List</h1>

    <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
        <form id="request_date" class="form-horizontal" action="{{ url('reports/transaction-listing') }}" method="get">
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
                            <div class="input-group-append" onclick="window.location.assign('{{ url('reports/transaction-listing') }}')">
                                <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            <table id="dt_sales_orders" class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Branch</th>
                        <th>Cashier</th>
                        <th>Cost Center</th>
                        <th>Invoice No</th>
                        <th>Distributor</th>
                        <th>Transaction Type</th>
                        <th>Payment Type</th>
                        <th>Item</th>
                        <th>Account</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr>
                            <td>{{ $sale->updated_at->format('m/d/Y') }}</td>
                            <td>{{ $sale->branch->name ?? NULL }}</td>
                            <td>{{ $sale->payment->created_by }}</td>
                            <td>{{ $sale->branch->cost_center ?? NULL }}</td>
                            <td>{{ Helper::get_si_assignment_no($sale->si_assignment_id) }}</td>
                            <td>{{ Helper::get_distributor_name_by_bcid($sale->bcid) }}</td>
                            <td>{{ $sale->transaction_type->name }}</td>
                            <td>{{ $sale->payment->payment_type }}</td>
                            <td>{{ $sale->sales_details[0]['item_name'] }}</td>
                            <td>{{ $sale->income_expense_account->income_account ?? NULL}}</td>
                            <td>{{ $sale->grandtotal_amount }}</td>
                        </tr>
                    @endforeach
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // re-initialize the datatable with additional column filters
        var table = $('#dt_sales_orders').DataTable({
            dom: 'Brtip',
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show All']],
            order: [[0, 'desc']],
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    footer: true,
                    filename: 'Translist_Report_' + getCurrentDate(),
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            }
        });

        // Add a single header row for both original titles and filter inputs
        $('#dt_sales_orders thead tr').clone(true).appendTo('#dt_sales_orders thead').attr('id', 'filterRow');
        $('#dt_sales_orders thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            if (i >= 1 && i <= 8) { // filters for columns branch to items
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            } else {
                $(this).html('');
            }
        });

        // Function to get the current date in the format MM-DD-YYYY
        function getCurrentDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var yyyy = today.getFullYear();
            return mm + '-' + dd + '-' + yyyy;
        }
    });
</script>
@endsection
