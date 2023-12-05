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
        // Check for duplicate record
        $duplicate_record = ShippingFee::whereParcelSize($request->parcel_size)
                                ->whereRegion($request->region)
                                ->whereDeleted(false)
                                ->exists();
    
        if ($duplicate_record) {
            return redirect()->back()->with('error', 'Duplicate record found for parcel size and region.');
        }
    
        $shipping_fee = new ShippingFee();
        $shipping_fee->uuid = Str::uuid();
        $shipping_fee->parcel_size = $request->parcel_size;
        $shipping_fee->region = $request->region;
        $shipping_fee->dimension = $request->dimension;
        $shipping_fee->parcel_rate = $request->parcel_rate;
        $shipping_fee->status = 1;
        $shipping_fee->created_by = Auth::user()->name;
    
        if ($shipping_fee->save()) {
            return redirect()->back()->with('success', 'Shipping Fee has been created!');
        } else {
            return redirect()->back()->with('error', 'Failed to create shipping fee.');
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
        // Check for duplicate record
        $duplicate_record = ShippingFee::whereParcelSize($request->parcel_size)
                                ->whereRegion($request->region)
                                ->whereNot('uuid', $uuid)
                                ->exists();
                                
        if ($duplicate_record) {
            return redirect()->back()->with('error', 'Duplicate record found for parcel size and region.');
        }
    
        // Find the shipping fee record
        $shipping_fee = ShippingFee::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        // Update the fields
        $shipping_fee->parcel_size = $request->parcel_size;
        $shipping_fee->region = $request->region;
        $shipping_fee->dimension = str_replace(',', '', $request->dimension);
        $shipping_fee->parcel_rate = str_replace(',', '', $request->parcel_rate);
    
        // Only update status if it's changed
        if ($request->has('status') && $shipping_fee->status != $request->status) {
            $shipping_fee->status = $request->status;
        }
    
        // Set the updated_by field
        $shipping_fee->updated_by = Auth::user()->name;
    
        // Try to update the record
        if ($shipping_fee->update()) {
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
