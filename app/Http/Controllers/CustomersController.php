<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\AreaGroups;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerCategories;
use App\Http\Controllers\Controller;
use App\Models\SrpTypes;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customers::with('area_groups','customer_categories','srp_types')
        ->whereDeleted(false)
        ->orderByDesc('id')
        ->get();

        $customer_categories = CustomerCategories::whereDeleted(false)->whereStatus(1)->get();

        $area_groups = AreaGroups::whereDeleted(false)->whereStatus(1)->get();

        $srp_types = SrpTypes::whereDeleted(false)->get();

        return view('customer.index',compact('customers','customer_categories','area_groups','srp_types'));

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
        $exist = Customers::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $customer = new Customers();
            $customer->uuid = Str::uuid();
            $customer->name = $request->name;
            $customer->proprietor = $request->proprietor;
            $customer->address = $request->address;
            $customer->zip_code = $request->zip_code;
            $customer->category_id = $request->category_id;
            $customer->area_id = $request->area_id;
            $customer->email = $request->email;
            $customer->contact_number = $request->contact_number;
            $customer->vat_type = $request->vat_type;
            $customer->tin = $request->tin;
            $customer->srp_type_id = $request->srp_type_id;
            $customer->status = 1;
            $customer->created_by = Auth::user()->name;
            $customer->save();
            return redirect()->back()->with('success', 'Customer has been created!');
        } else {
            return redirect()->back()->with('error', 'Customer already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {

        //dd($request);
        
        $customer = Customers::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Customers::where('name', $request->name)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Customer already exists!");
        } 

            $customer->name = $request->name ?? $customer->name;
            $customer->proprietor = $request->proprietor ?? $customer->proprietor;
            $customer->address = $request->address ?? $customer->address;
            $customer->zip_code = $request->zip_code ?? $customer->zip_code;
            $customer->category_id = $request->category_id ?? $customer->category_id;
            $customer->area_id = $request->area_id ?? $customer->area_id;
            $customer->email = $request->email ?? $customer->email;
            $customer->contact_number = $request->contact_number ?? $customer->contact_number;
            $customer->vat_type = $request->vat_type ?? $customer->vat_type;
            $customer->tin = $request->tin ?? $customer->tin;
            $customer->srp_type_id = $request->srp_type_id ?? $customer->srp_type_id;
            $customer->status = $request->status ?? $customer->status;
            $customer->updated_by = Auth::user()->name;
            $customer->update();
        
            return redirect()->back()->with('success', 'Customer has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customers $customers)
    {
        //
    }
}
