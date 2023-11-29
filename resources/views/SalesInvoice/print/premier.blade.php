
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
<style>
    @media print {
        .print-none {
            color: transparent;
        }
    }
</style>
<body>
    <div class="wrapper">
        <div>
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
            </table>
        </div>
        <div class="row" style="margin-top: 100px; line-height: 15px;">
            <div class="col-12">
                <div>
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
                </div>
                <div style="position: absolute; top: 250px; width: 100%; margin-top: 55px; padding-right: 15px;">

                    <table width="100%">
                        <tr>
                            <td style="width:10%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:8%"></td>
                            <td style="width:8%"></td>
                            <td style="width:14%" class="text-right text-bold">Subtotal</td>
                            <td style="width:15%" class="text-right">{{ $sales_order->total_amount }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right text-bold">Shipping Fee</td>
                            <td class="text-right">{{ $sales_order->shipping_fee }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right print-none">VATable Sales</td>
                            <td class="text-right">{{ $sales_order->vatable_sales }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center text-bold print-none">MODE OF PAYMENT</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right print-none">VAT-Exempt Sales</td>
                            <td class="text-right">0.00</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0 0 0 25px;">{{ $sales_order->payment->payment_type }}: {{ $sales_order->amount_tendered}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right print-none">Zero Rated Sales</td>
                            <td class="text-right">0.00</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0 0 0 25px;">{{ $sales_order->so_no }}</td>
                            <td></td>
                            <td>Total Qty: {{ $sales_order->total_item_count }}</td>
                            <td></td>
                            <td class="text-right print-none">Add: 12% VAT</td>
                            <td class="text-right">{{ $sales_order->vat_amount }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0 0 0 25px;">{{ $sales_order->si_no }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="3" class="text-right text-bold print-none">TOTAL AMOUNT DUE</td>
                            <td class="text-right text-bold">{{ $sales_order->grandtotal_amount }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2" class="text-center text-bold">{{ $sales_order->updated_by }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row d-print-none" style="position: absolute; top: 650px; width: 100%;">
            <div class="col-12 text-center">
                <button class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
                
            </div>
        </div>
    </div>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>window.addEventListener("load", window.print());</script>
</body>
</html>
