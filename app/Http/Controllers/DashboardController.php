<?php

namespace App\Http\Controllers;

use App\Models\dashboard;
use App\Models\Deliveries;
use Illuminate\Http\Request;
use App\Models\DeliveryDetails;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $deliveries = Deliveries::where('deliveries.deleted', false)
        //     ->leftJoin('payments as p', function($join) {
        //         $join->on('p.id', '=', 'deliveries.payment_id')
        //             ->where('p.deleted', 0);
        //     })
        //     ->select([
        //         'deliveries.store_name',
        //         DB::raw('SUM(deliveries.total_quantity) as total_quantity'),
        //         DB::raw('SUM(deliveries.total_amount) as total_amount'),
        //         DB::raw('SUM(p.total_amount_paid) as total_amount_paid'),
        //         DB::raw('SUM(p.balance) as balance'),
        //         DB::raw('SUM(p.change) as cash_change')
        //     ])
        //     ->whereNot('deliveries.delivery_status', 3)
        //     ->groupBy('deliveries.store_name')
        //     ->orderBy('deliveries.total_amount', 'DESC')
        //     ->get();

            
        // $details = DeliveryDetails::leftJoin('deliveries as d', function($join) {
        //         $join->on('d.id', '=', 'delivery_details.delivery_id') // Assuming there's a delivery_id in delivery_details
        //             ->where('d.deleted', 0);
        //     })
        //     ->select(
        //         'delivery_details.item_name',
        //         DB::raw('SUM(delivery_details.quantity) AS total_quantity'),
        //         DB::raw('SUM(delivery_details.size_in_kg) AS total_size_in_kg'),
        //         DB::raw('SUM(delivery_details.amount) AS total_amount')
        //     )
        //     ->where('delivery_details.deleted', 0)
        //     ->groupBy('delivery_details.item_name')
        //     ->orderByDesc(DB::raw('total_size_in_kg'))
        //     ->get();
    
        // // Calculate overall totals
        // $grand_total_quantity = $deliveries->sum('total_quantity');
        // $grand_total_amount = $deliveries->sum('total_amount_paid');
        // $total_amount = $deliveries->sum('total_amount');
        // $difference = $grand_total_amount - $total_amount;

        // $top_customers = $deliveries->sortByDesc('total_amount')->take(5);

        // $top_products = $details->sortByDesc('total_amount')->take(5);
    
        // // Calculate counts for delivery_status 1 and 2
        // $status_new_count = Deliveries::where('delivery_status', 1)
        //     ->where('deleted', false)
        //     ->count();

        // $status_completed_count = Deliveries::where('delivery_status', 2)
        //     ->where('deleted', false)
        //     ->count();

        // // Calculate counts for delivery_status 1 and 2
        // $status_pending_count = Deliveries::where('payment_status', 1)
        // ->where('deleted', false)
        // ->count();

        // $status_fully_paid_count = Deliveries::where('payment_status', 2)
        // ->where('deleted', false)
        // ->count();

        // $status_partial_count = Deliveries::where('payment_status', 4)
        // ->where('deleted', false)
        // ->count();

        $products = Products::whereDeleted(false)->get();

        // Now $deliveries contains both the grouped results and the overall totals
        return view('dashboard.index', compact('products'));
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
    public function show(dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dashboard $dashboard)
    {
        //
    }
}
