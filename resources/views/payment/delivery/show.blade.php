@extends('adminlte::page')

@section('title', 'Delivery Management')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payments - Delivery Details</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon 
                        @if ($delivery->delivery_status === 1)
                            badge-info
                        @elseif ($delivery->delivery_status === 2)
                            badge-success
                        @elseif ($delivery->delivery_status === 3)
                            badge-danger
                        @else
                            badge-default
                        @endif
                        text-md text-bold" id="ribbon_bg">
                        {{ $delivery->deliverystatus->name }}
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    Customer: <span class="text-bold">{{ $delivery->store_name }}</span>
                    <br>
                    Srp Type: <span class="text-bold">{{ $delivery->srp_type }}</span>
                    <br>
                    Category: <span class="text-bold">{{ $delivery->customer_category }}</span>
                    <br>
                    Area Group: <span class="text-bold">{{ $delivery->area_group }}</span>
                    <br>
                    Agent: <span class="text-bold">{{ $delivery->agents }}</span>
                    <br>
                    Payment Status: <span class="text-bold"></span>
                        @php
                            $statusId = $delivery->payment_status;
                            $badgeClass = '';
                            
                            switch ($statusId) {
                                case 1:
                                    $badgeClass = 'badge-warning';
                                    break;
                                case 2:
                                    $badgeClass = 'badge-success';
                                    break;
                                case 3:
                                    $badgeClass = 'badge-danger';
                                    break;
                                case 4:
                                    $badgeClass = 'badge-info';
                                    break;
                                default:
                                    $badgeClass = 'badge-secondary'; // Default badge style for unknown status IDs
                                    break;
                            }
                        @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $delivery->paymentstatus->name }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-12">
                    Delivery Number: <span class="text-bold">{{ $delivery->dr_no }}</span>
                    <br>
                    Delivered By: <span class="text-bold">{{ $delivery->delivered_by }}</span>
                    <br>
                    Delivery Date: <span class="text-bold">{{ $delivery->delivery_date }}</span>
                    <br>
                    Due Date: <span class="text-bold">{{ $delivery->due_date }}</span>
                    <br>
                    Delivered Date: <span class="text-bold">
                        @if ($delivery->delivered_date)
                            {{ date('m-d-Y', strtotime($delivery->delivered_date)) }}
                        @else
                            
                        @endif
                    </span>
                    <br>
                    Remarks: <span class="text-bold">{{ $delivery->remarks }}</span>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Item Code</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Pack Size</th>
                                <th class="text-center">Item Discount</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($delivery->delivery_details as $dd)
                                <tr>
                                    <td class="text-center">{{ $dd->item_code }}</td>
                                    <td class="text-center">{{ $dd->item_name }}</td>
                                    <td class="text-center">{{ $dd->pack_size }}</td>
                                    <td class="text-center">{{ $dd->item_discount ?? 0 }} %</td>
                                    <td class="text-center" style="width:9%">{{ $dd->quantity }}</td>
                                    <td class="text-right" style="width:12%">{{ number_format($dd->item_price, 2) }}</td>
                                    <td class="text-right" style="width:15%">{{ number_format($dd->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td class="text-right text-bold" colspan="6">Sub Total</td>
                                    <td class="text-right">{{ number_format($delivery->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="6">
                                        <span class="ml-1">Discount Value</span>
                                    </td>
                                    <td class="text-right text-bold">{{ number_format($delivery->add_discount_value, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold" colspan="6">Grand Total</td>
                                    <td class="text-right text-bold">{{ number_format($delivery->grandtotal_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" {{ $delivery->add_discount != null ? 'checked' : '' }}>
                            <label for="checkbox_add_discount">Add Discount:</label>
                            <span class="ml-2"> {{ $delivery->add_discount }} %</span>
                        </div>
                    </div>
                </div>
            </div>

        <div class="card-footer text-center">
            <a href="{{ url('payments/delivery') }}" class="btn btn-lg btn-info float-left" style="margin-top: 8px; margin-right: 10px;"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            
            {{--  Submit Payment  --}}
            @if(in_array($delivery->delivery_status, [2,3]) && $delivery->payment_status === 2)
                <button class="btn btn-lg btn-success float-right d-none" style="margin-top: 8px; margin-left: 10px" id="btn-submit-payment" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" {{ Helper::BP(2,4) }}>
                    <i class="far fa-share-square"></i>&nbsp;Submit Payment
                </button>
            @elseif($delivery->delivery_status !== 3 && !in_array($delivery->payment_status, [3, 4]))
                <button class="btn btn-lg btn-success float-right" style="margin-top: 8px; margin-left: 10px" id="btn-submit-payment" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" {{ Helper::BP(2,4) }}>
                    <i class="far fa-share-square"></i>&nbsp;Submit Payment
                </button>
            @endif


            {{--  Update Payment  --}}
            @if(in_array($delivery->payment_status, [1,2,3]))
                <button class="btn btn-lg btn-primary float-right d-none" style="margin-top: 8px; margin-left: 10px" id="btn-update-payment" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" {{ Helper::BP(2,4) }}>
                    <i class="fas fa-file-upload"></i>&nbsp;Update Payment
                </button>
            @else
                <button class="btn btn-lg btn-primary float-right" style="margin-top: 8px; margin-left: 10px" id="btn-update-payment" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" {{ Helper::BP(2,4) }}>
                    <i class="fas fa-file-upload"></i>&nbsp;Update Payment
                </button>
            @endif
                        

                @php
                    $allowed_roles = [1, 2]; // Define an array of allowed role IDs
                    $user_id = Auth::user()->role_id; // Get the role ID of the currently authenticated user
                @endphp

                @if(in_array($user_id, $allowed_roles))
                    @if($delivery->delivery_status === 3)
                        <button class="btn btn-lg btn-danger float-right mx-2 d-none" id="btn-for-cancel" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" style="margin-top: 10px" {{ Helper::BP(4,4) }}>
                            <i class="fas fa-ban"></i>&nbsp;Cancel Order
                        </button>
                    @else
                        <button class="btn btn-lg btn-danger float-right mx-2" id="btn-for-cancel" data-uuid="{{ $delivery->uuid }}" data-dr-no="{{ $delivery->dr_no }}" style="margin-top: 8px"{{ Helper::BP(4,4) }}>
                            <i class="fas fa-ban"></i>&nbsp;Cancel Order
                        </button>
                    @endif
                @endif
        </div>
    </div>

    @include('components.payment')

    {{-- hidden form to submit SO for invoicing --}}
    <form id="form_for_submit" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="hidden_uuid">
            <input type="hidden" name="delivery_status" value="Completed">
            <input type="hidden" name="delivered_date" id="hidden_delivered_date">
        @csrf
    </form>

    <form id="form_for_cancel" method="POST">
        @method('PATCH')
            <input type="hidden" name="uuid" id="form_cancel_uuid">
            <input type="hidden" name="delivery_status" value="3">
            <input type="hidden" name="delivery_remarks" id="form_cancel_delivery_remarks">
            <input type="hidden" name="version" value="{{ $delivery->version }}">
        @csrf
    </form>

@endsection

@section('adminlte_css')
<style>
.table-bordered {
    border: 0px solid #dee2e6;
}

tfoot tr td:first-child {
    border: none !important;
}

</style>
@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#posting_datetime').datetimepicker({
            defaultDate: new Date(), 
            maxDate: new Date(),
            icons: { 
                time: 'far fa-clock' 
            } 
        });


    $('#btn-for-complete').on('click', function() {
        var uuid = $(this).data("uuid");
        var dr_no = $(this).data("dr-no");

        // Get the current date in YYYY-MM-DD format
        var currentDate = new Date().toISOString().slice(0, 10);

        // Show the confirmation with date input
        Swal.fire({
            title: 'Are you sure you want to finalize order # ' + dr_no + ' ?\n\nEnter actual delivery date.',
            icon: 'warning',
            html: '<input id="datepicker" type="date" class="form-control" autofocus value="' + currentDate + '">',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Complete Order!',
            onOpen: function() {
                // No need to initialize a datepicker library, use native behavior
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Add uuid dynamically to hidden uuid field
                $('#hidden_uuid').val(uuid);

                // Get the selected date from the datepicker input
                var date_delivered = $('#datepicker').val();

                // Set the selected date in the hidden field
                $('#hidden_delivered_date').val(date_delivered);

                // Update the action of form_for_submit
                $('#form_for_submit').attr('action', window.location.origin + '/delivery-management/' + uuid);

                // Submit the form
                $('#form_for_submit').submit();
            }
        });
    });


    $('#btn-for-cancel').on('click', function() {
        var uuid = $(this).attr("data-uuid");
        var dr_no = $(this).attr("data-dr-no");

        // show the confirmation
        Swal.fire({
            title: 'Are you sure to cancel \n' + dr_no + '?',
            text: 'Remarks:',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            onOpen: () => Swal.getConfirmButton().focus(),
            input: 'text',
            inputName: '',
            inputAttributes: {
                autocapitalize: 'on',
                required: 'true',
            },
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value.length >= 4) {
                        resolve();
                    } else if (value.length == 0) {
                        resolve('Please fill out this field!');
                    } else if (value.length <= 3) {
                        resolve('Remarks too short!');
                    } else {
                        resolve('Invalid Format!');
                    }
                });
            },
            confirmButtonText: 'Yes, submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                // add uuid dynamically to hidden uuid field
                $('#form_cancel_uuid').val(uuid);

                // update the action of form_for_invoicing 
                $('#form_cancel_delivery_remarks').val(result.value);
                $('#form_for_cancel').attr('action', window.location.origin + '/payments/delivery/' + uuid);

                // finally, submit the form
                $('#form_for_cancel').submit();
            }
        });
    });

       //Event for Submit to Payment
    $('#btn-submit-payment').on('click', function() {
        var dr_no = $(this).attr("data-dr-no");
        // show the confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Submit ' + dr_no + ' for Payment!',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ url('payments/delivery/' . $delivery->uuid . '/edit' ) }}";
            }
        });
        });

        // Prevent user from using enter key
        $("input:text").keypress(function(event) {
        if (event.keyCode === 10 || event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    //Event for Submit to Payment
    $('#btn-update-payment').on('click', function() {
        var dr_no = $(this).attr("data-dr-no");
        // show the confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Update ' + dr_no + ' Payment?',
            icon: 'warning',
            showCancelButton: true,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ url('payments/delivery/' . $delivery->uuid . '/edit-payment' ) }}";
            }
        });
        });

        // Prevent user from using enter key
        $("input:text").keypress(function(event) {
        if (event.keyCode === 10 || event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});
</script>
@endsection