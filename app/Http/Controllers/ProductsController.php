<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Helpers\Helper;
use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('brands','product_category')
        ->whereDeleted(false)
        ->orderByDesc('id')
        ->get();

        $product_categories = ProductsCategory::whereDeleted(false)->get();

        $brands = Brands::whereDeleted(false)->get();

        return view('product.index',compact('products','product_categories','brands'));
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

        //dd($request);
        $exist = Products::whereCode($request->code)->whereDeleted(false)->first();
        if(!$exist) {
            $product = new Products();
            $product->uuid = Str::uuid();
            $product->upc = Helper::generateNextUPCNo();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->code = $request->code;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->size = $request->size;
            $product->uom = $request->uom;
            $product->uom_abbrv = $request->uom_abbrv;
            $product->pack_size = $request->pack_size;
            $product->size_in_kg = $request->size_in_kg;
            $product->packs_per_case = $request->packs_per_case;
            $product->orig_srp = $request->orig_srp;
            $product->spec_srp = $request->spec_srp;
            $product->remarks = $request->remarks;
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $imageName = Str::random(10) . '.' . $images->getClientOriginalExtension();
            
                // Specify the public path where the image will be stored
                $publicPath = public_path('images/products'); // Adjust the directory as needed
            
                // Store the image in the specified path
                $images->move($publicPath, $imageName);
            
                $product->images = 'images/products/' . $imageName;
            }
            $product->status = 1;
            $product->created_by = Auth::user()->name;
            $product->save();
            return redirect()->back()->with('success', 'Product has been created!');
        } else {
            return redirect()->back()->with('error', 'Product already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        //dd($request);
    
        // Check if the new name is unique, excluding the current product
        $products = Products::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Products::where('name', $request->name)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Product already exists!");
        } 
    
        // Update product details
        $products->name = $request->name ?? $products->name;
        $products->description = $request->description ?? $products->description;
        $products->code = $request->code ?? $products->code;
        $products->brand_id = $request->brand_id ?? $products->brand_id;
        $products->category_id = $request->category_id ?? $products->category_id;
        $products->size = $request->size ?? $products->size;
        $products->uom = $request->uom ?? $products->uom;
        $products->uom_abbrv = $request->uom_abbrv ?? $products->uom_abbrv;
        $products->pack_size = $request->pack_size ?? $products->pack_size;
        $products->size_in_kg = $request->size_in_kg ?? $products->size_in_kg;
        $products->packs_per_case = $request->packs_per_case ?? $products->packs_per_case;
        $products->orig_srp = $request->orig_srp ?? $products->orig_srp;
        $products->spec_srp = $request->spec_srp ?? $products->spec_srp;
        $products->remarks = $request->remarks ?? $products->remarks;
        $products->status = $request->status ?? $products->status;
    
        if ($request->hasFile('images')) {
            // Delete the existing image file if it exists
            if ($products->images) {
                $imagePath = public_path($products->images);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
            // Store the new image
            $images = $request->file('images');
            $imageName = Str::random(10) . '.' . $images->getClientOriginalExtension();
            $publicPath = public_path('images/products');
            $images->move($publicPath, $imageName);
            $products->images = 'images/products/' . $imageName;
        }
    
        $products->updated_by = Auth::user()->name;
        $products->update();
    
        return redirect()->back()->with('success', 'Product has been updated!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
