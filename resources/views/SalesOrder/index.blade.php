@extends('adminlte::page')

@section('title', 'Sales Orders')

@section('content_header')
    


    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Orders</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_sales_order" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">SO #</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Total NUC</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach($sales_orders as $salesorder)
                            <tr>
                                <td class="text-center"><a href="{{ url('sales-orders/' . $salesorder->id ) }}" target="_self">{{ $salesorder->id }}</a></td>
                                <td class="text-center">{{ $salesorder->so_no }}</td>
                                <td class="text-center">{{ $salesorder->total_amount }}</td>
                                <td class="text-center">{{ $salesorder->total_nuc }}</td>
                                <td class="text-center">     
                                    <a class="btn btn-default" href=""><i class="fas fa-file-invoice"> Submit</i></a>       
                                    <a class="btn btn-default" href=""><i class="fas fa-pencil-alt"> Edit</i></a>       
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
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

        $('#dt_sales_order').DataTable({
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('salesorders_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {data: 'so_no', class: 'text-center'},
                {data: 'total_amount', class: 'text-center'},
                {data: 'total_nuc', class: 'text-center'},
                {data: null, class: 'text-center',
                render: function ( data, type, row ) {
                return '<a class="btn btn-default" href="#"><i class="fas fa-file-invoice"> Submit</i></a><a class="btn btn-default" href="#"><i class="fas fa-pencil-alt"> Edit</i></a>';
                }
            },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });
    });
</script>
@endsection