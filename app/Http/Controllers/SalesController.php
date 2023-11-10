<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;
use Auth;
use App\Helpers\Helper;
use App\Models\Branch;
use App\Models\Company;
use App\Models\History;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\ShippingFee;
use App\Models\TransactionType;
use App\Models\User;
use Carbon\Carbon; 
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');

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
                            ->whereStatusId(1)
                            ->whereDeleted(false)
                            ->when(!empty($user_branch), function($query) use ($user_branch) {
                                $query->whereIn('branch_id', explode(',',$user_branch));
                            })
                            ->orderByDesc('id')
                            ->get();

        return view('SalesOrder.index', compact('sales_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now()->toDateString();

        $transaction_types = TransactionType::where(function ($query) use ($now) {
                                $query->where(function ($sub_query) {
                                    // Include transaction types with no associated validity period
                                    $sub_query->whereNotExists(function ($validity_sub_query) {
                                        $validity_sub_query
                                            ->from('transaction_type_validities')
                                            ->whereRaw('transaction_type_validities.transaction_type_id = transaction_types.id');
                                    });
                                })->orWhere(function ($sub_query) use ($now) {
                                    // Include transaction types with a valid period that includes the current date
                                    $sub_query->whereExists(function ($validity_sub_query) use ($now) {
                                        $validity_sub_query
                                            ->from('transaction_type_validities')
                                            ->whereRaw('transaction_type_validities.transaction_type_id = transaction_types.id')
                                            ->where('transaction_type_validities.valid_from', '<=', $now)
                                            ->where('transaction_type_validities.valid_to', '>=', $now);
                                    });
                                })->orWhere(function ($sub_query) use ($now) {
                                    // Include transaction types with a valid period that includes the current date
                                    $sub_query->whereExists(function ($validity_sub_query) use ($now) {
                                        $validity_sub_query
                                            ->from('transaction_type_validities')
                                            ->whereRaw('transaction_type_validities.transaction_type_id = transaction_types.id')
                                            ->where('transaction_type_validities.valid_from', null)
                                            ->where('transaction_type_validities.valid_to', null);
                                    });
                                });
                            })->orderBy('name')->get();
 
        $shipping_fees = ShippingFee::whereDeleted(false)->get();

        $companies = Company::whereDeleted(false)->whereIn('status_id', [8,1])->get(); // 1 does not exists in status table as active/enable

        $company_ids = [];
        foreach($companies as $company) {
            $company_ids[] = $company->id;
        }

        // users without branch id
        $branches = Branch::whereDeleted(false)->whereIn('company_id', $company_ids)->orderBy('name')->get(['id','name']);   

        // users with branch id
        if(!empty(Auth::user()->branch_id)) {
            $branch_ids = explode(',', Auth::user()->branch_id);

            $branches = Branch::whereDeleted(false)
                            ->whereIn('id', $branch_ids)
                            ->get(['id','name']);
        }

        return view('SalesOrder.create', compact('transaction_types','branches','shipping_fees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sales = new Sales();
        $sales->uuid = Helper::uuid(new Sales);
        $sales->transaction_type_id = $request->transaction_type_id;
        $sales->company_id = Helper::get_company_id_by_branch_id($request->branch_id);
        $sales->branch_id = $request->branch_id;
        $sales->so_no = Helper::generate_so_no($request->branch_id);
        $sales->bcid = $request->bcid;
        $sales->distributor_name = $request->distributor_name;
        $sales->shipping_fee = $request->shipping_fee ?? 0; // conditional
        $sales->total_amount = $request->total_amount;
        $sales->total_nuc = $this->compute_total_nuc(str_replace(',', '', $request->subtotal_nuc)); // computation of total nuc is not included in the js
        $sales->vatable_sales = $request->vatable_sales;
        $sales->vat_amount = $request->vat_amount;
        $sales->grandtotal_amount = $request->grandtotal_amount;
        $sales->status_id = 1; //set to default - 1 (Draft)
        $sales->group_name = $request->group_name;
        $sales->created_by = Auth::user()->name;
        $sales->updated_by = Auth::user()->name;

        // if the parent information is saved, then, save the details information
        if($sales->save()) {

            // create a new array
            $item_details = [];
            foreach ($request->item_name as $key => $value) {
                $item_details[$key]['item_name'] = $value;

                if (isset($request->item_code[$key])) {
                    $item_details[$key]['item_code'] = $request->item_code[$key];
                }
            
                if (isset($request->quantity[$key])) {
                    $item_details[$key]['quantity'] = str_replace(',', '', $request->quantity[$key]);
                }
            
                if (isset($request->amount[$key])) {
                    $item_details[$key]['amount'] = str_replace(',', '', $request->amount[$key]);
                }
            
                if (isset($request->nuc[$key])) {
                    $item_details[$key]['nuc'] = str_replace(',', '', $request->nuc[$key]);
                }
            
                if (isset($request->rs_points[$key])) {
                    $item_details[$key]['rs_points'] = str_replace(',', '', $request->rs_points[$key]);
                }
            
                if (isset($request->subtotal_nuc[$key])) {
                    $item_details[$key]['subtotal_nuc'] = str_replace(',', '', $request->subtotal_nuc[$key]);
                }
            
                if (isset($request->subtotal_amount[$key])) {
                    $item_details[$key]['subtotal_amount'] = str_replace(',', '', $request->subtotal_amount[$key]);
                }
            
                // Save each item's details to the sales details table
                $details = new SalesDetails();
                $details->sales_id = $sales->id;
                $details->item_code = $item_details[$key]['item_code'] ?? null;
                $details->item_name = $value;
                $details->item_price = $item_details[$key]['amount'] ?? null;
                $details->item_nuc = $item_details[$key]['nuc'] ?? null;
                $details->quantity = $item_details[$key]['quantity'] ?? null;
                $details->amount = $item_details[$key]['subtotal_amount'] ?? null;
                $details->nuc = $item_details[$key]['subtotal_nuc'] ?? null;
                $details->created_by = Auth::user()->name;
                $details->updated_by = Auth::user()->name;
                $details->save();
            }

            // save to history
            Helper::transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Create Sales Order', NULL);
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
        $shipping_fees = ShippingFee::whereDeleted(false)->get();

        return view('SalesOrder.edit', compact('sales_order','transaction_types','branches','shipping_fees'));
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

            Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Submitted For Invoicing', NULL);

        } else {
            // other requests, status_id goes here. (from EDIT method)
            //dd($request);

            // update the bcid, distributor's name and group if available, else retain the original data
            $sales->bcid = $request->bcid ?? $sales->bcid;
            $sales->distributor_name = $request->distributor_name ?? $sales->distributor_name;
            $sales->group_name = $request->group_name ?? $sales->group_name;
            // update total amount and total nuc points, else retain the original
            $sales->total_amount = $request->total_amount ?? $sales->total_amount;
            $sales->total_nuc = $request->total_nuc ?? $sales->total_nuc;
            $sales->shipping_fee = $request->shipping_fee ?? $sales->shipping_fee;
            $sales->vatable_sales = $request->vatable_sales ?? $sales->vatable_sales;
            $sales->vat_amount = $request->vat_amount ?? $sales->vat_amount;
            $sales->grandtotal_amount = $request->grandtotal_amount ?? $sales->grandtotal_amount;
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

                        if (isset($request->item_code[$key])) {
                            $item_details[$key]['item_code'] = $request->item_code[$key];
                        }

                        if (isset($request->quantity[$key])) {
                            $item_details[$key]['quantity'] = str_replace(',', '', $request->quantity[$key]);
                        }
                    
                        if (isset($request->amount[$key])) {
                            $item_details[$key]['amount'] = str_replace(',', '', $request->amount[$key]);
                        }
                    
                        if (isset($request->nuc[$key])) {
                            $item_details[$key]['nuc'] = str_replace(',', '', $request->nuc[$key]);
                        }
                    
                        if (isset($request->rs_points[$key])) {
                            $item_details[$key]['rs_points'] = str_replace(',', '', $request->rs_points[$key]);
                        }
                    
                        if (isset($request->subtotal_nuc[$key])) {
                            $item_details[$key]['subtotal_nuc'] = str_replace(',', '', $request->subtotal_nuc[$key]);
                        }
                    
                        if (isset($request->subtotal_amount[$key])) {
                            $item_details[$key]['subtotal_amount'] = str_replace(',', '', $request->subtotal_amount[$key]);
                        }
                    }

                    // save the flat array to sales details table
                    foreach($item_details as $item) {
                        $details = new SalesDetails();
                        $details->sales_id = $sales->id;
                        $details->item_code = $item['item_code'] ?? null;;
                        $details->item_name = $item['item_name'] ?? null;;
                        $details->item_price = $item['amount'] ?? null;;
                        $details->quantity = $item['quantity'] ?? null;;
                        $details->amount = $item['subtotal_amount'] ?? null;; 
                        $details->nuc = $item['subtotal_nuc'] ?? null;;
                        $details->created_by = Auth::user()->name;
                        $details->updated_by = Auth::user()->name;
                        $details->save();
                    }
                }

                $message = $sales->so_no . ' successfully updated';
            }

            Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Update Sales Order', NULL);

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

    private function compute_total_nuc($nuc) {
        $total_nuc = 0;
        foreach ($nuc as $item) {
            $total_nuc += $item;
        }
        return $total_nuc;
    }
}
