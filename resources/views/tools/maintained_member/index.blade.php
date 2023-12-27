@extends('adminlte::page')

@section('title', 'Maintained Members')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Maintained Members</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_maintained" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Year</th>
                            <th class="text-center">Month</th>
                            <th class="text-center">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintained_members as $account)
                            <tr>
                                <td class="text-center">{{ $account->bcid }}</td>
                                <td class="text-center">{{ $account->year }}</td>
                                <td class="text-center">{{ $account->month }}</td>
                                <td class="text-center">{{ $account->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" id="btn-sync"><i class="fas fa-sync mr-1"></i>Sync</button>     
            </div>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {     
        $('#dt_maintained').DataTable({
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
            order: [[1, 'desc']],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
            initComplete: function () {
                $("#dt_origins").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
    });
</script>
@endsection