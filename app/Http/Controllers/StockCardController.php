<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockCard;
use App\Models\Sales;
use App\Models\SalesDetails;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sales::with('sales_details')
                        ->where('status_id', 4)
                        ->where('deleted', 0)
                        ->whereRelation('sales_details', function($query) {
                            $query->where('item_code','CF');
                        })
                        ->get();

        return view('stockcard.index', compact('sales'));
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
    public function show(StockCard $stockCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockCard $stockCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockCard $stockCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockCard $stockCard)
    {
        //
    }
}
