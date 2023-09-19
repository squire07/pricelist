<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;
use Auth;
use App\Helpers\Helper;
use App\Models\Branch;
use App\Models\History;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\TransactionType;
use Carbon\Carbon; 
class SalesController extends Controller
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
                            ->whereStatusId(1)
                            ->whereDeleted(false)
                            ->orderByDesc('id')
                            ->get();

        return view('SalesOrder.index', compact('sales_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaction_types = TransactionType::whereDeleted(false)->get(['id','name']);
        $branches = Branch::whereDeleted(false)->get(['id','name']);
        return view('SalesOrder.create', compact('transaction_types','branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sales = new Sales();
        $sales->uuid = Helper::uuid(new Sales);
        $sales->transaction_type_id = $request->transaction_type_id;
        $sales->branch_id = $request->branch_id;
        $sales->so_no = Helper::generate_so_no();
        $sales->bcid = $request->bcid;
        $sales->distributor_name = $request->distributor_name;
        $sales->group_name = $request->group_name;
        $sales->company = $request->company;
        $sales->shipping_fee = $request->shipping_fee;
        $sales->grandtotal_amount = $request->hidden_grandtotal_amount;
        $sales->total_amount = $request->hidden_total_amount; // must be refactored
        $sales->total_nuc = $request->hidden_total_nuc; // must be refactored
        $sales->status_id = 1; //set to default - 1 (Draft)
        $sales->created_by = Auth::user()->name;
        $sales->updated_by = Auth::user()->name;
        
        // if the parent information is saved, then, save the details information
        if($sales->save()) {

            // create a new array
            $item_details = [];

            // convert the multiple array into one single array (flat array)
            foreach($request->item_name as $key => $value) {
                $item_details[$key]['item_name'] = $value;

                // instead of using multi nested foreach loop, lets break it down individually and just find the matching keys
                foreach($request->quantity as $key_quantity => $value_quantity) {
                    if($key == $key_quantity) {
                        $item_details[$key]['quantity'] = $value_quantity;
                    }
                }
                foreach($request->amount as $key_amount => $value_amount) {
                    if($key == $key_amount) {
                        $item_details[$key]['amount'] = $value_amount;
                    }
                }
                foreach($request->nuc as $key_nuc => $value_nuc) {
                    if($key == $key_nuc) {
                        $item_details[$key]['nuc'] = $value_nuc;
                    }
                }
                foreach($request->rs_points as $key_rs_points => $value_rs_points) {
                    if($key == $key_rs_points) {
                        $item_details[$key]['rs_points'] = $value_rs_points;
                    }
                }
                foreach($request->subtotal_nuc as $key_subtotal_nuc => $value_subtotal_nuc) {
                    if($key == $key_subtotal_nuc) {
                        $item_details[$key]['subtotal_nuc'] = $value_subtotal_nuc;
                    }
                }
                foreach($request->subtotal_amount as $key_subtotal_amount => $value_subtotal_amount) {
                    if($key == $key_subtotal_amount) {
                        $item_details[$key]['subtotal_amount'] = $value_subtotal_amount;
                    }
                }
            }

            // save the flat array to sales details table
            foreach($item_details as $item) {
                $details = new SalesDetails();
                $details->sales_id = $sales->id;
                $details->item_name = $item['item_name'];
                $details->item_price = $item['amount'];
                $details->quantity = $item['quantity'];
                $details->amount = $item['subtotal_amount']; 
                $details->nuc = $item['subtotal_nuc'];
                $details->created_by = Auth::user()->name;
                $details->updated_by = Auth::user()->name;
                $details->save();
            }

            // save to history
            // code goes here for HISTORY

            Helper::history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Create Sales Order', NULL);
        }

        return redirect('sales-orders')->with('success','Sales Order Saved!');
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

        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();
        
        return view('SalesOrder.show', compact('sales_order','histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales, $uuid)
    {
        $sales_order = Sales::whereUuid($uuid)
                        ->with('transaction_type','status')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })
                        ->firstOrFail();

        $transaction_types = TransactionType::whereDeleted(false)->get();
        $branches = Branch::whereDeleted(false)->get(['id','name']);

        return view('SalesOrder.edit', compact('sales_order','transaction_types','branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $uuid = $request->uuid ?? $uuid;
        
        $sales = Sales::whereUuid($uuid)->whereDeleted(false)->firstOrFail();  
        
        // check if request contains status_id = 2
        if(isset($request->status_id) && $request->status_id == 2) {
            $sales->status_id = $request->status_id;
            $sales->updated_by = Auth::user()->name; // updated_at will be automatically filled by laravel
            if($sales->update()) {
                // pass the message to user if the update is successful
                $message = $sales->so_no . ' successfully marked for invoicing';
            }

            Helper::history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Submitted For Invoicing', NULL);

        } else {
            // other requests, status_id goes here. (from EDIT method)
            //dd($request);

            // update the bcid, distributor's name and group if available, else retain the original data
            $sales->bcid = $request->bcid ?? $sales->bcid;
            $sales->distributor_name = $request->distributor_name ?? $sales->distributor_name;
            $sales->group_name = $request->group_name ?? $sales->group_name;
            // update total amount and total nuc points, else retain the original
            $sales->total_amount = $request->hidden_total_amount ?? $sales->total_amount;
            $sales->total_nuc = $request->hidden_total_nuc ?? $sales->total_nuc;
            if($sales->update()) {

                // check if there is/are item(s) for deletion 
                if(isset($request->deleted_item_id) && !is_null($request->deleted_item_id)) {
                    // mark the id(s) as deleted 
                    $exploded_ids = explode(',', $request->deleted_item_id);
                    foreach($exploded_ids as $sales_details_id) {
                        // update the sales_details table
                        $sales_details = SalesDetails::whereId($sales_details_id)->first();
                        $sales_details->deleted = 1;
                        $sales_details->deleted_at = Carbon::now();
                        $sales_details->deleted_by = Auth::user()->name;
                        $sales_details->update();
                    }
                }

            
                // check for additional item(s)
                $item_details = [];
                if(isset($request->item_name)) {
                    // convert the multiple array into one single array (flat array)
                    foreach($request->item_name as $key => $value) {
                        $item_details[$key]['item_name'] = $value;

                        // instead of using multi nested foreach loop, lets break it down individually and just find the matching keys
                        foreach($request->quantity as $key_quantity => $value_quantity) {
                            if($key == $key_quantity) {
                                $item_details[$key]['quantity'] = $value_quantity;
                            }
                        }
                        foreach($request->amount as $key_amount => $value_amount) {
                            if($key == $key_amount) {
                                $item_details[$key]['amount'] = $value_amount;
                            }
                        }
                        foreach($request->nuc as $key_nuc => $value_nuc) {
                            if($key == $key_nuc) {
                                $item_details[$key]['nuc'] = $value_nuc;
                            }
                        }
                        foreach($request->rs_points as $key_rs_points => $value_rs_points) {
                            if($key == $key_rs_points) {
                                $item_details[$key]['rs_points'] = $value_rs_points;
                            }
                        }
                        foreach($request->subtotal_nuc as $key_subtotal_nuc => $value_subtotal_nuc) {
                            if($key == $key_subtotal_nuc) {
                                $item_details[$key]['subtotal_nuc'] = $value_subtotal_nuc;
                            }
                        }
                        foreach($request->subtotal_amount as $key_subtotal_amount => $value_subtotal_amount) {
                            if($key == $key_subtotal_amount) {
                                $item_details[$key]['subtotal_amount'] = $value_subtotal_amount;
                            }
                        }
                    }

                    // save the flat array to sales details table
                    foreach($item_details as $item) {
                        $details = new SalesDetails();
                        $details->sales_id = $sales->id;
                        $details->item_name = $item['item_name'];
                        $details->item_price = $item['amount'];
                        $details->quantity = $item['quantity'];
                        $details->amount = $item['subtotal_amount']; 
                        $details->nuc = $item['subtotal_nuc'];
                        $details->created_by = Auth::user()->name;
                        $details->updated_by = Auth::user()->name;
                        $details->save();
                    }
                }

                $message = $sales->so_no . ' successfully updated';
            }

            Helper::history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Update Sales Order', NULL);

        }

        // redirect to index page with dynamic message coming from different statuses
        return redirect('sales-orders')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }

    public function sales_orders_list(Request $request) 
    {   
        $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        if($request->has('daterange')) {
            $date = explode(' - ',$request->daterange);
            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
        } 

        $sales_orders = Sales::with('status','transaction_type')
                            ->whereBetween('created_at', [$from, $to])
                            ->whereStatusId(1)
                            ->whereDeleted(false)
                            ->orderByDesc('id')
                            ->get();

        return DataTables::of($sales_orders)->toJson();
    }

}
