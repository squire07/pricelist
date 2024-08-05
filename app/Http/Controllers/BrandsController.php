<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brands::whereDeleted(false)->get();
        return view('brand.index',compact('brands'));
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
        $exist = Brands::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $brands = new Brands();
            $brands->uuid = Str::uuid();
            $brands->name = $request->name;
            $brands->created_by = Auth::user()->name;
            $brands->save();
            return redirect()->back()->with('success', 'Brand has been created!');
        } else {
            return redirect()->back()->with('error', 'Brand already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brands $brands)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brands $brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        //dd($request);

        $brand = Brands::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Brands::where('name', $request->name)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Brand already exists!");
        } 

            $brand->name = $request->name ?? $brand->name;    
            $brand->active = $request->active ?? $brand->active;   
            $brand->updated_by = Auth::user()->name;
            $brand->update();

            return redirect()->back()->with('success', 'Brand has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brands $brands)
    {
        //
    }
}
