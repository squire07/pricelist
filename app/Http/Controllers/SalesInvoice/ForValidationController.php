<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Models\Sales;
use App\Helpers\Helper;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SalesInvoiceForValidation;


class ForValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales_orders = Sales::with('status','transaction_type')
                            ->where(function ($query) use ($request) {
                                if ($request->has('daterange')) {
                                    $date = explode(' - ', $request->daterange);
                                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        
                                    // Apply the whereBetween condition
                                    $query->whereBetween('created_at', [$from, $to]);
                                }
                            })
                            ->whereStatusId(5)
                            ->whereDeleted(false)
                            ->orderByDesc('id')
                            ->get();

        return view('SalesInvoice.for_validation.index', compact('sales_orders'));
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
        $sales_order = Sales::with('payment')->whereUuid($uuid)
                        ->whereStatusId(5)
                        ->with('transaction_type')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();

        // convert the details from json_object to array object
        if(isset($sales_order->payment->details)) {
            $sales_order->payment->details = json_decode($sales_order->payment->details,true);
        }

        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();
        
        return view('SalesInvoice.for_validation.show', compact('sales_order','histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceForValidation $salesInvoiceForValidation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $uuid = $request->uuid ?? $uuid;
        
        $sales = Sales::whereUuid($uuid)->whereDeleted(false)->firstOrFail();  

        // check if request contains status_id = 3
        if(isset($request->status_id) && $request->status_id == 3) { // Cancel
            $sales->status_id = $request->status_id;
            $sales->si_remarks = $request->si_remarks;
            $sales->updated_by = Auth::user()->name; // updated_at will be automatically filled by laravel
            if($sales->update()) {
                // pass the message to user if the update is successful
                $message = $sales->so_no . ' successfully marked Cancelled';
            }
            Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Cancel Sales Invoice', $sales->si_remarks);
        }

        
        // redirect to index page with dynamic message coming from different statuses
        return redirect('sales-invoice/for-validation')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceForValidation $salesInvoiceForValidation)
    {
        //
    }

    public function sales_invoice_for_validation_list() 
    {
        $sales_invoice_for_validation = Sales::with('status','transaction_type')->whereIn('status_id', [4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_for_validation)->toJson(); 
    }
}
