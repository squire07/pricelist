@extends('adminlte::page')

@section('title', 'Income and Expense Accounts')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Income and Expense Accounts</h1>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-bold">{{ $accounts->name ?? null }}</div>
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                <table id="dt_transaction_types" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Currency</th>
                            <th class="text-center">Income Account</th>
                            <th class="text-center">Expense Account</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts->accounts as $account)
                            <tr>
                                <td class="text-center">{{ $account->id }}</td>
                                <td>{{ $account->company->name }}</td>
                                <td class="text-center validity">{{ $account->currency }}</td>
                                <td class="text-center">{{ $account->income_account }}</td>
                                <td class="text-center">{{ $account->expense_account }}</td>
                                <td class="text-center">{{ $account->updated_at }}</td>
                                <td class="text-center">{{ $account->updated_by }}</td>
                                <td class="text-center"></td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>   
            <div class="card-footer">
                <a href="{{ url('transaction-types') }}" class="btn btn-sm btn-primary" id="btn-sync">Return To Transaction Types</a>     
            </div> 
        </div>
    </div>
@endsection

@section('adminlte_css')
<style>

</style>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        
    });
</script>
@endsection