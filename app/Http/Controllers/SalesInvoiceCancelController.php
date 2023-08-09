<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\SalesInvoiceCancel;
use Yajra\DataTables\Facades\DataTables;

class SalesInvoiceCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesInvoice.cancelled');
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
    public function show(SalesInvoiceCancel $salesInvoiceCancel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceCancel $salesInvoiceCancel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoiceCancel $salesInvoiceCancel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceCancel $salesInvoiceCancel)
    {
        //
    }

    public function sales_invoice_cancel_list() 
    {
        $sales_invoice_cancelled = Sales::with('status','transaction_type')->whereIn('status_id', [3])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_cancelled)->toJson(); 
    }
}
