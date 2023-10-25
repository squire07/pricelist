
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GL v2</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<body>
    <div class="wrapper">
        <div class="row mt-5">
            <div class="col-md-6 col-sm-12">
                Name: <span class="text-bold">{{ $sales_order->distributor_name }}</span>
                <br>
                BCID: <span class="text-bold">{{ $sales_order->bcid }}</span>
                <br>
                Group: <span class="text-bold">{{ $sales_order->group_name }}</span>
            </div>
            <div class="col-md-6 col-sm-12">
                Transaction Type: <span class="text-bold">{{ $sales_order->transaction_type->name }}</span>
                <br>
                Sales Order Number: <span class="text-bold">{{ $sales_order->so_no }}</span>
                <br>
                Sales Invoice Number: <span class="text-bold">{{ $sales_order->si_no }}</span>
                <br>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:10%">Item Code</th>
                            <th class="text-center" style="width:50%">Item Name</th>
                            <th class="text-center" style="width:10%">Quantity</th>
                            <th class="text-center" style="width:15%">Price</th>
                            <th class="text-center" style="width:15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_order->sales_details as $sd)
                            <tr>
                                <td>{{ $sd->item_code }}</td>
                                <td>{{ $sd->item_name }}</td>
                                <td class="text-center">{{ $sd->quantity }}</td>
                                <td class="text-right">{{ $sd->item_price }}</td>
                                <td class="text-right">{{ $sd->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right text-bold" colspan="4">Sub Total</td>
                            <td class="text-right">{{ $sales_order->total_amount }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4">Shipping Fee</td>
                            <td class="text-right">{{ $sales_order->shipping_fee }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4">VATable Sales</td>
                            <td class="text-right">{{ $sales_order->vatable_sales }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4">VAT Amount</td>
                            <td class="text-right">{{ $sales_order->vat_amount }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-bold" colspan="4">Grand Total</td>
                            <td class="text-right text-bold">{{ $sales_order->grandtotal_amount }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
