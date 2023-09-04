<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Models\Sales;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AllController extends Controller
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
                
                        $sales_orders = Sales::with('status','transaction_type')
                                            ->whereBetween('created_at', [$from, $to])
                                            ->whereIn('status_id', [2,3,4,5])
                                            ->whereDeleted(false)
                                            ->orderByDesc('id')
                                            ->get();
                
                        return view('SalesInvoice.all.index', compact('sales_orders'));
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
    public function show($uuid)
    {
        $sales_order = Sales::whereUuid($uuid)
        ->with('transaction_type')
        ->with('sales_details', function($query) {
            $query->where('deleted',0);
        })
        ->firstOrFail();
        return view('SalesInvoice.all.show', compact('sales_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        //
    }

    public function sales_invoice_all_list() 
    {
        $sales_invoice_all = Sales::with('status','transaction_type')->whereIn('status_id', [2,3,4,5])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_all)->toJson(); 
    }
}
