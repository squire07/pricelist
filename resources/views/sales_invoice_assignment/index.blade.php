@extends('adminlte::page')

@section('title', 'Sales Invoice Assignment')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Invoice Assignment</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info btn-add-booklet" data-toggle="modal" data-target="#modal-add">Add Booklet</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">

            <ul class="nav nav-tabs text-bold" id="custom-tabs-tab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="booklets-tab" data-toggle="pill" href="#booklets" role="tab" aria-controls="booklets" aria-selected="true">Booklets</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="prefixed-tab" data-toggle="pill" href="#prefixed" role="tab" aria-controls="prefixed" aria-selected="false">Prefixed</a>
                </li>
            </ul>

            <div class="tab-content" id="custom-tabs-tabContent">
                <div class="tab-pane fade show active" id="booklets" role="tabpanel" aria-labelledby="booklets-tab">
                    <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                        <table id="dt_booklet_a" class="table table-bordered table-hover table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Cashier</th>
                                    <th class="text-center">Series From</th>
                                    <th class="text-center">Series To</th>
                                    <th class="text-center">Branch</th>
                                    <th class="text-center">Count</th>
                                    <th class="text-center">% Usage</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booklets as $series)
                                    @if($series->prefixed == 0)
                                        <tr>
                                            <td class="text-center">{{ $series->id }}</td>
                                            <td>{{ $series->cashier->name ?? '' }}</td>
                                            <td class="text-center">{{ $series->series_from }}</td>
                                            <td class="text-center">{{ $series->series_to }}</td>
                                            <td class="text-center">{{ $series->branch->name }}</td>
                                            <td class="text-center">{{ $series->count }}</td>
                                            <td class="text-center">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $series->percentage_used }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $series->percentage_used . '%' }}">
                                                    </div>
                                                </div>
                                                <span>{{ $series->percentage_used . '%' }}</span>
                                            </td>
                                            <td class="text-center">{{ $series->created_at }}</td>
                                            <td class="text-center">{{ $series->created_by }}</td>
                                            <td class="text-center">
                                                <a href="{{ url('sales-invoice-assignment/' . $series->uuid ) }}" class="btn btn-sm btn-default"><i class="far fa-eye"></i>&nbsp;Show</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>


                <div class="tab-pane fade" id="prefixed" role="tabpanel" aria-labelledby="prefixed-tab">
                    <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                        <table id="dt_booklet" class="table table-bordered table-hover table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Cashier</th>
                                    <th class="text-center">Series From</th>
                                    <th class="text-center">Series To</th>
                                    <th class="text-center">Branch</th>
                                    <th class="text-center">Count</th>
                                    <th class="text-center">% Usage</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booklets as $series)
                                    @if($series->prefixed == 1)
                                        <tr>
                                            <td class="text-center">{{ $series->id }}</td>
                                            <td>{{ $series->cashier->name ?? '' }}</td>
                                            <td class="text-center">{{ 'A' . $series->series_from }}</td>
                                            <td class="text-center">{{ 'A' . $series->series_to }}</td>
                                            <td class="text-center">{{ $series->branch->name }}</td>
                                            <td class="text-center">{{ $series->count }}</td>
                                            <td class="text-center">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $series->percentage_used }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $series->percentage_used . '%' }}">
                                                    </div>
                                                </div>
                                                <span>{{ $series->percentage_used . '%' }}</span>
                                            </td>
                                            <td class="text-center">{{ $series->created_at }}</td>
                                            <td class="text-center">{{ $series->created_by }}</td>
                                            <td class="text-center">
                                                <a href="{{ url('sales-invoice-assignment/' . $series->uuid ) }}" class="btn btn-sm btn-default"><i class="far fa-eye"></i>&nbsp;Show</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
               
        </div>
    </div>

    <div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Invoice Booklet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('sales-invoice-assignment.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group">
                                <label for="cashier_id">Cashier</label>
                                <select class="select2" id="cashier_id" name="cashier_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                    <option disabled selected>-- Select Cashier --</option>
                                    @foreach($cashiers as $cashier)
                                        <option value="{{ $cashier->id }}" data-branch-id="{{ $cashier->branch_id }}">
                                            {{ $cashier->name . ' (' . str_replace(',', ', ', Helper::get_branch_name_by_id($cashier->branch_id)) . ')'}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-none" id="div_cashier_branch_id">
                                <label for="cashier_branch_id">Branch</label>
                                <select class="select2" id="cashier_branch_id" name="cashier_branch_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                                </select>
                            </div>

                            <label for="">Series</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-bold">From</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" name="series_from" id="series_from" maxlength="6" pattern="0-9\s]+" required inputmode="numeric">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-bold">To</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" name="series_to" id="series_to" maxlength="6" pattern="[0-9\s]+" required inputmode="numeric">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="form-group clearfix">
                                        <div class="d-inline">
                                            <input type="checkbox" id="checkbox_prefix" name="checkbox_prefix">
                                            <label for="checkbox_prefix" class="ml-1">Add prefix "A"</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm m-2" id="btn-modal-save"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // disable the btn-modal-save
        $('#btn-modal-save').prop('disabled',true);

        // reset the values
        $('.btn-add-booklet').on('click', function() {
            $('#series_from').val('');
            $('#series_to').val('');
        });


        $('#dt_booklet').DataTable({
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
                    targets: [9], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_booklet").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });


        $('#dt_booklet_a').DataTable({
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
                    targets: [9], // column index (start from 0)
                    orderable: false, // set orderable false for selected columns
                }
            ],
            initComplete: function () {
                $("#dt_booklet_a").wrap("<div style='overflow:auto;width:100%;position:relative;'></div>");

                var elements = document.getElementsByClassName('btn-secondary');
                while(elements.length > 0){
                    elements[0].classList.remove('btn-secondary');
                }
            }
        });
        // this will check the real value of textbox then disables/enable the button
        $('#series_from').on('keyup', function() {
            let a = this.value;
            let b = $('#series_to').val();
            if(b.trim() !== '') {
                if (parseFloat(a) < parseFloat(b)) {
                    $('#btn-modal-save').prop('disabled',false);
                } else {
                    $('#btn-modal-save').prop('disabled',true);
                }
            } else {
                $('#btn-modal-save').prop('disabled',true);
            }
        });

        // this will check the real value of textbox then disables/enable the button
        $('#series_to').on('keyup', function() {
            let a = this.value;
            let b = $('#series_from').val();
            if(b.trim() !== '') {
                if (parseFloat(a) > parseFloat(b)) {
                    $('#btn-modal-save').prop('disabled',false);
                } else {
                    $('#btn-modal-save').prop('disabled',true);
                }
            } else {
                $('#btn-modal-save').prop('disabled',true);
            }
        });

        $('#cashier_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var branch_id = selectedOption.data('branch-id');

            // split if multiple
            var multiple_ids = /,/.test(branch_id);

            if(multiple_ids === true) {
                // show the branch div
                $('#div_cashier_branch_id').removeClass('d-none');

                // fetch the data by using the cashier's id
                fetch(window.location.origin + '/api/branches_by_cashiers_id/' + $('#cashier_id').val(), {
                    method: 'get',
                    headers: {
                        'Content-type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then((response) => {
                    obj = JSON.parse(JSON.stringify(response));

                    // empty or remove first the content if there is/are
                    $('#cashier_branch_id').empty();

                    // append the cashier_branch_id
                    for(let i=0; i<obj.length; i++) {
                        // Create a new option element
                        var new_option = new Option(obj[i].name, obj[i].id, false, false);

                        // Append the new option to the select element
                        $('#cashier_branch_id').append(new_option);
                    }
                    // update the option
                    $('#cashier_branch_id').trigger('change');
                })
            } else {
                // hide the branch div
                $('#div_cashier_branch_id').addClass('d-none');
            }
        });

        $('#btn-modal-save').on('click', function() {
            $(this).prop('disabled',true);
            $('#form_modal_add').submit();
        });
    
        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#modal-add').on("hide.bs.modal", function (e) {

            if (!$('#modal-add').hasClass('programmatic')) {
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
                        $('#modal-add').addClass('programmatic');
                        $('#modal-add').modal('hide');
                        e.stopPropagation();
                        $('#cashier_id').val('');
                    } else {
                        e.stopPropagation();

                    }
                });

            }
            return true;
        });
            $('#modal-add').on('hidden.bs.modal', function () {
            $('#modal-add').removeClass('programmatic');
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
    });
</script>
@endsection
