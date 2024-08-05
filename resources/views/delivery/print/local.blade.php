
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delivery Management</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/BMREA___.TTF') }}">
</head>
<style>
    @media print {
        .print-none {
            color: transparent;
        }
        /* @font-face {
            font-family: 'BMREA';
            src: url('/fonts/BMREA___.TTF') format('truetype');
            font-weight: normal;
            font-style: normal;
        } */
        body {
            font-family: 'BMREA', sans-serif;
        } 
    } 

    body {
        font-family: 'BMREA', sans-serif;
    }

    /* CSS style for the table header (thead) */
    table {
        border-collapse: collapse; /* Collapse table borders */
        width: 100%;
    }
    
    th {
        border: 2px solid #ddd; /* Add a 1px solid border around each th element */
        padding: 3px; /* Add padding inside each th */
        text-align: center; /* Center-align text within th */
    }

        /* Increase font size for specific cells */
        .increase-font-size {
        font-size: 20px; /* Set font size to 20px */
    }

        .thick-hr {
            height: 3px;
            border: none;
            background-color: #333;
    }
</style>

<body>
<img src="{{ asset('images/frozone_print.png') }}" style="width: 100%; height: 10%; position: absolute; top: 0; left: 0;" alt="Frozone Print">
        <div>
            <table style="width: 100%; margin-top: 150px; table-layout: fixed;">
                <tr>
                    <td style="width: 50%;">
                        Customer: <span style="font-weight: bold;">{{ $deliveries->store_name }}</span>
                    </td>
                    <td style="width: 50%; text-align: right;">
                        DR No.: <span style="font-weight: bold;">{{ $deliveries->dr_no }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">
                        Address: <span style="font-weight: bold;">{{ $deliveries->address }}</span>
                    </td>
                    <td style="vertical-align: top; text-align: right;">
                        DR Date: <span style="font-weight: bold;">{{ $deliveries->delivery_date }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">
                        Agent: <span style="font-weight: bold;">{{ $deliveries->agents }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-12">
                <div>
                    <table class="table table-striped" style="width:100%;">
                        <thead>
                            <tr style="font-size: 14px">
                                <th class="text-center" style="width: 10%">Item Code</th>
                                <th class="text-center" style="width: 10%">Pack Size</th>
                                <th class="text-center" style="width:40%">Product Name</th>
                                <th class="text-center" style="width:5%">Discount</th>
                                <th class="text-center" style="width:15%">Price Per Pack</th>
                                <th class="text-center" style="width:10%">Qty (Pack)</th>
                                <th class="text-right" style="width:20%">Total Amt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 5px;"></tr>
                            @foreach($deliveries->delivery_details as $dd)
                                <tr style="font-size: 14px;  line-height: 10px;">
                                    <td class="text-center" style="width: 5%">{{ $dd->item_code }}</td>
                                    <td class="text-center" style="width: 5%">{{ $dd->pack_size }}</td>
                                    <td class="text-center" style="width: 40%">{{ $dd->item_name }}</td>
                                    <td class="text-center" style="width: 5%">{{ $dd->item_discount ?? 0}}%</td>
                                    <td class="text-center" style="width: 10%">₱ {{ number_format($dd->item_price, 2) }}</td>
                                    <td class="text-center" style="width: 10%">{{ $dd->quantity }}</td>
                                    <td class="text-right" style="width: 20%">₱ {{ number_format($dd->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="width: 100%;">
                    <table width="100%">
                        <tr>
                            <td style="width: 5%;"></td>
                            <td style="width: 5%"></td>
                            <td style="width: 40%"></td>
                            <td style="width: 5%"></td>
                            <td class="text-right" style="width: 25%">Subtotal</td>
                            <td class="text-center"style="width: 10%">{{ $deliveries->total_quantity }}</td>
                            <td class="text-right" style="width: 15%">₱ {{ number_format($deliveries->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-size: 14px;"><i>This serves as delivery receipt. This Document is not valid for claiming input taxes.</i></td>
                            <td colspan="2" class="text-right" >Less Discount</td>
                            <td class="text-center">{{ number_format($deliveries->add_discount,2) }}%</td>
                            <td class="text-right">₱ {{ number_format($deliveries->add_discount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center"></td>
                            <td colspan="2" class="text-right">Net Subtotal</td>
                            <td></td>
                            <td class="text-right">₱ {{ number_format($deliveries->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2" class="text-right">Tax</td>
                            <td class="text-center">0.00%</td>
                            <td class="text-right">₱ {{ number_format($deliveries->vat_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2" class="text-right text-bold increase-font-size">TOTAL AMOUNT DUE</td>
                            <td colspan="2" class="text-right text-bold increase-font-size">₱ {{ number_format($deliveries->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div style="width: 100%; margin-top: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td></td>
                            <td colspan="2" style="width: 40px;">Prepared By:</td>
                            <td colspan="2" style="width: 30px;">Delivered By:</td>
                            <td colspan="2" style="width: 30px;">Received By:</td>
                            <td></td>
                        </tr>
                        <tr style="height: 20px;">
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                        <td></td>
                            <td colspan="2" class="text-left text-bold">{{ $deliveries->created_by }}</td>
                            <td colspan="2" class="text-left text-bold">{{ $deliveries->delivered_by }}</td>
                            <td colspan="2" class="text-left"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="1" class="text-left">Signature over printed Name/Date</td>
                            <td></td>
                            <td colspan="1" class="text-left">Signature over printed Name/Date</td>
                            <td></td>
                            <td colspan="2" class="text-left">Signature over printed Name/Date</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row d-print-none" style="position: absolute; top: 1000px; width: 100%;">
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
