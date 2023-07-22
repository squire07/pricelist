<?php

namespace App\Http\Controllers;

use App\Models\TransactionListing;
use Illuminate\Http\Request;

class TransactionListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transactionlisting.index');
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
    public function show(TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionListing $transactionListing)
    {
        //
    }
}
