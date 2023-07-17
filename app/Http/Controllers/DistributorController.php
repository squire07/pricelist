<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;
use DataTables;
use Cache;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Distributor.distributor');
    }

    /**
     * Returns json object. DataTable with handle the get() property.
     */
    public function distributor_list() 
    {
        $distributors = Distributor::whereDeleted(false);
        return DataTables::of($distributors)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // will be done at Prime Dashboard
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // will be done at Prime Dashboard
    }


    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        //
    }
}
