<?php

namespace App\Http\Controllers;

use App\Models\ShippingFee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $existSizeRegionDimensionRate = ShippingFee::whereParcelSize($request->parcel_size)->whereDeleted(false)->first();
        if(!$existSizeRegionDimensionRate) {
            $shipping_fee = new ShippingFee();
            $shipping_fee->uuid = Str::uuid();
            $shipping_fee->parcel_size = $request->parcel_size;
            $shipping_fee->region = $request->region;
            $shipping_fee->dimension = $request->dimension;
            $shipping_fee->parcel_rate = $request->parcel_rate;
            $shipping_fee->created_by = Auth::user()->name;
            $shipping_fee->save();
            return redirect()->back()->with('success', 'Shipping Fee has been created!');
        } else {
            return redirect()->back()->with('error', 'Shipping Fee already exists!');
        }
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
    public function update(Request $request, $uuid)
    {
        if (ShippingFee::where('parcel_size', $request->parcel_size)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Parcel size {$request->parcel_size} already exists!");
        }
        $shipping_fee = ShippingFee::whereUuid($uuid)->whereDeleted(false)->firstOrFail(); 
        $shipping_fee->parcel_size = $request->parcel_size;
        $shipping_fee->region = $request->region;
        $shipping_fee->dimension = $request->dimension;
        $shipping_fee->parcel_rate = $request->parcel_rate;
        $shipping_fee->updated_by = Auth::user()->name;
        if($shipping_fee->update()) {
            return redirect()->back()->with('success', 'Shipping Fee has been updated!');
        } else { 
            return redirect()->back()->with('error', 'Failed to update shipping fee.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingFee $shippingFee)
    {
        //
    }
}
