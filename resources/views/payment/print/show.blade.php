
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GL v2</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
    <div class="wrapper">
        <table style="width: 100%; margin-top: 180px">
            <tr>
                <td class="text-left text-bold" style="padding-left: 200px;">{{ $sales_order->distributor_name }} [{{ $sales_order->bcid }}] [{{ $sales_order->group_name }}]</td>
            </tr>
            <tr>
                <td class="text-right">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-right text-bold" style="padding-left: 100px;">{{ date('m/d/Y', strtotime($sales_order->updated_at))}} TIME: {{ date('h:i A', strtotime($sales_order->updated_at))}}</td>
            </tr>
        {{-- </tbody> --}}
    </table>
        <div class="row" style="margin-top: 100px; line-height: 15px;">
            <div class="col-12">
                <table style="width:100%">
                    <tbody>
                        @foreach($sales_order->sales_details as $sd)
                            <tr>
                                <td class="text-center" style="width: 10%">{{ $sd->item_code }}</td>
                                <td class="text-center" style="width: 50%">{{ $sd->item_name }}</td>
                                <td class="text-center" style="width: 5%">{{ $sd->quantity }}</td>
                                <td class="text-center" style="width: 5%">&nbsp;</td>
                                <td class="text-right" style="width: 15%">{{ $sd->item_price }}</td>
                                <td class="text-right" style="width: 15%">{{ $sd->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="position: absolute; top: 250px; width: 100%; margin-top: 70px; padding-right: 15px;">
                <table style="width: 100%">
                        <tr>
                            <td class="text-right" style="width: 60%">&nbsp;</td>
                            <td class="text-right text-bold" style="width: 30%; padding-right: 40px">Sub Total</td>
                            <td class="text-right" style="width: 10%">{{ $sales_order->total_amount }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">&nbsp;</td>
                            <td class="text-right text-bold" style="width: 30%; padding-right: 40px">Shipping Fee</td>
                            <td class="text-right">{{ $sales_order->shipping_fee }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right text-bold d-print-none">VATable Sales</td>
                            <td class="text-right">{{ $sales_order->vatable_sales }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right text-bold d-print-none">VAT-Exempt Sales</td>
                            <td class="text-right">0.00</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 50px;">{{ $sales_order->payment->payment_type }}: {{ $sales_order->amount_tendered}}</td>
                            <td>&nbsp;</td>
                            <td class="text-right text-bold d-print-none">Zero Rated Sales</td>
                            <td class="text-right">0.00</td>
                        </tr>
                    {{-- </tbody> --}}
                </table>
                <table style="width: 100%">
                        <tr>
                            <td style="width: 45%; padding-left: 50px;">{{ $sales_order->so_no }}</td>
                            <td style="width: 20%; padding-left: 100px;">Total Qty: {{ $sales_order->total_item_count }}</td>
                            <td class="text-right text-bold d-print-none">Add 12% VAT</td>
                            <td class="text-right">{{ $sales_order->vat_amount }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 50px;">{{ $sales_order->si_no }}</td>
                            <td>&nbsp;</td>
                            <td class="text-right text-bold d-print-none">Total Amount Due</td>
                            <td class="text-right text-bold">{{ $sales_order->grandtotal_amount }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right text-bold" style="padding-right: 100px;">{{ $sales_order->updated_by }}</td>
                        </tr>
                    {{-- </tbody> --}}
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-print-none">
        <div class="col-12 text-center">
            <button class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
        </div>
    </div>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>window.addEventListener("load", window.print());</script>
</body>
</html>
