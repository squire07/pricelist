@if(isset($sales_order->payment->details))
<div class="card card-primary card-outline">
    <div class="card-header text-bold">Accounts</div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:50%">Income</th>
                    <th class="text-center" style="width:50%">Expense</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $sales_order->income_expense_account->income_account ?? '' }}</td>
                    <td class="text-center">{{ $sales_order->income_expense_account->expense_account ?? ''}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif