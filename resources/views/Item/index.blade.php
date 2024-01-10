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
                            <th class="text-center">RS Points</th>
                            <th class="text-center">PV Points</th>
                            <th class="text-center">Last Sync At</th>
                            <th class="text-center">Last Sync By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td class="text-center">{{ $item->code }}</td>
                                <td>
                                    @if($item->item_bundle->isNotEmpty())
                                        <a class="item_code" data-id="{{ $item->code }}" style="cursor: pointer;">{{ $item->name }}</a>
                                    @else
                                        {{ $item->name }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->description }}</td>
                                <td class="text-right">{{ $item->amount }}</td>
                                <td class="text-right">{{ $item->nuc }}</td>
                                <td class="text-right">{{ $item->rs_points }}</td>
                                <td class="text-right">{{ $item->pv_points }}</td>
                                <td class="text-center">{{ $item->updated_at }}</td>
                                <td class="text-center">{{ $item->updated_by }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" id="btn-sync" {{ !in_array(Auth::user()->role_id, [11,12]) ? 'disabled' : '' }}><i class="fas fa-sync mr-1"></i>Sync</button>     
            </div>    
        </div>
    </div>

    <div class="modal fade" id="modal-item-bundle" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-12">
                            <table class="table table-bordered table-sm" id="item-bundle-table"></table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_add_close" >Close</button>
                </div>
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

        $('#btn-sync').on('click', function() {
            Swal.fire({
                title: 'Are you sure you want to sync with ERPNext?',
                text: "This may take some time!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sync!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    Swal.getCancelButton().setAttribute('hidden', true);
                    return fetch(window.location.origin + '/items/sync-item')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.ok
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sync complete!',
                        icon: 'success',
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        });

        $(document).on('click', '.item_code', function() {

            // clear all the table contents
            $('#item-bundle-table > tr').remove();

            let item_code = $(this).attr('data-id');

            fetch(window.location.origin + '/api/item/bundle/' + item_code, {
                method: 'get',
                headers: {
                    'Content-type': 'application/json',
                }
            })
            .then(response => response.json())
            .then((response) => {
                obj = JSON.parse(JSON.stringify(response));

                $('.modal-title').text(obj[0]['bundle_description']);

                var el = '<tr>' + 
                            '<th class="text-center">Code</th>' + 
                            '<th class="text-center">Description</th>' +
                            '<th class="text-center">Quantity</th>' +
                            '<th class="text-center">UOM</th>' +
                        '</tr>';
                $.each(obj, function(key, data) {
                    el += '<tr>' +
                            '<td class="text-center">' + data['item_code'] + '</td>' + 
                            '<td>' + data['item_description'] + '</td>' + 
                            '<td class="text-center">' + data['quantity'] + '</td>' + 
                            '<td class="text-center">' + data['uom'] + '</td>' + 
                        '</tr>'
                });

                $("#item-bundle-table").append(el); 

                $('#modal-item-bundle').modal('show');
            })
        });
    });
</script>
@endsection