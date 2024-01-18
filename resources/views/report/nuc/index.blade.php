@extends('adminlte::page')

@section('title', 'NUC Report')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>NUC Report</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">

                <form id="request_date" class="form-horizontal" action="{{ url('reports/nuc') }}" method="get">
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <label for="daterange">Request Date</label>
                            <div class="form-group form-group-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange" value="{{ Request::get('daterange') }}">

                                    {{-- <div class="input-group-append" onclick="document.getElementById('request_date').submit();">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('reports/nuc') }}')">
                                        <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control form-control-sm select2 select2-primary" name="branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    @if(count($branches) > 1)
                                        <option value="" selected="true">-- All --</option>
                                    @endif
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ Request::get('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div style="margin-top:29px">
                                <input type="button" class="btn btn-default btn-sm" value="Search" onclick="document.getElementById('request_date').submit();">
                                <input type="button" class="btn btn-default btn-sm" value="Reset" onclick="window.location.assign('{{ url('reports/nuc') }}')">
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_nuc" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Distributor</th>
                            <th class="text-center">Branch</th>
                            <th class="text-center">Invoice No</th>
                            <th class="text-center">SI No</th>
                            <th class="text-center">NUC Points</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Credited/Cancelled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nucs as $nuc)
                            <tr>
                                <td class="text-center">{{ $nuc->bcid }}</td>
                                <td class="text-center">{{ Helper::get_distributor_name_by_bcid($nuc->bcid) ?? NULL}}</td>
                                <td class="text-center">{{ $nuc->branch }}</td>
                                <td class="text-center">{{ $nuc->oid }}</td>
                                <td class="text-center">{{ $nuc->sales->si_no ?? '' }}</td>
                                <td class="text-right">{{ $nuc->total_nuc }}</td>
                                <td class="text-center">{!! Helper::get_nuc_status($nuc->status) !!}</td>
                                <td class="text-center">{{ $nuc->created_at }}</td>
                                <td class="text-center">{{ $nuc->created_at == $nuc->updated_at ? '' : $nuc->updated_at }}</td>
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


        var current_date = new Date();
        var month = (current_date.getMonth() + 1).toString().padStart(2, '0');
        var day = current_date.getDate().toString().padStart(2, '0');
        var year = current_date.getFullYear().toString();
        var hours = current_date.getHours() % 12 || 12; // Convert to 12-hour format
        var minutes = current_date.getMinutes().toString().padStart(2, '0');
        var ampm = current_date.getHours() >= 12 ? 'pm' : 'am';

        var formatted_datetime = `${month}-${day}-${year} ${hours}:${minutes}${ampm}`;

        var report_title = 'NUC Report - ' + formatted_datetime;

        var total = 0;

        $('#dt_nuc').DataTable({
            dom: 'Bfrtip',
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
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn-default btn-sm',
                    title: report_title,
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var totalRow = '<row r="' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                            '<c t="inlineStr" r="A' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                                '<is>' +
                                    '<t xml:space="preserve"></t>' +
                                '</is>' +
                            '</c>' +
                            '<c t="inlineStr" r="B' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                                '<is>' +
                                    '<t xml:space="preserve"></t>' +
                                '</is>' +
                            '</c>' +
                            '<c t="inlineStr" r="C' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                                '<is>' +
                                    '<t xml:space="preserve"></t>' +
                                '</is>' +
                            '</c>' +
                            '<c t="inlineStr" r="D' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                                '<is>' +
                                    '<t xml:space="preserve"></t>' +
                                '</is>' +
                            '</c>' +
                            '<c t="inlineStr" r="E' + (sheet.getElementsByTagName('row').length + 1) + '" s="2">' +
                                '<is>' +
                                    '<t xml:space="preserve">Total:</t>' +
                                '</is>' +
                            '</c>' +
                            '<c r="F' + (sheet.getElementsByTagName('row').length + 1) + '" s="66">' +
                                '<v>' + total + '</v>' +
                            '</c>' +
                            '<c t="inlineStr" r="H' + (sheet.getElementsByTagName('row').length + 1) + '">' +
                                '<is>' +
                                    '<t xml:space="preserve"></t>' +
                                '</is>' +
                            '</c>' +
                        '</row>';

                        // Append the total row to the worksheet
                        sheet.getElementsByTagName('sheetData')[0].innerHTML += totalRow;
                    },
                }
            ],
            order: [[7, 'desc']],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
           // Add a footer callback to calculate totals
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total the visible data
                total = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update the total cell in the footer
                $(api.column(6).footer()).html(total);
            },
            initComplete: function () {
                $("#dt_nuc").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
    });
</script>
@endsection