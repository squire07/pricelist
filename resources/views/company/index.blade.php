@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Companies</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Company</button>
            </div>
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
                            <th class="text-center">Created By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center">{{ $company->id }}</td>
                                <td>{{ $company->name }}</td>
                                <td class="text-center">{{ $company->code }}</td>
                                <td class="text-center">{{ $company->created_by }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($company->status_id) }}">{{ $company->status->name }}</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                    data-toggle="modal"
                                    data-target="#modal-show"
                                    data-uuid="{{ $company->uuid }}"
                                    data-company-name="{{ $company->name }}" 
                                    data-company-code="{{ $company->code }}"
                                    data-company-status_id="{{ $company->status->name}}"
                                    data-company-remarks="{{ $company->remarks }}"
                                    data-company-updated_by="{{ $company->updated_by }}">
                                    <i class="far fa-eye"></i>&nbsp;Show
                                </button>
                                <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit" 
                                    data-uuid="{{ $company->uuid }}" 
                                    data-company-name="{{ $company->name }}" 
                                    data-company-code="{{ $company->code }}"
                                    data-company-status_id="{{ $company->status->name}}"
                                    data-company-remarks="{{ $company->remarks }}">
                                    <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                </button>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    <div class="modal fade" id="modal-add">
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
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Company Code</label>
                                <input type="text" class="form-control form-control-sm" name="code" maxlength="2"  pattern="[a-zA-Z0-9\s]+" required>
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
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                                <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-12">
                                                <div class="form-group">
                                                    Name
                                                    <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" required pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    Company Code
                                                    <input type="text" class="form-control form-control-sm" maxlength="3" name="code" id="modal_edit_code" required pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    Company Status?<br>
                                                    <input type="radio" id="modal_edit_status_id" name="status" value="8" checked="checked" style="margin-top: 8px">
                                                    <label>Active</label>&nbsp;
                                                    <input type="radio" id="modal_edit_status_id" name="status" value="9">
                                                    <label>Inactive<br>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    Remarks
                                                <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required oninput="this.value = this.value.toUpperCase()" pattern="[a-zA-Z0-9\s]+" style="font-weight:bold">
                                                </div>
                                            </div>
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
    <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Company Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon" id="ribbon_bg">
                                        <span id="modal_show_status_id"></span>
                                    </div>
                                </div>
                            </div>         
                        <div class="container-fluid">
                            <div class="col-12">
                                Name:
                                <span id="modal_show_name" style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Company Code:
                                <span id="modal_show_code"  style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Remarks:
                                <span id="modal_show_remarks" style="font-weight:bold"></span>
                            </div>
                            <div class="col-12">
                                Updated By:
                                <span id="modal_show_updated_by" style="font-weight:bold"></span>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        </div>
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
                    targets: [5], // column index (start from 0)
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
    });

        // use class instead of id because the button are repeating. ID can be only used once
        $('.btn_edit').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-company-name");
            var code = $(this).attr("data-company-code");
            var remarks = $(this).attr("data-company-remarks");
            var status_id = $(this).attr("data-company-status_id");

            $('#modal_edit_name').val(name); 
            $('#modal_edit_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);

            // define the edit form action
            let action = window.location.origin + "/companies/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });


        $('.btn_show').on('click', function() {
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
</script>
@endsection
