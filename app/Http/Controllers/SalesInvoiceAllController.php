<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\SalesInvoiceAll;
use Yajra\DataTables\Facades\DataTables;

class SalesInvoiceAllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesInvoice.All');
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
    public function show(SalesInvoiceAll $salesInvoiceAll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceAll $salesInvoiceAll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoiceAll $salesInvoiceAll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceAll $salesInvoiceAll)
    {
        //
    }

    public function sales_invoice_all_list() 
    {
        $sales_invoice_all = Sales::with('status','transaction_type')->whereIn('status_id', [2,3,4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_all)->toJson(); 
    }
}
