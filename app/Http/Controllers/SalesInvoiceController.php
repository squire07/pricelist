<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesInvoice.index');
    }
    public function released()
    {
        return view('SalesInvoice.released');
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
    public function show(SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        //
    }

    public function sales_invoice_list() 
    {
        $sales_invoices = Sales::with('status','transaction_type')->whereIn('status_id', [2])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoices)->toJson(); 
    }
}