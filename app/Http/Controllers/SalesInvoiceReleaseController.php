<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\SalesInvoiceRelease;
use Yajra\DataTables\Facades\DataTables;

class SalesInvoiceReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(SalesInvoiceRelease $salesInvoiceRelease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceRelease $salesInvoiceRelease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoiceRelease $salesInvoiceRelease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceRelease $salesInvoiceRelease)
    {
        //
    }

    public function sales_invoice_released_list() 
    {
        $sales_invoice_released = Sales::with('status','transaction_type')->whereIn('status_id', [4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_released)->toJson(); 
    }
}
