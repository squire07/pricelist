@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Companies</h1>
            </div>
            {{-- <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Company</button>
            </div> --}}
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_company" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center">{{ $company->id }}</td>
                                <td class="text-center">{{ $company->name }}</td>
                                <td class="text-center">{{ $company->code }}</td>
                                <td class="text-center">{{ $company->status == 0 ? 'Inactive' : 'Active' }}</td>
                                <td class="text-center">{{ $company->updated_by }}</td>
                                <td class="text-center">{{ $company->updated_at }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                    data-toggle="modal"
                                    data-target="#modal-show"
                                    data-uuid="{{ $company->uuid }}"
                                    data-company-name="{{ $company->name }}" 
                                    data-company-code="{{ $company->code }}"
                                    data-company-status_id="{{ $company->status == 0 ? 'Inactive' : 'Active' }}"
                                    data-company-remarks="{{ $company->remarks }}"
                                    data-company-updated_by="{{ $company->updated_by }}"
                                    {{ Helper::BP(8,3) }}>
                                    <i class="far fa-eye"></i>&nbsp;Show
                                </button>
                                <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit" 
                                    data-uuid="{{ $company->uuid }}" 
                                    data-company-name="{{ $company->name }}" 
                                    data-company-code="{{ $company->code }}"
                                    data-company-status="{{ $company->status == 0 ? 'Inactive' : 'Active' }}"
                                    data-company-remarks="{{ $company->remarks }}"
                                    {{ Helper::BP(8,4) }}>
                                    <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                </button>
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

    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('companies.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25" id="modal_add_name" pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Company Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="2" id="modal_add_code" pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{--  modal for create --}}
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Company Code</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="2" name="code" id="modal_edit_code" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Company Status</label>
                                    <div class="col-12">
                                        <input type="radio" id="status_8" name="status" value="8">
                                        <label for="" class="mr-4">Active</label>
                                        <input type="radio" id="status_9" name="status" value="9">
                                        <label for="">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  modal for show --}}
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Company Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="ribbon-wrapper ribbon-lg">
                            <div class="ribbon" id="ribbon_bg">
                                <span id="modal_show_status_id"></span>
                            </div>
                        </div>
                    </div>         
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Company Code</td>
                                <td><span id="modal_show_code" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Remarks</td>
                                <td><span id="modal_show_remarks" style="font-weight:bold"></span></td>
                            </tr>
                            <tr>
                                <td width="25%">Updated By</td>
                                <td><span id="modal_show_updated_by" style="font-weight:bold"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_company').DataTable({
            dom: 'Bfrtip',
            autoWidth: true,
            responsive: true,
            order: [[ 0, "asc" ]],
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            columnDefs: [ 
                {
                    targets: [6], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_company").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-company-name");
            var code = $(this).attr("data-company-code");
            var remarks = $(this).attr("data-company-remarks");
            var status_id = $(this).attr("data-company-status_id");

            $('#modal_edit_name').val(name); 
            $('#modal_edit_code').val(code);
            $('#modal_show_status_id').val(status_id);

            if(status_id == 'Active') {
                $('#status_8[value="8"]').prop('checked', true);
            } else {
                $('#status_9[value="9"]').prop('checked', true);
            } 

            // define the edit form action
            let action = window.location.origin + "/companies/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });


        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-company-name");
            var code = $(this).attr("data-company-code");
            var remarks = $(this).attr("data-company-remarks");
            var status_id = $(this).attr("data-company-status_id");
            var updated_by = $(this).attr("data-company-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_code').text(code);
            $('#modal_show_remarks').text(remarks);
            $('#modal_show_status_id').text(status_id);
            $('#modal_show_updated_by').text(updated_by);
            if (status_id == 'Active') {
                $('#ribbon_bg').addClass('bg-success').removeClass('bg-danger');
            } else {
                $('#ribbon_bg').addClass('bg-danger').removeClass('bg-success');
            }
        });

                // Prevent from redirecting back to homepage when cancel button is clicked accidentally
                $('#modal-add , #modal-edit').on("hide.bs.modal", function (e) {

        if (!$('#modal-add , #modal-edit').hasClass('programmatic')) {
            e.preventDefault();
            swal.fire({
                title: 'Are you sure?',
                text: "Please confirm that you want to cancel",
                type: 'warning',
                showCancelButton: true,
                allowEnterKey: false,
                allowOutsideClick: false,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.value) {
                    $('#modal-add , #modal-edit').addClass('programmatic');
                    $('#modal-add , #modal-edit').modal('hide');
                    e.stopPropagation(); 
                    $('#modal_add_name').val('');
                    $('#modal_add_code').val('');
                    $('#modal_edit_remarks').val('');
                } else {
                    e.stopPropagation();

                }
            });

            }
            return true;
            });

            $('#modal-add , #modal-edit').on('hidden.bs.modal', function () {
            $('#modal-add , #modal-edit').removeClass('programmatic');
        });

        // Prevent user from using enter key
        $("input:text, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13 || event.keyCode == "Escape" ) {
                event.preventDefault();
                return false;
            }
        });

        $( '#modal-add, #modal-edit' ).on( 'keypress', function( e ) {
            if( event.keyCode === 10 || e.keyCode === 13 || event.keyCode == "Escape" ) {
                e.preventDefault();
                $( this ).trigger( 'submit' );
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
                    return fetch(window.location.origin + '/companies/sync-company')
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
