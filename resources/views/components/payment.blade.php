@if(isset($sales_order->payment->details))
<div class="card card-primary card-outline">
    <div class="card-header text-bold">Payment</div>
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
                {{--  @foreach($sales_order->payment->details as $payment)
                    <tr>
                        <td>{{ $payment['name'] }}</td>
                        <td class="text-center">{{ isset($payment['ref_no']) ? strtoupper($payment['ref_no']) : '' }}</td>
                        <td class="text-right">{{ $payment['amount'] }}</td>
                        <td class="text-center">{{ $sales_order->payment->created_at }}</td>
                    </tr>
                @endforeach --}}
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