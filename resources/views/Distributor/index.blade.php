@extends('adminlte::page')

@section('title', 'Distributor List')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Distributor List</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_distributors" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">BCID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">Subgroup</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" id="btn-sync" {{ !in_array(Auth::user()->role_id, [11,12]) ? 'disabled' : '' }}><i class="fas fa-sync mr-1"></i>Sync</button>     
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

        $('#dt_distributors').DataTable({
            dom: 'Bfrtip',
            serverSide: true,
            processing: true,
            deferRender: true,
            paging: true,
            autoWidth: true,
            responsive: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],
            order: [[ 0, "desc" ]],
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: "{{ route('distributor_list') }}",
                pages: 20 // number of pages to fetch
            }),
            columns: [
                {data: 'bcid', class: 'text-center'},
                {data: 'name'},
                {data: 'group', class: 'text-center'},
                {data: 'subgroup', class: 'text-center'},
            ],
                language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },

        });

        $('#btn-sync').on('click', function() {
            Swal.fire({
                title: 'Are you sure you want to sync with Prime Dashboard?',
                text: "This may take some time!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sync!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    Swal.getCancelButton().setAttribute('hidden', true);
                    return fetch(window.location.origin + '/distributors/sync-distributors')
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