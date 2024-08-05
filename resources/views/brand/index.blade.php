@extends('adminlte::page')

@section('title', 'Customer Categories')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add" {{ Helper::BP(12,2) }}>Add brand</button>
            </div>
        </div>
    </div>
@stop

@php
    $show_button_state = Helper::BP(12,3);
    $edit_button_state = Helper::BP(12,4);
@endphp

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_brand" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td class="text-center">{{ $brand->id }}</td>
                                <td class="text-left">{{ $brand->name }}</td>
                                <td class="text-center">
                                    @if($brand->active == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $brand->created_by }}</td>
                                <td class="text-center">{{ $brand->created_at }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                        data-toggle="modal"
                                        data-target="#modal-show"
                                        data-id="{{ $brand->id }}"
                                        data-uuid="{{ $brand->uuid }}"
                                        data-brand-name="{{ $brand->name }}" 
                                        data-brand-updated_by="{{ $brand->updated_by }}"
                                        {{ $show_button_state }}>
                                        <i class="far fa-eye"></i>&nbsp;Show
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-id="{{ $brand->id }}" 
                                        data-uuid="{{ $brand->uuid }}" 
                                        data-brand-name="{{ $brand->name }}" 
                                        data-brand-remarks="{{ $brand->remarks }}"
                                        data-brand-active="{{ $brand->active }}"
                                        {{ $edit_button_state }}>
                                        <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>


    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New brand</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('brands.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <label for="name" data-required="true">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25" id="modal_add_name" required>
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
                    <h4 class="modal-title">Edit brand</h4>
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
                                    <label for="name" data-required="true">Name</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <label for="code">Brand Status</label>
                                    <div class="col-12">
                                        <input type="radio" name="active" value="1">
                                        <label for="" class="mr-4">Active</label>
                                        <input type="radio" name="active" value="0">
                                        <label for="">Inactive</label>
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
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Customer brand Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">      
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td width="25%">Name</td>
                                <td><span id="modal_show_name" style="font-weight:bold"></span></td>
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
<style>
input[type="text2"], textarea {
  color: #ffffff;
  text-align: center;
  border: none;
  outline: none;
  font-weight: bold;
}

/* Style for text within labels */
label[for][data-required="true"]::after {
    content: " *";
    color: red;
}

</style>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_brand').DataTable({
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
                    targets: [1], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_brand").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });

        // use class instead of id because the button are repeating. ID can be only used once
        $(document).on('click', '.btn_edit', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-brand-name");
            var active = $(this).attr("data-brand-active");
            var remarks = $(this).attr("data-brand-remarks");

            $('#modal_edit_name').val(name); 
            $('#modal_show_remarks').val(remarks);

            // Set status radio button based on the 'status' value
            if(active == 1) {
                $('input[type="radio"][value="1"]').prop('checked', true);
            } else if(active == 0) {
                $('input[type="radio"][value="0"]').prop('checked', true);
            } 

            // define the edit form action
            let action = window.location.origin + "/brands/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $(document).on('click', '.btn_show', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-brand-name");
            var remarks = $(this).attr("data-brand-remarks");
            var updated_by = $(this).attr("data-brand-updated_by");

            // set multiple attributes
            $('#modal_show_name').text(name);
            $('#modal_show_remarks').text(remarks);
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
            if (event.keyCode === 10 || event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $( '#modal-add, #modal-edit' ).on( 'keypress', function( e ) {
        if( event.keyCode === 10 || e.keyCode === 13 ) {
            e.preventDefault();
            $( this ).trigger( 'submit' );
        }
        });

        $("#modal_add_name, #modal_edit_name").on("keypress", function(event) {
            const forbiddenChars = ["/", "\\"];
            if (forbiddenChars.includes(event.key)) {
                event.preventDefault(); // Prevent adding the character
            }
        });
    });
</script>
@endsection