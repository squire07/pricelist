<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CustomerCategories::whereDeleted(false)->get();
        return view('customer_category.index',compact('categories'));
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
        $exist = CustomerCategories::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $customer_categories = new CustomerCategories();
            $customer_categories->uuid = Str::uuid();
            $customer_categories->name = $request->name;
            $customer_categories->created_by = Auth::user()->name;
            $customer_categories->save();
            return redirect()->back()->with('success', 'Category has been created!');
        } else {
            return redirect()->back()->with('error', 'Category already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerCategories $customerCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCategories $customerCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $customer_categories = CustomerCategories::whereUuid($uuid)->whereDeleted(false)->firstOrFail();

        // check first if CustomerCategories name and code exist
        $existName = CustomerCategories::whereName($request->name)->whereDeleted(false)->first();

        if(!$existName) {
            $customer_categories->name = $request->name;     
            $customer_categories->updated_by = Auth::user()->name;
            $customer_categories->update();
            $msg = 'Category has been updated!';
            $msgType = 'success';
        } else {
            $msg = 'Category already exist';
            $msgType = 'error';
        }
        return redirect('customer-categories')->with($msgType, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerCategories $customerCategories)
    {
        //
    }
}
