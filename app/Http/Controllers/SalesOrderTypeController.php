<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Models\SalesOrderType;
use Yajra\DataTables\DataTables;

class SalesOrderTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('TransactionType.index');
    }

    /**
     * Returns json object. DataTable with handle the get() property.
     */
    public function salesordertype_list() 
    {
        $salesordertypes = SalesOrderType::whereDeleted(false);
        return DataTables::of($salesordertypes)->toJson();
    }

    /**`
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
    public function show(SalesOrderType $salesOrderType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrderType $salesOrderType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrderType $salesOrderType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrderType $salesOrderType)
    {
        //
    }
}
