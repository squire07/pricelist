@extends('adminlte::page')

@section('title', 'Transaction Type')

@section('content_header')
    


    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaction Types</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_transaction_types" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Is Active</th>
                            <th class="text-center">Last Sync At</th>
                            <th class="text-center">Last Sync By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction_types as $transaction_type)
                            <tr>
                                <td class="text-center">{{ $transaction_type->id }}</td>
                                <td>{{ $transaction_type->name }}</td>
                                <td class="text-center">
                                    @if($transaction_type->is_active == 1)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $transaction_type->updated_at }}</td>
                                <td class="text-center">{{ $transaction_type->updated_by }}</td>
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
        $('#dt_transaction_types').DataTable({
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
                $("#dt_transaction_types").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });  

        $('#btn-sync').on('click', function() {
            Swal.fire({
                title: 'Are you sure you want to sync from ERPNext?',
                text: "This may take some time!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sync!',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(window.location.origin + '/transaction-types/sync-transaction-type')
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
    });
</script>
@endsection