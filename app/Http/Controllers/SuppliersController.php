<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Suppliers::whereDeleted(false)->get();
        return view('supplier.index',compact('suppliers'));
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
        $exist = Suppliers::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $supplier = new Suppliers();
            $supplier->uuid = Str::uuid();
            $supplier->name = $request->name;
            $supplier->proprietor = $request->proprietor;
            $supplier->address = $request->address;
            $supplier->zip_code = $request->zip_code;
            $supplier->email = $request->email;
            $supplier->contact_number = $request->contact_number;
            $supplier->vat_type = $request->vat_type;
            $supplier->tin = $request->tin;
            $supplier->status = 1;
            $supplier->created_by = Auth::user()->name;
            $supplier->save();
            return redirect()->back()->with('success', 'Supplier has been created!');
        } else {
            return redirect()->back()->with('error', 'Supplier already exists!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Suppliers $suppliers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suppliers $suppliers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $supplier = Suppliers::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Suppliers::where('name', $request->name)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Supplier already exists!");
        } 

            $supplier->name = $request->name;
            $supplier->proprietor = $request->proprietor;
            $supplier->address = $request->address;
            $supplier->zip_code = $request->zip_code;
            $supplier->email = $request->email;
            $supplier->contact_number = $request->contact_number;
            $supplier->vat_type = $request->vat_type;
            $supplier->tin = $request->tin;     
            $supplier->updated_by = Auth::user()->name;
            $supplier->update();
        
            return redirect()->back()->with('success', 'Supplier has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers $suppliers)
    {
        //
    }
}
