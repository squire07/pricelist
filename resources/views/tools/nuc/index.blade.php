@extends('adminlte::page')

@section('title', 'NUC')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>NUC</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_nuc" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">UUID</th>
                            <th class="text-center">BCID</th>
                            <th class="text-center">SO No</th>
                            <th class="text-center">SI No</th>
                            <th class="text-center">NUC Points</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nucs as $nuc)
                            <tr>
                                <td class="text-center">{{ $nuc->uuid }}</td>
                                <td class="text-center">{{ $nuc->bcid }}</td>
                                <td class="text-center">{{ $nuc->sales->so_no ?? '' }}</td>
                                <td class="text-center">{{ $nuc->sales->si_no ?? '' }}</td>
                                <td class="text-right">{{ $nuc->total_nuc }}</td>
                                <td class="text-center">{{ $nuc->status == 0 ? null : 'Credited' }}</td>
                                <td class="text-center">{{ $nuc->created_at }}</td>
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
            ],
            order: [[6, 'desc']],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
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