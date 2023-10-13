@extends('adminlte::page')

@section('title', 'Items')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Items</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_items" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">NUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->description }}</td>
                                <td class="text-right">{{ $item->amount }}</td>
                                <td class="text-right">{{ $item->nuc }}</td>
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
        $('#dt_items').DataTable({
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
            columnDefs: [
                { 'orderable': false, 'targets': 0 } // Disable sorting for the first column (index 0)
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
            initComplete: function () {
                $("#dt_items").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });  
    });
</script>
@endsection