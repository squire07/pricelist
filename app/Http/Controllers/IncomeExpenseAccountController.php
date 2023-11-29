<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IncomeExpenseAccount;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Auth;

class IncomeExpenseAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, IncomeExpenseAccount $incomeExpenseAccount)
    {
        $validatedData = request()->validate([
            'transaction_type_id' => 'required|int',
            'company_id' => 'required|int',
            'currency' => 'required|string',
            'income_account' => 'required|string',
            'expense_account' => 'required|string',
        ]); 

        $validatedData['uuid'] = Str::uuid();
        $validatedData['created_by'] = Auth::user()->name;
        $validatedData['updated_by'] = Auth::user()->name;

        $account = IncomeExpenseAccount::whereCompanyId($request->company_id)
                    ->whereCurrency($request->currency)
                    ->whereIncomeAccount($request->income_account)
                    ->whereExpenseAccount($request->expense_account)
                    ->first();

        // if(is_null($account)) {
            $incomeExpenseAccount->create($validatedData);
            return redirect()->back()->with('success','Account successfully saved!');
        // } else {
        //     return redirect()->back()->with('error','Account already exists!');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        // Note: this is the index page of income and expense account page (sub of transaction types)
        $accounts = TransactionType::with('accounts')->whereUuid($uuid)->first();
        
        $companies = Company::whereDeleted(false)->whereIn('status_id', [8,1])->get(); // 1 does not exists as status. To refactor soon as Active 1 = true, 0 = false;
        $currencies = Helper::get_erpnext_data('/api/resource/Currency?filters={"enabled":"1"}');
        $currencies = $currencies['data']['data'];
        
        return view('income_expense_account.index', compact('accounts','companies','currencies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomeExpenseAccount $incomeExpenseAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomeExpenseAccount $incomeExpenseAccount)
    {
        $validatedData = request()->validate([
            'company_id' => 'required|int',
            'currency' => 'required|string',
            'income_account' => 'required|string',
            'expense_account' => 'required|string',
        ]);

        $account = IncomeExpenseAccount::whereCompanyId($request->company_id)
                    ->whereCurrency($request->currency)
                    ->whereIncomeAccount($request->income_account)
                    ->whereExpenseAccount($request->expense_account)
                    ->whereNot('id', $incomeExpenseAccount->id)
                    ->first();

        if(is_null($account)) {
            $incomeExpenseAccount->update($validatedData);
            return redirect()->back()->with('success','Account successfully updated!');
        } else {
            return redirect()->back()->with('error','The account cannot be updated as it already exists!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeExpenseAccount $incomeExpenseAccount)
    {
        //
    }
}
