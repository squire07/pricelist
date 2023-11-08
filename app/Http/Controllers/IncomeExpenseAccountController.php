<?php

namespace App\Http\Controllers;

use App\Models\IncomeExpenseAccount;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use App\Helpers\Helper;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $accounts = TransactionType::with('accounts')->whereUuid($uuid)->first();
        
        $currencies = Helper::get_erpnext_data('/api/resource/Currency?filters={"enabled":"1"}');
        $currencies = $currencies['data'];

        return view('income_expense_account.index', compact('accounts','currencies'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeExpenseAccount $incomeExpenseAccount)
    {
        //
    }
}
