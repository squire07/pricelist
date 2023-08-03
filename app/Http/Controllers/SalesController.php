<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Branch;
use App\Models\Sales;
use App\Models\TransactionType;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesOrder.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaction_types = TransactionType::whereDeleted(false)->get(['id','name']);
        $branches = Branch::whereDeleted(false)->get(['id','name']);
        return view('SalesOrder.create', compact('transaction_types','branches'));
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
        $sales_order = Sales::with('sales_details')->whereUuid($uuid)->firstOrFail();

        return view('SalesOrder.show', compact('sales_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }

    public function sales_orders_list() 
    {
        $sales_orders = Sales::with('status')->whereStatusId(1)->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_orders)->toJson(); 
    }

}
