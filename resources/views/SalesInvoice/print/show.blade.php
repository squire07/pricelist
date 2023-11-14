
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GL v2</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<style>
    .fixed-bottom-right {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
</style>
</head>
<body>
    <div class="wrapper">
        <div class="row mt-5">
            <div class="col-md-6 col-sm-12">
                <span class="text-bold"></span>
                <br>
                <span class="text-bold"></span>
                <br>
                <span class="text-bold"></span>
                <br>
                <span class="text-bold"></span>
                <br>
                <span class="text-bold"></span>
            </div>
            <div class="col-md-6 col-sm-12">
                <span class="text-bold"></span>
                <br>
                <span class="text-bold"></span>
                <br>
                <span class="text-bold" style="margin-left: 200px">{{ $sales_order->distributor_name }} - {{ $sales_order->group_name }}</span>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table style="width:100%">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_order->sales_details as $sd)
                            <tr>
                                <td class="text-right" style="padding-left: 20px">{{ $sd->item_code }}</td>
                                <td class="text-center">{{ $sd->item_name }}</td>
                                <td class="text-center">{{ $sd->quantity }}</td>
                                <td class="text-right" style="padding-left: 50px">{{ $sd->item_price }}</td>
                                <td class="text-right">{{ $sd->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right text-bold" colspan="4"></td>
                            <td class="text-right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4"></td>
                            <td class="text-right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4"></td>
                            <td class="text-right">&nbsp;</td>
                        </tr>
                        {{-- <tr>
                            <td class="text-right text-bold" colspan="4">Sub Total</td>
                            <td class="text-right">{{ $sales_order->total_amount }}</td>
                        </tr> --}}
                        <tr>
                            <td class="text-right text-bold" colspan="4">Shipping Fee</td>
                            <td class="text-right">{{ $sales_order->shipping_fee }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4"></td>
                            <td class="text-right">&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="fixed-bottom-right">
            <div>Vatable Sales: {{ $sales_order->vatable_sales }}</div>
            <div>VAT Amount: {{ $sales_order->vat_amount }}</div>
            <div>Grand Total Amount: {{ $sales_order->grandtotal_amount }}</div>
        </div>
        <div class="row d-print-none">
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
<style>
    .grandtotal-amount {
        position: fixed;
        bottom: 20px;
        left: 20px;
    }
</style>