<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Helpers\Helper;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Employees;
use App\Models\Deliveries;
use App\Models\PaymentTerms;
use Illuminate\Http\Request;
use App\Models\DeliveryStatus;
use Illuminate\Support\Carbon;
use App\Models\DeliveryDetails;
use App\Http\Controllers\Controller;
use App\Models\PaymentStatus;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class DeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deliveries = Deliveries::with('delivery_details','customers','deliverystatus','paymentstatus','agents')
            ->where(function ($query) use ($request) {
                if ($request->has('daterange')) {
                    $date = explode(' - ', $request->daterange);
                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
        
                    // Apply the whereBetween condition
                    $query->whereBetween('created_at', [$from, $to]);
                }
            })
            ->whereDeleted(false)
            ->orderByDesc('id')
            ->get();

        $delivery_status = DeliveryStatus::whereDeleted(false)->get();

        $payment_status = PaymentStatus::whereDeleted(false)->get();

        $drivers = Employees::where('role_id', 4)->whereDeleted(false)->get();

        $agents = Employees::where('role_id', 5)->whereDeleted(false)->get();

        $customers = Customers::with('area_groups','customer_categories')->whereDeleted(false)->whereStatus(1)->get();

        $products = Products::whereDeleted(false)->whereStatus(1)->get();

        return view('delivery.index',compact('deliveries','delivery_status', 'payment_status', 'drivers', 'customers', 'agents', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deliveries = Deliveries::whereDeleted(false)->get();

        $delivery_status = DeliveryStatus::whereDeleted(false)->get();

        $payment_status = PaymentStatus::whereDeleted(false)->get();

        $employees = Employees::where('active', 1)->whereDeleted(false)->get();

        $customers = Customers::with('area_groups','customer_categories')->whereDeleted(false)->whereStatus(1)->get();

        $products = Products::whereDeleted(false)->get();

        $payment_terms = PaymentTerms::whereDeleted(false)->get();

        return view('delivery.create',compact('deliveries','delivery_status', 'payment_status', 'customers', 'employees', 'products', 'payment_terms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
    
        // Create a new deliveries instance for the new record
        $deliveries = new Deliveries();
        $deliveries->uuid = Helper::uuid(new Deliveries());
        $deliveries->dr_no = Helper::generateNextDRNo();
        $deliveries->delivery_date = $request->delivery_date;
        $deliveries->payment_terms = $request->payment_terms;
        $deliveries->due_date = $request->due_date;
        $deliveries->srp_type = $request->srp_type;
        $deliveries->store_name = $request->store_name;
        $deliveries->address = $request->address;
        $deliveries->customer_category = $request->customer_category;
        $deliveries->area_group = $request->area_group;
        $deliveries->add_discount = $request->add_discount ?? 0;
        $deliveries->add_discount_value = $request->add_discount_value ?? 0;
        $deliveries->total_quantity = $request->total_quantity;
        $deliveries->total_amount = str_replace(',', '', $request->total_amount);
        $deliveries->vatable_sales = $request->vatable_sales ?? 0;
        $deliveries->vat_amount = $request->vat_amount ?? 0;
        $deliveries->grandtotal_amount = str_replace(',', '', $request->grandtotal_amount);
        $deliveries->delivery_status = 1;
        $deliveries->payment_status = 1;
        $deliveries->delivered_by = $request->delivered_by;
        $deliveries->agents = $request->agents;
        $deliveries->remarks = $request->remarks;
        $deliveries->created_by = Auth::user()->name;
        $deliveries->updated_by = Auth::user()->name;
    
        // Save the new deliveries record
        if ($deliveries->save()) {

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

                if (isset($request->item_discount[$key])) {
                    $item_details[$key]['item_discount'] = str_replace(',', '', $request->item_discount[$key]);
                }

                if (isset($request->pack_size[$key])) {
                    $item_details[$key]['pack_size'] = str_replace(',', '', $request->pack_size[$key]);
                }

                if (isset($request->size_in_kg[$key])) {
                    $item_details[$key]['size_in_kg'] = str_replace(',', '', $request->size_in_kg[$key]);
                }
            
                if (isset($request->subtotal_amount[$key])) {
                    $item_details[$key]['subtotal_amount'] = str_replace(',', '', $request->subtotal_amount[$key]);
                }
                
                // Save each item's details to the deliveries details table
                $details = new DeliveryDetails();
                $details->delivery_id = $deliveries->id;
                $details->item_code = $item_details[$key]['item_code'] ?? null;
                $details->item_name = $value;
                $details->pack_size = $item_details[$key]['pack_size'] ?? null;
                $details->size_in_kg = $item_details[$key]['size_in_kg'] ?? null;
                $details->item_discount = $item_details[$key]['item_discount'] ?? null;
                $details->item_price = $item_details[$key]['amount'] ?? null;
                $details->quantity = $item_details[$key]['quantity'] ?? null;
                $details->amount = $item_details[$key]['subtotal_amount'] ?? null;
                $details->created_by = Auth::user()->name;
                $details->updated_by = Auth::user()->name;
                $details->save();
            }
        }
            // save to history
            //Helper::transaction_history($deliveries->id, $deliveries->uuid, $deliveries->transaction_type_id, $deliveries->status_id, $deliveries->so_no, 'deliveries Order', 'Create deliveries Order', NULL);

        return redirect('delivery-management')->with('success', $deliveries->dr_no . ' Successfully saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $delivery = Deliveries::whereUuid($uuid)
                            ->with('delivered_by','status','deliverystatus','payment')
                            ->with('delivery_details', function($query) {
                                $query->where('deleted',0);
                            })
                            ->firstOrFail();

        //$histories = History::whereUuid($delivery->uuid)->whereDeleted(false)->get();
        
        return view('delivery.show', compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deliveries $deliveries, $uuid)
    {
        $deliveries = Deliveries::whereUuid($uuid)
                    ->with('delivered_by','status','payment_terms','deliverystatus')
                    ->with('delivery_details', function($query) {
                        $query->where('deleted',0);
                    })
                    ->firstOrFail();

        $delivery_status = DeliveryStatus::whereDeleted(false)->get();

        $payment_status = Status::whereDeleted(false)->get();

        $employees = Employees::where('active', 1)->whereDeleted(false)->get();

        $customers = Customers::with('area_groups','customer_categories')->whereDeleted(false)->whereStatus(1)->get();

        $products = Products::whereDeleted(false)->get();

        $payment_terms = PaymentTerms::whereDeleted(false)->get();

        return view('delivery.edit',compact('deliveries','delivery_status', 'payment_status', 'customers', 'employees', 'products', 'payment_terms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        //dd($request);

        $uuid = $request->uuid ?? $uuid;

        $deliveries = Deliveries::whereUuid($uuid)->whereDeleted(false)->firstOrFail();  

        if($deliveries->version == $request->version) {
            // check if request contains status_id = 2
            if(isset($request->delivery_status) && $request->delivery_status == 2) {
                $deliveries->delivery_status = $request->delivery_status;
                $deliveries->delivered_date = Carbon::parse($request->delivered_date)->toDateTimeString();
                $deliveries->updated_by = Auth::user()->name; // updated_at w$deliveries->delivery_status = $request->delivery_status;ill be automatically filled by laravel
                $deliveries->version = $deliveries->version + 1;
                // submitted at
                $deliveries->submitted_at = Carbon::now()->toDateTimeString();
                if($deliveries->update()) {
                    // pass the message to user if the update is successful
                    $message = $deliveries->dr_no . ' successfully marked as Completed';
                }

                //Helper::transaction_history($deliveries->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Submitted For Invoicing', NULL);

            } else {
    
                $deliveries->delivery_date = $request->delivery_date ?? $deliveries->delivery_date;
                $deliveries->payment_terms = $request->payment_terms ??  $deliveries->payment_terms;
                $deliveries->due_date = $request->due_date ?? $deliveries->due_date;
                $deliveries->srp_type = $request->srp_type ?? $deliveries->srp_type;
                $deliveries->store_name = $request->store_name ?? $deliveries->store_name;
                $deliveries->address = $request->address ?? $deliveries->address;
                $deliveries->customer_category = $request->customer_category ?? $deliveries->customer_category;
                $deliveries->area_group = $request->area_group ?? $deliveries->area_group;
                $deliveries->add_discount = $request->add_discount ?? $deliveries->add_discount;
                $deliveries->add_discount_value = $request->add_discount_value ?? $deliveries->add_discount_value;
                $deliveries->total_quantity = $request->total_quantity ?? $deliveries->total_quantity;
                $deliveries->total_amount = str_replace(',', '', $request->total_amount);
                $deliveries->grandtotal_amount = str_replace(',', '', $request->grandtotal_amount);
                $deliveries->version = $deliveries->version + 1;
                $deliveries->delivery_status = $request->delivery_status ?? $deliveries->delivery_status;
                $deliveries->payment_status = 1;
                $deliveries->delivered_by = $request->delivered_by ?? $deliveries->delivered_by;
                $deliveries->agents = $request->agents ?? $deliveries->agents;
                $deliveries->remarks = $request->remarks ?? $request->remarks;
                $deliveries->created_by = Auth::user()->name;
                $deliveries->updated_by = Auth::user()->name;
            
                // Save the new deliveries record
                if ($deliveries->update()) {

                    // check if there is/are item(s) for deletion 
                    if(isset($request->deleted_item_id) && !is_null($request->deleted_item_id)) {
                        // mark the id(s) as deleted 
                        $exploded_ids = explode(',', $request->deleted_item_id);
                        foreach($exploded_ids as $delivery_details_id) {
                            // update the sales_details table
                            $delivery_details = DeliveryDetails::whereId($delivery_details_id)->first();
                            $delivery_details->deleted = 1;
                            $delivery_details->deleted_at = Carbon::now();
                            $delivery_details->deleted_by = Auth::user()->name;
                            $delivery_details->update();
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
                        
                            if (isset($request->item_discount[$key])) {
                                $item_details[$key]['item_discount'] = str_replace(',', '', $request->item_discount[$key]);
                            }
                        
                            if (isset($request->pack_size[$key])) {
                                $item_details[$key]['pack_size'] = str_replace(',', '', $request->pack_size[$key]);
                            }

                            if (isset($request->size_in_kg[$key])) {
                                $item_details[$key]['size_in_kg'] = str_replace(',', '', $request->size_in_kg[$key]);
                            }
                        
                            if (isset($request->subtotal_amount[$key])) {
                                $item_details[$key]['subtotal_amount'] = str_replace(',', '', $request->subtotal_amount[$key]);
                            }
                        }
                    
                        // Save each item's details to the deliveries details table
                        foreach($item_details as $item) {
                            $details = new DeliveryDetails();
                            $details->delivery_id = $deliveries->id;
                            $details->item_code = $item['item_code'] ?? null;
                            $details->item_name = $item['item_name'] ?? null;
                            $details->pack_size = $item['pack_size'] ?? null;
                            $details->size_in_kg = $item['size_in_kg'] ?? null;
                            $details->item_discount = $item['item_discount'] ?? null;
                            $details->item_price = $item['amount'] ?? null;
                            $details->quantity = $item['quantity'] ?? null;
                            $details->amount = $item['subtotal_amount'] ?? null;
                            $details->created_by = Auth::user()->name;
                            $details->updated_by = Auth::user()->name;
                            $details->save();
                        }
                    }

                    $message = $deliveries->dr_no . ' successfully updated';
                }

        //Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Order', 'Update Sales Order', NULL);

            }

            // redirect to index page with dynamic message coming from different statuses
            return redirect('delivery-management')->with('success', $message);

        } else {
            return redirect('delivery-management')->with('error', 'This delivery was recently modified by another user!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deliveries $deliveries)
    {
        //
    }

    public function print($uuid) 
    {
        //sleep(3); // allow x seconds interval before getting the sales details

        $deliveries = Deliveries::with('delivery_details','customers','deliverystatus','status','agents')  
        ->whereDeleted(false)
        ->orderByDesc('id')
        ->firstOrFail();
            

        return view('delivery.print.local', compact('deliveries'));

    }

}
