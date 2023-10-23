@extends('adminlte::page')

@section('title', 'Shipping Fee')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Fee</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Shipping Fee</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_shipping_fee" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Parcel Size</th>
                            <th class="text-center">Dimension</th>
                            <th class="text-center">Region</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipping_fees as $shipping_fee)
                            <tr>
                                <td class="text-center">{{ $shipping_fee->parcel_size }}</td>
                                <td class="text-center">{{ $shipping_fee->dimension }}</td>
                                <td class="text-center">{{ $shipping_fee->region }}</td>
                                <td class="text-center">{{ $shipping_fee->parcel_rate }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                        data-toggle="modal" 
                                        data-target="#modal-edit" 
                                        data-uuid="{{ $shipping_fee->uuid }}" 
                                        data-shipping_fee-parcel_size="{{ $shipping_fee->parcel_size }}" 
                                        data-shipping_fee-dimension="{{ $shipping_fee->dimension }}"
                                        data-shipping_fee-region="{{ $shipping_fee->region}}"
                                        data-shipping_fee-parcel_rate="{{ $shipping_fee->parcel_rate}}">
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
                    <h4 class="modal-title">Add New Shipping Fee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('shipping-fee.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Parcel Size</label>
                                <input type="text" class="form-control form-control-sm" name="parcel_size" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Dimension</label>
                                <input type="number" class="form-control form-control-sm" name="dimension" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Region</label>
                                <input type="text" class="form-control form-control-sm" name="region" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Parcel Rate</label>
                                <input type="number" class="form-control form-control-sm" name="parcel_rate" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_add_close" >Close</button>
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
                    <h4 class="modal-title">Edit Shipping Fee</h4>
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
                                    <label for="name">Parcel Size</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="25" name="parcel_size" id="modal_edit_parcel_size" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Dimension</label>
                                    <input type="number" class="form-control form-control-sm text-bold" maxlength="25" name="dimension" id="modal_edit_dimension" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Region</label>
                                    <input type="text" class="form-control form-control-sm text-bold" maxlength="25" name="region" id="modal_edit_region" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="remarks">Parcel Rate</label>
                                    <input type="number" class="form-control form-control-sm" name="parcel_rate" id="modal_edit_parcel_rate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal" id="modal_edit_close" >Close</button>
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
                    <h4 class="modal-title">Branch Details</h4>
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
                                Branch Code:
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
<style>
input[type="text2"], textarea {
  color: #ffffff;
  text-align: center;
  border: none;
  outline: none;
  font-weight: bold;
}
</style>

@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('#dt_shipping_fee').DataTable({
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
                    targets: [4], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_shipping_fee").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

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
            var parcel_size = $(this).attr("data-shipping_fee-parcel_size");
            var region = $(this).attr("data-shipping_fee-region");
            var dimension = $(this).attr("data-shipping_fee-dimension");
            var parcel_rate = $(this).attr("data-shipping_fee-parcel_rate");

            $('#modal_edit_parcel_size').val(parcel_size); 
            $('#modal_edit_dimension').val(dimension);
            $('#modal_edit_region').val(region);
            $('#modal_edit_parcel_rate').val(parcel_rate);

            // define the edit form action
            let action = window.location.origin + "/shipping-fee/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-branch-name");
            var code = $(this).attr("data-branch-code");
            var remarks = $(this).attr("data-branch-remarks");
            var status_id = $(this).attr("data-branch-status_id");
            var updated_by = $(this).attr("data-branch-updated_by");

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
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then(function(result) {
                    if (result.value) {
                        $('#modal-add , #modal-edit').addClass('programmatic');
                        $('#modal-add , #modal-edit').modal('hide');
                        e.stopPropagation();

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

</script>
@endsection
