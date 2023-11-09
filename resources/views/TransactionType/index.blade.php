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
                            <th class="text-center"></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Validity</th>
                            <th class="text-center">Currency</th>
                            <th class="text-center">Last Sync At</th>
                            <th class="text-center">Last Sync By</th>
                            <th class="text-center">Income/Expense</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction_types as $transaction_type)
                            <tr>
                                <td class="text-center dt-control"></td>
                                <td class="text-center">{{ $transaction_type->id }}</td>
                                <td>{{ $transaction_type->name }}</td>
                                <td class="text-center validity">
                                    @if(isset($transaction_type->validity->valid_from) && isset($transaction_type->validity->valid_to))
                                        {{ $transaction_type->validity->valid_from . ' - ' . $transaction_type->validity->valid_to }}

                                        <button class="btn btn-sm calendar-icon" 
                                            data-transaction-type-id="{{ $transaction_type->id }}"
                                            data-validity="{{ $transaction_type->validity->valid_from . ' - ' . $transaction_type->validity->valid_to }}">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    @else 
                                        <span class="text-bold">&#8734;</span>

                                        <button class="btn btn-sm calendar-icon" data-transaction-type-id="{{ $transaction_type->id }}">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="text-center">{{ $transaction_type->currency }}</td>
                                <td class="text-center">{{ $transaction_type->updated_at }}</td>
                                <td class="text-center">{{ $transaction_type->updated_by }}</td>
                                <td class="text-center">
                                    <a href="{{ url('income-expense-accounts/' . $transaction_type->uuid) }}" class="btn btn-sm btn-default" target="_self">
                                        <i class="fas fa-share-square mr-2"></i>Accounts
                                    </a>
                                </td>

                                @foreach($transaction_type->accounts as $account)
                                    <td class="d-none">{{ $account->company->name ?? null }}</td>
                                    <td class="d-none">{{ $account->currency }}</td>
                                    <td class="d-none">{{ $account->income_account }}</td>
                                    <td class="d-none">{{ $account->expense_account }}</td>
                                @endforeach
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

    <div class="modal fade" id="modal-validity" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Validity Period</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="POST" id="modal_validity" autocomplete="off">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>  
                                        <input type="text" class="form-control float-right text-center" id="validity_period" name="validity_period" value="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"style="display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default btn-sm" style="align-self: flex-start;" data-dismiss="modal">Close</button>
                    <div style="display: flex; justify-content: flex-end;">
                        <button class="btn btn-default btn-sm mr-2" id="btn-reset">Reset</button>
                        <button class="btn btn-primary btn-sm" id="btn-update"><i class="far fa-save mr-1"></i>Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_css')
<style>
.validity {
    text-align: left;
    position: relative;
}
.calendar-icon {
    position: absolute;
    right: 8px; /* Adjust this value to control the distance from the right side */
    top: 50%;
    transform: translateY(-50%);
}
</style>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        let table_transType = $('#dt_transaction_types').DataTable({
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
            order: [[1,'asc']],
            columnDefs: [
                { orderable: false, targets: [0,7] }, // Disable sorting for the first column (index 0)
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
                title: 'Are you sure you want to sync with ERPNext?',
                text: "This may take some time!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sync!',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    Swal.getCancelButton().setAttribute('hidden', true);
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

        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#modal-validity').on("hide.bs.modal", function (e) {

        if (!$('#modal-validity').hasClass('programmatic')) {
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
                    $('#modal-validity').addClass('programmatic');
                    $('#modal-validity').modal('hide');
                    e.stopPropagation();
                } else {
                    e.stopPropagation();

                }
            });

        }
        return true;
        });

        $('#modal-validity').on('hidden.bs.modal', function () {
        $('#modal-validity').removeClass('programmatic');
        });

        // Prevent user from using enter key
        $("input:text, button").keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        
        $(document).on('click', '.calendar-icon', function() {
            var id = $(this).data('transaction-type-id');
            var validity = $(this).data('validity');

            if(validity !== undefined) {
                var date_range_array = validity.split(' - ');
                var start_date = date_range_array[0];
                var end_date = date_range_array[1];

                initialize_daterangepicker(start_date, end_date);
            } else {
                initialize_daterangepicker();
            }

            // set the textbox value
            $('#validity_period').val(validity);
            // define the edit form action
            $('#modal_validity').attr('action', window.location.origin + "/transaction-types/" + id);
            $('#modal-validity').modal('show');
        });

        $('#btn-update').on('click', function() {
            $('#modal_validity').submit();
        });

        $('#btn-reset').on('click', function() {
            $('#validity_period').val(''); // Clear the input field
        });



        function initialize_daterangepicker(valid_from, valid_to) {
            $('#validity_period').daterangepicker({
                autoUpdateInput: true,
                minYear: 2023,
                showDropdowns: false,
                drops: 'down',
                locale: {
                    format: 'MM/DD/YYYY'
                },
                startDate: valid_from || moment(),  // Use the value from the textbox or a default value
                endDate: valid_to || moment()
            }).on("apply.daterangepicker", function (e, picker) {
                var date_range = picker.startDate.format(picker.locale.format) + ' - ' + picker.endDate.format(picker.locale.format);
                picker.element.val(date_range);
            });
        }


        function format_final(data) {
            let tbody = '';
            if(data.length > 8) {
                for (let i = 8; i < data.length; i += 4) {
                    tbody += '<tr>';
                    for (let j = 0; j < 4 && i + j < data.length; j++) {
                        // Add the text-center class for the second and third columns
                        const className = j > 0 ? 'text-center' : '';
                        tbody += `<td class="${className}">${data[i + j]}</td>`;
                    }
                    tbody += '</tr>';
                }
            } else {
                tbody += '<tr><td class="text-center" colspan="4">No Income and Expense Account(s) Found</td></tr>';
            }

            return (
                '<table cellpadding="5" cellspacing="0" border="0" style="width:100%;">' +
                    '<thead>' +
                        '<tr>' +
                            '<th class="text-center">Company</th><th class="text-center">Currency</th><th class="text-center">Income Account</th><th class="text-center">Expense Account</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>' + tbody + '</tbody>' +
                '</table>'
            );
        }

        $('#dt_transaction_types tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table_transType.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('td-shown');
            } else {
                // Open this row
                row.child(format_final(row.data())).show();
                tr.addClass('td-shown');
            }
        }); 
    });
</script>
@endsection