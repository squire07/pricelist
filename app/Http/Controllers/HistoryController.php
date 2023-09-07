<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
                        // default to today's date
                        $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
                        $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';
                
                        if($request->has('daterange')) {
                            $date = explode(' - ',$request->daterange);
                            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';                                                                                                                                                      
                            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        } 
                
                        $sales_histories = History::with('status','transaction_type')
                                            ->whereBetween('created_at', [$from, $to])
                                            ->whereIn('status_id', [1,2,3,4,5])
                                            ->whereDeleted(false)
                                            ->orderByDesc('id')
                                            ->get();
                
                        return view('History.index', compact('sales_histories'));
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
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }
}
