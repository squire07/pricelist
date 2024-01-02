<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Branch;
use App\Models\History;
use App\Models\BuildReport;
use App\Models\Nuc;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BuildReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales_orders = Nuc::with('distributor','branch')
                            ->where(function ($query) use ($request) {
                                if ($request->has('daterange')) {
                                    $date = explode(' - ', $request->daterange);
                                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        
                                    // Apply the whereBetween condition
                                    $query->whereBetween('created_at', [$from, $to]);
                                }
                            })                       
                            ->orderByDesc('id')
                            ->where('status', 1)
                            ->get();
                
        return view('buildreport.index', compact('sales_orders'));
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
    public function show(BuildReport $buildReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BuildReport $buildReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BuildReport $buildReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuildReport $buildReport)
    {
        //
    }
}
