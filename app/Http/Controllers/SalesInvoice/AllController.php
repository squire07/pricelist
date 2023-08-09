<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\SalesInvoice;
use Yajra\DataTables\Facades\DataTables;

class AllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SalesInvoice.all.index');
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

    public function sales_invoice_all_list() 
    {
        $sales_invoice_all = Sales::with('status','transaction_type')->whereIn('status_id', [2,3,4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_all)->toJson(); 
    }
}
