@extends('adminlte::page')

@section('title', 'Sales Invoice Payments')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon {{ Helper::badge($sales_order->status_id) }} text-bold" id="ribbon_bg">
                        {{ $sales_order->status->name }}
                    </div>
                </div>
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
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">NUC</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales_order->sales_details as $sd)
                                <tr>
                                    <td>{{ $sd->item_name }}</td>
                                    <td class="text-center">{{ $sd->quantity }}</td>
                                    <td class="text-right">{{ $sd->nuc }}</td>
                                    <td class="text-right">{{ $sd->amount }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right text-bold">Total</td>
                                    <td class="text-right text-bold" id="tfoot_total_amount"></b>{{ $sales_order->total_amount }}</td>
                                    <td class="text-right text-bold" id="tfoot_total_amount"></b>{{ $sales_order->total_nuc }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
    
    
            <div class="row">
                <div class="col-6">
                    <p class="lead">Payment Methods:</p>
                    <select class="form-control form-control-sm select2 select2-primary" id="payment_type" name="payment_type_id" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                        <option value="">-- Select Payment Type --</option>
                        @foreach($payment_types as $payment_type)
                            <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <p class="lead">Remarks:</p>
                        <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                    </div>
                </div>
    
                <div class="col-6">
                    <p class="lead">Amount Due:</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td class="text-right text-bold">{{ $sales_order->total_amount }}</td>
                            </tr>
                            <tr>
                                <th>Tax (12%)</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Shipping:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td class="text-right text-bold">{{ $sales_order->total_amount }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">
                    <a href="{{ url('sales-invoice/for-invoice') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

                    @if($sales_order->status_id == 4)
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    @endif
                    @if($sales_order->status_id != 4)
                        <button type="button" class="btn btn-success float-right" id="btn_submit_payment" data-toggle="modal" data-target="#modal-submit-payment"><i class="far fa-credit-card"></i> Submit Payment</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-submit-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="#" method="POST" id="form_modal_submit_payment" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            Total Amount:
                            <input type="number" class="form-control form-control-sm text-right" id="total_amount"  style="font-size:25px;" value="{{ $sales_order->total_amount }}" disabled/>
                        <br>
                        </div>
                        <div class="col-12">
                            Cash Tendered:
                            <input type="number" class="form-control form-control-sm text-right" id="cash_tendered" style="font-size:25px;" name="cash_tendered" maxlength="12" min="0" pattern="^\d+(?:\.\d{1,2})?$" required>
                            {{-- pattern="^\d+(?:\.\d{1,2})?$" oninput="validity.valid||(value=value.replace(/\D+/g, ''))" required> --}}
                        </div><br>
                        <div class="col-12">
                            Cash Change:
                            <input type="number" class="form-control form-control-sm text-right" id="cash_change"  style="font-size:25px;" name="cash_change" maxlength="12" min="0" placeholder="0.00" value="0.00" disabled>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm m-2" id="btn_modal_print_invoice"><i class="fas fa-print mr-2"></i>Print Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('adminlte_js')
<script>
$(document).ready(function() {

    $('#btn_submit_payment').prop('disabled', true);
    $('#btn_modal_print_invoice').prop('disabled', true);

    $('#btn_submit_payment').on('click', function() {
        $('#cash_tendered').val('');
        $("#cash_change").val('0.00');
    });

    $("#payment_type").on('change', function() {
        if($(this).val() != '') {
            $('#btn_submit_payment').prop('disabled', false);
        } else {
            $('#btn_submit_payment').prop('disabled', true);
        }
    });

    $("#total_amount, #cash_tendered").keyup(function()
    {
        var cchange = 0;
        var tamount = Number($("#total_amount").val());
        var ctendered = Number($("#cash_tendered").val());
        var cchange = 0;

        if ($(this).length > 0 && ctendered > 0) {
            cchange = ctendered - tamount;
        } else {
            cchange = 0;
        }

        console.log(cchange);       

        $("#cash_change").val(cchange.toFixed(2));
    });


    $('#cash_tendered').on('keyup change', function() {
        if(Number($(this).val()) >= Number($('#total_amount').val())) {
            $('#btn_modal_print_invoice').prop('disabled', false);
        } else {
            $('#btn_modal_print_invoice').prop('disabled', true);
        }
    });

    // submit
    $('#btn_modal_print_invoice').on('click', function() {
        // console.log('test')
    }); 
});
</script>

@endsection