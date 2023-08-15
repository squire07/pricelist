<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Http\Controllers\Controller;
use App\Models\PaymentList;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesInvoice;
use Yajra\DataTables\Facades\DataTables;

class ForInvoicingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesInvoice.for_invoicing.index');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales, $uuid)
    {
        $sales_order = Sales::with('sales_details','transaction_type','status')->whereUuid($uuid)->firstOrFail();
        $payment_types = PaymentList::whereDeleted(false)->get(['id','name']);
        return view('SalesInvoice.for_invoicing.edit', compact('sales_order','payment_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sales_invoice_list() 
    {
        $sales_invoice = Sales::with('status','transaction_type')->whereIn('status_id', [2])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice)->toJson(); 
    }

}
