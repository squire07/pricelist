<?php

namespace App\Http\Controllers;

use App\Models\ShippingFee;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipping_fees = ShippingFee::whereDeleted(false)->get();
        return view('shipping_fee.index',compact('shipping_fees'));
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
    public function show(ShippingFee $shippingFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingFee $shippingFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingFee $shippingFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingFee $shippingFee)
    {
        //
    }
}
