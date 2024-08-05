<div class="card card-primary card-outline">
    <div class="card-header text-bold">Payment Details</div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:10%">Payment Status</th>
                    <th class="text-center" style="width:20%">Payment Method</th>
                    <th class="text-center" style="width:20%">Reference</th>
                    <th class="text-center" style="width:10%">Total Amount</th>
                    <th class="text-center" style="width:10%">Amount Paid</th>
                    <th class="text-center" style="width:5%">Balance</th>
                    <th class="text-center" style="width:5%">Change</th>
                    <th class="text-center" style="width:20%">Created By</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
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
                                default:
                                    $badgeClass = 'badge-info'; // Default badge style for unknown status IDs
                                    break;
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $delivery->paymentstatus->name }}</span>
                    </td>
                    <td class="text-center">{{ $delivery->payment->payment_type ?? ''}}</td>
                    <td class="text-center">{{ $delivery->payment->payment_references ?? ''}}</td>
                    <td class="text-right">{{ number_format($delivery->payment->total_amount ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($delivery->payment->total_amount_paid ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($delivery->payment->balance ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($delivery->payment->change ?? 0, 2) }}</td>
                    <td class="text-center">{{ $delivery->payment->created_by ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>