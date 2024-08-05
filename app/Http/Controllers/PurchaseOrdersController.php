<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $purchase_orders = PurchaseOrders::whereDeleted(false)->get();
        // return view('purchase_orders.index',compact('purchase_orders'));
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
    public function show(PurchaseOrders $purchaseOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrders $purchaseOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrders $purchaseOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrders $purchaseOrders)
    {
        //
    }
}
