@if(isset($sales_order->payment->details))
<div class="card card-primary card-outline">
    <div class="card-header text-bold">
        <div class="card-title">Payment</div>

        @if(in_array(Auth::user()->role_id, [8,13]) && Request::segment(2) == 'for-validation') {{-- Role: Accounting and Accounting Admin --}}
            <div class="card-tools">
                <button type="button" class="btn btn-tool" id="btn_payment_edit"><i class="far fa-edit"></i></button>
            </div>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:30%">Payment Type</th>
                    <th class="text-center" style="width:30%">Reference No</th>
                    <th class="text-center" style="width:20%">Amount</th>
                    <th class="text-center" style="width:20%">Paid At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sales_order->payment->details[0]['name'] }}</td>
                    <td class="text-center">
                        {{ isset($sales_order->payment->details[0]['ref_no']) ? strtoupper($sales_order->payment->details[0]['ref_no']) : '' }}
                        @if (isset($sales_order->payload) && $sales_order->payload->payment_response_status == 417)
                            <i class="fas fa-times-circle text-red ml-2"></i>
                        @endif
                    </td>
                    <td class="text-right">{{  $sales_order->grandtotal_amount }}</td>
                    <td class="text-center">{{ $sales_order->payment->created_at }}</td>
                </tr>
                <tr>
                    <td>Amount Tendered</td>
                    <td></td>
                    <td class="text-right">{{ $sales_order->payment->details[0]['amount'] }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Cash Change</td>
                    <td></td>
                    <td class="text-right">{{ $sales_order->payment->change }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    @if (isset($sales_order->payload) && $sales_order->payload->payment_response_status == 417)
        <div class="card-footer text-center">
            @php
                $json = json_decode($sales_order->payload->payment_response_body, true);

                // Check if the decoding was successful
                if ($json !== null) {
                    // Extract the exception message
                    $exception_message = explode(':', $json['exception'], 2)[1];

                    // Trim any leading or trailing spaces
                    $exception_message = trim($exception_message);
                }
            @endphp

            {{ $exception_message }}
        </div>
    @endif
</div>
@endif

{{--  modal for edit --}}
@if(Request::segment(2) == 'for-validation')
<div class="modal fade" id="modal-edit-payment-details" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Payment Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form-horizontal" action="{{ route('update_payment_details', $sales_order->uuid) }}" method="POST" id="form_modal_edit" autocomplete="off">
                <input type="hidden" name="payment_id" value={{ $sales_order->payment_id }}>
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="payment_method_id">Payment Method</label>
                                <select class="form-control form-control-sm" name="payment_method_id" id="modal_edit_payment_details_name" required>
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}" {{ $payment_method->name == $sales_order->payment->payment_type ? 'selected' : '' }}>{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                            
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="ref_no">Reference Number</label>
                                <input type="text" class="form-control form-control-sm" maxlength="125" name="ref_no" id="modal_edit_payment_details_ref_no" value="{{ $sales_order->payment->details[0]['ref_no'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_payment_details_submit"><i class="fas fa-save mr-2"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif